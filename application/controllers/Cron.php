<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
		$this->data['system_name'] = $this->general->get_system_var('system_name');
		$this->data['email'] = $this->general->get_system_var('email');
		$this->data['phone'] = $this->general->get_system_var('phone');
		$this->data['address'] = $this->general->get_system_var('address');
	}
	public function disperse_roi(){
		//proceeding roi, this is for fron job
		$users = $this->general->get_tbl_field('users', 'username', 'user_group', 'member');
		if (count($users)>0){
			foreach($users as $user){
				$this->commissions->do_roi_single_user($user);
			}
		}
	}
	public function database_backup(){
		// creating database backup
		$this->load->dbutil();
		$prefs = array(     
			'format'      => 'zip',             
			'filename'    => 'database.sql'
			);
		$backup = $this->dbutil->backup($prefs); 
		$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
		$save = 'db_backup/'.$db_name;
		if (write_file($save, $backup)){
			$data['backup_file'] = $db_name;
			$data['dated'] = date('Y-m-d H:i:s');
			$this->db->insert('db_backups', $data);
		}
	}
	
}
