<?php
class Wallet extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	
	public function manual_payments_list($status){
		$this->db->select('manual_payments.*, products.title, payments.payment_gross');
		$this->db->from('manual_payments');
		$this->db->join('products', 'products.id = manual_payments.product_id');
		$this->db->join('payments', 'payments.id = manual_payments.payments_id');
		$this->db->where('manual_payments.status', $status);
		return $this->db->get()->result_array();
	}
	public function add_purchase_transaction($product_id, $username, $amount, $tranx_id, $method){
		$product_title = $this->commissions->product_name($product_id);
		$message = $product_title.' Purchased for '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> by using '.$method;
		$this->add_transaction($username, $tranx_id, 'Debit', $message);
		
		$noti['username'] = $username;
		$noti['msg_from'] = 'Admin';
		$noti['message'] = $product_title.' has been purchased successfully having Transaction ID '.$tranx_id.' and amount '.currency($amount).' by using '.$method;
		$noti['dated'] = date('Y-m-d H:i:s');
		$this->db->insert('notifications', $noti);
	}
	public function total_income($username, $type){
		$amount = '0';
		$result = $this->db->query("
		SELECT 
		sum(income.amount) as total
		FROM 
		income
		WHERE
		income.username='".$username."'
		AND
		income.type='".$type."'
		")->result_array();
		$amount = $result[0]['total'];
		if (!$amount){
			$amount = '0';
		}
		return $amount;
		
		
	}
	public function add_income($username, $amount, $type){
		$type_name = 'income';
		if ($type == 'personal-sponsor-bonus'){
			$type_name = 'Personal Sponsor Bonus';
		} elseif ($type == 'network-binary-bonus'){
			$type_name = 'Network Binary Bonus';
		} elseif ($type == 'generation-bonus'){
			$type_name = 'Generation Bonus';
		} elseif ($type == 'reverse-generation-bonus'){
			$type_name = 'Reverse Generation Bonus';
		} elseif ($type == 'roi'){
			$type_name = 'Return on Investment (ROI)';
		} elseif ($type == 'matching-roi'){
			$type_name = 'Matching ROI';
		}
		if (empty($username)){
			$response['status'] = 'error';
			$response['message'] = 'Beneficiary Username Required';
			return $response;
		}
		
		if (empty($amount)){
			$amount = 0;
		}
		if ($amount > 0){
			$tranx_id = $this->general->create_salt(12);
			
			$statement_message = $type_name.' '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been credited to your Wallet';
			$this->wallet->add_wallet_statement($username, $tranx_id, $statement_message, 'Credit', $amount);
			
			$this->wallet->add_to_wallet($username, $amount, 'wallet');
			$transfer['tranx_id'] = $tranx_id;
			$transfer['username'] = $username;
			$transfer['type'] = $type;
			$transfer['amount'] = $amount;
			$transfer['dated'] = date('Y-m-d H:i:s');
			$save = $this->db->insert('income', $transfer);
		
		
			if ($save){
				$noti['username'] = $username;
				$noti['msg_from'] = 'Admin';
				$noti['message'] = 'You have earned '.$type_name.' '.currency($amount).', Transaction ID '.$tranx_id.'';
				$noti['dated'] = date('Y-m-d H:i:s');
				$this->db->insert('notifications', $noti);
				
				$message = $type_name.' '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been credited to your account';
				$this->add_transaction($username, $tranx_id, 'Credit', $message);
				
				$response['status'] = 'success';
				$response['message'] = $type_name.' '.currency($amount).' Credited to Wallet with transaction id '.$tranx_id;
				return $response;
			} else {
				$response['status'] = 'error';
				$response['message'] = 'An error occured, Please try again';
				return $response;
			}
		}
	}
	
	public function add_funds($username, $amount){
		if (empty($username)){
			$response['status'] = 'error';
			$response['message'] = 'Beneficiary Username Required';
			return $response;
		}
		$username_exists = $this->user_account->username_exists($username);
		if ($username_exists == false){
			$response['status'] = 'error';
			$response['message'] = 'Beneficiary not Found';
			return $response;
		}
		
		if (empty($amount)){
			$amount = 0;
		}
		if ($amount < 0){
			$response['status'] = 'error';
			$response['message'] = 'Please enter a positive value';
			return $response;
		}
		$tranx_id = $this->general->create_salt(12);
		
		$statement_message = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been credited to your Wallet by Admin';
		$this->wallet->add_wallet_statement($username, $tranx_id, $statement_message, 'Credit', $amount);
		
		$this->wallet->add_to_wallet($username, $amount, 'wallet');
		$transfer['tranx_id'] = $tranx_id;
		$transfer['transfer_type'] = 'Credit';
		$transfer['transfer_to'] = $username;
		$transfer['amount'] = $amount;
		$transfer['dated'] = date('Y-m-d H:i:s');
		$save = $this->db->insert('admin_transactions', $transfer);
		if ($save){
			$noti['username'] = $username;
			$noti['msg_from'] = 'Admin';
			$noti['message'] = 'Amount '.currency($amount).' with Transaction ID '.$tranx_id.' has been credited to your account by Admin';
			$noti['dated'] = date('Y-m-d H:i:s');
			$this->db->insert('notifications', $noti);
			
			$message = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been credited to your account by Admin';
			$this->add_transaction($username, $tranx_id, 'Credit', $message);
			
			$response['status'] = 'success';
			$response['message'] = 'Funds '.currency($amount).' Credited to Wallet with transaction id '.$tranx_id;
			return $response;
		} else {
			$response['status'] = 'error';
			$response['message'] = 'An error occured, Please try again';
			return $response;
		}
	}
	public function deduct_funds($username, $amount){
		if (empty($username)){
			$response['status'] = 'error';
			$response['message'] = 'Beneficiary Username Required';
			return $response;
		}
		$username_exists = $this->user_account->username_exists($username);
		if ($username_exists == false){
			$response['status'] = 'error';
			$response['message'] = 'Beneficiary not Found';
			return $response;
		}
		
		if (empty($amount)){
			$amount = 0;
		}
		if ($amount < 0){
			$response['status'] = 'error';
			$response['message'] = 'Please enter a positive value';
			return $response;
		}
		$tranx_id = $this->general->create_salt(12);
		
		$statement_message = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been debited from your wallet by Admin';
		$this->wallet->add_wallet_statement($username, $tranx_id, $statement_message, 'Debit', $amount);
		
		$this->wallet->deduct_from_wallet($username, $amount, 'wallet');
		$transfer['tranx_id'] = $tranx_id;
		$transfer['transfer_type'] = 'Debit';
		$transfer['transfer_to'] = $username;
		$transfer['amount'] = $amount;
		$transfer['dated'] = date('Y-m-d H:i:s');
		$save = $this->db->insert('admin_transactions', $transfer);
		if ($save){
			$noti['username'] = $username;
			$noti['msg_from'] = 'Admin';
			$noti['message'] = 'Amount '.currency($amount).' with Transaction ID '.$tranx_id.' has been debited from your account by Admin';
			$noti['dated'] = date('Y-m-d H:i:s');
			$this->db->insert('notifications', $noti);
			
			$message = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been debited from your account by Admin';
			$this->add_transaction($username, $tranx_id, 'Debit', $message);
			
			$response['status'] = 'success';
			$response['message'] = 'Funds '.currency($amount).' Debited from Wallet with transaction id '.$tranx_id;
			return $response;
		} else {
			$response['status'] = 'error';
			$response['message'] = 'An error occured, Please try again';
			return $response;
		}
	}
	public function wallet_purchase($product_id, $username, $amount, $tranx_id, $method){
		$this->add_purchase_transaction($product_id, $username, $amount, $tranx_id, $method);
		
		$statement_message = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been debited from your wallet to complete purchase process';
		$this->wallet->add_wallet_statement($username, $tranx_id, $statement_message, 'Debit', $amount);
		
		$this->deduct_from_wallet($username, $amount, 'wallet');
	}
	public function transfer($from, $to, $amount){
		
		if (empty($to)){
			$response['status'] = 'error';
			$response['message'] = 'Beneficiary Username Required';
			return $response;
		}
		if ($to == $from){
			$response['status'] = 'error';
			$response['message'] = 'Self Transfer not Allowed';
			return $response;
		}
		$username_exists = $this->user_account->username_exists($to);
		if ($username_exists == false){
			$response['status'] = 'error';
			$response['message'] = 'Beneficiary not Found';
			return $response;
		}
		if (empty($amount)){
			$amount = 0;
		}
		$min_transfer = $this->general->get_system_var('min_transfer');
		if ($amount < $min_transfer){
			$response['status'] = 'error';
			$response['message'] = 'Minimum possible transfer Amount is '.currency($min_transfer);
			return $response;
		}
		if ($amount > $this->wallet->wallet_amount($from, 'wallet')){
			$response['status'] = 'error';
			$response['message'] = 'Insufficients funds for this transaction';
			return $response;
		}
		
		$tranx_id = $this->general->create_salt(12);
		
		$statement_message_from = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been Debited from your wallet to '.$to;
		$this->wallet->add_wallet_statement($from, $tranx_id, $statement_message_from, 'Debit', $amount);
		
		$this->wallet->deduct_from_wallet($from, $amount, 'wallet');
		
		$statement_message_to = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been credited to your wallet by '.$from;
		$this->wallet->add_wallet_statement($to, $tranx_id, $statement_message_to, 'Credit', $amount);
		
		$this->wallet->add_to_wallet($to, $amount, 'wallet');
		$transfer['tranx_id'] = $tranx_id;
		$transfer['transfer_from'] = $from;
		$transfer['transfer_to'] = $to;
		$transfer['amount'] = $amount;
		$transfer['dated'] = date('Y-m-d H:i:s');
		$save = $this->db->insert('transfers', $transfer);
		if ($save){
			$noti['username'] = $to;
			$noti['msg_from'] = $from;
			$noti['message'] = 'Amount '.currency($amount).' with Transaction ID '.$tranx_id.' has been credited to your account from '.$from;
			$noti['dated'] = date('Y-m-d H:i:s');
			$this->db->insert('notifications', $noti);
			
			$to_message = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been credited to your account by '.$from;
			$this->add_transaction($to, $tranx_id, 'Credit', $to_message);
			
			$from_message = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been debited from your account to '.$to;
			$this->add_transaction($from, $tranx_id, 'Debit', $from_message);
			
			$response['status'] = 'success';
			$response['message'] = 'Transfer completed with transaction id '.$tranx_id;
			return $response;
		} else {
			$response['status'] = 'error';
			$response['message'] = 'An error occured, Please try again';
			return $response;
		}
		
		
	}
	public function withdraw($username, $amount, $method, $method_details){
		if (empty($amount)){
			$amount = 0;
		}
		if (empty($method)){
			$response['status'] = 'error';
			$response['message'] = 'Please Select Payment Method';
			return $response;
		}
		if (empty($method_details)){
			$response['status'] = 'error';
			$response['message'] = 'Account Details required for selected Payment Method';
			return $response;
		}
		if ($amount < $this->general->get_system_var('min_withdraw')){
			$response['status'] = 'error';
			$response['message'] = 'Minimum possible withdraw Amount is '.currency($this->general->get_system_var('min_withdraw'));
			return $response;
		}
		if ($amount > $this->wallet->wallet_amount($username, 'wallet')){
			$response['status'] = 'error';
			$response['message'] = 'Insufficients funds for this transaction';
			return $response;
		}
		if ($this->general->get_system_var('withdraw_fee')>0){
			$fee = ($amount * $this->general->get_system_var('withdraw_fee')) / 100;
			$withdrawable = $amount - $fee;
		} else {
			$fee = 0;
			$withdrawable = $amount;
		}
		
		$tranx_id = $this->general->create_salt(12);
		$data['transection_id'] = $tranx_id;
		$data['username'] = $username;
		$data['amount'] = $amount;
		$data['fees'] = $fee;
		$data['withdrawable'] = $withdrawable;
		$data['method'] = $method;
		$data['details'] = $method_details;
		$data['req_date'] = date('Y-m-d H:i:s');
		$data['status'] = '0';
		$save = $this->db->insert('withdraw', $data);
		if ($save){
			
			$noti['username'] = $username;
			$noti['msg_from'] = 'Admin';
			$noti['message'] = 'Amount '.currency($amount).' with Transaction ID '.$tranx_id.' has been debited from your account and pending for withdraw';
			$noti['dated'] = date('Y-m-d H:i:s');
			$this->db->insert('notifications', $noti);
			
			$to_message = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been debited from your account and pending for withdraw';
			$this->add_transaction($username, $tranx_id, 'Debit', $to_message);
			
			$statement_message = 'Amount '.currency($amount).' with Transaction ID <a href="#" data-tranx-id="'.$tranx_id.'">'.$tranx_id.'</a> has been debited from your wallet and pending for withdraw';
			$this->wallet->add_wallet_statement($username, $tranx_id, $statement_message, 'Debit', $amount);
			
			$this->wallet->deduct_from_wallet($username, $amount, 'wallet');
			
			$email = $this->user_account->user_email($username);
			if ($email){
				$s = strtotime($data['req_date']);
				$mail_options = array(
					'name' 			=> $this->user_account->user_name($username),
					'username' 		=> $username,
					'system_name' 	=> $this->general->get_system_var('system_name'),
					'transaction_id' 		=> $tranx_id,
					'withdraw_amount' 		=> $amount,
					'withdraw_fee' 		=> $fee,
					'withdraw_receiveable' 		=> $withdrawable,
					'withdraw_method' 		=> $method,
					'withdraw_method_details' 		=> $method_details,
					'transaction_time' 	=> date('H:i:s', $s),
					'transaction_date' 	=> date('Y-m-d', $s)
				);
				$this->emails->send_type_email($email, 'request_withdraw', $mail_options);
				$mobile = $this->user_account->user_mobile($username);
				if ($mobile){
					$this->sms->send_type_sms($mobile, 'request_withdraw', $mail_options);
				}
				
			}
			
			$response['status'] = 'success';
			$response['message'] = 'Withdraw Request sent, transaction id '.$tranx_id;
			return $response;
		} else {
			$response['status'] = 'error';
			$response['message'] = 'An error occured, Please try again';
			return $response;
		}
	}
	public function add_transaction($username, $tranx_id, $tranx_type, $details){
		$data['username'] = $username;
		$data['transaction_id'] = $tranx_id;
		$data['tranx_type'] = $tranx_type;
		$data['details'] = $details;
		$data['dated'] = date('Y-m-d H:i:s');
		return $this->db->insert('transactions', $data);
	}
	public function creat_wallet($username, $type){
		$data['username'] 			= $username;
		$data['amount'] 			= 0;
		$data['type'] 				= $type;
		$data['dated'] 			= date('Y-m-d H:i:s');
		$this->general->insert_data('wallet', $data);
	}
	public function wallet_amount($username, $type){
		$amount = 0;
		$query = $this->db->query("SELECT amount FROM wallet WHERE username='$username' AND type='$type'");
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
				$amount = $row['amount'];
			}
		} else {
			$this->creat_wallet($username, $type);
		}
		return $amount;
	}
	public function add_to_wallet($username, $amount, $type){
		$available_amount = $this->wallet_amount($username, $type);
		$total_amount = $available_amount + $amount;
		$data_arr['amount'] 			= $total_amount;
		$data_arr['dated'] 			= date('Y-m-d H:i:s');
		$this->general->update_data2('wallet', 'username', $username, 'type', $type, $data_arr);
	}
	
	public function deduct_from_wallet($username, $amount, $type){
		$available_amount = $this->wallet_amount($username, $type);
		$total_amount = $available_amount - $amount;
		$data_arr['amount'] 			= $total_amount;
		$data_arr['dated'] 			= date('Y-m-d H:i:s');
		$this->general->update_data2('wallet', 'username', $username, 'type', $type, $data_arr);
	}
	public function add_wallet_statement($username, $tranx_id, $message, $type, $amount){
		$available = $this->wallet_amount($username, 'wallet');
		if ($type == 'Debit'){
			$total = $available - $amount;
		} elseif ($type == 'Credit'){
			$total = $available + $amount;
		} else {
			return false;
		}
		$data['username'] = $username;
		$data['tranx_id'] = $tranx_id;
		$data['message'] = $message;
		$data['type'] = $type;
		$data['amount'] = $amount;
		$data['total'] = $total;
		$data['dated'] = date('Y-m-d H:i:s');
		$this->db->insert('wallet_statement', $data);
	}
	
	public function withdraw_total($username){
		$total = '0';
		$result= $this->db->query("
		SELECT 
		SUM(amount) as total
		FROM withdraw 
		WHERE
		withdraw.username='".$username."'
		AND
		status='1'
		
		")->result_array();
		$total = $result[0]['total'];
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function withdraw_total_a(){
		$total = '0';
		$result= $this->db->query("
		SELECT 
		SUM(amount) as total
		FROM withdraw 
		WHERE
		status='1'
		
		")->result_array();
		$total = $result[0]['total'];
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function withdraw_total_pending_a(){
		$total = '0';
		$result= $this->db->query("
		SELECT 
		SUM(amount) as total
		FROM withdraw 
		WHERE
		status='0'
		
		")->result_array();
		$total = $result[0]['total'];
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function withdraw_total_pending($username){
		$total = '0';
		$result= $this->db->query("
		SELECT 
		SUM(amount) as total
		FROM withdraw 
		WHERE
		status='0'
		AND
		withdraw.username='".$username."'
		")->result_array();
		$total = $result[0]['total'];
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function total_income_a($type){
		$amount = '0';
		$result = $this->db->query("
		SELECT 
		sum(income.amount) as amount
		FROM 
		income
		WHERE
		income.type='".$type."'
		")->result_array();
		$amount = $result[0]['amount'];
		if (!$amount){
			$amount = '0';
		}
		return $amount;
	}
	public function total_wallet_a($type){
		$amount = '0';
		$result = $this->db->query("
		SELECT 
		sum(wallet.amount) as amount
		FROM 
		wallet
		WHERE
		wallet.type='".$type."'
		")->result_array();
		$amount = $result[0]['amount'];
		if (!$amount){
			$amount = '0';
		}
		return $amount;
	}
}