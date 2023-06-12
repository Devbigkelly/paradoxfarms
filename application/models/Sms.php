<?php
class Sms extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	
	public function send_type_sms($to, $type, $options=array()){
		if ($this->general->get_system_var('sms_notifications_status') == '0'){
			return false;
		}
		$username = $this->user_account->username_by_mobile($to);
		$data = $this->db->query("SELECT id FROM notification_settings WHERE username='$username' AND type='$type' AND carrier_type = 'sms'")->result_array();
		if (count($data)>0){
			return false;
		}
		$body = '';
		$name = get_array_value($options, 'name');
		$username = get_array_value($options, 'username');
		$sponsor_username = get_array_value($options, 'sponsor_username');
		$sponsor_name = get_array_value($options, 'sponsor_name');
		$withdraw_amount = get_array_value($options, 'withdraw_amount');
		$withdraw_fee = get_array_value($options, 'withdraw_fee');
		$withdraw_receiveable = get_array_value($options, 'withdraw_receiveable');
		$withdraw_method = get_array_value($options, 'withdraw_method');
		$withdraw_method_details = get_array_value($options, 'withdraw_method_details');
		$transaction_id = get_array_value($options, 'transaction_id');
		$transaction_date = get_array_value($options, 'transaction_date');
		$transaction_time = get_array_value($options, 'transaction_time');
		$action_date = get_array_value($options, 'action_date');
		$action_time = get_array_value($options, 'action_time');
		$email_activation_link = get_array_value($options, 'email_activation_link');
		$password_reset_link = get_array_value($options, 'password_reset_link');
		$e_pin = get_array_value($options, 'e_pin');
		$product_name = get_array_value($options, 'product_name');
		$product_price = get_array_value($options, 'product_price');
		$product_img_path = get_array_value($options, 'product_img_path');
		$two_factor_code = get_array_value($options, 'two_factor_code');
		$referral_url = get_array_value($options, 'referral_url');
		$message = get_array_value($options, 'message');
		$template = $this->general->get_tbl_field('sms_templates', '*', 'type', $type);
		if (count($template)>0){
			if ($template[0]['status'] == '0'){
				return false;
			}
			$body = $template[0]['message'];
			if ($name){
				$body      = str_replace('[[name]]',$name,$body);
			}
			if ($username){
				$body      = str_replace('[[username]]',$username,$body);
			}
			if ($sponsor_name){
				$body      = str_replace('[[sponsor_name]]',$sponsor_name,$body);
			}
			if ($sponsor_username){
				$body      = str_replace('[[sponsor_username]]',$sponsor_username,$body);
			}
			if ($withdraw_amount){
				$body      = str_replace('[[withdraw_amount]]',$withdraw_amount,$body);
			}
			if ($withdraw_fee){
				$body      = str_replace('[[withdraw_fee]]',$withdraw_fee,$body);
			}
			if ($withdraw_receiveable){
				$body      = str_replace('[[withdraw_receiveable]]',$withdraw_receiveable,$body);
			}
			if ($withdraw_method){
				$body      = str_replace('[[withdraw_method]]',$withdraw_method,$body);
			}
			if ($withdraw_method_details){
				$body      = str_replace('[[withdraw_method_details]]',$withdraw_method_details,$body);
			}
			if ($transaction_id){
				$body      = str_replace('[[transaction_id]]',$transaction_id,$body);
			}
			if ($transaction_date){
				$body      = str_replace('[[transaction_date]]',$transaction_date,$body);
			}
			if ($transaction_time){
				$body      = str_replace('[[transaction_time]]',$transaction_time,$body);
			}
			if ($action_date){
				$body      = str_replace('[[action_date]]',$action_date,$body);
			}
			if ($action_time){
				$body      = str_replace('[[action_time]]',$action_time,$body);
			}
			if ($email_activation_link){
				$body      = str_replace('[[email_activation_link]]',$email_activation_link,$body);
			}
			if ($password_reset_link){
				$body      = str_replace('[[password_reset_link]]',$password_reset_link,$body);
			}
			if ($e_pin){
				$body      = str_replace('[[e_pin]]',$e_pin,$body);
			}
			if ($product_name){
				$body      = str_replace('[[product_name]]',$product_name,$body);
			}
			if ($product_price){
				$body      = str_replace('[[product_price]]',$product_price,$body);
			}
			if ($product_img_path){
				$body      = str_replace('[[product_img_path]]',$product_img_path,$body);
			}
			if ($two_factor_code){
				$body      = str_replace('[[two_factor_code]]',$two_factor_code,$body);
			}
			if ($referral_url){
				$body      = str_replace('[[referral_url]]',$referral_url,$body);
			}
			if ($message){
				$body      = str_replace('[[message]]',$message,$body);
			}
			$system_name = $this->general->get_system_var('system_name');
			
			$body      = str_replace('[[system_name]]',$system_name,$body);
			$subject = $template[0]['subject'];
			
			//return $body;
			return $this->do_sms($to, $body);
		} else {
			return false;
		}
	}
	public function do_sms($to, $message){
		
		$default_gateway = $this->general->get_system_var('default_sms_gateway');
		if ($default_gateway == 'twillo'){
			$status = $this->general->get_system_var('twillo_status');
			if ($status == '1'){
				return $this->twillo_sms($to, $message);
			} else {
				return false;
			}
		} elseif ($default_gateway == 'messente'){
			$status = $this->general->get_system_var('messente_status');
			if ($status == '1'){
				return $this->messente_sms($to, $message);
			} else {
				return false;
			}
		} elseif ($default_gateway == 'infobip'){
			$status = $this->general->get_system_var('infobip_status');
			if ($status == '1'){
				return $this->infobip_sms($to, $message);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function twillo_sms($to, $message){
		$this->load->library('twillo');
		$twillo = new Twillo();
		$res = $twillo->send_message($to, $message);
		if ($res){
			echo true;
		} else {
			echo false;
		}
	}
	public function messente_sms($to, $message){
		$this->load->library('messente');
		$response = send_message($to, $message);
		if ($response['error_code'] == '' || empty($response['error_code'])){
			return true;
		} else {
			return false;
		}
	}
	public function infobip_sms($to, $message){
		$this->load->library('infobip');
		$infobip = new Infobip();
		$res = $infobip->send_message($to, $message);
		if ($res){
			echo true;
		} else {
			echo false;
		}
	}
}