<?php
class Dashboards extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	public function user_dashboard($username){
		$data['wallet_amount'] = currency($this->wallet->wallet_amount($username,'wallet'));
		$data['total_users'] = $this->total_user_referrals($username);
		$data['active_users'] = $this->total_active_referrals($username);
		$data['psb'] = $this->commissions->total_type_income($username,'personal-sponsor-bonus');
		$data['nbb'] = $this->commissions->total_type_income($username,'network-binary-bonus');
		$data['gb'] = $this->commissions->total_type_income($username,'generation-bonus');
		$data['rgb'] = $this->commissions->total_type_income($username,'reverse-generation-bonus');
		$data['roi'] = $this->commissions->total_type_income($username,'roi');
		$data['matching_roi'] = $this->commissions->total_type_income($username,'matching-roi');
		
		$data['withdrawn'] = currency($this->wallet->withdraw_total($username));
		$data['open_tickets'] = $this->support->count_open_tickets($username);
		$data['purchased'] = $this->products_purchased_user($username);
		$data['total_sale'] = currency($this->total_sales($username));
		
		$data['withdraw_pending'] = currency($this->wallet->withdraw_total_pending($username));
		return $data;
	}
	public function admin_dashboard(){
		$data['wallet_amount'] = currency($this->wallet->total_wallet_a('wallet'));
		$data['total_users'] = $this->total_admin_users();
		$data['active_users'] = $this->total_active_users();
		$data['psb'] = $this->commissions->total_type_income_all_users('personal-sponsor-bonus');
		$data['nbb'] = $this->commissions->total_type_income_all_users('network-binary-bonus');
		$data['gb'] = $this->commissions->total_type_income_all_users('generation-bonus');
		$data['rgb'] = $this->commissions->total_type_income_all_users('reverse-generation-bonus');
		$data['roi'] = $this->commissions->total_type_income_all_users('roi');
		$data['matching_roi'] = $this->commissions->total_type_income_all_users('matching-roi');
		
		$data['withdrawn'] = currency($this->wallet->withdraw_total_a());
		$data['withdraw_pending'] = currency($this->wallet->withdraw_total_pending_a());
		$data['open_tickets'] = $this->support->count_open_tickets_a();
		$data['purchased'] = $this->products_purchased_admin();
		$data['total_sale'] = currency($this->total_purchase_admin());
		return $data;
	}
	
	
	public function admin_bar_chart_data(){
		$to_date = date('Y-m-d');
		$new_timestamp = strtotime('-11 months', strtotime($to_date));
		$from_date =  date("Y-m-01",$new_timestamp);
		$this->db->select('SUM(amount) as total, Date(dated) as date, Month(dated) as month, Year(dated) as year');
		$this->db->from('income');
		$this->db->where("date_format(dated,'%Y-%m-%d') between '".date('Y-m-d',strtotime($from_date))."' and '".date('Y-m-d',strtotime($to_date))."'",null,false);
		$this->db->group_by('month');
		$income = $this->db->get()->result_array();
		
		$start    = (new DateTime($from_date))->modify('first day of this month');
		$end      = (new DateTime($to_date))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		
		$income_data = array();
		$month_data = array();
		foreach ($period as $key => $dt) {
			$num = $key + 1;
			$month = $dt->format("m");
			$month_name = $dt->format("M");
			$mnth = array($num, $month_name);
			$month_data[] = $mnth;
			$month_key = array_search($month, array_column($income, 'month'));
			
			if ($month_key){
				$i_value = $income[$month_key]['total'];
			} else {
				$i_value = 0;
			}
			$income_arr = array($num, $i_value);
			$income_data[] = $income_arr;
		}
		$response['income'] = $income_data;
		$response['months'] = $month_data;
		return $response;
	}
	public function bar_chart_data($username){
		$to_date = date('Y-m-d');
		$new_timestamp = strtotime('-11 months', strtotime($to_date));
		$from_date =  date("Y-m-01",$new_timestamp);
		$this->db->select('SUM(amount) as total, Date(dated) as date, Month(dated) as month, Year(dated) as year');
		$this->db->from('income');
		$this->db->where("date_format(dated,'%Y-%m-%d') between '".date('Y-m-d',strtotime($from_date))."' and '".date('Y-m-d',strtotime($to_date))."'",null,false);
		$this->db->where('username', $username);
		$this->db->group_by('month');
		$income = $this->db->get()->result_array();
		
		$start    = (new DateTime($from_date))->modify('first day of this month');
		$end      = (new DateTime($to_date))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		
		$income_data = array();
		$month_data = array();
		foreach ($period as $key => $dt) {
			$num = $key + 1;
			$month = $dt->format("m");
			$month_name = $dt->format("M");
			$year = $dt->format("y");
			$mnth = array($num, $month_name);
			$month_data[] = $mnth;
			$month_key = array_search($month, array_column($income, 'month'));
			
			if ($month_key){
				$i_value = $income[$month_key]['total'];
			} else {
				$i_value = 0;
			}
			$income_arr = array($num, $i_value);
			$income_data[] = $income_arr;
		}
		$response['income'] = $income_data;
		$response['months'] = $month_data;
		return $response;
	}
	public function line_chart_data($username){
		$matrix = $this->general->get_system_var('matrix');
		
		if ($matrix == '2x'){
			$binary = $this->matrix2x->getChildrenForPlacement($username);
			$direct = $this->matrix2x->direct_childs($username);
		} else {
			$binary = $this->matrix3x->getChildrenForPlacement($username);
			$direct = $this->matrix3x->direct_childs($username);
		}
		if (count($binary)<1){
			$binary[] = '';
		}
		if (count($direct)<1){
			$direct[] = '';
		}
		$to_date = date('Y-m-d');
		$new_timestamp = strtotime('-11 months', strtotime($to_date));
		$from_date =  date("Y-m-01",$new_timestamp);
		$this->db->select('SUM(selling_price) as amount, Date(dated) as date, Month(dated) as month, Year(dated) as year');
		$this->db->from('purchase');
		$this->db->where("date_format(dated,'%Y-%m-%d') between '".date('Y-m-d',strtotime($from_date))."' and '".date('Y-m-d',strtotime($to_date))."'",null,false);
		$this->db->where_in('username', $binary);
		$this->db->group_by('month');
		$binary_sale = $this->db->get()->result_array();
		
		$this->db->select('SUM(selling_price) as amount, Date(dated) as date, Month(dated) as month, Year(dated) as year');
		$this->db->from('purchase');
		$this->db->where("date_format(dated,'%Y-%m-%d') between '".date('Y-m-d',strtotime($from_date))."' and '".date('Y-m-d',strtotime($to_date))."'",null,false);
		$this->db->where_in('username', $direct);
		$this->db->group_by('month');
		$direct_sale = $this->db->get()->result_array();
		
		$start    = (new DateTime($from_date))->modify('first day of this month');
		$end      = (new DateTime($to_date))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);

		$binary_data = array();
		$direct_data = array();
		$month_data = array();
		foreach ($period as $key => $dt) {
			$num = $key + 1;
			$month = $dt->format("m");
			$month_name = $dt->format("M");
			$year = $dt->format("y");
			$mnth = array($num, $month_name.'-'.$year);
			$month_data[] = $mnth;
			$binary_key = array_search($month, array_column($binary_sale, 'month'));
			if ($binary_key){
				$b_value = $binary_sale[$binary_key]['amount'];
			} else {
				$b_value = 0;
			}
			//$binary = array($year.'-'.$month, $b_value);
			$binary = array($num, $b_value);
			$binary_data[] = $binary;
			
			$direct_key = array_search($month, array_column($direct_sale, 'month'));
			if ($direct_key){
				$d_value = $direct_sale[$direct_key]['amount'];
			} else {
				$d_value = 0;
			}
			//$direct = array($year.'-'.$month, $d_value);
			$direct = array($num, $d_value);
			$direct_data[] = $direct;
		}
		
		$response['binary'] = $binary_data;
		$response['direct'] = $direct_data;
		$response['months'] = $month_data;
		return $response;
	}
	
	public function total_sales($username){
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
	public function total_purchase_admin(){
		$amount = '0';
		$result = $this->db->query("
		SELECT 
		sum(purchase.selling_price) as amount
		FROM 
		purchase
		")->result_array();
		$amount = $result[0]['amount'];
		if (!$amount){
			$amount = '0';
		}
		return $amount;
	}
	public function products_purchased_user($username){
		$data = $this->db->query("SELECT id FROM purchase WHERE username='$username'")->result_array();
		return count($data);
	}
	public function products_purchased_admin(){
		$data = $this->db->query("SELECT id FROM purchase")->result_array();
		return count($data);
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
	public function total_active_referrals($username){
		$matrix = $this->general->get_system_var('matrix');
		$total = '0';
		if ($matrix == '2x'){
			$data = $this->db->query("SELECT username FROM binary_2x WHERE direct_referral = '$username'")->result_array();
		} else {
			$data = $this->db->query("SELECT username FROM binary_3x WHERE direct_referral = '$username'")->result_array();
		}
		
		if (count($data)>0){
			foreach($data as $row){
				if ($this->commissions->product_purchased($row['username']) == true){
					$total = $total + 1;
				}
			}
			
		}
		return $total;
	}
	public function total_active_users(){
		$total = '0';
		$data = $this->db->query("SELECT username FROM users")->result_array();
		if (count($data)>0){
			foreach($data as $row){
				if ($this->commissions->product_purchased($row['username']) == true){
					$total = $total + 1;
				}
			}
			
		}
		return $total;
	}
	public function total_admin_users(){
		$data = $this->db->query("SELECT id FROM users WHERE user_group='member'")->result_array();
		return count($data);
	}
	public function card_details($username){
		$data['name'] = $this->user_account->user_name($username);
		$data['avatar'] = $this->user_account->get_small_pic($username);
		$data['wallet_amount'] = currency($this->wallet->wallet_amount($username, 'wallet'));
		$data['referrals'] = $this->total_user_referrals($username);
		$data['purchased'] = $this->products_purchased_user($username);
		return $data;
		
	}
	public function total_user_referrals($username){
		$matrix = $this->general->get_system_var('matrix');
		if ($matrix == '2x'){
			$data = $this->db->query("SELECT id FROM binary_2x WHERE direct_referral='$username'")->result_array();
		} else {
			$data = $this->db->query("SELECT id FROM binary_3x WHERE direct_referral='$username'")->result_array();
		}
		return count($data);
	}
	public function income_total_entries($type, $username=''){
		$this->db->select('id');
		if ($username !==''){
			$this->db->where ('username', $username);
		}
		$this->db->where('type',$type);
		return $this->db->count_all_results('income');
	}
	public function wallet_history_total_entries($username=''){
		$this->db->select('id');
		if ($username !==''){
			$this->db->where ('username', $username);
		}
		return $this->db->count_all_results('wallet_statement');
	}
}