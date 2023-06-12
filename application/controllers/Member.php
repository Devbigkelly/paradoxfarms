<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->data['system_name'] = $this->general->get_system_var('system_name');
		$this->limit = 5;
		// if usergroup is not member, redirect to login page
		if ($this->session->userdata('user_group') !== 'member'){redirect(base_url('auth/login'));}
		$currency = $this->session->userdata('currency');
		if(!isset($currency)){
			$def_currency = $this->returns->default_currency($this->session->userdata('user_name'));
			$this->session->set_userdata('currency',$def_currency);
		}
	}
	
	public function dashboard(){
		$line_chart = $this->dashboards->line_chart_data($this->session->userdata('user_name'));
		$bar_chart 	= $this->dashboards->bar_chart_data($this->session->userdata('user_name'));
		$this->data['line_chart_direct'] = json_encode($line_chart['direct']);
		$this->data['line_chart_binary'] = json_encode($line_chart['binary']);
		$this->data['line_chart_months'] = json_encode($line_chart['months']);
		$this->data['bar_chart_income'] = json_encode($bar_chart['income']);
		$this->data['bar_chart_months'] = json_encode($bar_chart['months']);
		
		$this->data['dash'] = $this->dashboards->user_dashboard($this->session->userdata('user_name'));
		$bonus_chart = array(
			array(1, $this->data['dash']['psb'] + 0),
			array(2, $this->data['dash']['nbb'] + 0),
			array(3, $this->data['dash']['gb'] + 0),
			array(4, $this->data['dash']['rgb'] + 0),
			array(5, $this->data['dash']['roi'] + 0),
			array(6, $this->data['dash']['matching_roi']),
		);
		$this->data['bonus_chart'] = json_encode($bonus_chart);
		$this->data['file'] = 'home';
		$this->data['title'] = 'Dashboard';
		$this->data['page_title'] = 'Dashboard';
		$this->load->view('backoffice/index', $this->data);
	}
	public function index()
	{
		redirect('member/dashboard');
	}
	///////////CURRENCY//////////////
	function set_currency($currency)
    {
        $this->session->set_userdata('currency', $currency);
		$data['default_currency'] = $currency;
		$this->general->update_data('users', 'username', $this->session->userdata('user_name'), $data);
		header("Location: {$_SERVER['HTTP_REFERER']}");
    }
	public function transaction($param1=''){
		// transaction POPUP when user clicks on transaction ID
		$this->data['tranxs'] = $this->general->get_tbl_field_where2('transactions', '*', 'username', $this->session->userdata('user_name'), 'transaction_id', $param1);
		$this->load->view('modal/transaction', $this->data);
	}
	public function add_referral($username='', $position=''){
		// add referral from genealogy POPUP when user clicks on Black space in genealogy
		$countries = file_get_contents(base_url('assets/countries.json'));
		$this->data['countries'] = json_decode($countries, true);
		$this->data['direct_referral'] = $username;
		$this->data['binary_referral'] = $username;
		$this->data['position'] = ucfirst($position);
		$this->load->view('modal/add_referral', $this->data);
	}
	public function save_referral(){
		if ($this->input->post()){
			$matrix = $this->general->get_system_var('matrix');
			$matrix_type = $this->general->get_system_var('matrix_type');
			if ($matrix == '2x'){
				if ($this->matrix2x->is_position_available($this->input->post('binary_referral', true), $this->input->post('position', true)) == false){
					die(json_encode(array(
						'status' => 'error',
						'message' => 'Selected space already filled',
					)));
				}
			} else {
				if ($this->matrix3x->is_position_available($this->input->post('binary_referral', true), $this->input->post('position', true)) == false){
					die(json_encode(array(
						'status' => 'error',
						'message' => 'Selected space already filled',
					)));
				}
			}
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
			if(empty($this->input->post('country', true))){
				die(json_encode(array(
					'status' => 'error',
					'message' => 'Please select your country',
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
			if ($save){
				$user_id = $this->db->insert_id();
				$binary['username'] = $this->input->post('username', true);
				$binary['direct_referral'] = $this->input->post('direct_referral', true);
				$binary['binary_referral'] = $this->input->post('binary_referral', true);
				$binary['position'] = $this->input->post('position', true);
				if ($matrix == '2x'){
					// inserting user in 2x Matrix
					$save = $this->db->insert('binary_2x', $binary);
				} elseif ($matrix == '3x'){
					// inserting user in 3x Matrix
					$save = $this->db->insert('binary_3x', $binary);
				}
				// sending notification to sponsor
				$noti['username'] = $this->input->post('direct_referral', true);
				$noti['msg_from'] = $this->input->post('username', true);
				$noti['message'] = $data['name'].' has signed up under you having username '.$this->input->post('username', true);
				$noti['dated'] = date('Y-m-d H:i:s');
				$this->db->insert('notifications', $noti);
			
				$email = $this->user_account->user_email($this->input->post('direct_referral', true));
				if ($email){
					$s = strtotime($data['created']);
					$mail_options = array(
						'name' 			=> $this->input->post('name', true),
						'username' 		=> $this->input->post('username', true),
						'sponsor_username' 		=> $this->input->post('direct_referral', true),
						'sponsor_name' 		=> $this->user_account->user_name($this->input->post('direct_referral', true)),
						'system_name' 	=> $this->data['system_name'],
						'action_time' 	=> date('H:i:s', $s),
						'action_date' 	=> date('Y-m-d', $s)
					);
					$this->emails->send_type_email($email, 'new_referral_registered', $mail_options);
					$mobile = $this->user_account->user_mobile($this->input->post('direct_referral', true));
					if ($mobile){
						$this->sms->send_type_sms($mobile, 'new_referral_registered', $mail_options);
					}
				}
				// sending notification to sponsor
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
						'url' => $_SERVER['HTTP_REFERER'],
						'status' => 'success',
						'message' => 'Account created successfully, Activation Link can be found in Email.',
					)));
				} else {
					die(json_encode(array(
						'redirect' => 'yes',
						'url' => $_SERVER['HTTP_REFERER'],
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
			$this->session->set_flashdata('error', 'Invalid Request sent.');
			redirect(base_url('member/dashboard'));
			exit();
		}
	}
	
	
	public function kyc($param1 = ''){
		if ($this->general->get_system_var('kyc_status') == '0'){
			$this->session->set_flashdata('error', 'KYC Disabled.');
			redirect(base_url('member/dashboard'));
			exit();
		}
		if ($param1 == ''){
			$is_verified = $this->kyc_model->is_kyc_verified($this->session->userdata('user_name'));
			if ($is_verified == true){
				$this->data['file'] = 'kyc_confirmation';
			} else {
				if ($this->kyc_model->is_kyc_provided($this->session->userdata('user_name')) == true){
					$this->data['file'] = 'kyc_waiting';
				} else {
					$this->data['data'] = $this->general->get_all_tbl_data('kyc_requirements', 'id, document_title');
					$this->data['file'] = 'kyc_form';
				}
				
			}
			
			$this->data['title'] = 'KYC';
			$this->data['page_title'] = 'KYC';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'upload') {
			if ($this->input->post()){
				if (empty($this->input->post('kyc_requirement_id'))){
					$this->session->set_flashdata('error', 'Please select documnent title.');
					redirect(base_url('member/kyc'));
					exit();
				}
				$doc_title = $this->kyc_model->doc_title_by_id($this->input->post('kyc_requirement_id', true));
				if ($doc_title){
					$validextensions = array("jpg", "jpeg", "png", "PNG", "xlxx", "xlsx", "pdf", "doc", "docx");
					$response = $this->general->upload_media($_FILES["file"], $validextensions);
					if ($response['status'] == 'error'){
						$this->session->set_flashdata('error', $response['message']);
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						$file = $response['directory'].'/'.$response['file_name'];
						
						$data['username'] = $this->session->userdata('user_name');
						$data['kyc_requirement_id'] = $this->input->post('kyc_requirement_id', true);
						$data['document'] = $doc_title;
						$data['file'] = $file;
						$data['status'] = '0';
						$data['dated'] = date('Y-m-d H:i:s');
						$save = $this->db->insert('kyc_user_docs', $data);
						if ($save){
							$this->session->set_flashdata('success', 'Document sumbitted successfully.');
							redirect(base_url('member/kyc'));
							exit();
						} else {
							$this->session->set_flashdata('error', 'An error occured, please try again.');
							redirect(base_url('member/kyc'));
							exit();
						}
					}
				} else {
					$this->session->set_flashdata('error', 'An error occured, please try again.');
					redirect(base_url('member/kyc'));
					exit();
				}
				
			} else {
				$this->session->set_flashdata('error', 'Invalid Request sent.');
				redirect(base_url('member/kyc'));
				exit();
			}
		} else {
			$this->error_404();
		}
		
	}
	public function wallet_history(){
		$username = $this->session->userdata('user_name');
		$this->data['data'] = $this->general->get_tbl_field('wallet_statement', '*', 'username', $username);
		$this->data['file'] = 'wallet_statement';
		$this->data['title'] = 'Wallet History';
		$this->data['page_title'] = 'Wallet History';
		$this->load->view('backoffice/index', $this->data);
	}
	public function wallet_history_ajax(){
		$username = $this->session->userdata('user_name');
		if (isset($_POST['start'])){
			$row = $_POST['start'];
		} else {
			$row = 0;
		}
		if (isset($_POST['draw'])){
			$draw = $_POST['draw'];
		} else {
			$draw = $this->limit;
		}
		if (isset($_POST['length'])){
			$rowperpage = $_POST['length'];
		} else {
			$rowperpage = $this->limit;
		}
		
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$_POST['search']['value'];
		
		$data = array();
		$record = array();
		$total_record = 0;
		$total_record = $this->dashboards->wallet_history_total_entries($username);
		$record = $this->db->query('SELECT tranx_id, message, type, username, amount, total, dated FROM wallet_statement WHERE username="'.$username.'" ORDER by '.$columnName.' '.$columnSortOrder.' LIMIT '.$row.', '.$rowperpage.'')->result_array();
		if (count($record)>0){
			foreach ($record as  $key => $res){
				$r['id'] = $key + 1 + $row;
				$r['tranx_id'] = modal_anchor(get_uri("member/transaction/".$res['tranx_id']), $res['tranx_id'], array("class" => "view ico-circle", "title" => 'Transaction Details'));;
				$r['message'] = $res['message'];
				$r['type'] = $res['type'];
				$r['amount'] = currency($res['amount']);
				$r['total'] = currency($res['total']);
				$r['dated'] = $res['dated'];
				$data[] = $r;
			}
		}
		$results = array(
		  "draw" => intval($draw),
		  "iTotalRecords" => $total_record,
		  "iTotalDisplayRecords" => $total_record,
		  "aaData" => $data
		);
		echo json_encode($results);	
	}
	public function income($param1=''){
		// income history by passing parameter income type in URL
		if ($param1 == 'personal-sponsor-bonus'){
			$this->data['file'] = 'psb-history';
			$this->data['title'] = 'Personal Sponsor Bonus';
			$this->data['page_title'] = 'Personal Sponsor Bonus';
		} elseif ($param1 == 'network-binary-bonus'){
			$this->data['file'] = 'nbb-history';
			$this->data['title'] = 'Network Binary Bonus';
			$this->data['page_title'] = 'Network Binary Bonus';
		} elseif ($param1 == 'generation-bonus'){
			$this->data['file'] = 'gb-history';
			$this->data['title'] = 'Generation Bonus';
			$this->data['page_title'] = 'Generation Bonus';
		} elseif ($param1 == 'reverse-generation-bonus'){
			$this->data['file'] = 'rgb-history';
			$this->data['title'] = 'Reverse Generation Bonus';
			$this->data['page_title'] = 'Reverse Generation Bonus';
		} elseif ($param1 == 'roi'){
			$this->data['file'] = 'roi-history';
			$this->data['title'] = 'Return on Investment (ROI)';
			$this->data['page_title'] = 'Return on Investment (ROI)';
		} elseif ($param1 == 'matching-roi'){
			$this->data['file'] = 'matching-roi-history';
			$this->data['title'] = 'Return on Investment (ROI)';
			$this->data['page_title'] = 'Matching ROI';
		} else {
			$this->error_404();
		}
		$this->load->view('backoffice/index', $this->data);
	}
	public function income_ajax($param1=''){
		$username 	= $this->session->userdata('user_name');
		if (isset($_POST['start'])){
			$row = $_POST['start'];
		} else {
			$row = 0;
		}
		if (isset($_POST['draw'])){
			$draw = $_POST['draw'];
		} else {
			$draw = $this->limit;
		}
		if (isset($_POST['length'])){
			$rowperpage = $_POST['length'];
		} else {
			$rowperpage = $this->limit;
		}
		
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$_POST['search']['value'];
		
		$data = array();
		$record = array();
		$total_record = 0;
		if ($param1 == 'personal-sponsor-bonus' || 
			$param1 == 'network-binary-bonus' || 
			$param1 == 'generation-bonus' || 
			$param1 == 'reverse-generation-bonus' || 
			$param1 == 'roi' || 
			$param1 == 'matching-roi'){
				$total_record = $this->dashboards->income_total_entries($param1, $username);
				$record = $this->db->query('SELECT tranx_id, username, amount, dated FROM income WHERE username="'.$username.'" AND type="'.$param1.'" ORDER by '.$columnName.' '.$columnSortOrder.' LIMIT '.$row.', '.$rowperpage.'')->result_array();
		}
		if (count($record)>0){
			foreach ($record as $key => $res){
				$r['id'] = $key + 1 + $row;
				$r['tranx_id'] = modal_anchor(get_uri("member/transaction/".$res['tranx_id']), $res['tranx_id'], array("class" => "view ico-circle", "title" => 'Transaction Details'));;
				$r['amount'] = currency($res['amount']);
				$r['dated'] = $res['dated'];
				$data[] = $r;
			}
		}
		$results = array(
		  "draw" => intval($draw),
		  "iTotalRecords" => $total_record,
		  "iTotalDisplayRecords" => $total_record,
		  "aaData" => $data
		);
		echo json_encode($results);	
	}
	public function placement_settings($param1='', $param2=''){
		//TREE Placemenet settings whether user wants to be placed on left or center or right, By default it is Left
		$username 	= $this->session->userdata('user_name');
		$type = $this->general->get_system_var('matrix_type');
		if ($type == 'forced'){
			$this->session->set_flashdata('error', 'Custom Placement does not on forced matrix.');
			redirect(base_url('member/dashboard'));
			exit();
		}
		$matrix = $this->general->get_system_var('matrix');
		if ($param1 == '' && $param2 == ''){
			if ($matrix == '2x'){
				$this->data['file'] = 'tree_2x_settings';
				$tree_data = $this->general->get_tbl_field('binary_2x_position', '*', 'username', $this->session->userdata('user_name'));
			} else {
				$this->data['file'] = 'tree_3x_settings';
				$tree_data = $this->general->get_tbl_field('binary_3x_position', '*', 'username', $this->session->userdata('user_name'));
			}
			if (count($tree_data)>0){
				$this->data['tree_data'] = $tree_data;
			} else {
				$data['username'] 	= $this->session->userdata('user_name');
				$data['binary'] 	= $this->session->userdata('user_name');
				$data['position'] 	= 'Left';
				if ($matrix == '2x'){
					// updating 2x matrix placement setting
					$this->general->insert_data('binary_2x_position', $data);
					$this->data['tree_data'] = $this->general->get_tbl_field('binary_2x_position', '*', 'username', $this->session->userdata('user_name'));
				} else {
					// updating 3x matrix placement setting
					$this->general->insert_data('binary_3x_position', $data);
					$this->data['tree_data'] = $this->general->get_tbl_field('binary_3x_position', '*', 'username', $this->session->userdata('user_name'));
				}
			}
			$this->data['title'] = 'Tree Settings';
			$this->data['page_title'] = 'Tree Settings';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'update' && $param2 == '2x'){
			// Updating placement settings for 2x Matrix
			if ($this->input->post()){
				if (empty($this->input->post('username', true))){
					$this->session->set_flashdata('error', 'Please Enter Username.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if ($this->input->post('username', true) == $username){
					$data['binary'] 	= $this->input->post('username', true);
					$data['position'] 	= $this->input->post('position', true);
					$this->general->update_data('binary_2x_position', 'username', $username, $data);
					$this->session->set_flashdata('success', 'Binary Settings updated Successfully.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$binaries = $this->matrix2x->getChildrenForPlacement($username);
					if (in_array($this->input->post('username', true), $binaries)){
						$data['binary'] 	= $this->input->post('username', true);
						$data['position'] 	= $this->input->post('position', true);
						$this->general->update_data('binary_2x_position', 'username', $username, $data);
						$this->session->set_flashdata('success', 'Tree settings updated successfully.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						$this->session->set_flashdata('error', 'User Not Found.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
				}
				
			} else {
				$this->session->set_flashdata('error', 'Invalid Request Sent.');
				redirect(base_url('member/placement-settings'));
				exit();
			}
		} elseif ($param1 == 'update' && $param2 == '3x'){
			// Updating placement settings for 3x Matrix
			if ($this->input->post()){
				if (empty($this->input->post('username', true))){
					$this->session->set_flashdata('error', 'Please Enter Username.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if ($this->input->post('username', true) == $username){
					$data['binary'] 	= $this->input->post('username', true);
					$data['position'] 	= $this->input->post('position', true);
					$this->general->update_data('binary_3x_position', 'username', $username, $data);
					$this->session->set_flashdata('success', 'Binary Settings updated Successfully.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$binaries = $this->matrix3x->getChildrenForPlacement($username);
					if (in_array($this->input->post('username', true), $binaries)){
						$data['binary'] 	= $this->input->post('username', true);
						$data['position'] 	= $this->input->post('position', true);
						$this->general->update_data('binary_3x_position', 'username', $username, $data);
						$this->session->set_flashdata('success', 'Tree settings updated successfully.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						$this->session->set_flashdata('error', 'User Not Found.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Request Sent.');
				redirect(base_url('member/placement-settings'));
				exit();
			}
		} else {
			$this->error_404();
		}
	}
	public function genealogy($param1='', $param2=''){
		// Genealogy view for 2x Matrix, 2x Forced Matrix, 3x Matrix and 3x Forced Matrix
		$matrix = $this->general->get_system_var('matrix');
		$type = $this->general->get_system_var('matrix_type');
		if ($matrix == '2x'){
			if ($type == 'forced'){
				$this->data['file'] = 'genealogy-2x-forced';
			} else {
				$this->data['file'] = 'genealogy-2x';
			}
			$this->data['table'] = 'binary_2x';
		} elseif ($matrix == '3x'){
			if ($type == 'forced'){
				$this->data['file'] = 'genealogy-3x-forced';
			} else {
				$this->data['file'] = 'genealogy-3x';
			}
			$this->data['table'] = 'binary_3x';
		}
		
		if($param1 == ''){
			// where genealogy view of logged in user 
			$this->data['username'] = $this->session->userdata("user_name");
		} else {
			// where genealogy view of user with username passed in url
			$this->data['username'] = $param1;
		}
		$this->data['title'] = 'Genealogy';
		$this->data['page_title'] = 'Genealogy';
		$this->load->view('backoffice/index', $this->data);
	}
	public function genealogy_referrals($param1=''){
		$username = $this->session->userdata("user_name");
		$matrix = $this->general->get_system_var('matrix');
		if ($param1 == 'parents'){
			if ($matrix == '2x'){
				$this->data['data'] = $this->matrix2x->getParentsArray($username, 'binary_2x');
			} elseif ($matrix == '3x') {
				$this->data['data'] = $this->matrix3x->getParentsArray($username, 'binary_3x');
			}
			$this->data['file'] = 'tree_parents';
			$this->data['title'] = 'Parents in Tree';
			$this->data['page_title'] = 'Parents in Tree';
		} elseif ($param1 == 'children'){
			if ($matrix == '2x'){
				$this->data['data'] = $this->matrix2x->getChildrenArray($username, 'binary_2x');
			} elseif ($matrix == '3x') {
				$this->data['data'] = $this->matrix3x->getChildrenArray($username, 'binary_3x');
			}
			$this->data['file'] = 'tree_childs';
			$this->data['title'] = 'Children in Tree';
			$this->data['page_title'] = 'Children in Tree';
		} elseif ($param1 == 'left'){
			if ($matrix == '2x'){
				$this->data['data'] = $this->matrix2x->get_leg($username, 'Left');
			} elseif ($matrix == '3x') {
				$this->data['data'] = $this->matrix3x->get_leg($username, 'Left');
			}
			$this->data['file'] = 'tree_left_childs';
			$this->data['title'] = 'Left Children in Tree';
			$this->data['page_title'] = 'Left Children in Tree';
		} elseif ($param1 == 'right'){
			if ($matrix == '2x'){
				$this->data['data'] = $this->matrix2x->get_leg($username, 'Right');
			} elseif ($matrix == '3x') {
				$this->data['data'] = $this->matrix3x->get_leg($username, 'Right');
			}
			$this->data['file'] = 'tree_right_childs';
			$this->data['title'] = 'Right Children in Tree';
			$this->data['page_title'] = 'Right Children in Tree';
		} else {
			$this->error_404();
		}
		$this->load->view('backoffice/index', $this->data);
	}
	public function referrals($param1='', $param2='', $param3=''){
		if ($param2 == ''){
			$username = $this->session->userdata('user_name');
		} else {
			$username = $param2;
		}
		$matrix = $this->general->get_system_var('matrix');
		if ($param1 == 'list-view' || $param1 == 'card-view'){
			if ($matrix == '2x'){
				$this->data['data'] = $this->general->get_tbl_field('binary_2x', '*', 'direct_referral', $username);
			} else {
				$this->data['data'] = $this->general->get_tbl_field('binary_3x', '*', 'direct_referral', $username);
			}
		} else {
			if ($matrix == '2x'){
				$this->data['data'] = $this->matrix2x->direct_genealogy($username);
			} else { 
				$this->data['data'] = $this->matrix3x->direct_genealogy($username);
			}
			
		}
		
		if ($param1 == 'list-view'){
			// list view of personal referrals
			$this->data['username'] = $username;
			$this->data['file'] = 'referrals_list';
			$this->data['title'] = 'Referrals List';
			$this->data['page_title'] = 'Referrals List';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'card-view'){
			// block view of personal referrals
			$this->data['username'] = $username;
			$this->data['file'] = 'referrals_card';
			$this->data['title'] = 'Referrals Cards';
			$this->data['page_title'] = 'Referrals Cards';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'genealogy'){
			// block view of personal referrals
			$this->data['username'] = $username;
			$this->data['file'] = 'referrals_genealogy';
			$this->data['title'] = 'Referrals Genealogy';
			$this->data['page_title'] = 'Referrals Genealogy';
			$this->load->view('backoffice/index', $this->data);
		} else {
			$this->error_404();
		}
	}
	public function products($param1='', $param2='', $param3=''){
		$username = $this->session->userdata('user_name');
		if ($param1 == '' && $param2 == ''){
			// active payment gateways, can be managed from admin panel
			$this->data['payment_gateways'] = json_decode($this->general->get_system_var('active_payment_methods'), true);
			$this->data['data'] = $this->general->get_all_tbl_data('products', '*');
			$this->data['file'] = 'products_list';
			$this->data['title'] = 'Products';
			$this->data['page_title'] = 'Products';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'purchase-history' && $param2 == ''){
			$this->data['data'] = $this->general->get_tbl_field('purchase', '*', 'username', $username);
			$this->data['file'] = 'purchase_history';
			$this->data['title'] = 'Purchase History';
			$this->data['page_title'] = 'Purchase History';
			$this->load->view('backoffice/index', $this->data);
		} else {
			$this->error_404();
		}
	}
	
	

	public function faqs($param1='', $param2=''){
		//frequently asked questions
		$this->data['data'] = $this->general->get_all_data_by_order('faqs', '*', 'id', 'ASC');
		$this->data['file'] = 'faqs';
		$this->data['title'] = 'Frequently Asked Questions';
		$this->data['page_title'] = 'Frequently Asked Questions';
		$this->load->view('backoffice/index', $this->data);
	}
	public function support($param1='', $param2='', $param3=''){
		if ($param1 == ''){
			// Support tickets and generate new ticket
			$this->data['file'] = 'support';
			$this->data['title'] = 'Support';
			$this->data['page_title'] = 'Support';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'tickets' && $param2 == 'closed'){
			//Tickets with closed status
			$this->data['data'] = $this->general->get_tbl_field_where2('support_ticket', '*', 'username', $this->session->userdata('user_name'), 'status', 'closed');
			$this->data['type'] = 'closed';
			$this->data['file'] = 'tickets';
			$this->data['title'] = 'Closed Tickets';
			$this->data['page_title'] = 'Closed Tickets';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'tickets' && $param2 == 'open'){
			//Tickets with open status
			$this->data['data'] = $this->general->get_tbl_field_where2('support_ticket', '*', 'username', $this->session->userdata('user_name'), 'status', 'open');
			$this->data['type'] = 'open';
			$this->data['file'] = 'tickets';
			$this->data['title'] = 'Open Tickets';
			$this->data['page_title'] = 'Open Tickets';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'ticket' && $param2 !== ''){
			//open any specific ticket of logged in user
			$this->data['ticket'] = $this->support->ticket_data($this->session->userdata('user_name'), $param2);
			if (count($this->data['ticket'])>0){
				$this->data['data'] = $this->support->get_ticket_data($this->data['ticket'][0]['id']);
				$this->data['file'] = 'ticket';
				$this->data['title'] = 'Support';
				$this->data['page_title'] = 'Ticket: '.$this->data['ticket'][0]['ticket_id'];
				$this->load->view('backoffice/index', $this->data);
			} else {
				$this->session->set_flashdata('error', 'Record not found.');
				redirect(base_url('member/support'));
				exit();
			}
			
		} elseif ($param1 == 'attachment'){
			//send attachment in support ticket message
			$validextensions = array("jpg", "jpeg", "png", "PNG");
			$logo_res = $this->general->upload_media($_FILES["file"], $validextensions);
			if ($logo_res['status'] == 'error'){
				$this->session->set_flashdata('error', $logo_res['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$image = $logo_res['directory'].'/'.$logo_res['file_name'];
				
				$data['ticket_id'] = $this->input->post('ticket_id', true);
				$data['text'] = $image;
				$data['username'] = $this->session->userdata('user_name');
				$data['is_attachment'] = 1;
				$data['updated'] = date('Y-m-d H:i:s');
				$inserd = $this->general->insert_data('support_ticket_data', $data);
				if ($inserd){
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			}
		} elseif ($param1 == 'send-message'){
			//send support message
			if ($this->input->post()){
				$data['ticket_id'] = $this->input->post('ticket_id', true);
				$data['text'] = strip_tags($this->input->post('message', true));
				$data['username'] = $this->session->userdata('user_name');
				$data['updated'] = date('Y-m-d H:i:s');
				$save = $this->general->insert_data('support_ticket_data', $data);
				if ($save == false){
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
				}
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
				
			} else {
				$this->session->set_flashdata('error', 'Invalid Request Sent.');
				redirect(base_url('member/support'));
				exit();
			}
		} elseif ($param1 == 'generate-ticket'){
			// generating new ticket
			if ($this->input->post()){
				if (strlen($this->input->post('title', true))<5){
					$this->session->set_flashdata('error', 'Title must contain atleast five chracters');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (strlen($this->input->post('message', true))<10){
					$this->session->set_flashdata('error', 'Please write you question');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$data['username'] = $this->session->userdata('user_name');
				$data['ticket_id'] = $this->general->generate_ref_id();
				$data['title'] = $this->input->post('title', true);
				$data['status'] = 'open';
				$data['updated'] = date('Y-m-d H:i:s');
				$ticket_id = $this->general->insert_data_for_id('support_ticket', $data);
				if (is_numeric($ticket_id)){
					$data2['ticket_id'] = $ticket_id;
					$data2['text'] = strip_tags($this->input->post('message', true));
					$data2['username'] = $this->session->userdata('user_name');
					$data2['updated'] = date('Y-m-d H:i:s');
					$inserd = $this->general->insert_data('support_ticket_data', $data2);
					
					redirect(base_url('member/support/ticket/'.$data['ticket_id']) . '', 'refresh');
					exit();
				} else{
					redirect(base_url('member/support') . '', 'refresh');
					exit();
				}
			} else {
				redirect(base_url('member/support') . '', 'refresh');
				exit();
			}
		} else {
			$this->error_404();
		}
	}
	public function withdraw($param1='', $param2='', $param3=''){
		
		$username = $this->session->userdata('user_name');
		
		if ($param1 == 'history'){
			// withdraw history
			$this->data['data'] = $this->general->get_tbl_field('withdraw', '*', 'username', $username);
			$this->data['file'] = 'withdraw_history';
			$this->data['title'] = 'Withdraw History';
			$this->data['page_title'] = 'Withdraw History';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'form' && $param2 == ''){
			if ($this->general->get_system_var('epin_status') == '1'){
				if ($this->user_account->epin_exists($username) == false){
					$this->session->set_flashdata('error', 'You must generate epin before performing any transaction.');
					redirect(base_url('member/profile/generate-epin'));
					exit();
				}
			}
			// withdraw form
			$this->data['methods'] = json_decode($this->general->get_system_var('withdraw_methods'));
			$this->data['withdraw_disabled'] = $this->returns->withdraw_disabled($username);
			$this->data['amount'] = $this->wallet->wallet_amount($username, 'wallet');
			$this->data['file'] = 'withdraw_form';
			$this->data['title'] = 'Withdraw Funds';
			$this->data['page_title'] = 'Withdraw Funds';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'form' && $param2 == 'do'){
			if ($this->returns->withdraw_disabled($username) == true){
				$this->session->set_flashdata('error', 'Withdraw Disabled, Please contact support for more information.');
				redirect(base_url('member/withdraw/form'));
				exit();
			}
			if ($this->kyc_model->is_kyc_verified($this->session->userdata('user_name')) == false){
				if ($this->kyc_model->is_kyc_provided($this->session->userdata('user_name')) == true){
					$this->session->set_flashdata('error', 'KYC Verification Pending, Please wait.');
				} else {
					$this->session->set_flashdata('error', 'KYC Verification Required.');
				}
				
				redirect(base_url('member/kyc'));
				exit();
			}
			// requesting withdraw and validating if user has enough balance for withdraw
			if ($this->input->post()){
				if ($this->general->get_system_var('epin_status') == '1'){
					if ($this->user_account->verify_epin($this->session->userdata('user_name'), $this->input->post('epin', true)) == false){
						$this->session->set_flashdata('error', 'Incorrect E-PIN');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
				}
				$response = $this->wallet->withdraw($this->session->userdata('user_name'), $this->input->post('amount', true), $this->input->post('method', true), $this->input->post('details', true));
				$this->session->set_flashdata($response['status'], $response['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('member/withdraw/form'));
				exit();
			}
		} else {
			$this->error_404();
		}
	}
	public function transfer($param1='', $param2='', $param3=''){
		
		if ($this->general->get_system_var('enable_transfer') == '0'){
			// checking whether internal transfer is disabled in admin panel
			$this->session->set_flashdata('error', 'Invalid request sent.');
			redirect(base_url('member/dashboard'));
			exit();
		}
		$username = $this->session->userdata('user_name');
		
		
		if ($param1 == 'history'){
			// transfers history
			$this->data['data'] = $this->db->query("SELECT * FROM transfers WHERE transfer_from='$username' OR transfer_to='$username'")->result_array();
			$this->data['file'] = 'transfer_history';
			$this->data['title'] = 'Transfer History';
			$this->data['page_title'] = 'Transfer History';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'form' && $param2 == ''){
			if ($this->general->get_system_var('epin_status') == '1'){
				if ($this->user_account->epin_exists($username) == false){
					$this->session->set_flashdata('error', 'You must generate epin before performing any transaction.');
					redirect(base_url('member/profile/generate-epin'));
					exit();
				}
			}
			// transfer form
			$this->data['amount'] = $this->wallet->wallet_amount($username, 'wallet');
			$this->data['transfer_disabled'] = $this->returns->transfer_disabled($username);
			$this->data['file'] = 'transfer_form';
			$this->data['title'] = 'Funds Transfer';
			$this->data['page_title'] = 'Funds Transfer';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'form' && $param2 == 'do'){
			if ($this->returns->transfer_disabled($username) == true){
				$this->session->set_flashdata('error', 'Transfer Disabled, Please contact support for more information.');
				redirect(base_url('member/transfer/form'));
				exit();
			}
			if ($this->kyc_model->is_kyc_verified($this->session->userdata('user_name')) == false){
				if ($this->kyc_model->is_kyc_provided($this->session->userdata('user_name')) == true){
					$this->session->set_flashdata('error', 'KYC Verification Pending, Please wait.');
				} else {
					$this->session->set_flashdata('error', 'KYC Verification Required.');
				}
				
				redirect(base_url('member/kyc'));
				exit();
			}
			//processing transfer and validating if user has enough amount to transfer
			if ($this->input->post()){
				if ($this->general->get_system_var('epin_status') == '1'){
					if ($this->user_account->verify_epin($this->session->userdata('user_name'), $this->input->post('epin', true)) == false){
						$this->session->set_flashdata('error', 'Incorrect E-PIN');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
				}
				$response = $this->wallet->transfer($this->session->userdata('user_name'), $this->input->post('username', true), $this->input->post('amount', true));
				
				$this->session->set_flashdata($response['status'], $response['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('member/transfer/form'));
				exit();
			}
		} else {
			$this->error_404();
		}
	}
	public function invitation($param1='', $param2=''){
		if ($this->general->get_system_var('invitation_status') == '0'){
			$this->session->set_flashdata('error', 'Action not allowed.');
			redirect(base_url('member/dashboard'));
			exit();
		}
		if ($param1 == ''){
			$this->data['file'] = 'invitation_form';
			$this->data['title'] = 'Invite New User';
			$this->data['page_title'] = 'Invite New User';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'do'){
			if ($this->input->post()){
				if (empty($this->input->post('name', true))){
					$this->session->set_flashdata('error', 'Invitee name required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('email', true))){
					$this->session->set_flashdata('error', 'Invitee email required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('mobile', true))){
					$this->session->set_flashdata('error', 'Invitee Mobile Number required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if(!filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)){
					$this->session->set_flashdata('error', 'Invalid Email address format');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if ($this->user_account->email_exists($this->input->post('email', true)) == true){
					$this->session->set_flashdata('error', 'Email already exists');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} 
				$this->load->library('mobile_number');
				$mobile = new mobile_number();
				$is_mobile_valid = $mobile->is_valid_number($this->input->post('mobile', true));
				if ($is_mobile_valid == false){
					$this->session->set_flashdata('error', 'Invalid Mobile number');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if ($this->user_account->mobile_exists($this->input->post('mobile', true)) == true){
					$this->session->set_flashdata('error', 'Mobile Number already registered');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (strlen($this->input->post('message', true)) < 10){
					$this->session->set_flashdata('error', 'Invitation message requires atleast 10 characters');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$data['username'] 		= $this->session->userdata('user_name');
				$data['invitee_name'] 	= $this->input->post('name', true);
				$data['invitee_email'] 	= $this->input->post('email', true);
				$data['invitee_mobile']	= $mobile->system_number($this->input->post('mobile', true));
				$data['message'] 		= $this->input->post('message', true);
				$data['dated'] 			= date('Y-m-d H:i:s');
				$save = $this->db->insert('invitations', $data);
				if ($save){
					$s = strtotime($data['dated']);
					$mail_options = array(
						'name' 			=> $this->input->post('name', true),
						'sponsor_name' 		=> $this->user_account->user_name($this->session->userdata('user_name')),
						'sponsor_username' 		=> $this->session->userdata('user_name'),
						'referral_url' 		=> base_url('auth/register/'.$this->session->userdata('user_name')),
						'message' 		=> $this->input->post('message', true),
						'system_name' 	=> $this->data['system_name'],
						'action_time' 	=> date('H:i:s', $s),
						'action_date' 	=> date('Y-m-d', $s)
					);
					$this->emails->send_type_email($this->input->post('email', true), 'invite_new_referral', $mail_options);
					$this->sms->send_type_sms($data['mobile'], 'invite_new_referral', $mail_options);
					$this->session->set_flashdata('success', 'Invitation Sent.');
					redirect(base_url('member/invitation'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					redirect(base_url('member/invitation'));
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('member/invitation'));
				exit();
			}
		} else {
			$this->error_404();
		}
	}
	public function profile($param1='', $param2=''){
		// user profile
		if ($param1 == ''){
			// countries list 
			$countries = file_get_contents(base_url('assets/countries.json'));
			$this->data['countries'] = json_decode($countries, true);
			$this->data['data'] = $this->general->get_tbl_field('users', '*', 'username', $this->session->userdata('user_name'));
			$this->data['file'] = 'profile';
			$this->data['title'] = 'Profile';
			$this->data['page_title'] = 'Profile';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'do-update' && $param2 == 'avatar'){
			// update profile avatar
			$validextensions = array("jpg", "jpeg", "png", "PNG");
			$logo_res = $this->general->upload_media($_FILES["logo"], $validextensions);
			if ($logo_res['status'] == 'error'){
				$this->session->set_flashdata('error', $logo_res['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$image = $logo_res['directory'].'/'.$logo_res['file_name'];
				$thumb = 'avatar-'.$logo_res['file_name'];
				// resizing image to 160 x 160
				$this->img_resize->load($image);
				$this->img_resize->resize(160,160);
				$this->img_resize->save('uploads/'.$thumb);
				
				$data['username'] = $this->session->userdata('user_name');
				$data['small'] = $logo_res['directory'].'/'.$thumb;
				$data['big'] = $image;
				$data['updated'] = date('Y-m-d H:i:s');
				$save = $this->db->insert('avatar', $data);
				if ($save){
					$this->session->set_flashdata('success', 'Avatar Saved Successfully.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			}
		} elseif ($param1 == 'do-update' && $param2 == ''){
			// updating user profile
			if ($this->input->post()){
				$userdata = $this->general->get_tbl_field('users', '*', 'username', $this->session->userdata('user_name'));
				if(strlen($this->input->post('name', true)) < 4 || strlen($this->input->post('name', true)) > 25){
					$this->session->set_flashdata('error', 'Name must be greater than 4 chracters');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('email', true))){
					$this->session->set_flashdata('error', 'Email Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('dob', true))){
					$this->session->set_flashdata('error', 'Date of Birth Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('country', true))){
					$this->session->set_flashdata('error', 'Please select your country');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('mobile', true))){
					$this->session->set_flashdata('error', 'Mobile Number Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if ($userdata[0]['mobile'] !== $this->input->post('mobile', true)){
					$this->load->library('mobile_number');
					$mobile = new mobile_number();
					$is_mobile_valid = $mobile->is_valid_number($this->input->post('mobile', true));
					if ($is_mobile_valid == false){
						$this->session->set_flashdata('error', 'Invalid Mobile number');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
					if ($this->user_account->mobile_exists($this->input->post('mobile', true)) == true){
						$this->session->set_flashdata('error', 'Mobile No already registered');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} 
					$data['mobile'] = $mobile->system_number($this->input->post('mobile', true));
					$data['region_code'] = $mobile->region_code($this->input->post('mobile', true));
				}
				// validating email address
				if ($userdata[0]['email'] !== $this->input->post('email', true)){
					if(!filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)){
						$this->session->set_flashdata('error', 'Invalid Email address format');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
					//checking if email already exists
					if ($this->user_account->email_exists($this->input->post('email', true)) == true){
						$this->session->set_flashdata('error', 'Email already exists');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} 
					$data['email'] = $this->input->post('email', true);
				}
				$data['name'] = $this->input->post('name', true);
				$data['dob'] = $this->input->post('dob', true);
				$data['country'] = $this->input->post('country', true);
				
				$update = $this->general->update_data('users', 'username', $this->session->userdata('user_name'), $data);
				if ($update){
					$this->session->set_flashdata('success', 'Profile Updated.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('member/profile'));
				exit();
			}
		} elseif ($param1 == 'generate-epin' && $param2 == ''){
			if ($this->user_account->epin_exists($this->session->userdata('user_name')) == true){
				$this->session->set_flashdata('error', 'E-PIN already generated.');
				redirect(base_url('member/profile'));
				exit();
			}
			$this->data['file'] = 'generate_epin';
			$this->data['title'] = 'Generate E-PIN';
			$this->data['page_title'] = 'Generate E-PIN';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'generate-epin' && $param2 == 'do'){
			if ($this->input->post()){
				if (!is_numeric($this->input->post('epin', true))){
					$this->session->set_flashdata('error', 'E-PIN must be a numeric value.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (strlen($this->input->post('epin', true)) !== 5){
					$this->session->set_flashdata('error', 'E-PIN must contain 5 characters.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if ($this->input->post('epin', true) !== $this->input->post('re_epin', true)){
					$this->session->set_flashdata('error', 'E-PINs don\'t match.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$data['username'] = $this->session->userdata('user_name');
				$data['e_pin'] = $this->input->post('epin', true);
				$data['dated'] = date('Y-m-d H:i:s');
				$save = $this->db->insert('e_pins', $data);
				if ($save){
					$email = $this->user_account->user_email($this->session->userdata('user_name'));
					if ($email){
						$s = strtotime($data['dated']);
						$mail_options = array(
							'name' 			=> $this->user_account->user_name($this->session->userdata('user_name')),
							'username' 		=> $this->session->userdata('user_name'),
							'system_name' 	=> $this->data['system_name'],
							'e_pin' 		=> $this->input->post('epin', true),
							'action_time' 	=> date('H:i:s', $s),
							'action_date' 	=> date('Y-m-d', $s)
						);
						$this->emails->send_type_email($email, 'epin_generated', $mail_options);
						$mobile = $this->user_account->user_mobile($this->session->userdata('user_name'));
						if ($mobile){
							$this->sms->send_type_sms($mobile, 'epin_generated', $mail_options);
						}
					}
					
					$this->session->set_flashdata('success', 'E-PIN generated successfully.');
					redirect(base_url('member/profile'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('member/profile/generate-epin'));
				exit();
			}
			
		} elseif ($param1 == 'notification-settings' && $param2 == ''){
			$this->data['templates'] = $this->db->query("SELECT title, type,email,sms FROM notifications_list ORDER by id ASC")->result_array();
			$this->data['file'] = 'notification_settings';
			$this->data['title'] = 'Disable Notifications';
			$this->data['page_title'] = 'Disable Notifications';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'notification-settings' && $param2 == 'do'){
			if ($this->input->post()){
				$notification = $this->input->post('notification');
				$this->general->delete_tbl_data('notification_settings', 'username', $this->session->userdata('user_name'));
				if (is_array($notification)){
					if (count($notification)>0){
						foreach ($notification as $type=>$noti){
							foreach($notification[$type] as $career=>$notitype){
								$notify['username'] = $this->session->userdata('user_name');
								$notify['type'] = $type;
								if ($career == 'sms'){
									$notify['carrier_type'] = 'sms';
								} elseif ($career == 'email'){
									$notify['carrier_type'] = 'email';
								}
								$this->db->insert('notification_settings', $notify);
							}
						}
					}
				}
				$this->session->set_flashdata('success', 'Notification Settings updated.');
				redirect(base_url('member/profile/notification-settings'));
				exit();
				
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('member/profile/notification-settings'));
				exit();
			}
		} elseif ($param1 == 'change-password' && $param2 == ''){
			$this->data['file'] = 'change_password';
			$this->data['title'] = 'Change Password';
			$this->data['page_title'] = 'Change Password';
			$this->load->view('backoffice/index', $this->data);
		} elseif ($param1 == 'change-password' && $param2 == 'do'){
			// changing password
			if ($this->input->post()){
				// checking if current password is validated
				$auth = $this->user_account->verify_login($this->session->userdata('user_name'), $this->input->post('current', true));
				if ($auth == false){
					$this->session->set_flashdata('error', 'Invalid current password.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
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
				if ($this->input->post('password', true) == $this->input->post('current', true)){
					$this->session->set_flashdata('error', 'New password must be other than current password.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$data['updated'] = date('Y-m-d H:i:s');
				$data['password'] = md5($this->input->post('password', true));
				$update = $this->general->update_data('users', 'username', $this->session->userdata('user_name'), $data);
				if ($update){
					$this->session->set_flashdata('success', 'Password Updated.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('member/profile/change-profile'));
				exit();
			}
		} else {
			$this->error_404();
		}
		
	}
	public function error_404(){
		$this->data['file'] = 'error_404';
		$this->data['title'] = '404 Page not Fount';
		$this->data['page_title'] = '';
		$this->load->view('backoffice/index', $this->data);
	}
	
}
