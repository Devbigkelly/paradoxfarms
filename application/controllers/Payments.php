<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->data['system_name'] = $this->general->get_system_var('system_name');
	}
	public function gateways($param1=''){
		// Payment gateways POPUP when user clicks on Product to purchase
		$this->data['product_id'] = $param1;
		$this->data['payment_gateways'] = json_decode($this->general->get_system_var('active_payment_methods'), true);
		$this->load->view('modal/select_gateway', $this->data);
	}
	public function index($param1='', $param2=''){
		if ($this->input->post()){
			if (empty($this->input->post('product_id', true))){
				$this->session->set_flashdata('error', 'Please select a product');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
			if (empty($this->input->post('method', true))){
				$this->session->set_flashdata('error', 'Please select payment method');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
			$product = $this->general->get_tbl_field('products', '*', 'id', $this->input->post('product_id', true));
			if (count($product)>0){
				// inserting transaction to database with status pending
				$tranx_id = $this->general->create_salt(12);
				$data['product_id'] 			= $this->input->post('product_id', true);
				$data['username'] 				= $this->session->userdata('user_name');
				$data['tranx_id'] 				= $tranx_id;
				$data['payment_gross'] 			= $product[0]['selling_price'];
				$data['currency_code'] 			= 'usd';
				$data['method'] 				= $this->input->post('method', true);
				$data['status'] 				= '0';
				$data['dated'] 					= date('Y-m-d H:i:s');
				$this->db->insert('payments',$data);
				$insert_ID =  $this->db->insert_id();
				if ($this->input->post('method', true) == 'Internal-Wallet'){
					// if method is wallet, validate wallet, if user has enough amount to pay
					$wallet_payment_id = $insert_ID;
					$available_amount = $this->wallet->wallet_amount($this->session->userdata('user_name'), 'wallet');
					if ($available_amount >= $product[0]['selling_price']){
						//deducting amount from wallet and sending notification
						$this->wallet->wallet_purchase($data['product_id'], $data['username'], $product[0]['selling_price'], $data['tranx_id'], 'Internal-Wallet');
						
						//generating commissions for product purchase
						$this->commissions->purchase_product($data['username'], $data['product_id'], $data['tranx_id'], 'Internal-Wallet');
						
						//updating transaction status to completed
						$tr['status'] = '1';
						$tr['payment_details'] 	= 'wallet payment';
						$this->general->update_data('payments', 'id', $wallet_payment_id, $tr);
						
						$this->session->set_flashdata('success', 'Transaction Completed successfully');
						redirect(base_url('member/dashboard'));
						exit();
					} else {
						$this->session->set_flashdata('error', 'Insufficient funds for this transaction');
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					}
				} elseif ($this->input->post('method', true) == 'Manual-Payment'){
					$manual_payment_id = $insert_ID;
					$validextensions = array("jpg", "jpeg", "png", "PNG", "PDF");
					$logo_res = $this->general->upload_media($_FILES["image"], $validextensions);
					if ($logo_res['status'] == 'error'){
						$this->general->delete_tbl_data('payments', 'id', $manual_payment_id);
						$this->session->set_flashdata('error', $logo_res['message']);
						header("Location: {$_SERVER['HTTP_REFERER']}");
						exit();
					} else {
						$image = $logo_res['directory'].'/'.$logo_res['file_name'];
						$manual['tranx_id'] = $data['tranx_id'];
						$manual['username'] = $this->session->userdata('user_name');
						$manual['payments_id'] = $manual_payment_id;
						$manual['product_id'] = $this->input->post('product_id', true);
						$manual['proof'] = $image;
						$manual['status'] = '0';
						$manual['dated'] = date('Y-m-d H:i:s');
						$save = $this->db->insert('manual_payments', $manual);
						if ($save){
							$this->session->set_flashdata('success', 'Your Purchase will be processed as soon as we verify your payment.');
							redirect(base_url('member/dashboard'));
							exit();
						} else {
							$this->session->set_flashdata('error', 'An error occured, Please try again.');
							redirect(base_url('member/products'));
							exit();
						}
					}
				} elseif ($this->input->post('method', true) == 'Paypal'){
					// loading paypal library
					$this->load->library('paypal');
					$paypal_payment_id = $insert_ID;
					$this->session->set_userdata('paypal_payment_id', $paypal_payment_id);
					$paypal_email              = $this->general->get_system_var('paypal_email');
					
					//$this->paypal->add_field('rm', 2);
					/* $this->paypal->add_field('charset', 'utf-8');
					$this->paypal->add_field('item_number', $product[0]['id']);
					$this->paypal->add_field('no_note', 0);
					$this->paypal->add_field('cmd', '_xclick');
					$this->paypal->add_field('amount', $this->cart->format_number($product[0]['selling_price']));
					$this->paypal->add_field('custom', $paypal_payment_id);
					$this->paypal->add_field('business', $paypal_email); */
					
					$this->paypal->add_field('rm', 1);
					$this->paypal->add_field('item_name', $product[0]['title']);
					$this->paypal->add_field('item_number', $product[0]['id']);
					$this->paypal->add_field('currency_code', 'USD');
					$this->paypal->add_field('no_shipping', 1);
					$this->paypal->add_field('no_note', 1);
					$this->paypal->add_field('cmd', '_xclick');
					$this->paypal->add_field('amount', $this->cart->format_number($product[0]['selling_price']));
					$this->paypal->add_field('custom', $paypal_payment_id);
					$this->paypal->add_field('business', $paypal_email);
					
					//paypal IPN for validating transaction
					$this->paypal->add_field('notify_url', base_url('payments/paypal-response/ipn'));
					
					// redirecting Paypal cancel transaction
					$this->paypal->add_field('cancel_return', base_url('payments/paypal-response/cancel'));
					
					// redirecting paypal transaction successfull
					$this->paypal->add_field('return', base_url('payments/paypal-response/success/'.$paypal_payment_id));
					
					$this->paypal->submit_paypal_post();
				} elseif ($this->input->post('method', true) == 'Stripe'){
					$stripe_payment_id = $insert_ID;
					$this->session->set_userdata('stripe_payment_id', $stripe_payment_id);
					redirect(base_url('payments/stripe/'.$this->input->post('product_id', true)));
				} elseif ($this->input->post('method', true) == 'Perfect-Money'){
					$perfect_money_payment_id = $insert_ID;
					$this->session->set_userdata('perfect_money_payment_id', $perfect_money_payment_id);
					
					// perfect money inline form
					$frm_attributes = array('id' => '', 'name' => 'perfect_money_form');
					echo form_open('https://perfectmoney.is/api/step1.asp', $frm_attributes);
					echo form_hidden('PAYEE_ACCOUNT', $this->general->get_system_var('perfect_money_account'));
					echo form_hidden('PAYEE_NAME', $this->data['system_name']);
					echo form_hidden('PAYMENT_ID', $tranx_id);
					echo form_hidden('PAYMENT_AMOUNT', number_format($product[0]['selling_price']), 2);
					echo form_hidden('PAYMENT_UNITS', 'USD');
					echo form_hidden('STATUS_URL', '');
					echo form_hidden('PAYMENT_URL', base_url('payments/perfect-money-response/success'));
					echo form_hidden('PAYMENT_URL_METHOD', 'POST');
					echo form_hidden('NOPAYMENT_URL', base_url('payments/perfect-money-response/cancel'));
					echo form_hidden('NOPAYMENT_URL_METHOD', 'LINK');
					echo form_hidden('SUGGESTED_MEMO', '');
					echo form_hidden('BAGGAGE_FIELDS', '');
					echo form_close();
					echo '<script>';
					echo 'window.onload = function(){';
					echo 'document.forms["perfect_money_form"].submit();';
					echo '}';
					echo '</script>';
					
				} elseif ($this->input->post('method', true) == 'Ipay88'){
					$userdata = $this->general->get_tbl_field('users', '*', 'username', $this->session->userdata('user_name'));
					// loading Ipay88 library
					$this->load->library('ipay88');
					
					$ipay88_payment_id = $insert_ID;
					$this->session->set_userdata('ipay88_payment_id', $ipay88_payment_id);
					
					$ipay88 = new IPay88($this->general->get_system_var('ipay88_merchant_code'));
					$ipay88->setMerchantKey($this->general->get_system_var('ipay88_merchant_key'));

					$ipay88->setField('PaymentId', $ipay88_payment_id);
					$ipay88->setField('RefNo', $data['tranx_id']);
					$ipay88->setField('Amount', $this->cart->format_number($product[0]['selling_price']));
					$ipay88->setField('Currency', 'USD');
					$ipay88->setField('ProdDesc', $product[0]['title']);
					$ipay88->setField('UserName', $userdata[0]['name']);
					$ipay88->setField('UserEmail', $userdata[0]['email']);
					$ipay88->setField('UserContact', $userdata[0]['mobile']);
					$ipay88->setField('Remark', '');
					$ipay88->setField('Lang', 'utf-8');
					$ipay88->setField('ResponseURL', base_url('payments/ipay88-response'));
					$ipay88->generateSignature();
					$ipay88_fields = $ipay88->getFields();
					if (!empty($ipay88_fields)){
						$frm_attributes = array('id' => '', 'name' => 'ipay88_form');
						echo form_open($ipay88::$epayment_url, $frm_attributes);
						foreach ($ipay88_fields as $key => $val){
							echo form_hidden($key, $val);
						}
						echo form_close();
						
						echo '<script>';
						echo 'window.onload = function(){';
						echo 'document.forms["ipay88_form"].submit();';
						echo '}';
						echo '</script>';
						
					}
				}
			} else {
				$this->session->set_flashdata('error', 'Product not Found');
				header("Location: {$_SERVER['HTTP_REFERER']}");
				exit();
			}
		} else {
			$this->session->set_flashdata('error', 'Invalid request sent.');
			redirect(base_url('member/products'));
			exit();
		}
	}
	
	public function ipay88_response(){
		
		// handling ipay88 response
		$this->load->library('ipay88');
		$ipay88 = new IPay88($this->general->get_system_var('ipay88_merchant_code'));
		$response = $ipay88->getResponse();
		if ($response['status']){
			$ipay88_payment_id = $this->session->userdata('ipay88_payment_id');
			$payment_data = $this->general->get_tbl_field('payments', '*', 'id', $ipay88_payment_id);
			if (count($payment_data)>0){
				$product_data = $this->general->get_tbl_field('products', '*', 'id', $payment_data[0]['product_id']);
				if (count($product_data)>0){
					
					//adding purchase notification and transaction
					$this->wallet->add_purchase_transaction($payment_data[0]['product_id'], $this->session->userdata('user_name'), $payment_data[0]['payment_gross'], $payment_data[0]['tranx_id'], 'Ipay88');
					
					// generating commissions
					$this->commissions->purchase_product($this->session->userdata('user_name'), $payment_data[0]['product_id'], $payment_data[0]['tranx_id'], 'Ipay88');
					
					// updating transaction status to completed
					$tr['status'] = '1';
					$tr['payment_details'] 	= json_encode($response);
					$this->general->update_data('payments', 'id', $ipay88_payment_id, $tr);
					
					$this->session->set_flashdata('success', 'Transaction Completed successfully');
					redirect(base_url('member/dashboard'));
					exit();
				}
			}
		} else {
			$ipay88_payment_id = $this->session->userdata('ipay88_payment_id');
			$this->general->delete_tbl_data('payments', 'id', $ipay88_payment_id);
			$this->session->set_userdata('ipay88_payment_id', false);
			$this->session->set_flashdata('error', 'Transaction Canceled');
			redirect(base_url('member/products'));
			exit();
		}
	}
	public function perfect_money_response($param1='', $param2=''){
		$perfect_money_payment_id = $this->session->userdata('perfect_money_payment_id');
		if ($param1 == 'success'){
			if ($this->input->post()){
				
				$payment_data = $this->general->get_tbl_field('payments', '*', 'id', $stripe_payment_id);
				if (count($payment_data)>0){
					if ($payment_data[0]['tranx_id'] == ($this->input->post('PAYMENT_ID') & $param2) ){
						$product_data = $this->general->get_tbl_field('products', '*', 'id', $payment_data[0]['product_id']);
						if (count($product_data)>0){
							//adding purchase notification and transaction
							$this->wallet->add_purchase_transaction($payment_data[0]['product_id'], $this->session->userdata('user_name'), $payment_data[0]['payment_gross'], $payment_data[0]['tranx_id'], 'Perfect-Money');
							// generating commissions
							$this->commissions->purchase_product($this->session->userdata('user_name'), $payment_data[0]['product_id'], $payment_data[0]['tranx_id'], 'Perfect-Money');
							
							// updating transaction status to completed
							$tr['status'] = '1';
							$tr['payment_details'] 	= json_encode($this->input->post());
							$this->general->update_data('payments', 'id', $perfect_money_payment_id, $tr);
							
							$this->session->set_flashdata('success', 'Transaction Completed successfully');
							redirect(base_url('member/dashboard'));
							exit();
						}
					} else {
						$this->general->delete_tbl_data('payments', 'id', $perfect_money_payment_id);
						$this->session->set_flashdata('error', 'Transaction Canceled');
						$this->session->set_userdata('perfect_money_payment_id', false);
						redirect(base_url('member/products'));
					}
				}
			} else {
				$this->general->delete_tbl_data('payments', 'id', $perfect_money_payment_id);
				$this->session->set_flashdata('error', 'Transaction Canceled');
				$this->session->set_userdata('perfect_money_payment_id', false);
				redirect(base_url('member/products'));
			}
		} elseif ($param1 == 'cancel') {
			$this->general->delete_tbl_data('payments', 'id', $perfect_money_payment_id);
			$this->session->set_flashdata('error', 'Transaction Canceled');
			$this->session->set_userdata('perfect_money_payment_id', false);
			redirect(base_url('member/products'));
		}
	}
	public function stripe($param1=''){
		$product = $this->general->get_tbl_field('products', '*', 'id', $param1);
		if (count($product)>0){
			$this->data['data'] = $product;
			$this->data['file'] = 'stripe';
			$this->data['title'] = 'Stripe';
			$this->data['page_title'] = 'Stripe';
			$this->load->view('backoffice/index', $this->data);
		} else {
			$this->session->set_flashdata('error', 'Product not Found');
			redirect(base_url('member/products'));
			exit();
		}
	}
	public function stripe_request(){
		$stripe_payment_id = $this->session->userdata('stripe_payment_id');
		$payment_data = $this->general->get_tbl_field('payments', '*', 'id', $stripe_payment_id);
		if (count($payment_data)>0){
			$product_data = $this->general->get_tbl_field('products', '*', 'id', $payment_data[0]['product_id']);
			if (count($product_data)>0){
				require_once('application/libraries/stripe-php/init.php');
				\Stripe\Stripe::setApiKey($this->general->get_system_var('stripe_secret'));
				$user_email = $this->db->get_where('users' , array('username' => $this->session->userdata('user_name')))->row()->email;
				echo ($user_email);
				$usera = \Stripe\Customer::create(array(
					'email' => $user_email, // customer email id
					'card'  => $_POST['stripeToken']
				));

				$charge = \Stripe\Charge::create(array(
					'customer'  => $usera->id,
					'amount'    => ceil($product_data[0]['selling_price']*100),
					'currency'  => 'USD'
				));
				
				if($charge->paid == true){
					//adding purchase notification and transaction
					$this->wallet->add_purchase_transaction($payment_data[0]['product_id'], $this->session->userdata('user_name'), $payment_data[0]['payment_gross'], $payment_data[0]['tranx_id'], 'Stripe');
					// generating commissions
					$this->commissions->purchase_product($this->session->userdata('user_name'), $payment_data[0]['product_id'], $payment_data[0]['tranx_id'], 'Stripe');
					
					// updating transaction status to completed
					$tr['status'] = '1';
					$tr['payment_details'] 	= "Customer Info: \n".json_encode($usera,true)."\n \n Charge Info: \n".json_encode($charge,true);;
					$this->general->update_data('payments', 'id', $stripe_payment_id, $tr);
					
					$this->session->set_flashdata('success', 'Transaction Completed successfully');
					redirect(base_url('member/dashboard'));
					exit();
				} else {
					$this->general->delete_tbl_data('payments', 'id', $stripe_payment_id);
					$this->session->set_flashdata('error', 'Transaction Canceled');
					$this->session->set_userdata('stripe_payment_id', false);
					redirect(base_url('member/products'));
				}
			}
		}
	}
	public function paypal_response($param1 = '', $param2=''){
		if ($param1 == 'ipn'){
			if ($this->paypal->validate_ipn() == true) {   
				$paypal_payment_id = $this->session->userdata('paypal_payment_id');
				$payment_data = $this->general->get_tbl_field('payments', '*', 'id', $paypal_payment_id);
				if (count($payment_data)>0){
					$product_data = $this->general->get_tbl_field('products', '*', 'id', $payment_data[0]['product_id']);
					if (count($product_data)>0){
						//adding purchase notification and transaction
						$this->wallet->add_purchase_transaction($payment_data[0]['product_id'], $this->session->userdata('user_name'), $payment_data[0]['payment_gross'], $payment_data[0]['tranx_id'], 'Paypal');
						// generating commissions
						$this->commissions->purchase_product($this->session->userdata('user_name'), $payment_data[0]['product_id'], $payment_data[0]['tranx_id'], 'Paypal');
						
						// updating transaction status to completed
						$tr['status'] = '1';
						$tr['payment_details'] 	= json_encode($_POST);
						$this->general->update_data('payments', 'id', $paypal_payment_id, $tr);
					}
				}
			}
		} elseif ($param1 == 'cancel'){
			$paypal_payment_id = $this->session->userdata('paypal_payment_id');
			$this->general->delete_tbl_data('payments', 'id', $paypal_payment_id);
			$this->session->set_flashdata('error', 'Transaction Canceled');
			$this->session->set_userdata('paypal_payment_id', false);
			redirect(base_url('member/products'));
			exit();
		} elseif ($param1 == 'success'){
			$paypal_payment_id = $this->session->userdata('paypal_payment_id');
			if ($param2 == $paypal_payment_id){
				$payment_data = $this->general->get_tbl_field('payments', '*', 'id', $paypal_payment_id);
				
				if (count($payment_data)>0){
					if ($payment_data[0]['status'] == '0'){
						$product_data = $this->general->get_tbl_field('products', '*', 'id', $payment_data[0]['product_id']);
						if (count($product_data)>0){
							//adding purchase notification and transaction
							$this->wallet->add_purchase_transaction($payment_data[0]['product_id'], $this->session->userdata('user_name'), $payment_data[0]['payment_gross'], $payment_data[0]['tranx_id'], 'Paypal');
							// generating commissions
							$this->commissions->purchase_product($this->session->userdata('user_name'), $payment_data[0]['product_id'], $payment_data[0]['tranx_id'], 'Paypal');
							
							// updating transaction status to completed
							$tr['status'] = '1';
							$tr['payment_details'] 	= json_encode($_POST);
							$this->general->update_data('payments', 'id', $paypal_payment_id, $tr);
							$this->session->set_flashdata('success', 'Transaction Completed');
						}
					} else {
						$this->session->set_flashdata('error', 'An error occured, Please try again');
					}
					
				} else {
					$this->session->set_flashdata('error', 'An error occured, Please try again');
				}
			}
			
			redirect(base_url('member/dashboard'));
			exit();
		}
	}
}
