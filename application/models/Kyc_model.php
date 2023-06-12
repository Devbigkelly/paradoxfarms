<?php
class Kyc_model extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	public function is_kyc_active(){
		if ($this->general->get_system_var('kyc_status') == '1'){
			return true;
		} else {
			return false;
		}
	}
	public function doc_title_by_id($document_id){
		$data = $this->db->query("SELECT document_title FROM kyc_requirements WHERE id='$document_id'")->result_array();
		if (count($data)>0){
			return $data[0]['document_title'];
		} else {
			return false;
		}
	}
	public function is_doc_provided($username, $document_id){
		$data = $this->db->query("SELECT id FROM kyc_user_docs WHERE username='$username' AND kyc_requirement_id='$document_id' AND status='0'")->result_array();
		if (count($data)>0){
			return true;
		} else {
			return false;
		}
	}
	public function approve_user_kyc($username){
		$this->db->where('username', $username);
		$this->db->where('status', '0');
		$data['status'] = '1';
		return $this->db->update('kyc_user_docs', $data);
	}
	public function reject_user_kyc($username){
		$this->db->where('username', $username);
		$this->db->where('status', '0');
		$data['status'] = '2';
		return $this->db->update('kyc_user_docs', $data);
	}
	public function get_kyc_list($status){
		$this->db->select('username, status, dated');
		$this->db->from('kyc_user_docs');
		$this->db->where('status', $status);
		$this->db->group_by('username');
		$data = $this->db->get()->result_array();
		//$data = $this->db->query("SELECT DISTINCT username, status, dated FROM kyc_user_docs WHERE status='$status'")->result_array();
		return $data;
	}
	public function required_docs(){
		$data = $this->general->get_all_tbl_data('kyc_requirements', 'id, document_title');
		return $data;
	}
	public function user_provided_docs($username){
		$data = $this->db->query("
		SELECT kyc_requirement_id
		FROM
		kyc_user_docs
		WHERE 
		username = '$username'
		AND
		status='0'
		OR
		username = '$username'
		AND
		status='1'
		")->result_array();
		return $data;
	}
	public function user_verified_docs($username){
		$data = $this->db->query("
		SELECT kyc_requirement_id
		FROM
		kyc_user_docs
		WHERE 
		username = '$username'
		AND
		status='1'
		")->result_array();
		return $data;
	}
	public function is_kyc_provided($username){
		if ($this->is_kyc_active() == false){
			return true;
		}
		$require = array();
		$required = $this->required_docs();
		
		$provided = $this->user_provided_docs($username);
		if (count($provided)>0){
			foreach($provided as $p){
				$provided_ids[] = $p['kyc_requirement_id'];
			}
			if (count($required)>0){
				foreach($required as $r){
					$require[] = $r['id'];
					if (!in_array($r['id'], $provided_ids)){
						return false;
					}
				}
				return true;
				
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	public function is_kyc_verified($username){
		if ($this->is_kyc_active() == false){
			return true;
		}
		$require = array();
		$required = $this->required_docs();
		
		$provided = $this->user_verified_docs($username);
		if (count($provided)>0){
			foreach($provided as $p){
				$provided_ids[] = $p['kyc_requirement_id'];
			}
			if (count($required)>0){
				foreach($required as $r){
					$require[] = $r['id'];
					if (!in_array($r['id'], $provided_ids)){
						return false;
					}
				}
				return true;
				
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
}