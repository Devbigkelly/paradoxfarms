<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->data['system_name'] = $this->general->get_system_var('system_name');
		if ($this->session->userdata('user_group') !== 'admin'){redirect(base_url('auth/login'));}
		$this->limit = 5;
		$this->data['logged_username'] = $this->session->userdata('user_name');
		$this->data['permissions'] = $this->returns->get_user_role_functions($this->data['logged_username']);
	}
	
	public function index()
	{ 
		redirect('admin/dashboard');
	}
	public function transaction($param1=''){
		// transaction modal when user clicks on transaction
		$this->data['tranxs'] = $this->general->get_tbl_field('transactions', '*', 'transaction_id', $param1);
		$this->load->view('modal/transaction', $this->data);
	}
	public function dashboard(){
		// admin dashboard
		$bar_chart 	= $this->dashboards->admin_bar_chart_data();
		$this->data['bar_chart_income'] = json_encode($bar_chart['income']);
		$this->data['bar_chart_months'] = json_encode($bar_chart['months']);
		$this->data['dash'] = $this->dashboards->admin_dashboard();
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
		$this->load->view('admin/index', $this->data);
	}
	public function roles($param1='', $param2='', $param3=''){
		if ($param1 == ''){
			if ($this->returns->permission_access('roles_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_all_tbl_data('roles', '*');
			$this->data['file'] = 'roles';
			$this->data['page_title'] = 'Roles List';
			$this->data['title'] = 'Roles';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'delete'){
			if ($this->returns->permission_access('roles_delete', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->general->delete_tbl_data('roles', 'id', $param2);
			$up['role_id'] = 0;
			$this->db->update('users', $up);
			$this->session->set_flashdata('success', 'Role deleted successfully');
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit();
		
		} elseif ($param1 == 'add-new'){
			if ($this->returns->permission_access('roles_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_tbl_field_order('permissions', '*', 'parent_id', '0', 'ASC');
			$this->data['file'] = 'add_role';
			$this->data['title'] = 'Create new Role';
			$this->data['page_title'] = 'Create new Role';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'adding'){
			if ($this->returns->permission_access('roles_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				if (empty($this->input->post('title'))){
					$this->session->set_flashdata('error', 'Title Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$permissions = $this->input->post('permissions');
				if (isset($permissions)){
					
					$url_title = strtolower($this->input->post('title'));
					
					$data['title'] = $this->input->post('title');
					$data['slug'] = url_title($url_title, 'underscore');
					$data['permissions'] = json_encode($permissions);
					$save = $this->db->insert('roles', $data);
					if ($save){
						$this->session->set_flashdata('success', 'New Role Created successfully');
						redirect(base_url('admin/roles'));
						exit();
					} else {
						$this->session->set_flashdata('error', 'An error occured, Please try again later.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
				} else {
					$this->session->set_flashdata('error', 'No permission selected');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Request sent');
				redirect(base_url('admin/roles/add-new'));
				exit();
			}
		} elseif ($param1 == 'edit'){
			if ($this->returns->permission_access('roles_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['role'] = $this->general->get_tbl_field('roles', '*', 'id', $param2);
			if (count($this->data['role'])>0){
				$this->data['data'] = $this->general->get_tbl_field_order('permissions', '*', 'parent_id', '0', 'ASC');
				$this->data['file'] = 'edit_role';
				$this->data['title'] = 'Edit Role';
				$this->data['page_title'] = 'Edit Role';
				$this->load->view('admin/index', $this->data);
			} else {
				$this->session->set_flashdata('error', 'Record not Found');
				redirect(base_url('admin/roles'));
				exit();
			}
			
		} elseif ($param1 == 'editing'){
			if ($this->returns->permission_access('roles_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				if (empty($this->input->post('title'))){
					$this->session->set_flashdata('error', 'Title Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$permissions = $this->input->post('permissions');
				if (isset($permissions)){
					
					$url_title = strtolower($this->input->post('title'));
					
					$data['title'] = $this->input->post('title');
					$data['slug'] = url_title($url_title, 'underscore');
					$data['permissions'] = json_encode($permissions);
					if ($this->input->post('role_id') == 1 || $this->input->post('role_id') == '1'){
						$updated = true;
					} else {
						$updated = $this->general->update_data('roles', 'id', $this->input->post('role_id'), $data);
					}
					
					if ($updated){
						$this->session->set_flashdata('success', 'Role Updated successfully');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						$this->session->set_flashdata('error', 'An error occured, Please try again later');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
				} else {
					$this->session->set_flashdata('error', 'No permission selected');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Request sent');
				redirect(base_url('admin/roles'));
				exit();
			}
		} else {
			$this->session->set_flashdata('error', 'Invalid Request sent');
			redirect(base_url('admin/roles'));
			exit();
		}
	}
	public function calendar(){
		if ($this->returns->permission_access('calender', $this->session->userdata('user_name')) == false){
			$this->error_404();
		}
		// events calendar
		$this->data['file'] = 'calendar';
		$this->data['title'] = 'Calendar';
		$this->data['page_title'] = 'Calendar';
		$this->load->view('admin/index', $this->data);
	}
	public function calendar_actions($param1=''){
		if ($param1 == 'insert'){
			if ($this->returns->permission_access('calender_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post('title')) {
				//collect data
				$error      = null;
				$title      = $this->input->post('title');
				$start      = $this->input->post('startDate');
				$end        = $this->input->post('endDate');
				$color      = $this->input->post('color');
				$text_color = $this->input->post('text_color');
				$details    = $this->input->post('details');

				//validation
				if ($title == '') {
					$error['title'] = 'Title is required';
				}

				if ($start == '') {
					$error['start'] = 'Start date is required';
				}

				if ($end == '') {
					$error['end'] = 'End date is required';
				}

				//if there are no errors, carry on
				if (! isset($error)) {

					//format date
					$start = date('Y-m-d H:i:s', strtotime($start));
					$end = date('Y-m-d H:i:s', strtotime($end));
					
					$data['success'] = true;
					$data['message'] = 'Success!';

					//store
					$insert = [
						'title'       => $title,
						'start_event' => $start,
						'end_event'   => $end,
						'color'       => $color,
						'text_color'  => $text_color,
						'details'  	  => $details
					];
					$this->db->insert('events_calander', $insert);
				  
				} else {

					$data['success'] = false;
					$data['errors'] = $error;
				}

				echo json_encode($data);
			}
		} elseif ($param1 == 'load'){
			if ($this->returns->permission_access('calender', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$response = array();
			$data = $this->general->get_all_tbl_data('events_calander', '*');
			if (count($data)>0){
				foreach($data as $row) {
					$response[] = [
						'id'              => $row['id'],
						'title'           => $row['title'],
						'start'           => $row['start_event'],
						'end'             => $row['end_event'],
						'backgroundColor' => $row['color'],
						'textColor'       => $row['text_color'],
						'details'         => $row['details']
					];
				}
			}
			echo json_encode($response);
		} elseif ($param1 == 'update'){
			if ($this->returns->permission_access('calender_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post('id')) {

				//collect data
				$error      = null;
				$id         = $this->input->post('id');
				$start      = $this->input->post('start');
				$end        = $this->input->post('end');
				$details    = $this->input->post('details');

				//optional fields
				$title      = $this->input->post('title');
				$color      = $this->input->post('color');
				$text_color = $this->input->post('text_color');
				$details 	= $this->input->post('details');

				//validation
				if ($start == '') {
					$error['start'] = 'Start date is required';
				}

				if ($end == '') {
					$error['end'] = 'End date is required';
				}

				//if there are no errors, carry on
				if (! isset($error)) {

					//reformat date
					$start = date('Y-m-d H:i:s', strtotime($start));
					$end = date('Y-m-d H:i:s', strtotime($end));
					
					$data['success'] = true;
					$data['message'] = 'Success!';

					//set core update array
					$update = [
						'start_event' => date('Y-m-d H:i:s', strtotime($_POST['start'])),
						'end_event' => date('Y-m-d H:i:s', strtotime($_POST['end']))
					];

					//check for additional fields, and add to $update array if they exist
					if ($title !='') {
						$update['title'] = $title;
					}

					if ($color !='') {
						$update['color'] = $color;
					}

					if ($text_color !='') {
						$update['text_color'] = $text_color;
					}
					if ($details !='') {
						$update['details'] = $details;
					}

					
					//update database
					$this->general->update_data('events_calander', 'id', $this->input->post('id'), $update);
				  
				} else {

					$data['success'] = false;
					$data['errors'] = $error;
				}

				echo json_encode($data);
			}
		} elseif ($param1 == 'delete'){
			if ($this->returns->permission_access('calender_delete', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->db->where('id', $this->input->post('id'));
			$this->db->delete('events_calander');
		} elseif ($param1 == 'get-event'){
			$response = array();
			$data = $this->general->get_tbl_field('events_calander', '*', 'id', $this->input->post('id'));
			if (count($data)>0){
				foreach($data as $row) {
					$response[] = [
						'id'              => $row['id'],
						'title'           => $row['title'],
						'start'           =>  date('d-m-Y H:i:s', strtotime($row['start_event'])),
						'end'             =>  date('d-m-Y H:i:s', strtotime($row['end_event'])),
						'color' 		  => $row['color'],
						'textColor'       => $row['text_color'],
						'details'         => $row['details']
					];
				}
			}
			echo json_encode($response);
		}
		$request = json_decode(file_get_contents('php://input'), true);
		if (is_array($request)){
			if ($request['action'] == 'inserted'){
				$data = $request['data'];
				$save = $this->db->insert('events_calander', $data);
				$insID = $this->db->insert_id();
				echo json_encode($insID);
			} elseif ($request['action'] == 'deleted'){
				$this->db->where('id', $request['id']);
				$this->db->delete('events_calander');
			} elseif ($request['action'] == 'updated'){
				$data = $request['data'];
				$this->db->where('id', $request['id']);
				$this->db->update('events_calander',$data);
			}
		}
	}
	public function kyc($param1='', $param2='', $param3=''){
		if (empty($param2) && empty($param3)){
			if ($this->returns->permission_access('kyc_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($param1 == 'pending'){
				$status = '0';
				$this->data['title'] = 'KYC Pending';
				$this->data['page_title'] = 'KYC Pending';
				$this->data['file'] = 'kyc_list_pending';
			} elseif ($param1 == 'verified'){
				$status = '1';
				$this->data['title'] = 'KYC Verified';
				$this->data['page_title'] = 'KYC Verified';
				$this->data['file'] = 'kyc_list_verified';
			} elseif ($param1 == 'rejected'){
				$status = '2';
				$this->data['title'] = 'KYC Rejected';
				$this->data['page_title'] = 'KYC Rejected';
				$this->data['file'] = 'kyc_list_rejected';
			}
			$this->data['data'] = $this->kyc_model->get_kyc_list($status);
			
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'approve'){
			if ($this->returns->permission_access('kyc_approve', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->kyc_model->approve_user_kyc($param2) == true){
				$email = $this->user_account->user_email($param2);
				if ($email){
					$s = strtotime(date('Y-m-d H:i:s'));
					$mail_options = array(
						'name' 			=> $this->user_account->user_name($param2),
						'username' 		=> $param2,
						'system_name' 	=> $this->data['system_name'],
						'action_time' 	=> date('H:i:s', $s),
						'action_date' 	=> date('Y-m-d', $s)
					);
					$this->emails->send_type_email($email, 'kyc_approved', $mail_options);
					$mobile = $this->user_account->user_mobile($param2);
					if ($mobile){
						$this->sms->send_type_sms($mobile, 'kyc_approved', $mail_options);
					}
				}
				$this->session->set_flashdata('success', 'KYC status updated successfully.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'An error occured, Please try again.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
		} elseif ($param1 == 'reject'){
			if ($this->returns->permission_access('kyc_reject', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->kyc_model->reject_user_kyc($param2) == true){
				$email = $this->user_account->user_email($param2);
				if ($email){
					$s = strtotime(date('Y-m-d H:i:s'));
					$mail_options = array(
						'name' 			=> $this->user_account->user_name($param2),
						'username' 		=> $param2,
						'system_name' 	=> $this->data['system_name'],
						'action_time' 	=> date('H:i:s', $s),
						'action_date' 	=> date('Y-m-d', $s)
					);
					$this->emails->send_type_email($email, 'kyc_rejected', $mail_options);
					$mobile = $this->user_account->user_mobile($param2);
					if ($mobile){
						$this->sms->send_type_sms($mobile, 'kyc_rejected', $mail_options);
					}
				}
				
				$this->session->set_flashdata('success', 'KYC status updated successfully.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'An error occured, Please try again.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
		} elseif ($param1 == 'documents'){
			if ($this->returns->permission_access('kyc_documents', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_tbl_field('kyc_user_docs', '*', 'username', $param2);
			$this->data['file'] = 'kyc_user_docs';
			$this->data['title'] = 'KYC Documents';
			$this->data['page_title'] = 'KYC Documents';
			$this->load->view('admin/index', $this->data);
		}
	}
	public function disperse_roi($param1=''){
		if ($this->returns->permission_access('roi_disperse', $this->session->userdata('user_name')) == false){
			$this->error_404();
		}
		if ($param1 == ''){
			// list of users, allowing admin to select specific users for ROI
			$this->data['data'] = $this->general->get_tbl_field('users', 'username', 'user_group', 'member');
			$this->data['file'] = 'disperse_roi';
			$this->data['title'] = 'Disperse ROI';
			$this->data['page_title'] = 'Disperse ROI';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'proceed'){
			if ($this->input->post()){
				$users = $this->input->post('users', true);
				if (count($users)>0){
					//sending roi to selected users
					$this->commissions->do_roi_array_users($users);
					
					$this->session->set_flashdata('success', 'ROI Dispersed.');
					redirect(base_url('admin/disperse-roi'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'Please select users to proceed.');
					redirect(base_url('admin/disperse-roi'));
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Request Sent.');
				redirect(base_url('admin/disperse-roi'));
				exit();
			}
		}
	}
	public function manual_payments($param1 = '', $param2=''){
		if ($param1 == 'pending'){
			if ($this->returns->permission_access('manual_payments_pending', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->wallet->manual_payments_list('0');
			$this->data['file'] = 'manual_payments_pending';
			$this->data['title'] = 'Pending Manual Payments';
			$this->data['page_title'] = 'Pending Manual Payments';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'verified'){
			if ($this->returns->permission_access('manual_payments_verified', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->wallet->manual_payments_list('1');
			$this->data['file'] = 'manual_payments_verified';
			$this->data['title'] = 'Verified Manual Payments';
			$this->data['page_title'] = 'Verified Manual Payments';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'rejected'){
			if ($this->returns->permission_access('manual_payments_rejected', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->wallet->manual_payments_list('2');
			$this->data['file'] = 'manual_payments_rejected';
			$this->data['title'] = 'Rejected Manual Payments';
			$this->data['page_title'] = 'Rejected Manual Payments';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'proof'){
			if ($this->returns->permission_access('manual_payments_proof', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$data = $this->general->get_tbl_field('manual_payments', 'proof', 'id', $param2);
			if (count($data)>0){
				echo '<img src="'.base_url($data[0]['proof']).'">';
			} else {
				$this->session->set_flashdata('error', 'Record not found.');
				redirect(base_url('admin/manual_payments'));
				exit();
			}
		} elseif ($param1 == 'approve'){
			if ($this->returns->permission_access('manual_payments_approve', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$data = $this->general->get_tbl_field('manual_payments', '*', 'id', $param2);
			if (count($data)>0){
				if ($data[0]['status'] == '0'){
					$payments_data = $this->general->get_tbl_field('payments', 'payment_gross', 'id', $data[0]['payments_id']);
					$price = $payments_data[0]['payment_gross'];
					//adding purchase notification and transaction
					$this->wallet->add_purchase_transaction($data[0]['product_id'], $data[0]['username'], $price, $data[0]['tranx_id'], 'Manual-Payment');
					// generating commissions
					$this->commissions->purchase_product($data[0]['username'], $data[0]['product_id'], $data[0]['tranx_id'], 'Manual-Payment');
					
					
					$noti['username'] = $data[0]['username'];
					$noti['msg_from'] = 'Admin';
					$noti['message'] = 'Your Transaction '.$data[0]['tranx_id'].' has been Approved, <a target="_blank" href="'.base_url($data[0]['proof']).'">click here to view proof</a>';
					$noti['dated'] = date('Y-m-d H:i:s');
					$this->db->insert('notifications', $noti);
					
					$mp['status'] = '1';
					$update = $this->general->update_data('manual_payments', 'id', $param2, $mp);
					if ($update){
						$mp['payment_details'] = $data[0]['proof'];
						$this->general->update_data('payments', 'id', $data[0]['payments_id'], $mp);
						$this->session->set_flashdata('success', 'Payment Approved');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						$this->session->set_flashdata('error', 'An error occured, Please try again');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
				} else {
					$this->session->set_flashdata('error', 'Transaction already approved.');
					redirect(base_url('admin/manual_payments'));
					exit();
				}
				
			} else {
				$this->session->set_flashdata('error', 'Record not found.');
				redirect(base_url('admin/manual_payments'));
				exit();
			}
		} elseif ($param1 == 'reject'){
			if ($this->returns->permission_access('manual_payments_reject', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$data = $this->general->get_tbl_field('manual_payments', '*', 'id', $param2);
			if (count($data)>0){
				$noti['username'] = $data[0]['username'];
				$noti['msg_from'] = 'Admin';
				$noti['message'] = 'Your Transaction '.$data[0]['tranx_id'].' has been rejected, please try again <a target="_blank" href="'.base_url($data[0]['proof']).'">click here to view proof</a>';
				$noti['dated'] = date('Y-m-d H:i:s');
				$this->db->insert('notifications', $noti);
				
				$mp['status'] = '2';
				$update = $this->general->update_data('manual_payments', 'id', $param2, $mp);
				if ($update){
					$this->general->update_data('payments', 'id', $data[0]['payments_id'], $mp);
					$this->session->set_flashdata('success', 'Payment Rejected');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Record not found.');
				redirect(base_url('admin/manual_payments'));
				exit();
			}
		}
		
	}
	public function income($param1=''){
		//user income hostory by passing oncome type parameter to URL
		if ($param1 == 'personal-sponsor-bonus'){
			if ($this->returns->permission_access('income_personal_sponsor_bonus', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'psb-history';
			$this->data['title'] = 'Personal Sponsor Bonus';
			$this->data['page_title'] = 'Personal Sponsor Bonus';
		} elseif ($param1 == 'network-binary-bonus'){
			if ($this->returns->permission_access('income_network_binary_bonus', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'nbb-history';
			$this->data['title'] = 'Network Binary Bonus';
			$this->data['page_title'] = 'Network Binary Bonus';
		} elseif ($param1 == 'generation-bonus'){
			if ($this->returns->permission_access('income_generation_bonus', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'gb-history';
			$this->data['title'] = 'Generation Bonus';
			$this->data['page_title'] = 'Generation Bonus';
		} elseif ($param1 == 'reverse-generation-bonus'){
			if ($this->returns->permission_access('income_reverse_generation_bonus', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'rgb-history';
			$this->data['title'] = 'Reverse Generation Bonus';
			$this->data['page_title'] = 'Reverse Generation Bonus';
		} elseif ($param1 == 'roi'){
			if ($this->returns->permission_access('income_roi', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'roi-history';
			$this->data['title'] = 'Return on Investment (ROI)';
			$this->data['page_title'] = 'Return on Investment (ROI)';
		} elseif ($param1 == 'matching-roi'){
			if ($this->returns->permission_access('income_matching_roi', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'matching-roi-history';
			$this->data['title'] = 'Return on Investment (ROI)';
			$this->data['page_title'] = 'Matching ROI';
		} else {
			$this->error_404();
		}
		$this->load->view('admin/index', $this->data);
	}
	public function income_ajax($param1=''){
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
				$total_record = $this->dashboards->income_total_entries($param1);
				$record = $this->db->query('SELECT tranx_id, username, amount, dated FROM income WHERE type="'.$param1.'" ORDER by '.$columnName.' '.$columnSortOrder.' LIMIT '.$row.', '.$rowperpage.'')->result_array();
		}
		if (count($record)>0){
			foreach ($record as  $key => $res){
				$r['id'] = $key + 1 + $row;
				$r['tranx_id'] = modal_anchor(get_uri("admin/transaction/".$res['tranx_id']), $res['tranx_id'], array("class" => "view ico-circle", "title" => 'Transaction Details'));;
				$r['username'] = $res['username'];
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
	public function purchase_history_ajax(){
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
		$searchQuery = $_POST['search']['value'];
		
		$data = array();
		$record = array();
		$total_record = 0;
		
		$this->db->select('id');
		$this->db->order_by($columnName, $columnSortOrder);
		//$this->db->limit($rowperpage, $row);
		$total_record =  $this->db->count_all_results('purchase');
		
		$record = $this->db->query('SELECT * FROM purchase ORDER by '.$columnName.' '.$columnSortOrder.' LIMIT '.$row.', '.$rowperpage.'')->result_array();
		if (count($record)>0){
			foreach ($record as $key => $res){
				$r['id'] 				= $key + 1 + $row;
				$r['tranx_id'] 			= modal_anchor(get_uri("admin/transaction/".$res['tranx_id']), $res['tranx_id'], array("class" => "view ico-circle", "title" => 'Transaction Details'));;
				$r['username'] 			= $res['username'];
				$r['product_id'] 			= $this->commissions->product_name($res['product_id']);
				$r['selling_price'] 	= currency($res['selling_price']);
				$r['payment_method'] 	= $res['payment_method'];
				$r['dated'] 			= $res['dated'];
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
	public function products($param1='', $param2='', $param3=''){
		if ($param1 == '' && $param2 == ''){
			if ($this->returns->permission_access('products_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// Displaying products list
			$this->data['data'] = $this->general->get_all_tbl_data('products', '*');
			$this->data['file'] = 'products_list';
			$this->data['title'] = 'Products List';
			$this->data['page_title'] = 'Products List';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'purchase-history' && $param2 == ''){
			if ($this->returns->permission_access('products_purchase_history', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// Displaying Products purchased by users
			$this->data['data'] = $this->general->get_all_tbl_data('purchase', '*');
			$this->data['file'] = 'purchase_history';
			$this->data['title'] = 'Purchase History';
			$this->data['page_title'] = 'Purchase History';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'edit' && $param2 !== '' && $param2 !== 'proceed'){
			if ($this->returns->permission_access('products_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//Edid for of a product if it exists in database
			$this->data['data'] = $this->general->get_tbl_field('products', '*', 'id', $param2);
			if (count($this->data['data'])>0){
				$this->data['file'] = 'edit_product';
				$this->data['title'] = 'Edit Product';
				$this->data['page_title'] = 'Edit Product';
				$this->load->view('admin/index', $this->data);
			} else {
				$this->session->set_flashdata('error', 'Record not Found.');
				redirect(base_url('admin/products'));
				exit();
			}
		} elseif ($param1 == 'edit' && $param2 == 'proceed'){
			if ($this->returns->permission_access('products_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// Updating product
			if ($this->input->post()){
				$data['psb'] = '0';
				$data['nbb'] = '0';
				$data['gb'] = '0';
				$data['rgb'] = '0';
				$data['roi'] = '0';
				if (empty($this->input->post('title', true))){
					die(json_encode(array(
						'status' => 'error',
						'message' => 'Product Title Required',
					)));
				}
				if (empty($this->input->post('selling_price', true))){
					die(json_encode(array(
						'status' => 'error',
						'message' => 'Product Price Required',
					)));
				}
				// if no image selected, Pervious image will be displayed 
				if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] !==''){
					$validextensions = array("jpg", "jpeg", "png", "PNG");
					$logo_res = $this->general->upload_media($_FILES["image"], $validextensions);
					if ($logo_res['status'] == 'error'){
						die(json_encode(array(
							'status' => 'error',
							'message' => $logo_res['message'],
						)));
					} else {
						$image = $logo_res['directory'].'/'.$logo_res['file_name'];
						$thumb = 'product-'.$logo_res['file_name'];
						$this->img_resize->load($image);
						$this->img_resize->resize(400,500);
						$this->img_resize->save($logo_res['directory'].'/'.$thumb);
						
						$data['thumb'] = $logo_res['directory'].'/'.$thumb;
						$data['image'] = $image;
					}
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('personal_sponsor_bonus_status') == '1'){
					if (empty($this->input->post('psb', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'Personal Sponsor Bonus Required',
						)));
					}
					$data['psb'] = $this->input->post('psb', true);
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('network_binary_bonus_status') == '1'){
					if (empty($this->input->post('nbb', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'Network Binary Bonus Required',
						)));
					}
					$data['nbb'] = $this->input->post('nbb', true);
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('generation_bonus_status') == '1'){
					if (empty($this->input->post('gb', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'Generation Bonus Required',
						)));
					}
					$data['gb'] = $this->input->post('gb', true);
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('reverse_generation_bonus_status') == '1'){
					if (empty($this->input->post('rgb', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'Reverse Generation Bonus Required',
						)));
					}
					$data['rgb'] = $this->input->post('rgb', true);
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('roi_status') == '1'){
					if (empty($this->input->post('roi', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'ROI Required',
						)));
					}
					$data['roi'] = $this->input->post('roi', true);
				}
				
				$data['title'] = $this->input->post('title', true);
				$data['selling_price'] = $this->input->post('selling_price', true);
				$update = $this->general->update_data('products', 'id', $this->input->post('product_id', true), $data);
				if ($update){
					die(json_encode(array(
						'status' => 'success',
						'message' => 'Product Updated successfully.',
					)));
				} else {
					die(json_encode(array(
						'status' => 'error',
						'message' => 'An error occured, Please try again.',
					)));
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Request Sent.');
				redirect(base_url('admin/products'));
				exit();
			}
		} elseif ($param1 == 'add-new' && $param2 == ''){
			if ($this->returns->permission_access('products_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// add new product form
			$this->data['file'] = 'add_product';
			$this->data['title'] = 'Add New Product';
			$this->data['page_title'] = 'Add New Product';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'add-new' && $param2 == 'proceed'){
			if ($this->returns->permission_access('products_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// adding new product
			if ($this->input->post()){
				$data['psb'] = '0';
				$data['nbb'] = '0';
				$data['gb'] = '0';
				$data['rgb'] = '0';
				$data['roi'] = '0';
				if (empty($this->input->post('title', true))){
					die(json_encode(array(
						'status' => 'error',
						'message' => 'Product Title Required',
					)));
				}
				if (empty($this->input->post('selling_price', true))){
					die(json_encode(array(
						'status' => 'error',
						'message' => 'Product Price Required',
					)));
				}
				// valid image extensions
				$validextensions = array("jpg", "jpeg", "png", "PNG");
				$logo_res = $this->general->upload_media($_FILES["image"], $validextensions);
				if ($logo_res['status'] == 'error'){
					die(json_encode(array(
						'status' => 'error',
						'message' => $logo_res['message'],
					)));
				} else {
					$image = $logo_res['directory'].'/'.$logo_res['file_name'];
					$thumb = 'avatar-'.$logo_res['file_name'];
					
					// resizing image to 400 x 500
					$this->img_resize->load($image);
					$this->img_resize->resize(400,500);
					$this->img_resize->save($logo_res['directory'].'/'.$thumb);
					
					$data['thumb'] = $logo_res['directory'].'/'.$thumb;
					$data['image'] = $image;
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('personal_sponsor_bonus_status') == '1'){
					if (empty($this->input->post('psb', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'Personal Sponsor Bonus Required',
						)));
					}
					$data['psb'] = $this->input->post('psb', true);
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('network_binary_bonus_status') == '1'){
					if (empty($this->input->post('nbb', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'Network Binary Bonus Required',
						)));
					}
					$data['nbb'] = $this->input->post('nbb', true);
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('generation_bonus_status') == '1'){
					if (empty($this->input->post('gb', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'Generation Bonus Required',
						)));
					}
					$data['gb'] = $this->input->post('gb', true);
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('reverse_generation_bonus_status') == '1'){
					if (empty($this->input->post('rgb', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'Reverse Generation Bonus Required',
						)));
					}
					$data['rgb'] = $this->input->post('rgb', true);
				}
				// checking if value required, can be managed form admin panel
				if ($this->general->get_commission_var('roi_status') == '1'){
					if (empty($this->input->post('roi', true))){
						die(json_encode(array(
							'status' => 'error',
							'message' => 'ROI Required',
						)));
					}
					$data['roi'] = $this->input->post('roi', true);
				}
				$data['title'] = $this->input->post('title', true);
				$data['selling_price'] = $this->input->post('selling_price', true);
				$save = $this->db->insert('products', $data);
				if ($save){
					$product_id = $this->db->insert_id();
					die(json_encode(array(
						'redirect' => 'yes',
						'url' => base_url('admin/products/edit/'.$product_id),
						'status' => 'success',
						'message' => 'New Product Added.',
					)));
				} else {
					die(json_encode(array(
						'status' => 'error',
						'message' => 'An error occured, Please try again',
					)));
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Request Sent.');
				redirect(base_url('admin/products/add-new'));
				exit();
			}
		} elseif ($param1 == 'delete' && $param2 !== ''){
			if ($this->returns->permission_access('products_delete', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
		}
	}
	public function faqs($param1='', $param2=''){
		//frequently asked questions
		if ($param1 == '' && $param2 == ''){
			if ($this->returns->permission_access('faqs_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_all_data_by_order('faqs', '*', 'id', 'ASC');
			$this->data['file'] = 'faqs';
			$this->data['title'] = 'Frequently Asked Questions';
			$this->data['page_title'] = 'Frequently Asked Questions';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'edit' && $param2 !== ''){
			if ($this->returns->permission_access('faqs_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_tbl_field('faqs', '*', 'id', $param2);
			if (count($this->data['data'])>0){
				$this->data['file'] = 'edit_faq';
				$this->data['title'] = 'Edit FAQ';
				$this->data['page_title'] = 'Edit FAQ';
				$this->load->view('admin/index', $this->data);
			} else {
				$this->session->set_flashdata('error', 'Record not found.');
				redirect(base_url('admin/faqs'));
				exit();
			}
			
		} elseif ($param1 == 'do-edit' && $param2 == ''){
			if ($this->returns->permission_access('faqs_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				if (empty($this->input->post('question', true))){
					$this->session->set_flashdata('error', 'Question required.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('answer', true))){
					$this->session->set_flashdata('error', 'Answer required.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$data['question'] = $this->input->post('question', true);
				$data['answer'] = $this->input->post('answer', true);
				$update = $this->general->update_data('faqs', 'id', $this->input->post('faq_id'), $data);
				if ($update){
					$this->session->set_flashdata('success', 'FAQ Updated successfully.');
					redirect(base_url('admin/faqs'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Request Sent.');
				redirect(base_url('admin/faqs'));
				exit();
			}
		} elseif ($param1 == 'add-new' && $param2 == ''){
			if ($this->returns->permission_access('faqs_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'add_faq';
			$this->data['title'] = 'Add FAQ';
			$this->data['page_title'] = 'Add FAQ';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'add-new' && $param2 == 'proceed'){
			if ($this->returns->permission_access('faqs_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				if (empty($this->input->post('question', true))){
					$this->session->set_flashdata('error', 'Question required.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('answer', true))){
					$this->session->set_flashdata('error', 'Answer required.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$data['question'] = $this->input->post('question', true);
				$data['answer'] = $this->input->post('answer', true);
				$save = $this->db->insert('faqs', $data);
				if ($save){
					$faq_id = $this->db->insert_id();
					$this->session->set_flashdata('success', 'FAQ saved successfully.');
					redirect(base_url('admin/faqs/edit/'.$faq_id));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Request Sent.');
				redirect(base_url('admin/faqs/add-new'));
				exit();
			}
		} elseif ($param1 == 'delete'){
			if ($this->returns->permission_access('faqs_delete', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->general->delete_tbl_data('faqs', 'id', $param2);
			$this->session->set_flashdata('success', 'FAQ deleted successfully.');
			redirect(base_url('admin/faqs'));
			exit();
		}
	}
	public function support($param1='', $param2='', $param3=''){
		if ($param1 == 'tickets' && $param2 == 'closed'){
			if ($this->returns->permission_access('support_tickets_closed', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// support tickets with status closed
			$this->data['data'] = $this->general->get_tbl_field('support_ticket', '*', 'status', 'closed');
			$this->data['type'] = 'closed';
			$this->data['file'] = 'closed_tickets';
			$this->data['title'] = 'Closed Tickets';
			$this->data['page_title'] = 'Closed Tickets';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'tickets' && $param2 == 'open'){
			if ($this->returns->permission_access('support_tickets_open', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// support tickets with status open
			$this->data['data'] = $this->general->get_tbl_field('support_ticket', '*', 'status', 'open');
			$this->data['type'] = 'open';
			$this->data['file'] = 'open_tickets';
			$this->data['title'] = 'Open Tickets';
			$this->data['page_title'] = 'Open Tickets';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'ticket' && $param2 !== ''){
			if ($this->returns->permission_access('support_ticket_detail', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//open specific ticket and view conversation if ticket exists
			$this->data['ticket'] = $this->support->ticket_data_admin($param2);
			if (count($this->data['ticket'])>0){
				$this->data['data'] = $this->support->get_ticket_data($this->data['ticket'][0]['id']);
				$this->data['file'] = 'ticket';
				$this->data['title'] = 'Support';
				$this->data['page_title'] = 'Ticket: '.$this->data['ticket'][0]['ticket_id'];
				$this->load->view('admin/index', $this->data);
			} else {
				$this->session->set_flashdata('error', 'Record not found.');
				redirect(base_url('member/support'));
				exit();
			}
			
		} elseif ($param1 == 'attachment'){
			if ($this->returns->permission_access('support_ticket_detail', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// sending attahments in support
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
				$data['is_reply'] = 1;
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
			if ($this->returns->permission_access('support_ticket_detail', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// sending support message
			if ($this->input->post()){
				$data['ticket_id'] = $this->input->post('ticket_id', true);
				$data['text'] = strip_tags($this->input->post('message', true));
				$data['username'] = $this->session->userdata('user_name');
				$data['is_reply'] = 1;
				$data['updated'] = date('Y-m-d H:i:s');
				$save = $this->general->insert_data('support_ticket_data', $data);
				if ($save == false){
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
				}
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
				
			} else {
				$this->session->set_flashdata('error', 'Invalid Request Sent.');
				redirect(base_url('admin/support/tickets/open'));
				exit();
			}
		} elseif ($param1 == 'open-ticket'){
			if ($this->returns->permission_access('support_ticket_change_status', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// change ticket status to open
			$updata['status'] = 'open';
			$saved = $this->general->update_data('support_ticket', 'id', $param2, $updata);
			$this->session->set_flashdata('success', 'Status Updated');
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit();
		} elseif ($param1 == 'close-ticket'){
			if ($this->returns->permission_access('support_ticket_change_status', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// change ticket status to closed
			$updata['status'] = 'closed';
			$saved = $this->general->update_data('support_ticket', 'id', $param2, $updata);
			$this->session->set_flashdata('success', 'Status Updated');
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit();
		}
	}
	public function upload_image(){
		if ($this->input->post()) {
			
			$validextensions = array("jpg", "jpeg", "png", "PNG");
			$logo_res = $this->general->upload_media($_FILES["upload"], $validextensions);
			if ($logo_res['status'] == 'error'){
				echo json_encode($logo_res['message']);
				exit();
			} else {
				$image = $logo_res['directory'].'/'.$logo_res['file_name'];
				$arr['uploaded'] = true;
				$arr['url'] = base_url($image);
				$arr['path'] = base_url($image);
				$arr['fileName'] = $logo_res['file_name'];
				echo json_encode($arr);
				exit();
			}
		}
	}
	public function moderators($param1='', $param2=''){
		if ($param1 == ''){
			if ($this->returns->permission_access('moderators_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->returns->moderators_list();
			$this->data['file'] = 'moderators_list';
			$this->data['title'] = 'Moderators List';
			$this->data['page_title'] = 'Moderators List';
			$this->load->view('admin/index', $this->data);
		}  elseif ($param1 == 'add-new' && $param2 == ''){
			if ($this->returns->permission_access('moderators_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$countries = file_get_contents(base_url('assets/countries.json'));
			$this->data['countries'] = json_decode($countries, true);
			$this->data['roles'] = $this->general->get_all_tbl_data('roles', '*');
			$this->data['file'] = 'moderator_add';
			$this->data['title'] = 'Add Moderator';
			$this->data['page_title'] = 'Add Moderator';
			$this->load->view('admin/index', $this->data);
		}  elseif ($param1 == 'add-new' && $param2 == 'proceed'){
			if ($this->returns->permission_access('moderators_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				$this->session->set_flashdata('name', $this->input->post('name'));
				$this->session->set_flashdata('username', $this->input->post('username'));
				$this->session->set_flashdata('email', $this->input->post('email'));
				$this->session->set_flashdata('mobile', $this->input->post('mobile'));
				$this->session->set_flashdata('dob', $this->input->post('dob'));
				$this->session->set_flashdata('country', $this->input->post('country'));
				$this->session->set_flashdata('role_id', $this->input->post('role_id'));
				$username_exists = $this->user_account->username_exists($this->input->post('username', true));
				if ($username_exists == true){
					$this->session->set_flashdata('error', 'Username already exists');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				// validating password for any special character
				if(preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/", $this->input->post('username', true))){
					$this->session->set_flashdata('error', 'Username contains illegal characters');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if ( preg_match('/\s/', $this->input->post('username', true)) ){
					$this->session->set_flashdata('error', 'Username contains whitespace');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if(strlen($this->input->post('username', true)) < 4 || strlen($this->input->post('username', true)) > 12){
					$this->session->set_flashdata('error', 'Username must be greater than 4 and less than 12 characters');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if(strlen($this->input->post('name', true)) < 4 || strlen($this->input->post('name', true)) > 25){
					$this->session->set_flashdata('error', 'Name must be greater than 4 chracters');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if ($this->user_account->email_exists($this->input->post('email', true)) == true){
					$this->session->set_flashdata('error', 'Email Already exists');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('email', true))){
					$this->session->set_flashdata('error', 'Email Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('role_id', true))){
					$this->session->set_flashdata('error', 'Role Required');
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
				$data['created'] = date('Y-m-d H:i:s');
				$data['password'] = md5($this->input->post('password', true));
				
				$data['mobile'] = $mobile->system_number($this->input->post('mobile', true));
				$data['region_code'] = $mobile->region_code($this->input->post('mobile', true));
				
				$data['name'] = $this->input->post('name', true);
				$data['username'] = $this->input->post('username', true);
				$data['email'] = $this->input->post('email', true);
				$data['dob'] = $this->input->post('dob', true);
				$data['user_group'] = 'admin';
				$data['role_id'] = $this->input->post('role_id', true);
				$data['status'] = '1';
				$data['country'] = $this->input->post('country', true);
				
				$save = $this->db->insert('users', $data);
				if ($save){
					if(isset($_FILES["logo"]["name"]) && $_FILES["logo"]["name"] !==''){
						$validextensions = array("jpg", "jpeg", "png", "PNG");
						$logo_res = $this->general->upload_media($_FILES["logo"], $validextensions);
						if ($logo_res['status'] == 'error'){
							$this->session->set_flashdata('error', $logo_res['message']);
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} 
					} else {
						$image = $logo_res['directory'].'/'.$logo_res['file_name'];
						$thumb = 'avatar-'.$logo_res['file_name'];
						$this->img_resize->load($image);
						$this->img_resize->resize(160,160);
						$this->img_resize->save('uploads/'.$thumb);
						
						$data['username'] = $this->input->post('username', true);
						$data['small'] = $logo_res['directory'].'/'.$thumb;
						$data['big'] = $image;
						$data['updated'] = date('Y-m-d H:i:s');
						$save = $this->db->insert('avatar', $data);
					}

					$this->session->set_flashdata('success', 'Moderator added successfully.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent');
				redirect(base_url('admin/moderators/add-new'));
				exit();
			}
		}  elseif ($param1 == 'update-password' && $param2 !== ''){
			if ($this->returns->permission_access('moderators_change_password', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// user password update form
			$username_exists = $this->user_account->username_exists($param2);
			if ($username_exists == false){
				$this->session->set_flashdata('error', 'Moderator not Found');
				redirect(base_url('admin/moderators'));
				exit();
			}
			$this->data['username'] = $param2;
			$this->data['file'] = 'moderator_password';
			$this->data['title'] = 'Update Moderator Password';
			$this->data['page_title'] = 'Update Moderator Password';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'edit-profile' && $param2 !== ''){
			if ($this->returns->permission_access('moderators_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//user profile update form if user exists
			$username_exists = $this->user_account->username_exists($param2);
			if ($username_exists == false){
				$this->session->set_flashdata('error', 'Moderator not Found');
				redirect(base_url('admin/moderators'));
				exit();
			}
			$countries = file_get_contents(base_url('assets/countries.json'));
			$this->data['countries'] = json_decode($countries, true);
			$this->data['data'] = $this->general->get_tbl_field('users', '*', 'username', $param2);
			$this->data['roles'] = $this->general->get_all_tbl_data('roles', '*');
			$this->data['file'] = 'moderator_profile';
			$this->data['title'] = 'Moderator Profile';
			$this->data['page_title'] = 'Moderator Profile';
			$this->load->view('admin/index', $this->data);
		}  elseif ($param1 == 'do-update-avatar' && $param2 !== ''){
			if ($this->returns->permission_access('moderators_update_avatar', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//changing user avatar
			$validextensions = array("jpg", "jpeg", "png", "PNG");
			$logo_res = $this->general->upload_media($_FILES["logo"], $validextensions);
			if ($logo_res['status'] == 'error'){
				$this->session->set_flashdata('error', $logo_res['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$image = $logo_res['directory'].'/'.$logo_res['file_name'];
				$thumb = 'avatar-'.$logo_res['file_name'];
				$this->img_resize->load($image);
				$this->img_resize->resize(160,160);
				$this->img_resize->save('uploads/'.$thumb);
				
				$data['username'] = $this->input->post('username');
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
		} elseif ($param1 == 'do-update-password' && $param2 !== ''){
			if ($this->returns->permission_access('moderators_change_password', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// changing user password
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
				$data['updated'] = date('Y-m-d H:i:s');
				$data['password'] = md5($this->input->post('password', true));
				$update = $this->general->update_data('users', 'username', $this->input->post('username', true), $data);
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
				redirect('admin/moderators');
				exit();
			}
		} elseif ($param1 == 'do-update-profile' && $param2 !== ''){
			if ($this->returns->permission_access('moderators_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// updating user profile
			if ($this->input->post()){
				$userdata = $this->general->get_tbl_field('users', '*', 'username', $this->input->post('username', true));
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
				if (empty($this->input->post('role_id', true))){
					$this->session->set_flashdata('error', 'Role Required');
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
				if ($userdata[0]['email'] !== $this->input->post('email', true)){
					if(!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)){
						$this->session->set_flashdata('error', 'Invalid Email address format');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
					if ($this->user_account->email_exists($this->input->post('email', true)) == true){
						$this->session->set_flashdata('error', 'Email already exists');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} 
					$data['email'] = $this->input->post('email', true);
				}
				$data['name'] = $this->input->post('name', true);
				$data['dob'] = $this->input->post('dob', true);
				$data['role_id'] = $this->input->post('role_id', true);
				$data['country'] = $this->input->post('country', true);
				
				$update = $this->general->update_data('users', 'username', $this->input->post('username', true), $data);
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
				redirect('admin/moderators');
				exit();
			}
		} elseif ($param1 == 'delete' && $param2 !== ''){
			if ($this->returns->permission_access('moderators_delete', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
		}
	}
	public function users($param1='', $param2=''){
		if ($param1 == ''){
			if ($this->returns->permission_access('users_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->user_account->get_users_list('member');
			$this->data['file'] = 'users';
			$this->data['title'] = 'Users List';
			$this->data['page_title'] = 'Users List';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'do-purchase-product'){
			if ($this->input->post()){
				$product_id = $this->input->post('product_id');
				$payment = $this->input->post('payment');
				if (isset($product_id) && $product_id !==''){
					$product = $this->general->get_tbl_field('products', '*', 'id', $this->input->post('product_id', true));
					$available_amount = $this->wallet->wallet_amount($this->input->post('username'), 'wallet');
					if ($payment == 'paid'){
						if ($available_amount < $product[0]['selling_price']){
							die(json_encode(array(
								'status' => 'error',
								'message' => 'User has insufficient funds in wallet for Paid Purchase',
							)));
						}
					}
					
					if (count($product)>0){
						///////////////
						$tranx_id = $this->general->create_salt(12);
						$data['product_id'] 			= $this->input->post('product_id', true);
						$data['username'] 				= $this->input->post('username');
						$data['tranx_id'] 				= $tranx_id;
						$data['payment_gross'] 			= $product[0]['selling_price'];
						$data['currency_code'] 			= 'usd';
						$data['status'] 				= '1';
						if ($payment == 'paid'){
							$data['method'] 				= 'Internal-Wallet';
							$data['payment_details'] 		= 'Purchased by admin and paid by user internal wallet';
						} else {
							$data['method'] 				= 'Internal-Wallet';
							$data['payment_details'] 		= 'Purchased by admin without payment';
						}
						$data['dated'] 					= date('Y-m-d H:i:s');
						$this->db->insert('payments',$data);
						
						if ($payment == 'paid'){
							//deducting amount from wallet and sending notification
							$this->wallet->wallet_purchase($data['product_id'], $data['username'], $product[0]['selling_price'], $data['tranx_id'], 'Internal-Wallet');
						}
						
						//generating commissions for product purchase
						$this->commissions->purchase_product($data['username'], $data['product_id'], $data['tranx_id'], 'Internal-Wallet');
						
						die(json_encode(array(
							'redirect' => 'yes',
							'url' => base_url('admin/users'),
							'status' => 'success',
							'message' => 'Producted purchased successfully.',
						)));
						///////////////
					} else {
						die(json_encode(array(
							'redirect' => 'no',
							'url' => '',
							'status' => 'error',
							'message' => 'Product not found',
							'html' => ''
						)));
					}
				} else {
					die(json_encode(array(
						'redirect' => 'no',
						'url' => '',
						'status' => 'error',
						'message' => 'No product selected',
						'html' => ''
					)));
				}
			} else {
				die(json_encode(array(
					'redirect' => 'no',
					'url' => '',
					'status' => 'error',
					'message' => 'Invalid Request sent',
					'html' => ''
				)));
			}
			
		} elseif ($param1 == 'purchase-product' && $param2 !== ''){
			if ($this->returns->permission_access('purchase_product', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['username'] = $param2;
			$this->data['data'] = $this->general->get_all_tbl_data('products', '*');
			$this->load->view('modal/admin_purchase_product', $this->data);
		} elseif ($param1 == 'delete' && $param2 !== ''){
			if ($this->returns->permission_access('users_delete', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$matrix = $this->general->get_system_var('matrix');
			if ($matrix == '2x'){
				$has_childs = $this->matrix2x->user_has_childs($param2);
			} else {
				$has_childs = $this->matrix2x->user_has_childs($param2);
			}
			if ($has_childs == true){
				$this->session->set_flashdata('error', 'Cannot delete until user has childs.');
				redirect(base_url('admin/users'));
				exit();
			} else {
				$this->user_account->delete_user_record($param2);
				$this->session->set_flashdata('success', 'User Deleted successfully.');
				redirect(base_url('admin/users'));
				exit();
			}
			
		} elseif ($param1 == 'issue-e-pin' && $param2 !== ''){
			if ($this->returns->permission_access('users_issue_epin', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$data['username'] = $param2;
			$data['e_pin'] = $this->general->five_digit_key();//$this->input->post('epin', true);
			$data['dated'] = date('Y-m-d H:i:s');
			$save = $this->db->insert('e_pins', $data);
			$email = $this->user_account->user_email($param2);
			if ($email){
				$s = strtotime(date('Y-m-d H:i:s'));
				$mail_options = array(
					'name' 			=> $this->user_account->user_name($param2),
					'username' 		=> $param2,
					'system_name' 	=> $this->data['system_name'],
					'e_pin' 		=> $data['e_pin'],//$this->input->post('epin', true),
					'action_time' 	=> date('H:i:s', $s),
					'action_date' 	=> date('Y-m-d', $s)
				);
				$this->emails->send_type_email($email, 'epin_re_generated_by_admin', $mail_options);
				$mobile = $this->user_account->user_mobile($param2);
				if ($mobile){
					$this->sms->send_type_sms($mobile, 'epin_re_generated_by_admin', $mail_options);
				}
				$this->session->set_flashdata('success', 'E-PIN generated successfully.');
				redirect(base_url('admin/users'));
				exit();
			} else {
				$this->session->set_flashdata('error', 'An error occured, Please try again.');
				redirect(base_url('admin/users'));
				exit();
			}
		} elseif ($param1 == 'verify-email' && $param2 !== ''){
			if ($this->returns->permission_access('users_email_verify', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$userdata = $this->general->get_tbl_field('users', 'id', 'username', $param2);
			if (count($userdata)>0){
				$data['status'] = '1';
				$data['updated'] = date('Y-m-d H:i:s');
				$update = $this->general->update_data('users', 'username', $param2, $data);
				if ($update){
					$this->session->set_flashdata('success', 'Email Verified successfully');
					redirect(base_url('admin/users'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again');
					redirect(base_url('admin/users'));
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'User not Found');
				redirect(base_url('admin/users'));
				exit();
			}
		} elseif ($param1 == 'login-as' && $param2 !== ''){
			if ($this->returns->permission_access('users_login_as', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// login as user to view user profile and its related record
			$username_exists = $this->user_account->username_exists($param2);
			if ($username_exists == false){
				$this->session->set_flashdata('error', 'User not Found');
				redirect(base_url('admin/users'));
				exit();
			}
			$data = $this->user_account->get_user_data($param2);
			if (count($data)>0){
				$sessiondata = array(
					'isLogin'		=>	true,
					'user_name'		=>	$data[0]['username'],
					'user_group'	=>	$data[0]['user_group'],
					'user_id'		=>	$data[0]['id']
				);
				$this->session->set_userdata($sessiondata);
				$this->session->set_flashdata('success', 'Login Successful.');
				if ($data[0]['user_group'] == 'admin'){
					redirect(base_url('admin'));
				} elseif ($data[0]['user_group'] == 'member'){
					redirect(base_url('member'));
				}
				exit();
			} else {
				$this->session->set_flashdata('error', 'User not Found');
				redirect(base_url('admin/users'));
				exit();
			}
		} elseif ($param1 == 'do-update-avatar' && $param2 !== ''){
			if ($this->returns->permission_access('users_update_avatar', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//changing user avatar
			$validextensions = array("jpg", "jpeg", "png", "PNG");
			$logo_res = $this->general->upload_media($_FILES["logo"], $validextensions);
			if ($logo_res['status'] == 'error'){
				$this->session->set_flashdata('error', $logo_res['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$image = $logo_res['directory'].'/'.$logo_res['file_name'];
				$thumb = 'avatar-'.$logo_res['file_name'];
				$this->img_resize->load($image);
				$this->img_resize->resize(160,160);
				$this->img_resize->save('uploads/'.$thumb);
				
				$data['username'] = $this->input->post('username');
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
		} elseif ($param1 == 'do-update-password' && $param2 !== ''){
			if ($this->returns->permission_access('users_change_password', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// changing user password
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
				$data['updated'] = date('Y-m-d H:i:s');
				$data['password'] = md5($this->input->post('password', true));
				$update = $this->general->update_data('users', 'username', $this->input->post('username', true), $data);
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
				redirect('admin/users');
				exit();
			}
		} elseif ($param1 == 'do-update-profile' && $param2 !== ''){
			if ($this->returns->permission_access('users_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// updating user profile
			if ($this->input->post()){
				$userdata = $this->general->get_tbl_field('users', '*', 'username', $this->input->post('username', true));
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
				if ($userdata[0]['email'] !== $this->input->post('email', true)){
					if(!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)){
						$this->session->set_flashdata('error', 'Invalid Email address format');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
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
				
				$update = $this->general->update_data('users', 'username', $this->input->post('username', true), $data);
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
				redirect('admin/users');
				exit();
			}
		} elseif ($param1 == 'update-password' && $param2 !== ''){
			if ($this->returns->permission_access('users_change_password', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// user password update form
			$username_exists = $this->user_account->username_exists($param2);
			if ($username_exists == false){
				$this->session->set_flashdata('error', 'User not Found');
				redirect(base_url('admin/users'));
				exit();
			}
			$this->data['username'] = $param2;
			$this->data['file'] = 'user_password';
			$this->data['title'] = 'Update User Password';
			$this->data['page_title'] = 'Update User Password';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'edit-profile' && $param2 !== ''){
			if ($this->returns->permission_access('users_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//user profile update form if user exists
			$username_exists = $this->user_account->username_exists($param2);
			if ($username_exists == false){
				$this->session->set_flashdata('error', 'User not Found');
				redirect(base_url('admin/users'));
				exit();
			}
			$countries = file_get_contents(base_url('assets/countries.json'));
			$this->data['countries'] = json_decode($countries, true);
			$this->data['data'] = $this->general->get_tbl_field('users', '*', 'username', $param2);
			$this->data['file'] = 'user_profile';
			$this->data['title'] = 'User Profile';
			$this->data['page_title'] = 'User Profile';
			$this->load->view('admin/index', $this->data);
		}
	}
	public function wallets($param1='', $param2=''){
		if ($param1 == ''){
			if ($this->returns->permission_access('wallets_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//user wallets
			$this->data['data'] = $this->general->get_all_tbl_data('wallet', '*');
			$this->data['file'] = 'user_wallets';
			$this->data['title'] = 'User Wallets';
			$this->data['page_title'] = 'User Wallets';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'admin-transactions' && $param2 !== ''){
			if ($this->returns->permission_access('wallets_admin_transactions', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//transactions manually made by admin, e.g adding or deducting funds from user wallet
			$username_exists = $this->user_account->username_exists($param2);
			if ($username_exists == false){
				$this->session->set_flashdata('error', 'User not Found');
				redirect(base_url('admin/wallets'));
				exit();
			}
			$this->data['data'] = $this->general->get_all_tbl_data('admin_transactions', '*', 'transfer_to', $param2);
			$this->data['file'] = 'user_wallet_admin_transaction';
			$this->data['title'] = 'Admin Transactions';
			$this->data['page_title'] = 'Admin Transactions';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'history' && $param2 !== ''){
			if ($this->returns->permission_access('wallets_history', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$username_exists = $this->user_account->username_exists($param2);
			if ($username_exists == false){
				$this->session->set_flashdata('error', 'User not Found');
				redirect(base_url('admin/wallets'));
				exit();
			}
			$this->data['data'] = $this->general->get_tbl_field('wallet_statement', '*', 'username', $param2);
			$this->data['file'] = 'wallet_statement';
			$this->data['title'] = 'User Wallet History';
			$this->data['page_title'] = 'User Wallet History';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'user' && $param2 !== ''){
			if ($this->returns->permission_access('wallets_options', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// specific user wallet for form for adding or deducting funds
			$username_exists = $this->user_account->username_exists($param2);
			if ($username_exists == false){
				$this->session->set_flashdata('error', 'User not Found');
				redirect(base_url('admin/wallets'));
				exit();
			}
			$this->data['amount'] = $this->wallet->wallet_amount($param2, 'wallet');
			$this->data['username'] = $param2;
			$this->data['file'] = 'user_wallet';
			$this->data['title'] = 'User Wallet';
			$this->data['page_title'] = 'User Wallet  <small>(Current Balance: '.currency($this->data['amount']).')</small>';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'add-funds'){
			if ($this->returns->permission_access('wallets_options', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//adding funds to user wallet
			if ($this->input->post()){
				$response = $this->wallet->add_funds($this->input->post('username', true), $this->input->post('amount', true));
				$this->session->set_flashdata($response['status'], $response['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent');
				redirect(base_url('admin/wallets'));
				exit();
			}
		} elseif ($param1 == 'deduct-funds'){
			if ($this->returns->permission_access('wallets_options', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//deducting funds from user wallet
			if ($this->input->post()){
				$response = $this->wallet->deduct_funds($this->input->post('username', true), $this->input->post('amount', true));
				$this->session->set_flashdata($response['status'], $response['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent');
				redirect(base_url('admin/wallets'));
				exit();
			}
		} elseif ($param1 == 'bonus-status'){
			if ($this->returns->permission_access('wallets_options', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				$this->general->delete_tbl_data('user_bonus_disabled', 'username', $this->input->post('username'));
				$data['username'] = $this->input->post('username', true);
				$data['dated'] = date('Y-m-d H:i:s');
				if ($this->input->post('psb_disabled') == true){
					$data['bonus_type'] = 'personal-sponsor-bonus';
					$this->db->insert('user_bonus_disabled', $data);
				}
				if ($this->input->post('nbb_disabled') == true){
					$data['bonus_type'] = 'network-binary-bonus';
					$this->db->insert('user_bonus_disabled', $data);
				}
				if ($this->input->post('gb_disabled') == true){
					$data['bonus_type'] = 'generation-bonus';
					$this->db->insert('user_bonus_disabled', $data);
				}
				if ($this->input->post('rgb_disabled') == true){
					$data['bonus_type'] = 'reverse-generation-bonus';
					$this->db->insert('user_bonus_disabled', $data);
				}
				if ($this->input->post('roi_disabled') == true){
					$data['bonus_type'] = 'roi';
					$this->db->insert('user_bonus_disabled', $data);
				}
				if ($this->input->post('mroi_disabled') == true){
					$data['bonus_type'] = 'matching-roi';
					$this->db->insert('user_bonus_disabled', $data);
				}
				$this->session->set_flashdata('success', 'Bonus Status Updated.');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent');
				redirect(base_url('admin/wallets'));
				exit();
			}
		} elseif ($param1 == 'wallet-status'){
			if ($this->returns->permission_access('wallets_options', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				if ($this->input->post('withdraw_disabled') == true){
					$data['withdraw_disabled'] = '1';
				} else {
					$data['withdraw_disabled'] = '0';
				}
				if ($this->input->post('transfer_disabled') == true){
					$data['transfer_disabled'] = '1';
				} else {
					$data['transfer_disabled'] = '0';
				}
				$update = $this->general->update_data('users', 'username', $this->input->post('username', true), $data);
				if ($update){
					$this->session->set_flashdata('success', 'Wallet Status Updated.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent');
				redirect(base_url('admin/wallets'));
				exit();
			}
		}
	}
	public function withdraws($param1='', $param2='', $param3=''){
		if ($param1 == '' && $param2 == ''){
			if ($this->returns->permission_access('withdraw_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_all_tbl_data('withdraw', '*');
			$this->data['file'] = 'withdraws_list';
			$this->data['title'] = 'Withdraw';
			$this->data['page_title'] = 'Withdraw';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'approve' && $param2 !== ''){
			if ($this->returns->permission_access('withdraw_approve', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//approve withdraw request
			$withdrawData = $this->general->get_tbl_field('withdraw', '*', 'id', $param2);
			if (count($withdrawData)>0){
				if ($withdrawData[0]['status'] == 2){
					$this->session->set_flashdata('success', 'Transaction Closed');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				//sending approval notification to user
				$noti['username'] = $withdrawData[0]['username'];
				$noti['msg_from'] = 'Admin';
				$noti['message'] = 'Withwraw Transaction ID '.$withdrawData[0]['transection_id'].' has been approved';
				$noti['dated'] = date('Y-m-d H:i:s');
				$this->db->insert('notifications', $noti);
			
				$updata['status'] = '1';
				$updata['approve_date'] = date('Y-m-d H:i:s');
				$saved = $this->general->update_data('withdraw', 'id', $param2, $updata);
				
				$email = $this->user_account->user_email($withdrawData[0]['username']);
				if ($email){
					$s = strtotime($noti['dated']);
					$mail_options = array(
						'name' 			=> $this->user_account->user_name($withdrawData[0]['username']),
						'username' 		=> $withdrawData[0]['username'],
						'system_name' 	=> $this->data['system_name'],
						'transaction_id' 		=> $withdrawData[0]['transection_id'],
						'withdraw_amount' 		=> $withdrawData[0]['amount'],
						'withdraw_fee' 		=> $withdrawData[0]['fees'],
						'withdraw_receiveable' 		=> $withdrawData[0]['withdrawable'],
						'withdraw_method' 		=> $withdrawData[0]['method'],
						'withdraw_method_details' 		=> $withdrawData[0]['details'],
						'action_time' 	=> date('H:i:s', $s),
						'action_date' 	=> date('Y-m-d', $s)
					);
					$this->emails->send_type_email($email, 'withdraw_confirmed', $mail_options);
					$mobile = $this->user_account->user_mobile($withdrawData[0]['username']);
					if ($mobile){
						$this->sms->send_type_sms($mobile, 'withdraw_confirmed', $mail_options);
					}
				}
				
				$this->session->set_flashdata('success', 'Withdraw Completed');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('admin/withdraws'));
				exit();
			}
			
		} elseif ($param1 == 'reject' && $param2 !== ''){
			if ($this->returns->permission_access('withdraw_reject', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// rejecting withdraw request
			$withdrawData = $this->general->get_tbl_field('withdraw', '*', 'id', $param2);
			if (count($withdrawData)>0){
				if ($withdrawData[0]['status'] == 1){
					$this->session->set_flashdata('success', 'Transaction Closed');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				
				//sending rejection notification
				$noti['username'] = $withdrawData[0]['username'];
				$noti['msg_from'] = 'Admin';
				$noti['message'] = 'Withwraw Transaction ID '.$withdrawData[0]['transection_id'].' has been rejected and '.currency($withdrawData[0]['amount']) .' has been credited to your Account';
				$noti['dated'] = date('Y-m-d H:i:s');
				$this->db->insert('notifications', $noti);
				
				//sending funds back to user wallet
				
				$statement_message = 'Withwraw Transaction ID '.$withdrawData[0]['transection_id'].' has been rejected and '.currency($withdrawData[0]['amount']) .' has been credited to your Wallet';
				$this->wallet->add_wallet_statement($withdrawData[0]['username'], $withdrawData[0]['transection_id'], $statement_message, 'Credit', $withdrawData[0]['amount']);
				
				$this->wallet->add_to_wallet($withdrawData[0]['username'], $withdrawData[0]['amount'], 'wallet');
				
				$updata['status'] = '2';
				$saved = $this->general->update_data('withdraw', 'id', $param2, $updata);
				
				$email = $this->user_account->user_email($withdrawData[0]['username']);
				if ($email){
					$s = strtotime($noti['dated']);
					$mail_options = array(
						'name' 			=> $this->user_account->user_name($withdrawData[0]['username']),
						'username' 		=> $withdrawData[0]['username'],
						'system_name' 	=> $this->data['system_name'],
						'transaction_id' 		=> $withdrawData[0]['transection_id'],
						'withdraw_amount' 		=> $withdrawData[0]['amount'],
						'withdraw_fee' 		=> $withdrawData[0]['fees'],
						'withdraw_receiveable' 		=> $withdrawData[0]['withdrawable'],
						'withdraw_method' 		=> $withdrawData[0]['method'],
						'withdraw_method_details' 		=> $withdrawData[0]['details'],
						'action_time' 	=> date('H:i:s', $s),
						'action_date' 	=> date('Y-m-d', $s)
					);
					$this->emails->send_type_email($email, 'withdraw_rejected', $mail_options);
					$mobile = $this->user_account->user_mobile($withdrawData[0]['username']);
					if ($mobile){
						$this->sms->send_type_sms($mobile, 'withdraw_rejected', $mail_options);
					}
				}
				
				$this->session->set_flashdata('success', 'Withdraw Rejected');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('admin/withdraws'));
				exit();
			}
			
			
		}
	}
	public function transfers($param1=''){
		if ($param1 == ''){
			if ($this->returns->permission_access('transfers_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_all_tbl_data('transfers', '*');
			$this->data['file'] = 'transfers_list';
			$this->data['title'] = 'Funds Transfer';
			$this->data['page_title'] = 'Funds Transfer';
			$this->load->view('admin/index', $this->data);
		}
	}
	public function profile($param1='', $param2=''){
		//admin profile
		if ($param1 == ''){
			$countries = file_get_contents(base_url('assets/countries.json'));
			$this->data['countries'] = json_decode($countries, true);
			$this->data['data'] = $this->general->get_tbl_field('users', '*', 'username', $this->session->userdata('user_name'));
			$this->data['file'] = 'profile';
			$this->data['title'] = 'Profile';
			$this->data['page_title'] = 'Profile';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'do-update' && $param2 == 'avatar'){
			//updating admin avatar
			$validextensions = array("jpg", "jpeg", "png", "PNG");
			$logo_res = $this->general->upload_media($_FILES["logo"], $validextensions);
			if ($logo_res['status'] == 'error'){
				$this->session->set_flashdata('error', $logo_res['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$image = $logo_res['directory'].'/'.$logo_res['file_name'];
				$thumb = 'avatar-'.$logo_res['file_name'];
				
				//resizing image to 160 x 160
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
			//updating admin profile
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
				if ($userdata[0]['email'] !== $this->input->post('email', true)){
					if(!filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)){
						$this->session->set_flashdata('error', 'Invalid Email address format');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
					//checking if new email is already used
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
				redirect(base_url('admin/profile'));
				exit();
			}
		} elseif ($param1 == 'change-password' && $param2 == ''){
			$this->data['file'] = 'change_password';
			$this->data['title'] = 'Change Password';
			$this->data['page_title'] = 'Change Password';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'change-password' && $param2 == 'do'){
			if ($this->input->post()){
				// changing password and verifying current password
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
				redirect(base_url('admin/profile/change-profile'));
				exit();
			}
		}
		
	}
	public function ranking($param1 = '', $param2 = '', $param3 = ''){
		if ($param1 == ''){
			if ($this->returns->permission_access('ranking_list', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_all_data_by_order('ranks', '*', 'rank_order', 'ASC');
			$this->data['file'] = 'rankings_list';
			$this->data['title'] = 'Ranking';
			$this->data['page_title'] = 'Ranking';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'edit' && $param2 !== ''){
			if ($this->returns->permission_access('ranking_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_tbl_field('ranks', '*', 'id', $param2);
			if (count($this->data['data'])>0){
				$this->data['file'] = 'rankings_edit';
				$this->data['title'] = 'Edit Rank';
				$this->data['page_title'] = 'Edit Rank';
				$this->load->view('admin/index', $this->data);
			} else {
				$this->session->set_flashdata('error', 'Record not Found');
				redirect(base_url('admin/ranking'));
				exit();
			}
		} elseif ($param1 == 'do-edit'){
			if ($this->returns->permission_access('ranking_edit', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				if (empty ($this->input->post('title', true))){
					$this->session->set_flashdata('error', 'Rank title required.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty ($this->input->post('rank_order', true))){
					$this->session->set_flashdata('error', 'Rank Order required.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('psb_min', true)) || $this->input->post('psb_min', true) == '0'){
					$data['psb_min'] = '0';
					$data['psb_max'] = $this->input->post('psb_max', true);
				} else {
					if ($this->input->post('psb_min', true) > $this->input->post('psb_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding_except_current($this->input->post('psb_min'), $this->input->post('psb_min'), 'psb', $this->input->post('rank_id'))){
							$this->session->set_flashdata('error', 'Personal sponsor bonus values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['psb_min'] = $this->input->post('psb_min', true);
							$data['psb_max'] = $this->input->post('psb_max', true);
						}
					}
				}
				
				if (empty($this->input->post('nbb_min', true)) || $this->input->post('nbb_min', true) == '0'){
					$data['nbb_min'] = '0';
					$data['nbb_max'] = $this->input->post('nbb_max', true);
				} else {
					if ($this->input->post('nbb_min', true) > $this->input->post('nbb_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding_except_current($this->input->post('nbb_min'), $this->input->post('nbb_max'), 'nbb', $this->input->post('rank_id'))){
							$this->session->set_flashdata('error', 'Network Binary bonus values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['nbb_min'] = $this->input->post('nbb_min', true);
							$data['nbb_max'] = $this->input->post('nbb_max', true);
						}
					}
				}
				
				if (empty($this->input->post('gb_min', true)) || $this->input->post('gb_min', true) == '0'){
					$data['gb_min'] = '0';
					$data['gb_max'] = $this->input->post('gb_max', true);
				} else {
					if ($this->input->post('gb_min', true) > $this->input->post('gb_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding_except_current($this->input->post('gb_min'), $this->input->post('gb_max'), 'gb', $this->input->post('rank_id'))){
							$this->session->set_flashdata('error', 'Generation bonus values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['gb_min'] = $this->input->post('gb_min', true);
							$data['gb_max'] = $this->input->post('gb_max', true);
						}
					}
				}
				
				if (empty($this->input->post('rgb_min', true)) || $this->input->post('rgb_min', true) == '0'){
					$data['rgb_min'] = '0';
					$data['rgb_max'] = $this->input->post('rgb_max', true);
				} else {
					if ($this->input->post('rgb_min', true) > $this->input->post('rgb_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding_except_current($this->input->post('rgb_min'), $this->input->post('rgb_max'), 'rgb', $this->input->post('rank_id'))){
							$this->session->set_flashdata('error', 'Reverse Generation bonus values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['rgb_min'] = $this->input->post('rgb_min', true);
							$data['rgb_max'] = $this->input->post('rgb_max', true);
						}
					}
				}
				
				if (empty($this->input->post('roi_min', true)) || $this->input->post('roi_min', true) == '0'){
					$data['roi_min'] = '0';
					$data['roi_max'] = $this->input->post('roi_max', true);
				} else {
					if ($this->input->post('roi_min', true) > $this->input->post('roi_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding_except_current($this->input->post('roi_min'), $this->input->post('roi_max'), 'roi', $this->input->post('rank_id'))){
							$this->session->set_flashdata('error', 'ROI values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['roi_min'] = $this->input->post('roi_min', true);
							$data['roi_max'] = $this->input->post('roi_max', true);
						}
					}
				}
				
				if (empty($this->input->post('m_roi_min', true)) || $this->input->post('m_roi_min', true) == '0'){
					$data['m_roi_min'] = '0';
					$data['m_roi_max'] = $this->input->post('m_roi_max', true);
				} else {
					if ($this->input->post('m_roi_min', true) > $this->input->post('m_roi_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding_except_current($this->input->post('m_roi_min'), $this->input->post('m_roi_max'), 'm_roi', $this->input->post('rank_id'))){
							$this->session->set_flashdata('error', 'Matching ROI values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['m_roi_min'] = $this->input->post('m_roi_min', true);
							$data['m_roi_max'] = $this->input->post('m_roi_max', true);
						}
					}
				}
				
				if (empty($this->input->post('min_direct_business', true))){
					$data['min_direct_business'] = '0';
				} else {
					$data['min_direct_business'] = $this->input->post('min_direct_business', true);
				}
				
				if (empty($this->input->post('min_team_business', true))){
					$data['min_team_business'] = '0';
				} else {
					$data['min_team_business'] = $this->input->post('min_team_business', true);
				}
				$data['title'] = $this->input->post('title', true);
				$data['rank_order'] = $this->input->post('rank_order', true);
				$data['rank_color'] = $this->input->post('rank_color', true);
				$update = $this->general->update_data('ranks', 'id', $this->input->post('rank_id'), $data);
				if ($update){
					$this->session->set_flashdata('success', 'Record updated successfully.');
					redirect(base_url('admin/ranking'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/ranking/add-new'));
				exit();
			}
		} elseif ($param1 == 'add-new' && $param2 == ''){
			if ($this->returns->permission_access('ranking_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'rankings_add';
			$this->data['title'] = 'Create New Rank';
			$this->data['page_title'] = 'Create New Rank';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'add-new' && $param2 == 'proceed'){
			if ($this->returns->permission_access('ranking_add', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				if (empty ($this->input->post('title', true))){
					$this->session->set_flashdata('error', 'Rank title required.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty ($this->input->post('rank_order', true))){
					$this->session->set_flashdata('error', 'Rank Order required.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('psb_min', true)) || $this->input->post('psb_min', true) == '0'){
					$data['psb_min'] = '0';
					$data['psb_max'] = $this->input->post('psb_max', true);
				} else {
					if ($this->input->post('psb_min', true) > $this->input->post('psb_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding($this->input->post('psb_min'), $this->input->post('psb_min'), 'psb')){
							$this->session->set_flashdata('error', 'Personal sponsor bonus values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['psb_min'] = $this->input->post('psb_min', true);
							$data['psb_max'] = $this->input->post('psb_max', true);
						}
					}
				}
				
				if (empty($this->input->post('nbb_min', true)) || $this->input->post('nbb_min', true) == '0'){
					$data['nbb_min'] = '0';
					$data['nbb_max'] = $this->input->post('nbb_max', true);
				} else {
					if ($this->input->post('nbb_min', true) > $this->input->post('nbb_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding($this->input->post('nbb_min'), $this->input->post('nbb_max'), 'nbb')){
							$this->session->set_flashdata('error', 'Network Binary bonus values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['nbb_min'] = $this->input->post('nbb_min', true);
							$data['nbb_max'] = $this->input->post('nbb_max', true);
						}
					}
				}
				
				if (empty($this->input->post('gb_min', true)) || $this->input->post('gb_min', true) == '0'){
					$data['gb_min'] = '0';
					$data['gb_max'] = $this->input->post('gb_max', true);
				} else {
					if ($this->input->post('gb_min', true) > $this->input->post('gb_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding($this->input->post('gb_min'), $this->input->post('gb_max'), 'gb')){
							$this->session->set_flashdata('error', 'Generation bonus values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['gb_min'] = $this->input->post('gb_min', true);
							$data['gb_max'] = $this->input->post('gb_max', true);
						}
					}
				}
				
				if (empty($this->input->post('rgb_min', true)) || $this->input->post('rgb_min', true) == '0'){
					$data['rgb_min'] = '0';
					$data['rgb_max'] = $this->input->post('rgb_max', true);
				} else {
					if ($this->input->post('rgb_min', true) > $this->input->post('rgb_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding($this->input->post('rgb_min'), $this->input->post('rgb_max'), 'rgb')){
							$this->session->set_flashdata('error', 'Reverse Generation bonus values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['rgb_min'] = $this->input->post('rgb_min', true);
							$data['rgb_max'] = $this->input->post('rgb_max', true);
						}
					}
				}
				
				if (empty($this->input->post('roi_min', true)) || $this->input->post('roi_min', true) == '0'){
					$data['roi_min'] = '0';
					$data['roi_max'] = $this->input->post('roi_max', true);
				} else {
					if ($this->input->post('roi_min', true) > $this->input->post('roi_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding($this->input->post('roi_min'), $this->input->post('roi_max'), 'roi')){
							$this->session->set_flashdata('error', 'ROI values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['roi_min'] = $this->input->post('roi_min', true);
							$data['roi_max'] = $this->input->post('roi_max', true);
						}
					}
				}
				
				if (empty($this->input->post('m_roi_min', true)) || $this->input->post('m_roi_min', true) == '0'){
					$data['m_roi_min'] = '0';
					$data['m_roi_max'] = $this->input->post('m_roi_max', true);
				} else {
					if ($this->input->post('m_roi_min', true) > $this->input->post('m_roi_max', true)){
						$this->session->set_flashdata('error', 'Max Value must be greater than min value.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						if ($this->ranking_model->is_overriding($this->input->post('m_roi_min'), $this->input->post('m_roi_max'), 'm_roi')){
							$this->session->set_flashdata('error', 'Matching ROI values overlaping to existing rank.');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						} else {
							$data['m_roi_min'] = $this->input->post('m_roi_min', true);
							$data['m_roi_max'] = $this->input->post('m_roi_max', true);
						}
					}
				}
				
				if (empty($this->input->post('min_direct_business', true))){
					$data['min_direct_business'] = '0';
				} else {
					$data['min_direct_business'] = $this->input->post('min_direct_business', true);
				}
				
				if (empty($this->input->post('min_team_business', true))){
					$data['min_team_business'] = '0';
				} else {
					$data['min_team_business'] = $this->input->post('min_team_business', true);
				}
				$data['title'] = $this->input->post('title', true);
				$data['rank_order'] = $this->input->post('rank_order', true);
				$data['rank_color'] = $this->input->post('rank_color', true);
				$save = $this->db->insert('ranks', $data);
				if ($save){
					$this->session->set_flashdata('success', 'New Rank addedd successfully.');
					redirect(base_url('admin/ranking'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/ranking/add-new'));
				exit();
			}
		} elseif ($param1 == 'delete' && $param2 == ''){
			if ($this->returns->permission_access('ranking_delete', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
		}
	}
	public function settings($param1 = '', $param2 = '', $param3 = ''){
		if ($param1 == ''){
			
		
		} elseif ($param1 == 'sms-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_sms_gateway', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'sms_settings';
			$this->data['title'] = 'SMS Gateway Settings';
			$this->data['page_title'] = 'SMS Gateway Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'sms-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_sms_gateway', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				$data['option_value'] = $this->input->post('twillo_status', true);
				$this->db->where('option_name' , 'twillo_status');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('twillo_phone_number', true);
				$this->db->where('option_name' , 'twillo_phone_number');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('twillo_sid', true);
				$this->db->where('option_name' , 'twillo_sid');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('twillo_token', true);
				$this->db->where('option_name' , 'twillo_token');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('messente_status', true);
				$this->db->where('option_name' , 'messente_status');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('messente_phone_number', true);
				$this->db->where('option_name' , 'messente_phone_number');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('messente_username', true);
				$this->db->where('option_name' , 'messente_username');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('messente_password', true);
				$this->db->where('option_name' , 'messente_password');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('infobip_status', true);
				$this->db->where('option_name' , 'infobip_status');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('infobip_phone_number', true);
				$this->db->where('option_name' , 'infobip_phone_number');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('infobip_username', true);
				$this->db->where('option_name' , 'infobip_username');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('infobip_password', true);
				$this->db->where('option_name' , 'infobip_password');
				$this->db->update('options' , $data);
				
				$this->session->set_flashdata('success', 'SMS Gateway Settings updated');
				redirect(base_url('admin/settings/sms-settings'));
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent');
				redirect(base_url('admin/settings/sms-settings'));
				exit();
			}
		} elseif ($param1 == 'sms-templates' && $param2 == ''){
			if ($this->returns->permission_access('settings_sms_templates', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_all_tbl_data('sms_templates', '*');
			$this->data['file'] = 'sms_templates';
			$this->data['title'] = 'SMS Templates';
			$this->data['page_title'] = 'SMS Templates';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'sms-templates' && $param2 == 'edit'){
			if ($this->returns->permission_access('settings_sms_templates', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_tbl_field('sms_templates', '*', 'id', $param3);
			if (count($this->data['data'])>0){
				$this->data['file'] = 'sms_template';
				$this->data['title'] = 'Edit SMS Template';
				$this->data['page_title'] = 'Edit SMS Template';
				$this->load->view('admin/index', $this->data);
			} else {
				$this->session->set_flashdata('error', 'Record Not found');
				redirect(base_url('admin/settings/sms-templates'));
				exit();
			}
			
		} elseif ($param1 == 'sms-templates' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_sms_templates', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				
				if (empty($this->input->post('message', true))){
					$this->session->set_flashdata('error', 'Message Body Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (strlen($this->input->post('message', true)) > 260){
					$this->session->set_flashdata('error', 'Maximum 260 chracters are allowed');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$tags = array("<script>", "</script>");
				$message = str_replace($tags, "", $this->input->post('message', true));
				 
				$data['status'] = $this->input->post('status', true);
				$data['message'] = $message;
				$updated = $this->general->update_data('sms_templates', 'id', $this->input->post('template_id', true), $data);
				if ($updated){
					$this->session->set_flashdata('success', 'SMS Template updated successfully');
					redirect(base_url('admin/settings/sms-templates'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, please try again');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent');
				redirect(base_url('admin/settings/sms-templates'));
				exit();
			}
		} elseif ($param1 == 'email-templates' && $param2 == ''){
			if ($this->returns->permission_access('settings_email_templates', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_all_tbl_data('email_templates', '*');
			$this->data['file'] = 'email_templates';
			$this->data['title'] = 'Email Templates';
			$this->data['page_title'] = 'Email Templates';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'email-templates' && $param2 == 'edit'){
			if ($this->returns->permission_access('settings_email_templates', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_tbl_field('email_templates', '*', 'id', $param3);
			if (count($this->data['data'])>0){
				$this->data['file'] = 'email_template';
				$this->data['title'] = 'Edit Email Template';
				$this->data['page_title'] = 'Edit Email Template';
				$this->load->view('admin/index', $this->data);
			} else {
				$this->session->set_flashdata('error', 'Record Not found');
				redirect(base_url('admin/settings/email-templates'));
				exit();
			}
			
			//$this->load->view('modal/email-template', $this->data);
		} elseif ($param1 == 'email-templates' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_email_templates', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				if (empty($this->input->post('subject', true))){
					$this->session->set_flashdata('error', 'Email Subject Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('message', true))){
					$this->session->set_flashdata('error', 'Email Body Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$tags = array("<script>", "</script>");
				$message = str_replace($tags, "", $this->input->post('message', false));
				 
				$data['status'] = $this->input->post('status', true);
				$data['subject'] = $this->input->post('subject', true);
				$data['message'] = $message;
				$updated = $this->general->update_data('email_templates', 'id', $this->input->post('template_id', true), $data);
				if ($updated){
					$this->session->set_flashdata('success', 'Email Template updated successfully');
					redirect(base_url('admin/settings/email-templates'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, please try again');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent');
				redirect(base_url('admin/settings/email-templates'));
				exit();
			}
		} elseif ($param1 == 'kyc-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_kyc', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['data'] = $this->general->get_all_tbl_data('kyc_requirements', 'id, document_title');
			$this->data['file'] = 'kyc_settings';
			$this->data['title'] = 'KYC Settings';
			$this->data['page_title'] = 'KYC Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'kyc-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_kyc', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post('kyc_status', true) == '1'){
				$docs = $this->input->post('docs', true);
				if (count($docs)>0){
					if ($docs[0] == ''){
						$this->session->set_flashdata('error', 'Atlease one document required if KYC is enabled');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						$this->db->empty_table('kyc_requirements');
						foreach ($docs as $doc){
							if ($doc !== ''){
								$this->db->insert('kyc_requirements', array('document_title' => $doc));
							}
						}
						
					}
				} else {
					$this->session->set_flashdata('error', 'Please Mention Required Documents');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			}
			$data['option_value'] = $this->input->post('kyc_status', true);
			$this->db->where('option_name' , 'kyc_status');
			$this->db->update('options' , $data);
			
			$this->session->set_flashdata('success', 'KYC Documents updated successfully');
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit();
		} elseif ($param1 == 'contact-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_contact', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'contact_settings';
			$this->data['title'] = 'Contact Settings';
			$this->data['page_title'] = 'Contact Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'contact-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_contact', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// contact and social media settings update
			if ($this->input->post()){
				$data['option_value'] = $this->input->post('facebook', true);
				$this->db->where('option_name' , 'facebook');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('twitter', true);
				$this->db->where('option_name' , 'twitter');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('google_plus', true);
				$this->db->where('option_name' , 'google_plus');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('pinterest', true);
				$this->db->where('option_name' , 'pinterest');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('linkedin', true);
				$this->db->where('option_name' , 'linkedin');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('youtube', true);
				$this->db->where('option_name' , 'youtube');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('instagram', true);
				$this->db->where('option_name' , 'instagram');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('delicious', true);
				$this->db->where('option_name' , 'delicious');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('dribbble', true);
				$this->db->where('option_name' , 'dribbble');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('foursquare', true);
				$this->db->where('option_name' , 'foursquare');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('gg-circle', true);
				$this->db->where('option_name' , 'gg-circle');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('forumbee', true);
				$this->db->where('option_name' , 'forumbee');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('qq', true);
				$this->db->where('option_name' , 'qq');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('snapchat', true);
				$this->db->where('option_name' , 'snapchat');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('tumblr', true);
				$this->db->where('option_name' , 'tumblr');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('twitch', true);
				$this->db->where('option_name' , 'twitch');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('vk', true);
				$this->db->where('option_name' , 'vk');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('whatsapp', true);
				$this->db->where('option_name' , 'whatsapp');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('vimeo', true);
				$this->db->where('option_name' , 'vimeo');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('phone', true);
				$this->db->where('option_name' , 'phone');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('address', true);
				$this->db->where('option_name' , 'address');
				$this->db->update('options' , $data);
				
				if (empty($this->input->post('email'))){
					$this->session->set_flashdata('error', 'Email Address Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if(!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)){
					$this->session->set_flashdata('error', 'Invalid Email address format');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				$data['option_value'] = $this->input->post('email', true);
				$this->db->where('option_name' , 'email');
				$this->db->update('options' , $data);
				
				$this->session->set_flashdata('success', 'Contact Settings Updated');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/settings/contact-settings'));
				exit();
			}
		} elseif ($param1 == 'commission-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_commission', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'commission_settings';
			$this->data['title'] = 'Commission Settings';
			$this->data['page_title'] = 'Commission Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'commission-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_commission', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//updating commission settings
			if ($this->input->post()){
				if ($this->input->post('personal_sponsor_bonus_status', true) == '1'){
					$personal_sponsor_bonus_values_array = explode(',', $this->input->post('personal_sponsor_bonus_values', true));
					if (count($personal_sponsor_bonus_values_array) != $this->input->post('personal_sponsor_bonus_levels', true)){
						$this->session->set_flashdata('error', 'Personal Sponsor Bonus Level and No of Level Values must be same');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						//if values in array are numeric
						if ($this->general->is_numeric_array($personal_sponsor_bonus_values_array) == true){
							$data['option_value'] = $this->input->post('personal_sponsor_bonus_levels', true);
							$this->db->where('option_name' , 'personal_sponsor_bonus_levels');
							$this->db->update('commission_settings' , $data);
							$data['option_value'] = json_encode($personal_sponsor_bonus_values_array);
							$this->db->where('option_name' , 'personal_sponsor_bonus_values');
							$this->db->update('commission_settings' , $data);
						} else {
							$this->session->set_flashdata('error', 'Personal Sponsor Bonus Level Values must be Numeric');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						}
					}
					
				}
				$data['option_value'] = $this->input->post('personal_sponsor_bonus_status', true);
				$this->db->where('option_name' , 'personal_sponsor_bonus_status');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('xup_status', true);
				$this->db->where('option_name' , 'xup_status');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('xup_level', true);
				$this->db->where('option_name' , 'xup_level');
				$this->db->update('commission_settings' , $data);
				//////////////////////////////////////////////////
				
				$data['option_value'] = $this->input->post('network_binary_bonus_status', true);
				$this->db->where('option_name' , 'network_binary_bonus_status');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('nbb_pair_type', true);
				$this->db->where('option_name' , 'nbb_pair_type');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('network_binary_bonus_percentage', true);
				$this->db->where('option_name' , 'network_binary_bonus_percentage');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('nbb_level_unlimited', true);
				$this->db->where('option_name' , 'nbb_level_unlimited');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('network_binary_bonus_levels', true);
				$this->db->where('option_name' , 'network_binary_bonus_levels');
				$this->db->update('commission_settings' , $data);
				//////////////////////////////////////////////////
				if ($this->input->post('generation_bonus_status', true) == '1'){
					$generation_bonus_values_array = explode(',', $this->input->post('generation_bonus_values', true));
					if (count($generation_bonus_values_array) != $this->input->post('generation_bonus_levels', true)){
						$this->session->set_flashdata('error', 'Generation Bonus Level and No of Level Values must be same');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						//if values in array are numeric
						if ($this->general->is_numeric_array($generation_bonus_values_array) == true){
							$data['option_value'] = $this->input->post('generation_bonus_levels', true);
							$this->db->where('option_name' , 'generation_bonus_levels');
							$this->db->update('commission_settings' , $data);
							$data['option_value'] = json_encode($generation_bonus_values_array);
							$this->db->where('option_name' , 'generation_bonus_values');
							$this->db->update('commission_settings' , $data);
						} else {
							$this->session->set_flashdata('error', 'Generation Bonus Level Values must be Numeric');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						}
					}
					
				}
				$data['option_value'] = $this->input->post('generation_bonus_status');
				$this->db->where('option_name' , 'generation_bonus_status');
				$this->db->update('commission_settings' , $data);
				//////////////////////////////////////////////////
				if ($this->input->post('reverse_generation_bonus_status', true) == '1'){
					$reverse_generation_bonus_values_array = explode(',', $this->input->post('reverse_generation_bonus_values', true));
					if (count($reverse_generation_bonus_values_array) != $this->input->post('reverse_generation_bonus_levels', true)){
						$this->session->set_flashdata('error', 'Reverse Generation Bonus Level and No of Level Values must be same');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						//if values in array are numeric
						if ($this->general->is_numeric_array($reverse_generation_bonus_values_array) == true){
							$data['option_value'] = $this->input->post('reverse_generation_bonus_levels', true);
							$this->db->where('option_name' , 'reverse_generation_bonus_levels');
							$this->db->update('commission_settings' , $data);
							$data['option_value'] = json_encode($reverse_generation_bonus_values_array);
							$this->db->where('option_name' , 'reverse_generation_bonus_values');
							$this->db->update('commission_settings' , $data);
						} else {
							$this->session->set_flashdata('error', 'Reverse Generation Bonus Level Values must be Numeric');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						}
					}
					
				}
				$data['option_value'] = $this->input->post('reverse_generation_bonus_status', true);
				$this->db->where('option_name' , 'reverse_generation_bonus_status');
				$this->db->update('commission_settings' , $data);
				//////////////////////////////////////////////////
				$data['option_value'] = $this->input->post('roi_status', true);
				$this->db->where('option_name' , 'roi_status');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('roi_percentage', true);
				$this->db->where('option_name' , 'roi_percentage');
				$this->db->update('commission_settings' , $data);
				//////////////////////////////////////////////////
				if ($this->input->post('matching_roi_status', true) == '1'){
					$matching_roi_values_array = explode(',', $this->input->post('matching_roi_values', true));
					if (count($matching_roi_values_array) != $this->input->post('matching_roi_levels', true)){
						$this->session->set_flashdata('error', 'Matching ROI Level and No of Level Values must be same');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						//if values in array are numeric
						if ($this->general->is_numeric_array($matching_roi_values_array) == true){
							$data['option_value'] = $this->input->post('matching_roi_levels', true);
							$this->db->where('option_name' , 'matching_roi_levels');
							$this->db->update('commission_settings' , $data);
							$data['option_value'] = json_encode($matching_roi_values_array);
							$this->db->where('option_name' , 'matching_roi_values');
							$this->db->update('commission_settings' , $data);
						} else {
							$this->session->set_flashdata('error', 'Matching ROI Level Values must be Numeric');
							header("Location: {$_SERVER['HTTP_REFERER']}");
							exit();
						}
					}
					
				}
				$data['option_value'] = $this->input->post('matching_roi_status', true);
				$this->db->where('option_name' , 'matching_roi_status');
				$this->db->update('commission_settings' , $data);
				//////////////////////////////////////////////////
				/////////////////////ELIGIBILITY/////////////////////
				$data['option_value'] = $this->input->post('psb_min_direct_sponsors', true);
				$this->db->where('option_name' , 'psb_min_direct_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('psb_min_purchases', true);
				$this->db->where('option_name' , 'psb_min_purchases');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('nbs_min_direct_sponsors', true);
				$this->db->where('option_name' , 'nbs_min_direct_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('nbs_min_binary_sponsors', true);
				$this->db->where('option_name' , 'nbs_min_binary_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('nbs_min_purchases', true);
				$this->db->where('option_name' , 'nbs_min_purchases');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('network_binary_bonus_base', true);
				$this->db->where('option_name' , 'network_binary_bonus_base');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('gb_min_direct_sponsors', true);
				$this->db->where('option_name' , 'gb_min_direct_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('gb_min_binary_sponsors', true);
				$this->db->where('option_name' , 'gb_min_binary_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('gb_min_direct_sponsors_bonus', true);
				$this->db->where('option_name' , 'gb_min_direct_sponsors_bonus');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('gb_min_nbb_bonus', true);
				$this->db->where('option_name' , 'gb_min_nbb_bonus');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('gb_min_purchases', true);
				$this->db->where('option_name' , 'gb_min_purchases');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('generation_bonus_base', true);
				$this->db->where('option_name' , 'generation_bonus_base');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('rgb_min_direct_sponsors', true);
				$this->db->where('option_name' , 'rgb_min_direct_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('rgb_min_binary_sponsors', true);
				$this->db->where('option_name' , 'rgb_min_binary_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('rgb_min_direct_sponsors_bonus', true);
				$this->db->where('option_name' , 'rgb_min_direct_sponsors_bonus');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('rgb_min_nbb_bonus', true);
				$this->db->where('option_name' , 'rgb_min_nbb_bonus');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('rgb_min_purchases', true);
				$this->db->where('option_name' , 'rgb_min_purchases');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('reverse_generation_bonus_base', true);
				$this->db->where('option_name' , 'reverse_generation_bonus_base');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('roi_min_direct_sponsors', true);
				$this->db->where('option_name' , 'roi_min_direct_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('roi_min_binary_sponsors', true);
				$this->db->where('option_name' , 'roi_min_binary_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('roi_min_direct_sponsors_bonus', true);
				$this->db->where('option_name' , 'roi_min_direct_sponsors_bonus');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('roi_min_nbb_bonus', true);
				$this->db->where('option_name' , 'roi_min_nbb_bonus');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('roi_min_purchases', true);
				$this->db->where('option_name' , 'roi_min_purchases');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('matching_roi_min_direct_sponsors', true);
				$this->db->where('option_name' , 'matching_roi_min_direct_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('matching_roi_min_binary_sponsors', true);
				$this->db->where('option_name' , 'matching_roi_min_binary_sponsors');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('matching_roi_min_direct_sponsors_bonus', true);
				$this->db->where('option_name' , 'matching_roi_min_direct_sponsors_bonus');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('matching_roi_min_nbb_bonus', true);
				$this->db->where('option_name' , 'matching_roi_min_nbb_bonus');
				$this->db->update('commission_settings' , $data);
				
				$data['option_value'] = $this->input->post('matching_roi_min_purchases', true);
				$this->db->where('option_name' , 'matching_roi_min_purchases');
				$this->db->update('commission_settings' , $data);
				/////////////////////ELIGIBILITY/////////////////////
				
				$this->session->set_flashdata('success', 'Commission Settings Updated');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/settings/commission-settings'));
				exit();
			}
			
		} elseif ($param1 == 'general-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_general', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'general_settings';
			$this->data['title'] = 'General Settings';
			$this->data['page_title'] = 'General Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'general-settings' && $param2 == 'logo'){
			if ($this->returns->permission_access('settings_general', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// Updating logo
			$validextensions = array("jpg", "jpeg", "png", "PNG");
			$logo_res = $this->general->upload_media($_FILES["logo"], $validextensions);
			if ($logo_res['status'] == 'error'){
				$this->session->set_flashdata('error', $logo_res['message']);
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$image = $logo_res['directory'].'/'.$logo_res['file_name'];
				$data['option_value'] = $image;
				if ($param3 == 'frontend'){
					// landing page logo
					$this->db->where('option_name' , 'logo');
				} elseif ($param3 == 'backend'){
					// admin panel, user panel and authintication form logo
					$this->db->where('option_name' , 'logo_backend');
				} elseif ($param3 == 'favicon'){
					// favicon for landing page, admin panel and user panel
					$this->db->where('option_name' , 'favicon');
				} elseif ($param3 == 'avatar'){
					// Default avatar for user profile
					$thumb = 'avatar-128-'.$logo_res['file_name'];
					$this->img_resize->load($image);
					$this->img_resize->resize(128,128);
					$this->img_resize->save('uploads/'.$thumb);
					$data['option_value'] = 'uploads/'.$thumb;
					$this->db->where('option_name' , 'avatar-small');
					$update = $this->db->update('options' , $data);
					
					$thumb = 'avatar-215-'.$logo_res['file_name'];
					$this->img_resize->load($image);
					$this->img_resize->resize(215,215);
					$this->img_resize->save('uploads/'.$thumb);
					$data['option_value'] = 'uploads/'.$thumb;
					$this->db->where('option_name' , 'avatar-big');
					
					$update = $this->db->update('options' , $data);
					if ($update){
						$this->session->set_flashdata('success', 'Image Uploaded.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						$this->session->set_flashdata('error', 'An error occured, Please try again.');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
				} elseif ($param3 == 'avatar-big'){
					// Default avatar for user profile
					$thumb = 'avatar-'.$logo_res['file_name'];
					$this->img_resize->load($image);
					$this->img_resize->resize(215,215);
					$this->img_resize->save('uploads/'.$thumb);
					$data['option_value'] = $thumb;
					$this->db->where('option_name' , 'avatar-big');
				}
				$update = $this->db->update('options' , $data);
				if ($update){
					$this->session->set_flashdata('success', 'Image Uploaded.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			}
		} elseif ($param1 == 'general-settings' && $param2 == 'seo-update'){
			if ($this->returns->permission_access('settings_general', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			if ($this->input->post()){
				$data['option_value'] = $this->input->post('meta_tags', true);
				$this->db->where('option_name' , 'meta_tags');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('meta_description', true);
				$this->db->where('option_name' , 'meta_description');
				$this->db->update('options' , $data);
				
				$this->session->set_flashdata('success', 'SEO Settings updated');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/settings/general-settings'));
				exit();
			}
		} elseif ($param1 == 'general-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_general', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			//update general settings
			if ($this->input->post()){
				
				if ($this->input->post('system_name', true) == ""){
					$this->session->set_flashdata('error', 'System Name Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$data['option_value'] = $this->input->post('system_name', true);
					$this->db->where('option_name' , 'system_name');
					$this->db->update('options' , $data);
				}
				if ($this->input->post('system_nick') == ""){
					$this->session->set_flashdata('error', 'Short Name Required', true);
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$data['option_value'] = $this->input->post('system_nick', true);
					$this->db->where('option_name' , 'system_nick');
					$this->db->update('options' , $data);
				}
				$data['option_value'] = $this->input->post('google_analytic_code', true);
				$this->db->where('option_name' , 'google_analytic_code');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('back_foot_left', TRUE);
				$this->db->where('option_name' , 'back_foot_left');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('back_foot_right', true);
				$this->db->where('option_name' , 'back_foot_right');
				$this->db->update('options' , $data);
				
				if ($this->input->post('ranking_system_status') == true){
					$data['option_value'] = '1';
				} else {
					$data['option_value'] = '0';
				}
				$this->db->where('option_name' , 'ranking_system_status');
				$this->db->update('options' , $data);
				
				if ($this->input->post('2fa_auth_status') == true){
					$data['option_value'] = '1';
				} else {
					$data['option_value'] = '0';
				}
				$this->db->where('option_name' , '2fa_auth_status');
				$this->db->update('options' , $data);
				
				if ($this->input->post('email_verification_required') == true){
					$data['option_value'] = '1';
				} else {
					$data['option_value'] = '0';
				}
				$this->db->where('option_name' , 'email_verification_required');
				$this->db->update('options' , $data);
				
				if ($this->input->post('epin_status') == true){
					$data['option_value'] = '1';
				} else {
					$data['option_value'] = '0';
				}
				$this->db->where('option_name' , 'epin_status');
				$this->db->update('options' , $data);
				
				if ($this->input->post('invitation_status') == true){
					$data['option_value'] = '1';
				} else {
					$data['option_value'] = '0';
				}
				$this->db->where('option_name' , 'invitation_status');
				$this->db->update('options' , $data);
				
				if ($this->input->post('register_without_sponsor') == true){
					$data['option_value'] = '1';
				} else {
					$data['option_value'] = '0';
				}
				$this->db->where('option_name' , 'register_without_sponsor');
				$this->db->update('options' , $data);
				
				if ($this->input->post('faqs_status') == true){
					$data['option_value'] = '1';
				} else {
					$data['option_value'] = '0';
				}
				$this->db->where('option_name' , 'faqs_status');
				$this->db->update('options' , $data);
				
				if ($this->input->post('sms_notifications_status') == true){
					$data['option_value'] = '1';
				} else {
					$data['option_value'] = '0';
				}
				$this->db->where('option_name' , 'sms_notifications_status');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('default_sms_gateway', true);
				$this->db->where('option_name' , 'default_sms_gateway');
				$this->db->update('options' , $data);
				
				$this->session->set_flashdata('success', 'General Settings updated');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/settings/general-settings'));
				exit();
			}
		} elseif ($param1 == 'smtp-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_smtp', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'smtp_settings';
			$this->data['title'] = 'SMTP Settings';
			$this->data['page_title'] = 'SMTP Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'smtp-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_smtp', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// updating SMTP settings
			if ($this->input->post()){
				if ($this->input->post('smtp_email', true) == ""){
					$this->session->set_flashdata('error', 'SMTP Email Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$data['option_value'] = $this->input->post('smtp_email', true);
					$this->db->where('option_name' , 'smtp_email');
					$this->db->update('options' , $data);
				}
				if ($this->input->post('smtp_password', true) == ""){
					$this->session->set_flashdata('error', 'SMTP Password Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$data['option_value'] = $this->input->post('smtp_password', true);
					$this->db->where('option_name' , 'smtp_password');
					$this->db->update('options' , $data);
				}
				if ($this->input->post('smtp_host', true) == ""){
					$this->session->set_flashdata('error', 'SMTP Host Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$data['option_value'] = $this->input->post('smtp_host', true);
					$this->db->where('option_name' , 'smtp_host');
					$this->db->update('options' , $data);
				}
				if ($this->input->post('smtp_port') == ""){
					$this->session->set_flashdata('error', 'SMTP Port Required', true);
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$data['option_value'] = $this->input->post('smtp_port', true);
					$this->db->where('option_name' , 'smtp_port');
					$this->db->update('options' , $data);
				}
				
				$this->session->set_flashdata('success', 'SMTP Settings updated');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/settings/smtp-settings'));
				exit();
			}
		} elseif ($param1 == 'transfer-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_transfer', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'transfer_settings';
			$this->data['title'] = 'Transfer Settings';
			$this->data['page_title'] = 'Transfer Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'transfer-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_transfer', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// updating transfer settings
			if ($this->input->post()){
				if ($this->input->post('min_transfer', true) == ""){
					$this->session->set_flashdata('error', 'Minimum Transfer Value Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$data['option_value'] = $this->input->post('min_transfer', true);
					$this->db->where('option_name' , 'min_transfer');
					$this->db->update('options' , $data);
				}
				
				$data['option_value'] = $this->input->post('enable_transfer', true);
				$this->db->where('option_name' , 'enable_transfer');
				$this->db->update('options' , $data);
				
				$this->session->set_flashdata('success', 'Transfer settings updated.');
				redirect(base_url('admin/settings/transfer-settings'));
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/settings/transfer-settings'));
				exit();
			}
		} elseif ($param1 == 'withdraw-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_withdraw', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$methods = json_decode($this->general->get_system_var('withdraw_methods'));
			$methods = implode(', ', $methods);
			$this->data['methods'] = $methods;
			$this->data['file'] = 'withdraw_settings';
			$this->data['title'] = 'Withdraw Settings';
			$this->data['page_title'] = 'Withdraw Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'withdraw-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_withdraw', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// updating withdraw settings
			if ($this->input->post()){
				if ($this->input->post('min_withdraw', true) == ""){
					$this->session->set_flashdata('error', 'Minimum Withdraw Value Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$data['option_value'] = $this->input->post('min_withdraw', true);
					$this->db->where('option_name' , 'min_withdraw');
					$this->db->update('options' , $data);
				}
				if ($this->input->post('withdraw_fee', true) == ""){
					$this->session->set_flashdata('error', 'Withdraw Fee Value Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$data['option_value'] = $this->input->post('withdraw_fee', true);
					$this->db->where('option_name' , 'withdraw_fee');
					$this->db->update('options' , $data);
				}
				if ($this->input->post('withdraw_methods', true) == ""){
					$this->session->set_flashdata('error', 'Atleast one Withdraw Method Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$methods = explode(',', $this->input->post('withdraw_methods', true));
					$data['option_value'] = json_encode($methods);
					$this->db->where('option_name' , 'withdraw_methods');
					$this->db->update('options' , $data);
				}
				$this->session->set_flashdata('success', 'Withdraw settings updated.');
				redirect(base_url('admin/settings/withdraw-settings'));
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/settings/withdraw-settings'));
				exit();
			}
		} elseif ($param1 == 'payment-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_payment_gateway', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['file'] = 'payment_settings';
			$this->data['title'] = 'InBound Payment Settings';
			$this->data['page_title'] = 'InBound Payment Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'payment-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_payment_gateway', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// Updating gateway payment settings for users to purchaase product
			if ($this->input->post()){
				$methods = array();
				if ($this->input->post('paypal_status', true) == '1'){
					$methods[] = 'Paypal';
				}
				if ($this->input->post('ipay88_status', true) == '1'){
					$methods[] = 'Ipay88';
				}
				if ($this->input->post('stripe_status', true) == '1'){
					$methods[] = 'Stripe';
				}
				if ($this->input->post('perfect_money_status', true) == '1'){
					$methods[] = 'Perfect-Money';
				}
				if ($this->input->post('wallet_status', true) == '1'){
					$methods[] = 'Internal-Wallet';
				}
				if ($this->input->post('manual_status', true) == '1'){
					$methods[] = 'Manual-Payment';
				}
				
				$data['option_value'] = json_encode($methods);
				$this->db->where('option_name' , 'active_payment_methods');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('wallet_status', true);
				$this->db->where('option_name' , 'wallet_status');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('manual_status', true);
				$this->db->where('option_name' , 'manual_status');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('paypal_status', true);
				$this->db->where('option_name' , 'paypal_status');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('paypal_email', true);
				$this->db->where('option_name' , 'paypal_email');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('perfect_money_account', true);
				$this->db->where('option_name' , 'perfect_money_account');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('ipay88_status', true);
				$this->db->where('option_name' , 'ipay88_status');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('ipay88_merchant_code', true);
				$this->db->where('option_name' , 'ipay88_merchant_code', true);
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('ipay88_merchant_key', true);
				$this->db->where('option_name' , 'ipay88_merchant_key');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('stripe_status', true);
				$this->db->where('option_name' , 'stripe_status');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('stripe_key', true);
				$this->db->where('option_name' , 'stripe_key');
				$this->db->update('options' , $data);
				
				$data['option_value'] = $this->input->post('stripe_secret', true);
				$this->db->where('option_name' , 'stripe_secret');
				$this->db->update('options' , $data);
				
				$this->session->set_flashdata('success', 'Payment Settings updated');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/settings/payment-settings'));
				exit();
			}
		} elseif ($param1 == 'currency-settings' && $param2 == ''){
			if ($this->returns->permission_access('settings_currency', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['currencies'] = $this->general->get_tbl_field_no_order('currency_settings', '*', 'status', 'ok');
			$this->data['file'] = 'currency_settings';
			$this->data['title'] = 'Currency Settings';
			$this->data['page_title'] = 'Currency Settings';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'currency' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_currency', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// Managing currency list
			if ($this->input->post()){
				if (empty($this->input->post('name', true))){
					$this->session->set_flashdata('error', 'Currency Name Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('symbol', true))){
					$this->session->set_flashdata('error', 'Currency Symbol Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if (empty($this->input->post('exchange_rate', true))){
					$this->session->set_flashdata('error', 'Currency Exchange Rate Required');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
				if ($this->input->post('status', true) == true){
					$status = 'ok';
				} else {
					$status = 'no';
				}
				$data['name'] = $this->input->post('name', true);
				$data['symbol'] = $this->input->post('symbol', true);
				$data['exchange_rate'] = $this->input->post('exchange_rate', true);
				$data['status'] = $status;
				$update = $this->general->update_data('currency_settings', 'currency_settings_id', $this->input->post('currency_settings_id', true), $data);
				if ($update){
					$this->session->set_flashdata('success', 'Currency updated successfully');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					header("Location: {$_SERVER['HTTP_REFERER']}");
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid request sent.');
				redirect(base_url('admin/settings/currency/list'));
				exit();
			}
		} elseif ($param1 == 'currency' && $param2 == 'list'){
			if ($this->returns->permission_access('settings_currency', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			$this->data['currencies'] = $this->general->get_all_tbl_data('currency_settings', '*');
			$this->data['file'] = 'currency_list';
			$this->data['title'] = 'Currencies';
			$this->data['page_title'] = 'Currencies';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'currency-settings' && $param2 == 'update'){
			if ($this->returns->permission_access('settings_currency', $this->session->userdata('user_name')) == false){
				$this->error_404();
			}
			// Updating currency settings
			$data['option_value'] = $this->input->post('currency_status', true);
			$this->db->where('option_name' , 'currency_status');
			$this->db->update('options' , $data);
			
			$data['option_value'] = $this->input->post('def_currency', true);
			$this->db->where('option_name' , 'def_currency');
			$this->db->update('options' , $data);
			
			$data['option_value'] = $this->input->post('currency_format', true);
			$this->db->where('option_name' , 'currency_format');
			$this->db->update('options' , $data);
			
			$data['option_value'] = $this->input->post('symbol_format', true);
			$this->db->where('option_name' , 'symbol_format');
			$this->db->update('options' , $data);
			
			$data['option_value'] = $this->input->post('no_of_decimals', true);
			$this->db->where('option_name' , 'no_of_decimals');
			$this->db->update('options' , $data);
			
			$this->session->set_flashdata('success', 'Currency Settings updated');
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit();
		}
	}
	public function cron_jobs(){
		if ($this->returns->permission_access('cron_jobs_list', $this->session->userdata('user_name')) == false){
			$this->error_404();
		}
		$this->data['file'] = 'cron_jobs';
		$this->data['title'] = 'Cron jobs';
		$this->data['page_title'] = 'Cron Jobs';
		$this->load->view('admin/index', $this->data);
	}
	public function database_backup($param1 = '', $param2=''){
		if ($this->returns->permission_access('database_backup', $this->session->userdata('user_name')) == false){
			$this->error_404();
		}
		if ($param1 == '' && $param2==''){
			$this->data['data'] = $this->general->get_all_tbl_data('db_backups', '*');
			$this->data['file'] = 'database_backup';
			$this->data['title'] = 'Database Backups';
			$this->data['page_title'] = 'Database Backups';
			$this->load->view('admin/index', $this->data);
		} elseif ($param1 == 'delete' && $param2 !=''){
			// delete database backup
			$data = $this->general->get_tbl_field('db_backups', 'backup_file', 'id', $param2);
			if (count($data)>0){
				$db_file = 'db_backup/'.$data[0]['backup_file'];
				// deleting backup file
				unlink($db_file);
				$this->general->delete_tbl_data('db_backups', 'id', $param2);
				$this->session->set_flashdata('success', 'Backup deleted successfully.');
				redirect(base_url('admin/database-backup'));
				exit();
			}
		} elseif ($param1 == 'restore' && $param2 !=''){
			$data = $this->general->get_tbl_field('db_backups', 'backup_file', 'id', $param2);
			if (count($data)>0){
				$db_file = 'db_backup/'.$data[0]['backup_file'];
				if (file_exists($db_file)){
					$lines = file($db_file);
					$statement = '';
					foreach ($lines as $line){
						$statement .= $line;
						if (substr(trim($line), -1) === ';'){
							$this->db->simple_query($statement);
							$statement = '';
						}
					}
					$this->session->set_flashdata('success', 'Backup Restored successfully.');
					redirect(base_url('admin/database-backup'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'Backup file not found.');
					redirect(base_url('admin/database-backup'));
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Record not found.');
				redirect(base_url('admin/database-backup'));
				exit();
			}
		} elseif ($param1 == 'download' && $param2 !=''){
			$data = $this->general->get_tbl_field('db_backups', 'backup_file', 'id', $param2);
			if (count($data)>0){
				$db_file = 'db_backup/'.$data[0]['backup_file'];
				//downloading backup file
				if (force_download($db_file, NULL)){
					$this->session->set_flashdata('success', 'File Downloaded successfully.');
					redirect(base_url('admin/database-backup'));
					exit();
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again.');
					redirect(base_url('admin/database-backup'));
					exit();
				}
			} else {
				$this->session->set_flashdata('error', 'Record not found.');
				redirect(base_url('admin/database-backup'));
				exit();
			}
		} elseif ($param1 == 'create-new' && $param2==''){
			//creating backup file and saving record to database
			$this->load->dbutil();
			$file_name = time().'.sql';
			$prefs = array(
				'tables'        => array(),   // Array of tables to backup.
				'ignore'        => array('db_backups'),                     // List of tables to omit from the backup
				'format'        => 'txt',                       // gzip, zip, txt
				'filename'      => $file_name.'.sql',              // File name - NEEDED ONLY WITH ZIP FILES
				'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
				'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
				'newline'       => "\n"                         // Newline character used in backup file
			);
			$backup =& $this->dbutil->backup($prefs); 
			$save = 'db_backup/'.$file_name;
			if (write_file($save, $backup)){
				
				$data['backup_file'] = $file_name;
				$data['dated'] = date('Y-m-d H:i:s');
				$this->db->insert('db_backups', $data);
				
				$this->session->set_flashdata('success', 'Backup created successfully.');
				redirect(base_url('admin/database-backup'));
				exit();
			} else {
				$this->session->set_flashdata('error', 'An error occured, Please try again.');
				redirect(base_url('admin/database-backup'));
				exit();
			}
		}
		
	}
	public function error_404(){
		$this->data['file'] = 'error_404';
		$this->data['title'] = '404 Page not Fount';
		$this->data['page_title'] = '';
		$this->load->view('admin/index', $this->data);
	}
	
}
