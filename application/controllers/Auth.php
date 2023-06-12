<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['system_name'] = $this->general->get_system_var('system_name');
		$this->data['system_address'] = $this->general->get_system_var('system_address');
		$this->data['system_name_short'] = $this->general->get_system_var('system_name_short');
		$this->data['logo_img'] = $this->general->get_system_var('logo');
	}
	public function index()
	{
		redirect('auth/login');
	}
	public function login(){
		// if already login, redirect to dashboard of logged in user, whether admin or member
		if ($this->session->userdata('isLogin')){redirect(base_url($this->session->userdata('user_group').'/dashboard'));}
		$this->data['title'] = 'Sign In - '. $this->data['system_name'];
		$this->data['file_title'] = 'Sign In';
		$this->data['file'] = 'login';
		$this->load->view('authentication/index', $this->data);

	}
	public function register($param1 ='')
	{
		// if already login, redirect to dashboard of logged in user, whether admin or member
		if ($this->session->userdata('isLogin')){redirect(base_url($this->session->userdata('user_group').'/dashboard'));}
		$countries = file_get_contents(base_url('assets/countries.json'));
		$this->data['countries'] = json_decode($countries, true);
		$this->data['sponsor'] = $param1;
		$this->data['title'] = 'Sign Up - '. $this->data['system_name'];
		$this->data['file_title'] = 'Create Account';
		$this->data['file'] = 'register';
		$this->load->view('authentication/index', $this->data);
	}
	public function get_country_code(){
		list($country_name,$country_code)=explode('-',$this->input->post('country', true));
		$country_code      = str_replace(' ','',$country_code);
		echo $country_code;
	}
	public function forget_password()
	{
		// if already login, redirect to dashboard of logged in user, whether admin or member
		if ($this->session->userdata('isLogin')){redirect(base_url($this->session->userdata('user_group').'/dashboard'));}
		$this->data['title'] = 'Recover Password - '. $this->data['system_name'];
		$this->data['file'] = 'forget-password';
		$this->load->view('authentication/index', $this->data);
	}
	public function new_password($param1='')
	{
		// if already login, redirect to dashboard of logged in user, whether admin or member
		if ($this->session->userdata('isLogin')){redirect(base_url($this->session->userdata('user_group').'/dashboard'));}
		$this->data['key'] = $param1;
		$this->data['title'] = 'Reset Password - '. $this->data['system_name'];
		$this->data['file'] = 'new-password';
		$this->load->view('authentication/index', $this->data);
	}
	public function do_register($param1=""){
		// if already login, redirect to dashboard of logged in user, whether admin or member
		if ($this->session->userdata('isLogin')){redirect(base_url($this->session->userdata('user_group').'/dashboard'));}
		if ($this->input->post()){
			$this->session->set_flashdata('name', $this->input->post('name'));
			$this->session->set_flashdata('username', $this->input->post('username'));
			$this->session->set_flashdata('email', $this->input->post('email'));
			$this->session->set_flashdata('mobile', $this->input->post('mobile'));
			$this->session->set_flashdata('country', $this->input->post('country'));
			if ($this->general->get_system_var('register_without_sponsor') == '0'){
				if (empty($this->input->post('sponsor', true))){
					die(json_encode(array(
						'status' => 'error',
						'message' => 'Sponsor Required to complete registration',
					)));
				}
			}
			
			// matrix and matrix type, can be updated only once while installing system
			$matrix = $this->general->get_system_var('matrix');
			$matrix_type = $this->general->get_system_var('matrix_type');
			
			//checking if username already exists
			$username_exists = $this->user_account->username_exists($this->input->post('username', true));
			if ($username_exists){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Username already registered',
				)));
			}
			// validating password for any special character
			if(preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/", $this->input->post('username', true))){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Username contains illegal characters',
				)));
			}
			if ( preg_match('/\s/', $this->input->post('username', true)) ){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Username contains whitespace',
				)));
			}
			if(strlen($this->input->post('username', true)) < 4 || strlen($this->input->post('username', true)) > 12){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Username must be greater than 4 and less than 12 characters',
				)));
			}
			
			// User Needs to be entered in matrix table whether he has sponsor or not
			$binary['username'] = $this->input->post('username');
			// if user has a sponsor
			
			if (!empty($this->input->post('sponsor', true))){
				// checking whether sponsor user exists
				$sponsor_exists = $this->user_account->username_exists($this->input->post('sponsor', true));
				if ($sponsor_exists == false){
					die(json_encode(array(
						'status' => 'error',
						'message' => 'Sponsor not found',
					)));
				}
				
				
				$binary['direct_referral'] = $this->input->post('sponsor', true);
				if ($matrix == '2x'){
					if ($matrix_type == 'forced'){
						//checking if sponsor is valid for current matrix
						if ($this->matrix2x->is_matrix_user($this->input->post('sponsor', true), 'binary_2x')){
							//locating parent and available position for user to be placed in tree
							$binary_data = $this->matrix2x->find_matrix_parent($this->input->post('sponsor', true), 'binary_2x');
							$binary['binary_referral'] = $binary_data['referral'];
							$binary['position'] = $binary_data['position'];
						}
					} else {
						//selecting tree placement position of the sponsor
						$binary_data = $this->general->get_tbl_field('binary_2x_position', '*', 'username', $this->input->post('sponsor', true));
						if(count($binary_data)>0){
							$binary_position = $binary_data[0]['position'];
							$binary_user = $binary_data[0]['binary'];
						} else {
							//inserting default position of sponsor 
							$binary_record['username'] 	= $this->input->post('sponsor', true);
							$binary_record['binary'] 	= $this->input->post('sponsor', true);
							$binary_record['position'] 	= 'Left';
							$this->general->insert_data('binary_2x_position', $binary_record);
							$binary_position = 'Left';
							$binary_user = $this->input->post('sponsor', true);
						}
						
						//finding referral and available position for user to be placed in tree
						$binery_ref = $this->matrix2x->find_binary_referral($binary_user, $binary_position);
						if (!empty($binery_ref)){
							$binary['binary_referral'] = $binery_ref;
							$binary['position'] = $binary_position;
						} else {
							$binary['binary_referral'] = "";
							$binary['position'] = "";
						}
					}
				} elseif ($matrix == '3x'){
					if ($matrix_type == 'forced'){
						//checking if sponsor is valid for current matrix
						if ($this->matrix3x->is_matrix_user($this->input->post('sponsor', true), 'binary_3x')){
							
							//locating parent and available position for user to be placed in tree
							$binery_ref = $this->matrix3x->find_matrix_parent($this->input->post('sponsor', true), 'binary_3x');
							$binary['binary_referral'] = $binary_data['referral'];
							$binary['position'] = $binary_data['position'];
						}
					} else {
						//selecting tree placement position of the sponsor
						$binary_data = $this->general->get_tbl_field('binary_3x_position', '*', 'username', $this->input->post('sponsor', true));
						if(count($binary_data)>0){
							$binary_position = $binary_data[0]['position'];
							$binary_user = $binary_data[0]['binary'];
						} else {
							//inserting default position of sponsor 
							$binary_record['username'] 	= $this->input->post('sponsor', true);
							$binary_record['binary'] 	= $this->input->post('sponsor', true);
							$binary_record['position'] 	= 'Left';
							$this->general->insert_data('binary_3x_position', $binary_record);
							$binary_position = 'Left';
							$binary_user = $this->input->post('sponsor', true);
						}
						//finding referral and available position for user to be placed in tree
						$binery_ref = $this->matrix3x->find_binary_referral($binary_user, $binary_position);
						if (!empty($binery_ref)){
							$binary['binary_referral'] = $binery_ref;
							$binary['position'] = $binary_position;
						} else {
							$binary['binary_referral'] = "";
							$binary['position'] = "";
						}
					}
				}
			}
			if(strlen($this->input->post('name', true)) < 4 || strlen($this->input->post('name', true)) > 25){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Name must be greater than 4 chracters',
				)));
			}
			//validating email address
			if(!filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Invalid Email address format',
				)));
			}
			// checking if email already existed
			if ($this->user_account->email_exists($this->input->post('email', true)) == true){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Email already exists',
				)));
			} 
			if(strlen($this->input->post('password', true)) < 5 || strlen($this->input->post('password', true)) > 16){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Password must be greater than 5 chracters',
				)));
			}
			if ($this->input->post('password', true) !== $this->input->post('repassword', true)){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Passwords not match',
				)));
			}
			
			if ( preg_match('/\s/', $this->input->post('password', true)) ){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Password contains whitespace',
				)));
			}
			if (empty($this->input->post('country', true))){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Please select your country',
				)));
			}
			if (empty($this->input->post('mobile', true))){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Mobile Number Required',
				)));
			}
			$this->load->library('mobile_number');
			$mobile = new mobile_number();
			$is_mobile_valid = $mobile->is_valid_number($this->input->post('mobile', true));
			if ($is_mobile_valid == false){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Invalid Mobile number',
				)));
			}
			if ($this->user_account->mobile_exists($this->input->post('mobile', true)) == true){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Mobile Number already registered',
				)));
			} 
			
			
			list($country_name,$country_code) = explode('-',$this->input->post('country', true));
			
			$data['name'] = $this->input->post('name', true);
			$data['username'] = $this->input->post('username', true);
			$data['email'] = $this->input->post('email', true);
			$data['country'] = $country_name;
			$data['mobile'] = $mobile->system_number($this->input->post('mobile', true));
			$data['region_code'] = $mobile->region_code($this->input->post('mobile', true));
			$data['password'] = md5($this->input->post('password', true));
			$data['user_group'] = 'member';
			if ($this->general->get_system_var('email_verification_required') == '1'){
				$data['status'] = '0';
			} else {
				$data['status'] = '1';
			}
			$data['created'] = date('Y-m-d H:i:s');
			$save = $this->db->insert('users', $data);
			//$save = true;
			if ($save){
				$user_id = $this->db->insert_id();
				if (!empty($this->input->post('sponsor', true))){
					// sending notification to sponsor, if sponsor available
					$noti['username'] = $this->input->post('sponsor', true);
					$noti['msg_from'] = $this->input->post('username', true);
					$noti['message'] = $data['name'].' has signed up under you having username '.$this->input->post('username', true);
					$noti['dated'] = date('Y-m-d H:i:s');
					$this->db->insert('notifications', $noti);
				
					$email = $this->user_account->user_email($this->input->post('sponsor', true));
					if ($email){
						$s = strtotime($data['created']);
						$mail_options = array(
							'name' 			=> $this->input->post('name', true),
							'username' 		=> $this->input->post('username', true),
							'sponsor_username' 		=> $this->input->post('sponsor', true),
							'sponsor_name' 		=> $this->user_account->user_name($this->input->post('sponsor', true)),
							'system_name' 	=> $this->data['system_name'],
							'action_time' 	=> date('H:i:s', $s),
							'action_date' 	=> date('Y-m-d', $s)
						);
						$this->emails->send_type_email($email, 'new_referral_registered', $mail_options);
						$mobile = $this->user_account->user_mobile($this->input->post('sponsor', true));
						if ($mobile){
							$this->sms->send_type_sms($mobile, 'new_referral_registered', $mail_options);
						}
					}
				}
				if ($matrix == '2x'){
					// inserting user in 2x Matrix
					$save = $this->db->insert('binary_2x', $binary);
				} elseif ($matrix == '3x'){
					// inserting user in 3x Matrix
					$save = $this->db->insert('binary_3x', $binary);
				}
				if ($this->general->get_system_var('email_verification_required') == '1'){
					$key = $this->general->random_string(15);
					
					$keyData['user_id'] = $user_id;
					$keyData['key_code'] = $key;
					$keyData['type'] = 'email_verification';
					$keyData['status'] = 0;
					$keyData['dated'] = date('Y-m-d H:i:s');
					$this->db->insert('user_profile_key', $keyData);
					
					$message = base_url('auth/verify-email/').$key;
					$email_add = $this->input->post('email', true);
					$s = strtotime($keyData['dated']);
					$mail_options = array(
						'name' 			=> $this->input->post('name', true),
						'username' 		=> $this->input->post('username', true),
						'system_name' 	=> $this->data['system_name'],
						'email_activation_link' 	=> $message,
						'action_time' 	=> date('H:i:s', $s),
						'action_date' 	=> date('Y-m-d', $s)
					);
					$this->emails->send_type_email($email_add, 'email_confirmation', $mail_options);
					die(json_encode(array(
						'redirect' => 'yes',
						'url' => base_url('auth/login'),
						'status' => 'success',
						'message' => 'Account created successfully, Activation Link can be found in Email.',
					)));
				} else {
					die(json_encode(array(
						'redirect' => 'yes',
						'url' => base_url('auth/login'),
						'status' => 'success',
						'message' => 'Account created successfully.',
					)));
				}
				
			} else {
				die(json_encode(array(
					'status' => 'error',
					'message' => 'An error occured, please try again.',
				)));
			}
			
		} else {
			$this->session->set_flashdata('error', 'Invalid request sent.');
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit();
		}
	}
	public function verify_email($param1=''){
		//verifying email address by clicking link in email
		$link = $param1;
		$key_data = $this->general->get_tbl_field('user_profile_key', '*', 'key_code', $link);
		if (count($key_data)>0){
			if ($key_data[0]['status'] == 1){
				$this->session->set_flashdata('error', 'Link Expired.');
				redirect('auth/login');
			} else {
				$link_data['status'] = 1;
				$this->general->update_data('user_profile_key', 'key_code', $param1, $link_data);
				
				$userdata['status'] = 1;
				$this->general->update_data('users', 'id', $key_data[0]['user_id'], $userdata);
				$this->session->set_flashdata('success', 'Email successfully verified, Login now.');
				redirect(base_url('auth/login'));
			}
			
			exit();
		} else {
			$this->session->set_flashdata('error', 'Email not found in our records, Please register now.');
			redirect(base_url('auth/register'));
			exit();
		}
	}
	public function set_new_password($param1=''){
		//setting new password
		if ($this->input->post()){
			if (strlen($this->input->post('password', true))<5){
				$this->session->set_flashdata('error', 'Password must contain atleast 5 characters.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
			if ($this->input->post('password', true) !== $this->input->post('repassword', true)){
				$this->session->set_flashdata('error', 'Passwords don\'t match.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
			$key = $this->input->post('key', true);
			// validating token against ugainst for allowing user to set new password
			$data = $this->general->get_tbl_field_where2('user_profile_key', '*', 'key_code', $key, 'type', 'password_reset');
			if (count($data)>0){
				if ($data[0]['status'] == 1){
					$this->session->set_flashdata('error', 'Link Expired.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$userdata = $this->general->get_tbl_field('users', '*', 'id', $data[0]['user_id']);
				if (count($userdata)>0){
					if ($userdata[0]['status'] == 2){
						$this->session->set_flashdata('error', 'Your account has been blocked, please contact department for further information.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						$link_data['status'] = 1;
						$this->general->update_data('user_profile_key', 'key_code', $key, $link_data);
						
						$usernewdata['password'] = md5($this->input->post('repassword', true));
						$this->general->update_data('users', 'id', $data[0]['user_id'], $usernewdata);
						$this->session->set_flashdata('success', 'Password successfully updated, Login now.');
						if ($param1 == 'front'){
							redirect(base_url('site/login'));
						} else {
							redirect(base_url('auth/login'));
						}
					}
				} else {
					$this->session->set_flashdata('error', 'Record not found.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid token provided.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
		} else {
			$this->session->set_flashdata('error', 'Invalid request sent.');
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit();
		}
	}
	
	
	public function do_login($role=""){
		
		if ($this->input->post()){
			// if already login, redirect to dashboard of logged in user, whether admin or member
			if ($this->session->userdata('isLogin')){redirect(base_url($this->session->userdata('user_group').'/dashboard'));}
			// verifying email aand password
			$login = $this->user_account->verify_login($this->input->post('email', true), $this->input->post('password', true));
			if ($login == true){
				$data = $this->user_account->get_user_data($this->input->post('email', true));
				if (count($data)>0){
					
					if ($data[0]['status'] == 0){
						$this->session->set_flashdata('error', 'Please verify your email address to continue.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
						
					} elseif ($data[0]['status'] == 2){
						$this->session->set_flashdata('error', 'Account Suspended, Please Contact department for further details.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
						
					} else {
						$sessiondata = array(
							'isLogin'		=>	true,
							'user_name'		=>	$data[0]['username'],
							'user_group'	=>	$data[0]['user_group'],
							'user_id'		=>	$data[0]['id']
						);
						if ($this->general->get_system_var('2fa_auth_status') == '0'){
							$this->session->set_userdata($sessiondata);
							$this->session->set_flashdata('success', 'Login Successful.');
							if ($data[0]['user_group'] == 'admin'){
								redirect(base_url('admin'));
							} elseif ($data[0]['user_group'] == 'member'){
								redirect(base_url('member'));
							}
							exit();
						} else {
							$teo_factor_sess_data = array(
								'name_fa2'			=>	$data[0]['name'],
								'user_name_fa2'		=>	$data[0]['username'],
								'user_group_fa2'	=>	$data[0]['user_group'],
								'user_id_fa2'		=>	$data[0]['id'],
								'user_email_fa2'	=>	$data[0]['email'],
								'two_factor_auth_code'		=>	$this->general->five_digit_key(),
							);
							$this->session->set_userdata($teo_factor_sess_data);
							
							$s = strtotime(date('Y-m-d H:i:s'));
							$mail_options = array(
								'name' 			=> $data[0]['name'],
								'username' 		=> $data[0]['username'],
								'system_name' 	=> $this->data['system_name'],
								'two_factor_code' 		=> $teo_factor_sess_data['two_factor_auth_code'],
								'action_time' 	=> date('H:i:s', $s),
								'action_date' 	=> date('Y-m-d', $s)
							);
							$this->emails->send_type_email($data[0]['email'], 'two_factor_login', $mail_options);
							$mobile = $this->user_account->user_mobile($data[0]['username']);
							if ($mobile){
								$this->sms->send_type_sms($mobile, 'two_factor_login', $mail_options);
							}
							$this->session->set_flashdata('warning', 'Please enter verification code. you received in your provided email.');
							redirect(base_url('auth/two-factor-authentication'));
							exit();
							
							
						}
						
					}
					
				} else {
					$this->session->set_flashdata('error', 'Invalid Credentials Entered.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Credentials Entered.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
				
			
		} else {
			$this->session->set_flashdata('error', 'Invalid request sent.');
			redirect(base_url('auth/login'));
			exit();
		}
	}
	public function two_factor_authentication($param1=''){
		if ($param1 == ''){
			if ($this->session->userdata('two_factor_auth_code')){
				$this->data['title'] = 'Two Factor Authentication - '. $this->data['system_name'];
				$this->data['file_title'] = 'Two Factor Authentication';
				$this->data['file'] = 'two_factor_auth';
				$this->load->view('authentication/index', $this->data);
			} else {
				$this->session->set_flashdata('error', 'Invalid Credentials Entered.');
				redirect(base_url('auth/login'));
				exit();
			}
		} elseif ($param1 == 'resend') {
			$key = $this->general->five_digit_key();
			
			$s = strtotime(date('Y-m-d H:i:s'));
			$mail_options = array(
				'name' 			=> $this->session->userdata('name_fa2'),
				'username' 		=> $this->session->userdata('user_name_fa2'),
				'system_name' 	=> $this->data['system_name'],
				'two_factor_code' 		=> $key,
				'action_time' 	=> date('H:i:s', $s),
				'action_date' 	=> date('Y-m-d', $s)
			);
			$this->emails->send_type_email($this->session->userdata('user_email_fa2'), 'two_factor_login', $mail_options);
			$mobile = $this->user_account->user_mobile($this->session->userdata('user_name_fa2'));
			if ($mobile){
				$this->sms->send_type_sms($mobile, 'two_factor_login', $mail_options);
			}
			$this->session->set_userdata('two_factor_auth_code', $key);
			$this->session->set_flashdata('success', 'Code sent again.');
			redirect(base_url('auth/two-factor-authentication'));
			exit();
		} elseif ($param1 == 'verify') {
			if ($this->input->post()){
				if ($this->input->post('two_factor_auth_code') == $this->session->userdata('two_factor_auth_code')){
					$sessiondata = array(
						'isLogin'		=>	true,
						'user_name'		=>	$this->session->userdata('user_name_fa2'),
						'user_group'	=>	$this->session->userdata('user_group_fa2'),
						'user_id'		=>	$this->session->userdata('user_id_fa2')
					);
					$this->session->set_userdata($sessiondata);
					
					$this->session->set_userdata('two_factor_auth_code', false);
					$this->session->set_userdata('name_fa2', false);
					$this->session->set_userdata('user_name_fa2', false);
					$this->session->set_userdata('user_group_fa2', false);
					$this->session->set_userdata('user_email_fa2', false);
					$this->session->set_userdata('user_id_fa2', false);
					
					
					$this->session->set_flashdata('success', 'Login Successful.');
					if ($this->session->userdata('user_group') == 'admin'){
						redirect(base_url('admin'));
					} elseif ($this->session->userdata('user_group') == 'member'){
						redirect(base_url('member'));
					}
					exit();
					
				} else {
					$this->session->set_flashdata('error', 'Incorrect Code, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('auth/login'));
				exit();
			}
		}
		
	}
	public function recover_password($param1=''){
		// if already login, redirect to dashboard of logged in user, whether admin or member
		if ($this->session->userdata('isLogin')){redirect(base_url($this->session->userdata('user_group').'/dashboard'));}
		if ($this->input->post()){
			if (empty($this->input->post('email', true))){
				$this->session->set_flashdata('error', 'Invalid Credentials.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
			$data = $this->general->get_tbl_field('users', '*', 'email', $this->input->post('email', true));
			if (count($data)>0){
				$key = $this->general->random_string(15);
				
				$keyData['user_id'] = $data[0]['id'];
				$keyData['key_code'] = $key;
				$keyData['type'] = 'password_reset';
				$keyData['status'] = 0;
				$keyData['dated'] = date('Y-m-d H:i:s');
				$this->db->insert('user_profile_key', $keyData);
				$message = base_url('auth/new-password/').$key;
				
				$email_add = $this->input->post('email', true);
				
				$s = strtotime(date('Y-m-d H:i:s'));
				$mail_options = array(
					'name' 			=> $data[0]['name'],
					'username' 		=> $data[0]['username'],
					'system_name' 	=> $this->data['system_name'],
					'password_reset_link' 	=> $message,
					'action_time' 	=> date('H:i:s', $s),
					'action_date' 	=> date('Y-m-d', $s)
				);
				$this->emails->send_type_email($email_add, 'password_reset', $mail_options);

			}
			$this->session->set_flashdata('success', 'If we find your email in our record, we wil send you a recovery email.');
			redirect(base_url('auth/login'));
			exit();
		} else {
			$this->session->set_flashdata('error', 'Invalid Request sent.');
			redirect(base_url('auth/forget-password'));
			
			exit();
		}
	}
	
	public function logout()
	{
		// deleting sessions and logging user out
		$this->session->set_userdata('isLogin', FALSE);
		$this->session->set_userdata('user_group', FALSE);
		$this->session->set_userdata('user_id', FALSE);
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
