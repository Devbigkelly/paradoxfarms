<?php
class Commissions extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	
	public function do_personal_sponsor_bonus($username, $amount){
		if ($this->general->get_commission_var('personal_sponsor_bonus_status') == '0'){
			return false;
		}
		$matrix = $this->general->get_system_var('matrix');
		$levels = $this->general->get_commission_var('personal_sponsor_bonus_levels');
		$values = json_decode($this->general->get_commission_var('personal_sponsor_bonus_values'));
		if ($matrix == '2x'){
			$parents = $this->matrix2x->direct_parents($username);
		} else {
			$parents = $this->matrix3x->direct_parents($username);
		}
		$xup_status = $this->general->get_commission_var('xup_status');
		if (count($parents) > 0 && $levels > 0){
			for($i = 0 ; $i < $levels; $i++){
				if (isset($parents[$i])){
					$beneficiry = $parents[$i];
					$value = ($values[$i] * $amount)/100;
					if ($xup_status == '1'){
						if ($i == 0){
							$xup_level = $this->general->get_commission_var('xup_level');
							$purchased = $this->total_user_poducts($username);
							if ($purchased > $xup_level){
								$this->add_personal_sponsor_bonus($beneficiry, $value, $matrix);
							}
						} else {
							$this->add_personal_sponsor_bonus($beneficiry, $value, $matrix);
						}
					} else {
						$this->add_personal_sponsor_bonus($beneficiry, $value, $matrix);
					}
					
				} else {
					break;
				}
			}
		}
	}
	
	
	
	public function do_network_binary_bonus($username, $amount=0){
		if ($this->general->get_commission_var('generation_bonus_status') == '0'){
			return false;
		}
		if ($this->general->get_system_var('matrix_type') == 'forced'){
			return false;
		}
		
		$matrix = $this->general->get_system_var('matrix');
		$is_unlimited = $this->general->get_commission_var('nbb_level_unlimited');
		
		if ($matrix == '2x'){
			$parents = $this->matrix2x->binary_parents($username);
		} else {
			$parents = $this->matrix3x->binary_parents($username);
		}
		$percentage = $this->general->get_commission_var('network_binary_bonus_percentage');
		if ($is_unlimited == '1'){
			if (count($parents)>0){
				foreach ($parents as $beneficiry){
					if ($this->general->get_commission_var('network_binary_bonus_base') == 'psb_total'){
						$amount = $this->total_type_income($beneficiry, 'personal-sponsor-bonus');
					}
					$commission = ($amount * $percentage)/100;
					if ($commission > 0){
						//Check if new pair is completed and not paid for it before
						$unpaid_pairs = $this->nbb_user_total_unpaid_pairs($beneficiry, $matrix);
						if ($unpaid_pairs > 0){
							$commission = $commission * $unpaid_pairs;
							$this->add_network_binary_bonus($beneficiry, $commission, $matrix);
							if ($this->general->get_commission_var('generation_bonus_base') == 'nbb'){
								$this->do_generation_bonus($beneficiry, $commission);
							}
							if ($this->general->get_commission_var('reverse_generation_bonus_base') == 'nbb'){
								$this->do_reverse_generation_bonus($beneficiry, $commission);
							}
							//Mark unpaid pair as paid
							$this->add_pairs($beneficiry, $unpaid_pairs);
						}
					}
				}
			}
		} else {
			$levels = $this->general->get_commission_var('network_binary_bonus_levels');
			if (count($parents) > 0 && $levels > 0){
				for($i = 0 ; $i < $levels; $i++){
					if (isset($parents[$i])){
						$beneficiry = $parents[$i];
						if ($this->general->get_commission_var('network_binary_bonus_base') == 'psb_total'){
							$amount = $this->total_type_income($beneficiry, 'personal-sponsor-bonus');
						}
						$commission = ($amount * $percentage)/100;
						if ($commission > 0){
							//Check if new pair is completed and not paid for it before
							$unpaid_pairs = $this->nbb_user_total_unpaid_pairs($beneficiry, $matrix);
							if ($unpaid_pairs > 0){
								$commission = $commission * $unpaid_pairs;
								$this->add_network_binary_bonus($beneficiry, $commission, $matrix);
								if ($this->general->get_commission_var('generation_bonus_base') == 'nbb'){
									$this->do_generation_bonus($beneficiry, $commission);
								}
								if ($this->general->get_commission_var('reverse_generation_bonus_base') == 'nbb'){
									$this->do_reverse_generation_bonus($beneficiry, $commission);
								}
								//Mark unpaid pair as paid
								$this->add_pairs($beneficiry, $unpaid_pairs);
							}
						}
					} else {
						break;
					}
				}
			}
		}
		
		
	}
	public function creat_pairs($username){
		$data['username'] 		= $username;
		$data['pairs'] 			= 0;
		$data['dated'] 			= date('Y-m-d H:i:s');
		$this->general->insert_data('user_info', $data);
	}
	public function saved_pairs($username){
		$amount = '0';
		$query = $this->db->query("SELECT pairs FROM user_info WHERE username='$username'")->result_array();
		if (count($query)>0){
			$amount = $query[0]['pairs'];
		} else {
			$this->creat_pairs($username);
		}
		return $amount;
	}
	public function add_pairs($username, $pairs){
		$available_pairs = $this->saved_pairs($username);
		$total_pairst = $available_pairs + $pairs;
		$data_arr['pairs'] 			= $total_pairst;
		$data_arr['dated'] 			= date('Y-m-d H:i:s');
		$this->general->update_data('user_info', 'username', $username, $data_arr);
	}
	public function nbb_user_total_unpaid_pairs($username, $matrix){
		$nbb_pair_type = $this->general->get_commission_var('nbb_pair_type'); 
		if ($matrix == '2x'){
			if ($nbb_pair_type == '0'){
				$current_pairs = $this->matrix2x->completed_pairs($username);
			} else {
				$current_pairs = $this->matrix2x->completed_paid_pairs($username);
			}
		} else {
			if ($nbb_pair_type == '0'){
				$current_pairs = $this->matrix3x->completed_pairs($username);
			} else {
				$current_pairs = $this->matrix3x->completed_paid_pairs($username);
			}
		}
		$saved_pairs = $this->saved_pairs($username);
		if ($current_pairs > $saved_pairs){
			return $current_pairs - $saved_pairs;
		} else {
			return '0';
		}
		
	}
	
	public function do_generation_bonus($username, $amount){
		if ($this->general->get_commission_var('generation_bonus_status') == '0'){
			return false;
		}
		$matrix = $this->general->get_system_var('matrix');
		$levels = $this->general->get_commission_var('generation_bonus_levels');
		$values = json_decode($this->general->get_commission_var('generation_bonus_values'));
		if ($matrix == '2x'){
			$parents = $this->matrix2x->direct_parents($username);
		} else {
			$parents = $this->matrix3x->direct_parents($username);
		}
		if (count($parents) > 0 && $levels > 0){
			for($i = 0 ; $i < $levels; $i++){
				if (isset($parents[$i])){
					$beneficiry = $parents[$i];
					$value = ($values[$i] * $amount)/100;
					$this->add_generation_bonus($beneficiry, $value, $matrix);
				} else {
					break;
				}
			}
		}
	}
	public function do_reverse_generation_bonus($username, $amount){
		if ($this->general->get_commission_var('reverse_generation_bonus_status') == '0'){
			return false;
		}
		$matrix = $this->general->get_system_var('matrix');
		$levels = $this->general->get_commission_var('reverse_generation_bonus_levels');
		$values = json_decode($this->general->get_commission_var('reverse_generation_bonus_values'));
		$this->rgb_recursion($username, $amount, $matrix, $values, $levels, 0);
	}
	public function do_roi_array_users($users_array){
		// $users_array array containing usernames only
		if ($this->general->get_commission_var('roi_status') == '0'){
			return false;
		}
		if (count($users_array)>0){
			$matrix = $this->general->get_system_var('matrix');
			$roi_percentage = $this->general->get_commission_var('roi_percentage');
			foreach ($users_array as $user){
				$total_roi = $this->total_roi_purchase($user);
				if ($total_roi > 0){
					$roi_amount = ($total_roi * $roi_percentage) /100;
					
					$this->add_roi($user, $roi_amount, $matrix);
					$this->do_matching_roi($user, $roi_amount);
					
				}
			}
		}
	}
	public function do_roi_single_user($username){
		if ($this->general->get_commission_var('roi_status') == '0'){
			return false;
		}
		
		$total_roi = $this->total_roi_purchase($username);
		if ($total_roi > 0){
			$matrix = $this->general->get_system_var('matrix');
			$roi_percentage = $this->general->get_commission_var('roi_percentage');
			$roi_amount = ($total_roi * $roi_percentage) /100;
			$this->add_roi($username, $roi_amount, $matrix);
			$this->do_matching_roi($username, $roi_amount);
		}
	}
	
	public function do_matching_roi($username, $amount){
		if ($this->general->get_commission_var('matching_roi_status') == '0'){
			return false;
		}
		$matrix = $this->general->get_system_var('matrix');
		$levels = $this->general->get_commission_var('matching_roi_levels');
		$values = json_decode($this->general->get_commission_var('matching_roi_values'));
		if ($matrix == '2x'){
			$parents = $this->matrix2x->direct_parents($username);
		} else {
			$parents = $this->matrix3x->direct_parents($username);
		}
		if (count($parents) > 0 && $levels > 0){
			for($i = 0 ; $i < $levels; $i++){
				if (isset($parents[$i])){
					$beneficiry = $parents[$i];
					$value = ($values[$i] * $amount)/100;
					$this->add_matching_roi($beneficiry, $value, $matrix);
				} else {
					break;
				}
			}
		}
	}
	public function rgb_recursion($username, $amount, $matrix, $values, $limit, $count=0){
		if ($limit > $count){
			if ($matrix == '2x'){
				$childs = $this->matrix2x->direct_childs($username);
			} else {
				$childs = $this->matrix3x->direct_childs($username);
			}
			if (count($childs) > 0){
				$total = ($amount * $values[$count])/100;
				$per_child = $total / count($childs);
				foreach ($childs as $child){
					$this->add_reverse_generation_bonus($child, $per_child, $matrix);
					$username = $child;
					$count = $count + 1;
					$this->rgb_recursion($username, $amount, $matrix, $values, $limit, $count);
				}
			}
			
		}
	}
	public function add_personal_sponsor_bonus($username, $amount, $matrix){
		if ($this->is_commission_eligible($username, 'personal-sponsor-bonus', $matrix) == true){
			$this->wallet->add_income($username, $amount, 'personal-sponsor-bonus');
		}
	}
	public function add_network_binary_bonus($username, $amount, $matrix){
		if ($this->is_commission_eligible($username, 'network-binary-bonus', $matrix) == true){
			$this->wallet->add_income($username, $amount, 'network-binary-bonus');
		}
	}
	public function add_generation_bonus($username, $amount, $matrix){
		if ($this->is_commission_eligible($username, 'generation-bonus', $matrix) == true){
			$this->wallet->add_income($username, $amount, 'generation-bonus');
		}
	}
	public function add_reverse_generation_bonus($username, $amount, $matrix){
		if ($this->is_commission_eligible($username, 'reverse-generation-bonus', $matrix) == true){
			$this->wallet->add_income($username, $amount, 'reverse-generation-bonus');
		}
	}
	public function add_roi($username, $amount, $matrix){
		if ($this->is_commission_eligible($username, 'roi', $matrix) == true){
			$this->wallet->add_income($username, $amount, 'roi');
		}
	}
	public function add_matching_roi($username, $amount, $matrix){
		if ($this->is_commission_eligible($username, 'matching-roi', $matrix) == true){
			$this->wallet->add_income($username, $amount, 'matching-roi');
		}
	}
	public function is_commission_disabled($username, $type){
		$this->db->select('id');
        $this->db->from('user_bonus_disabled');
        $this->db->where('username',$username);
        $this->db->where('bonus_type',$type);
        if ($this->db->get()->num_rows() > 0){
			return true;
		} else {
			return false;
		}
	}
	public function is_commission_eligible($username, $type, $matrix){
		if ($this->is_commission_disabled($username, $type) == true){
			return false;
		}
		if ($type == 'personal-sponsor-bonus'){
			$min_personal_sponsors = $this->general->get_commission_var('psb_min_direct_sponsors');
			if ($matrix == '2x'){
				$childs = $this->matrix2x->direct_childs_count($username, 'binary_2x');
			} else {
				$childs = $this->matrix3x->direct_childs_count($username, 'binary_3x');
			}
			if ($childs >= $min_personal_sponsors){
				$min_purchase = $this->general->get_commission_var('psb_min_purchases');
				$purchased = $this->total_products_purchase($username);
				if ($purchased >= $min_purchase){
					return true;
				} else {
					return false;
				}
				
			} else {
				return false;
			}
		} elseif ($type == 'network-binary-bonus'){
			$min_personal_sponsors = $this->general->get_commission_var('nbs_min_direct_sponsors');
			$min_binary_sponsors = $this->general->get_commission_var('nbs_min_binary_sponsors');
			if ($matrix == '2x'){
				$childs = $this->matrix2x->direct_childs_count($username, 'binary_2x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_2x');
			} else {
				$childs = $this->matrix3x->direct_childs_count($username, 'binary_3x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_3x');
			}
			if (($childs >= $min_personal_sponsors) && ($binary_childs >= $min_binary_sponsors)){
				$min_purchase = $this->general->get_commission_var('nbs_min_purchases');
				$purchased = $this->total_products_purchase($username);
				if ($purchased >= $min_purchase){
					return true;
				} else {
					return false;
				}
				
			} else {
				return false;
			}
		} elseif ($type == 'generation-bonus'){
			$min_personal_sponsors = $this->general->get_commission_var('gb_min_direct_sponsors');
			$min_binary_sponsors = $this->general->get_commission_var('gb_min_binary_sponsors');
			if ($matrix == '2x'){
				$childs = $this->matrix2x->direct_childs_count($username, 'binary_2x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_2x');
			} else {
				$childs = $this->matrix3x->direct_childs_count($username, 'binary_3x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_3x');
			}
			if (($childs >= $min_personal_sponsors) && ($binary_childs >= $min_binary_sponsors)){
				$min_purchase = $this->general->get_commission_var('nbs_min_purchases');
				$purchased = $this->total_products_purchase($username);
				if ($purchased >= $min_purchase){
					$total_direct_sponsors_bonus = $this->wallet->total_income($username, 'personal-sponsor-bonus');
					$total_binary_bonus = $this->wallet->total_income($username, 'network-binary-bonus');
					$min_direct_sponsors_bonus = $this->general->get_commission_var('gb_min_direct_sponsors_bonus');
					$min_binary_bonus = $this->general->get_commission_var('gb_min_nbb_bonus');
					if (($total_direct_sponsors_bonus >= $min_direct_sponsors_bonus) && ($total_binary_bonus >= $min_binary_bonus)){
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
				
			} else {
				return false;
			}
		} elseif ($type == 'reverse-generation-bonus'){
			$min_personal_sponsors = $this->general->get_commission_var('rgb_min_direct_sponsors');
			$min_binary_sponsors = $this->general->get_commission_var('rgb_min_binary_sponsors');
			if ($matrix == '2x'){
				$childs = $this->matrix2x->direct_childs_count($username, 'binary_2x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_2x');
			} else {
				$childs = $this->matrix3x->direct_childs_count($username, 'binary_3x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_3x');
			}
			if (($childs >= $min_personal_sponsors) && ($binary_childs >= $min_binary_sponsors)){
				$min_purchase = $this->general->get_commission_var('rgb_min_purchases');
				$purchased = $this->total_products_purchase($username);
				if ($purchased >= $min_purchase){
					$total_direct_sponsors_bonus = $this->wallet->total_income($username, 'personal-sponsor-bonus');
					$total_binary_bonus = $this->wallet->total_income($username, 'network-binary-bonus');
					$min_direct_sponsors_bonus = $this->general->get_commission_var('rgb_min_direct_sponsors_bonus');
					$min_binary_bonus = $this->general->get_commission_var('rgb_min_nbb_bonus');
					if (($total_direct_sponsors_bonus >= $min_direct_sponsors_bonus) && ($total_binary_bonus >= $min_binary_bonus)){
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
				
			} else {
				return false;
			}
		} elseif ($type == 'roi'){
			$min_personal_sponsors = $this->general->get_commission_var('roi_min_direct_sponsors');
			$min_binary_sponsors = $this->general->get_commission_var('roi_min_binary_sponsors');
			if ($matrix == '2x'){
				$childs = $this->matrix2x->direct_childs_count($username, 'binary_2x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_2x');
			} else {
				$childs = $this->matrix3x->direct_childs_count($username, 'binary_3x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_3x');
			}
			if (($childs >= $min_personal_sponsors) && ($binary_childs >= $min_binary_sponsors)){
				$min_purchase = $this->general->get_commission_var('roi_min_purchases');
				$purchased = $this->total_products_purchase($username);
				if ($purchased >= $min_purchase){
					$total_direct_sponsors_bonus = $this->wallet->total_income($username, 'personal-sponsor-bonus');
					$total_binary_bonus = $this->wallet->total_income($username, 'network-binary-bonus');
					$min_direct_sponsors_bonus = $this->general->get_commission_var('roi_min_direct_sponsors_bonus');
					$min_binary_bonus = $this->general->get_commission_var('roi_min_nbb_bonus');
					if (($total_direct_sponsors_bonus >= $min_direct_sponsors_bonus) && ($total_binary_bonus >= $min_binary_bonus)){
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
				
			} else {
				return false;
			}
		} elseif ($type == 'matching-roi'){
			$min_personal_sponsors = $this->general->get_commission_var('matching_roi_min_direct_sponsors');
			$min_binary_sponsors = $this->general->get_commission_var('matching_roi_min_binary_sponsors');
			if ($matrix == '2x'){
				$childs = $this->matrix2x->direct_childs_count($username, 'binary_2x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_2x');
			} else {
				$childs = $this->matrix3x->direct_childs_count($username, 'binary_3x');
				$binary_childs = $this->matrix2x->binary_childs_count($username, 'binary_3x');
			}
			if (($childs >= $min_personal_sponsors) && ($binary_childs >= $min_binary_sponsors)){
				$min_purchase = $this->general->get_commission_var('matching_roi_min_purchases');
				$purchased = $this->total_products_purchase($username);
				if ($purchased >= $min_purchase){
					$total_direct_sponsors_bonus = $this->wallet->total_income($username, 'personal-sponsor-bonus');
					$total_binary_bonus = $this->wallet->total_income($username, 'network-binary-bonus');
					$min_direct_sponsors_bonus = $this->general->get_commission_var('matching_roi_min_direct_sponsors_bonus');
					$min_binary_bonus = $this->general->get_commission_var('matching_roi_min_nbb_bonus');
					if (($total_direct_sponsors_bonus >= $min_direct_sponsors_bonus) && ($total_binary_bonus >= $min_binary_bonus)){
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
				
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function total_products_purchase($username){
		$total = '0';
		$result = $this->db->query("
		SELECT 
		count(purchase.id) as total
		FROM 
		purchase
		WHERE
		purchase.username='".$username."'
		")->result_array();
		$total = $result[0]['total'];
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function total_roi_purchase($username){
		$total = '0';
		$result = $this->db->query("
		SELECT 
		sum(purchase.roi) as total
		FROM 
		purchase
		WHERE
		purchase.username='".$username."'
		")->result_array();
		$total = $result[0]['total'];
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function total_type_income($username, $type){
		$total = '0';
		$result = $this->db->query("
		SELECT 
		sum(income.amount) as total
		FROM 
		income
		WHERE
		income.username='".$username."'
		AND
		type ='".$type."'
		")->result_array();
		$total = $result[0]['total'];
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function total_type_income_all_users($type){
		$total = '0';
		$result = $this->db->query("
		SELECT 
		sum(income.amount) as total
		FROM 
		income
		WHERE
		type ='".$type."'
		")->result_array();
		$total = $result[0]['total'];
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function product_name($product_id){
		$query = $this->db->query("SELECT title FROM products WHERE id='$product_id'")->result_array();
		if (count($query) > 0) {
			return $query[0]['title'];
		} else {
			return 'No Title';
		}
	}
	public function purchase_product($username, $product_id, $tranx_id, $method){
		$product = $this->general->get_tbl_field('products', '*', 'id', $product_id);
		if (count($product)>0){
			$data['tranx_id'] = $tranx_id;
			$data['username'] = $username;
			$data['product_id'] = $product_id;
			$data['selling_price'] = $product[0]['selling_price'];
			$data['psb'] = $product[0]['psb'];
			$data['nbb'] = $product[0]['nbb'];
			$data['gb'] = $product[0]['gb'];
			$data['rgb'] = $product[0]['rgb'];
			$data['roi'] = $product[0]['roi'];
			$data['payment_method'] = $method;
			$data['dated'] = date('Y-m-d H:i:s');
			
			$save = $this->db->insert('purchase', $data);
			if ($save){
				$this->do_personal_sponsor_bonus($username, $product[0]['psb']);
				$this->do_network_binary_bonus($username, $product[0]['nbb']);
				
				
				if ($this->general->get_commission_var('generation_bonus_base') == 'product_purchase'){
					$this->do_generation_bonus($username, $product[0]['gb']);
				}
				if ($this->general->get_commission_var('reverse_generation_bonus_base') == 'product_purchase'){
					$this->do_reverse_generation_bonus($username, $product[0]['rgb']);
				}
				
				$email = $this->user_account->user_email($username);
				if ($email){
					$s = strtotime($data['dated']);
					$mail_options = array(
						'name' 			=> $this->user_account->user_name($username),
						'username' 		=> $username,
						'system_name' 	=> $this->general->get_system_var('system_name'),
						'product_name' 		=> $product[0]['title'],
						'product_img_path' 		=> base_url($product[0]['thumb']),
						'product_price' 		=>$product[0]['selling_price'],
						'transaction_id' 		=> $tranx_id,
						'action_time' 	=> date('H:i:s', $s),
						'action_date' 	=> date('Y-m-d', $s)
					);
					$this->emails->send_type_email($email, 'product_purchased', $mail_options);
					$mobile = $this->user_account->user_mobile($username);
					if ($mobile){
						$this->sms->send_type_sms($mobile, 'product_purchased', $mail_options);
					}
				}
				
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function product_purchased($username){
		$query = $this->db->query("SELECT id FROM purchase WHERE username='$username'")->result_array();
		if (count($query) > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function total_user_poducts($username){
		$data = $this->db->query("SELECT id FROM purchase WHERE username='$username'")->result_array();
		return count($data);
	}
	
}