<?php
class Ranking_model extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	public function rank_clr($username){
		$user_rank = $this->user_rank($username);
		if ($user_rank == 'Not Available' || $user_rank == 'No Rank Yet' || $user_rank == ''){
			return 'navbar-white navbar-light';
		} else {
			$data =  $this->db->query("SELECT rank_color FROM ranks WHERE title='$user_rank'")->result_array();
			if (count($data)>0){
				return $data[0]['rank_color'];
			} else {
				return 'navbar-white navbar-light';
			}
		}
	}
	public function user_rank($username){
		if ($this->general->get_system_var('ranking_system_status') == '0'){
			return 'Not Available';
		}
		$ranks =  $this->db->query("SELECT id FROM ranks ORDER BY rank_order  DESC")->result_array();
		if (count($ranks)>0){
			foreach ($ranks as $key=>$r){
				if ($key == 0){
					$last_rank = $this->in_last_rank($username);
					if ($last_rank){
						return $last_rank;
					}
				} else {
					if ($this->in_rank($username, $r['id'])){
						return $r['title'];
					}
				}
			} 
			return 'No Rank Yet';
		} else {
			return 'Not Available';
		}
		
	}
	public function xnd_last_record($x=0){
		$data =  $this->db->query("SELECT * FROM ranks ORDER BY rank_order  DESC LIMIT $x,1")->result_array();
		return $data;
	}
	public function in_rank($username, $rank_id){
		$psb = false;
		$nbb = false;
		$gb = false;
		$rgb = false;
		$roi = false;
		$m_roi = false;
		$personal_business = false;
		$team_business = false;
		$data = $this->db->query("SELECT * FROM ranks WHERE id='$rank_id'")->result_array();
		if (count($data)>0){
			$user_psb = $this->wallet->total_income($username, 'personal-sponsor-bonus');
			if ($this->value_in_range($data['0']['psb_min'], $data['0']['psb_max'], $user_psb)){
				$user_nbb = $this->wallet->total_income($username, 'network-binary-bonus');
				if ($this->value_in_range($data['0']['nbb_min'], $data['0']['nbb_max'], $user_nbb)){
					$user_gb = $this->wallet->total_income($username, 'generation-bonus');
					if ($this->value_in_range($data['0']['gb_min'], $data['0']['gb_max'], $user_gb)){
						$user_rgb = $this->wallet->total_income($username, 'reverse-generation-bonus');
						if ($this->value_in_range($data['0']['rgb_min'], $data['0']['rgb_max'], $user_rgb)){
							$user_roi = $this->wallet->total_income($username, 'roi');
							if ($this->value_in_range($data['0']['roi_min'], $data['0']['roi_max'], $user_roi)){
								$user_m_roi = $this->wallet->total_income($username, 'matching-roi');
								if ($this->value_in_range($data['0']['m_roi_min'], $data['0']['m_roi_max'], $user_m_roi)){
									$user_persinal_business = $this->personal_business($username);
									if ($user_persinal_business >= $data['0']['min_direct_business']){
										$user_team_business = $this->team_business($username);
										if ($user_team_business >= $data['0']['min_team_business']){
											return $data['0']['title'];
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
		} else {
			return false;
		}
	}
	public function value_in_range($min, $max, $value){
		if ($value >= $min && $value <= $max){
			return true;
		} else {
			return false;
		}
	}
	public function in_last_rank($username){
		$psb = false;
		$nbb = false;
		$gb = false;
		$rgb = false;
		$roi = false;
		$m_roi = false;
		$personal_business = false;
		$team_business = false;
		$data = $this->db->query('SELECT * FROM ranks ORDER by rank_order DESC LIMIT 1')->result_array();
		if (count($data)>0){
			$user_psb = $this->wallet->total_income($username, 'personal-sponsor-bonus');
			if ($this->value_in_range_last($data['0']['psb_min'], $user_psb)){
				$user_nbb = $this->wallet->total_income($username, 'network-binary-bonus');
				if ($this->value_in_range_last($data['0']['nbb_min'], $user_nbb)){
					$user_gb = $this->wallet->total_income($username, 'generation-bonus');
					if ($this->value_in_range_last($data['0']['gb_min'], $user_gb)){
						$user_rgb = $this->wallet->total_income($username, 'reverse-generation-bonus');
						if ($this->value_in_range_last($data['0']['rgb_min'], $user_rgb)){
							$user_roi = $this->wallet->total_income($username, 'roi');
							if ($this->value_in_range_last($data['0']['roi_min'], $user_roi)){
								$user_m_roi = $this->wallet->total_income($username, 'matching-roi');
								if ($this->value_in_range_last($data['0']['m_roi_min'], $user_m_roi)){
									$user_persinal_business = $this->personal_business($username);
									if ($user_persinal_business >= $data['0']['min_direct_business']){
										$user_team_business = $this->team_business($username);
										if ($user_team_business >= $data['0']['min_team_business']){
											return $data['0']['title'];
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
		} else {
			return false;
		}
	}
	
	public function value_in_range_last($min, $value){
		if ($value >= $min){
			return true;
		} else {
			return false;
		}
	}
	public function team_business($username){
		$total = '0';
		$matrix = $this->general->get_system_var('matrix');
		if ($matrix == '2x'){
			$referrals = $this->matrix2x->getChildrenArray($username, 'binary_2x');
		} else {
			$referrals = $this->matrix3x->getChildrenArray($username, 'binary_3x');
		}
		if (count($referrals)>0){
			foreach($referrals as $r){
				$total = $total + $this->total_purchase($r);
			}
		}
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function personal_business($username){
		$total = '0';
		$referrals = $this->user_referrals($username);
		if (count($referrals)>0){
			foreach($referrals as $r){
				$total = $total + $this->total_purchase($r);
			}
		}
		if (!$total){
			$total = '0';
		}
		return $total;
	}
	public function total_purchase($username){
		$amount = '0';
		$result = $this->db->query("
		SELECT 
		sum(purchase.selling_price) as amount
		FROM 
		purchase
		WHERE
		purchase.username='".$username."'
		")->result_array();
		$amount = $result[0]['amount'];
		if (!$amount){
			$amount = '0';
		}
		return $amount;
	}
	
	public function user_referrals($username){
		$matrix = $this->general->get_system_var('matrix');
		$referrals = array();
		if ($matrix == '2x'){
			$data = $this->db->query("SELECT username FROM binary_2x WHERE direct_referral = '$username'")->result_array();
		} else {
			$data = $this->db->query("SELECT username FROM binary_3x WHERE direct_referral = '$username'")->result_array();
		}
		if (count($data)>0){
			foreach($data as $d){
				$referrals[] = $d['username'];
			}
		}
		return $referrals;
	}
	public function is_overriding_except_current($min, $max, $bonus_type = 'psb', $current_id){
		$data = $this->general->get_all_tbl_data('ranks', '*');
		if (count($data)>0){
			foreach ($data as $row){
				if ($row['id'] !== $current_id){
					if ($bonus_type == 'psb'){
						if ($row['psb_min'] <= $min && $row['psb_max'] >= $min){
							return true;
						} elseif ($row['psb_min'] <= $max && $row['psb_max'] >= $max){
							return true;
						} elseif ($min <= $row['psb_min'] && $row['psb_max'] <= $max){
							return true;
						}
					} elseif ($bonus_type == 'nbb'){
						if ($row['nbb_min'] <= $min && $row['nbb_max'] >= $min){
							return true;
						} elseif ($row['nbb_min'] <= $max && $row['nbb_max'] >= $max){
							return true;
						} elseif ($min <= $row['nbb_min'] && $row['nbb_max'] <= $max){
							return true;
						}
					} elseif ($bonus_type == 'gb'){
						if ($row['gb_min'] <= $min && $row['gb_max'] >= $min){
							return true;
						} elseif ($row['gb_min'] <= $max && $row['gb_max'] >= $max){
							return true;
						} elseif ($min <= $row['gb_min'] && $row['gb_max'] <= $max){
							return true;
						}
					} elseif ($bonus_type == 'rgb'){
						if ($row['rgb_min'] <= $min && $row['rgb_max'] >= $min){
							return true;
						} elseif ($row['rgb_min'] <= $max && $row['rgb_max'] >= $max){
							return true;
						} elseif ($min <= $row['rgb_min'] && $row['rgb_max'] <= $max){
							return true;
						}
					} elseif ($bonus_type == 'roi'){
						if ($row['roi_min'] <= $min && $row['roi_max'] >= $min){
							return true;
						} elseif ($row['roi_min'] <= $max && $row['roi_max'] >= $max){
							return true;
						} elseif ($min <= $row['roi_min'] && $row['roi_max'] <= $max){
							return true;
						}
					} elseif ($bonus_type == 'm_roi'){
						if ($row['m_roi_min'] <= $min && $row['m_roi_max'] >= $min){
							return true;
						} elseif ($row['m_roi_min'] <= $max && $row['m_roi_max'] >= $max){
							return true;
						} elseif ($min <= $row['m_roi_min'] && $row['m_roi_max'] <= $max){
							return true;
						}
					}
				}
				
			}
			return false;
		} else {
			return false;
		}
	}
	public function is_overriding($min, $max, $bonus_type = 'psb'){
		$data = $this->general->get_all_tbl_data('ranks', '*');
		if (count($data)>0){
			foreach ($data as $row){
				if ($bonus_type == 'psb'){
					if ($row['psb_min'] <= $min && $row['psb_max'] >= $min){
						return true;
					} elseif ($row['psb_min'] <= $max && $row['psb_max'] >= $max){
						return true;
					} elseif ($min <= $row['psb_min'] && $row['psb_max'] <= $max){
						return true;
					}
				} elseif ($bonus_type == 'nbb'){
					if ($row['nbb_min'] <= $min && $row['nbb_max'] >= $min){
						return true;
					} elseif ($row['nbb_min'] <= $max && $row['nbb_max'] >= $max){
						return true;
					} elseif ($min <= $row['nbb_min'] && $row['nbb_max'] <= $max){
						return true;
					}
				} elseif ($bonus_type == 'gb'){
					if ($row['gb_min'] <= $min && $row['gb_max'] >= $min){
						return true;
					} elseif ($row['gb_min'] <= $max && $row['gb_max'] >= $max){
						return true;
					} elseif ($min <= $row['gb_min'] && $row['gb_max'] <= $max){
						return true;
					}
				} elseif ($bonus_type == 'rgb'){
					if ($row['rgb_min'] <= $min && $row['rgb_max'] >= $min){
						return true;
					} elseif ($row['rgb_min'] <= $max && $row['rgb_max'] >= $max){
						return true;
					} elseif ($min <= $row['rgb_min'] && $row['rgb_max'] <= $max){
						return true;
					}
				} elseif ($bonus_type == 'roi'){
					if ($row['roi_min'] <= $min && $row['roi_max'] >= $min){
						return true;
					} elseif ($row['roi_min'] <= $max && $row['roi_max'] >= $max){
						return true;
					} elseif ($min <= $row['roi_min'] && $row['roi_max'] <= $max){
						return true;
					}
				} elseif ($bonus_type == 'm_roi'){
					if ($row['m_roi_min'] <= $min && $row['m_roi_max'] >= $min){
						return true;
					} elseif ($row['m_roi_min'] <= $max && $row['m_roi_max'] >= $max){
						return true;
					} elseif ($min <= $row['m_roi_min'] && $row['m_roi_max'] <= $max){
						return true;
					}
				}
			}
			return false;
		} else {
			return false;
		}
	}
}