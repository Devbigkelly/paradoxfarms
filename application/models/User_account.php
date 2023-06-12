<?php
class User_account extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	
	public function delete_user_record($username){
		$this->general->delete_tbl_data('admin_transactions', 'transfer_to', $username);
		$this->general->delete_tbl_data('binary_2x', 'username', $username);
		$this->general->delete_tbl_data('avatar', 'username', $username);
		$this->general->delete_tbl_data('binary_2x_position', 'username', $username);
		$this->general->delete_tbl_data('binary_3x', 'username', $username);
		$this->general->delete_tbl_data('binary_3x_position', 'username', $username);
		$this->general->delete_tbl_data('e_pins', 'username', $username);
		$this->general->delete_tbl_data('income', 'username', $username);
		$this->general->delete_tbl_data('invitations', 'username', $username);
		$this->general->delete_tbl_data('kyc_user_docs', 'username', $username);
		$this->general->delete_tbl_data('manual_payments', 'username', $username);
		$this->general->delete_tbl_data('notifications', 'username', $username);
		$this->general->delete_tbl_data('notification_settings', 'username', $username);
		$this->general->delete_tbl_data('payments', 'username', $username);
		$this->general->delete_tbl_data('purchase', 'username', $username);
		$this->general->delete_tbl_data('support_ticket', 'username', $username);
		$this->general->delete_tbl_data('support_ticket_data', 'username', $username);
		$this->general->delete_tbl_data('transactions', 'username', $username);
		$this->general->delete_tbl_data('transfers', 'transfer_to', $username);
		$this->general->delete_tbl_data('transfers', 'transfer_from', $username);
		$this->general->delete_tbl_data('users', 'username', $username);
		$this->general->delete_tbl_data('user_info', 'username', $username);
		$this->general->delete_tbl_data('wallet', 'username', $username);
		$this->general->delete_tbl_data('wallet_statement', 'username', $username);
		$this->general->delete_tbl_data('withdraw', 'username', $username);
	}
	public function user_info($username){
		$matrix = $this->general->get_system_var('matrix');
		if ($matrix == '2x'){
			$table = 'binary_2x';
		} elseif ($matrix == '3x'){
			$table = 'binary_3x';
		}
		$this->db->select('users.name, users.email, users.mobile, users.created, '.$table.'.direct_referral, '.$table.'.binary_referral, '.$table.'.position');
		$this->db->from('users');
		$this->db->join($table, $table.'.username = users.username');
		$this->db->where('users.username', $username);
		return $this->db->get()->result_array();
	}
	public function get_users_list($user_group){
		$matrix = $this->general->get_system_var('matrix');
		if ($matrix == '2x'){
			$this->db->select('users.name, users.username, users.created, users.status, binary_2x.direct_referral, binary_2x.binary_referral, binary_2x.position');
		} else {
			$this->db->select('users.name, users.username, users.created, users.status, binary_3x.direct_referral, binary_3x.binary_referral, binary_3x.position');
		}
		
		$this->db->from('users');
		if ($matrix == '2x'){
			$this->db->join('binary_2x', 'binary_2x.username = users.username');
		} else {
			$this->db->join('binary_3x', 'binary_3x.username = users.username');
		}
		$this->db->where('users.user_group', $user_group);
		return $this->db->get()->result_array();
		
	}
	public function epin_exists($username){
		$query = $this->db->query("SELECT id FROM e_pins WHERE username='$username'")->result_array();
		if (count($query)>0){
			return true;
		} else {
			return false;
		}
	}
	public function verify_epin($username, $epin){
		$query = $this->db->query("SELECT id FROM e_pins WHERE username='$username' AND e_pin='$epin' ORDER by id DESC LIMIT 1")->result_array();
		if (count($query)>0){
			return true;
		} else {
			return false;
		}
	}
	public function email_exists($email)
	{
		$query = $this->db->query("SELECT id FROM users WHERE email='$email'");
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function mobile_exists($mobile)
	{
		$query = $this->db->query("SELECT id FROM users WHERE mobile='$mobile'");
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function username_by_mobile($mobile)
	{
		$query = $this->db->query("SELECT username FROM users WHERE mobile='$mobile'")->result_array();
		if (count($query) > 0) {
			return $query[0]['username'];
		} else {
			return FALSE;
		}
	}
	public function username_by_email($email)
	{
		$query = $this->db->query("SELECT username FROM users WHERE email='$email'")->result_array();
		if (count($query) > 0) {
			return $query[0]['username'];
		} else {
			return FALSE;
		}
	}
	public function username_exists($username)
	{
		$query = $this->db->query("SELECT * FROM users WHERE username='$username'");
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function user_username_exists($username)
	{
		$query = $this->db->query("SELECT * FROM users WHERE user_group='member' AND username='$username'");
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function moderator_exists($username)
	{
		$query = $this->db->query("SELECT * FROM users WHERE user_group='admin' AND username='$username'");
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function verify_login($userid, $password)
	{
		$password = md5($password);
		$query = $this->db->query("SELECT * FROM users WHERE username='$userid' AND BINARY password='$password' OR  email='$userid' AND BINARY password='$password' LIMIT 1");
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function get_user_data($userid)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where("(username='$userid' OR email='$userid')", NULL, FALSE);
		$user_data = $this->db->get()->result_array();
		return $user_data;
	}
	public function user_name($username){
		$data = $this->db->query("SELECT name FROM users WHERE username='$username'")->result_array();
		if (count($data) > 0) {
			return $data[0]['name'];
		} else {
			return FALSE;
		}
	}
	public function user_email($username){
		$data = $this->db->query("SELECT email FROM users WHERE username='$username'")->result_array();
		if (count($data) > 0) {
			return $data[0]['email'];
		} else {
			return FALSE;
		}
	}
	public function user_mobile($username){
		$data = $this->db->query("SELECT mobile FROM users WHERE username='$username'")->result_array();
		if (count($data) > 0) {
			return $data[0]['mobile'];
		} else {
			return FALSE;
		}
	}
	
	public function get_small_pic($username){
			
		$image = base_url($this->general->get_system_var('avatar-small'));
		$query = $this->db->query("SELECT small FROM avatar WHERE username='$username' ORDER by id DESC LIMIT 1");
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
				$image = base_url($row['small']);
			}
		}
		if (!$image || $image == ""){
			$image = base_url($this->general->get_system_var('avatar-small'));
		}
		return $image;
	}
	public function get_large_pic($username){
		$image = base_url($this->general->get_system_var('avatar-big'));
		$query = $this->db->query("SELECT big FROM avatar WHERE username='$username' ORDER by id DESC LIMIT 1");
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
				$image = base_url($row['big']);
			}
		}
		if (!$image || $image == ""){
			$image = base_url($this->general->get_system_var('avatar-big'));
		}
		return $image;
	}
	public function get_pic($username, $type){
		if ($type == 'small'){
			$image = $this->get_small_pic($username);
		}
		if ($type == 'big'){
			$image = $this->get_large_pic($username);
		}
		return $image;
	}
	public function get_pic_blank($type){
		$image = base_url('uploads/plus.png');
		/* if ($type == 'small'){
			$image = base_url($this->general->get_system_var('avatar-small'));
		}
		if ($type == 'big'){
			$image = base_url($this->general->get_system_var('avatar-big'));
		} */
		return $image;
	}
}