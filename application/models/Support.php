<?php
class Support extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	
	public function user_tickets($username){
		$tickets = $this->general->get_tbl_field('support_ticket', '*', 'username', $username);
		if (count($tickets)>0){
			return $tickets;
		} else {
			return array();
		}
	}
	public function last_message($ticket_id){
		$data = $this->general->get_tbl_field('support_ticket_data', 'updated', 'ticket_id', $ticket_id);
		if (count($data)>0){
			$date = $data[0]['updated'];
			return $this->general->time_ago($date);
		} else {
			return 'No Message';
		}
	}
	public function ticket_id_by_key($key){
		$data = $this->general->get_tbl_field('support_ticket', 'id', 'ticket_id', $key);
		if (count($data)>0){
			return $data[0]['id'];
		} else {
			return false;
		}
	}
	public function ticket_data($username, $ticket_id){
		$this->db->select('*');
		$this->db->from('support_ticket');
		$this->db->where('username',$username);
		$this->db->where('ticket_id', $ticket_id);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$data = $this->db->get()->result_array();
		if(count($data) > 0){
			return $data;
		}else{
			return array();
		}
	}
	public function ticket_data_admin($ticket_id){
		$this->db->select('*');
		$this->db->from('support_ticket');
		$this->db->where('ticket_id', $ticket_id);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$data = $this->db->get()->result_array();
		if(count($data) > 0){
			return $data;
		}else{
			return array();
		}
	}
	public function count_open_tickets($username){
		$this->db->select('*');
		$this->db->from('support_ticket');
		$this->db->where('username',$username);
		$this->db->where('status','open');
		$this->db->order_by('id', 'DESC');
		$data = $this->db->get()->result_array();
		return count($data);
	}
	public function count_open_tickets_a(){
		$this->db->select('*');
		$this->db->from('support_ticket');
		$this->db->where('status','open');
		$this->db->order_by('id', 'DESC');
		$data = $this->db->get()->result_array();
		return count($data);
	}
	public function open_tickets($username){
		$this->db->select('*');
		$this->db->from('support_ticket');
		$this->db->where('username',$username);
		$this->db->where('status','open');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$data = $this->db->get()->result_array();
		if(count($data) > 0){
			return $data;
		}else{
			return array();
		}
	}
	public function get_ticket_data($ticket_id){
		$this->db->select('*');
		$this->db->from('support_ticket_data');
		$this->db->where('ticket_id',$ticket_id);
		$this->db->order_by('id', 'ACS');
		$data = $this->db->get()->result_array();
		if(count($data) > 0){
			return $data;
		}else{
			return array();
		}
	}
	public function is_ticket_available($ticket_id){
		$this->db->select('*');
		$this->db->from('support_ticket');
		$this->db->where('id',$ticket_id);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$data = $this->db->get()->result_array();
		if(count($data) > 0){
			return true;
		}else{
			return false;
		}
	}
	
}