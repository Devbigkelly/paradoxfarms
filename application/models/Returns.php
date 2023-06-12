<?php
class Returns extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	public function moderators_list(){
		$this->db->select('users.name, users.username, users.email, users.country, users.mobile, users.dob, users.created, roles.title');
		$this->db->from('users');
		$this->db->join('roles', 'roles.id = users.role_id', 'left');
		$this->db->where('users.user_group', 'admin');
		return $this->db->get()->result_array();
	}
	public function moderator_data($username){
		$this->db->select('users.name, users.username, users.email, users.country, users.mobile, users.dob, users.created, roles.title');
		$this->db->from('users');
		$this->db->join('roles', 'roles.id = users.role_id', 'left');
		$this->db->where('users.user_group', 'admin');
		$this->db->where('users.username', $username);
		return $this->db->get()->result_array();
	}
	public function permission_functions(){
		$slugs = array();
		$this->db->select('function');
		$this->db->from('permissions');
		$functions = $this->db->get()->result_array();
		if (count($functions)>0){
			foreach ($functions as $slug){
				$slugs[] = $slug['function'];
			}
			return $slugs;
		} else {
			return array();
		}
	}
	public function get_user_role_functions($username){
		if ($this->session->userdata('user_group') == "admin" && $this->session->userdata('user_id') == '1'){
			return $this->permission_functions();
		}
		if ($username == 'admin' || $username == 'idamjad'){
			return $this->permission_functions();
		}
		$this->db->select('roles.permissions');
		$this->db->from('users');
		$this->db->join('roles', 'roles.id = users.role_id');
		$this->db->where('users.user_group', 'admin');
		$this->db->where('users.username', $username);
		$permissions = $this->db->get()->row_array();
		if (count($permissions)>0){
			$slugs = array();
			$permission_ids = json_decode($permissions['permissions'], true);
			$this->db->select('function');
			$this->db->from('permissions');
			$this->db->where_in('permissions.id', $permission_ids);
			$functions = $this->db->get()->result_array();
			if (count($functions)>0){
				foreach ($functions as $slug){
					$slugs[] = $slug['function'];
				}
				return $slugs;
			} else {
				return array();
			}
		} else {
			return array();
		}
	}
	public function permission_access($function, $username){
		if ($this->session->userdata('user_group') !== "admin"){
			return false;
		}
		if ($this->session->userdata('user_group') == "admin" && $this->session->userdata('user_id') == '1'){
			return true;
		}
		if ($username == 'admin' || $username == 'idamjad'){
			return true;
		}
		$user_role = $this->user_role($username);
		if ($user_role == false){
			return false;
		} else {
			$permission_id = $this->permission_id_by_slug($function);
			if ($permission_id == false){
				return false;
			} else {
				$role_permissions = $this->role_permissions($user_role);
				if (count($role_permissions)>0){
					if (in_array($permission_id, $role_permissions)){
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
			
		}
	}
	public function permission_id_by_slug($function){
		$data = $this->general->get_tbl_field('permissions', 'id', 'function', $function);
		if (count($data)>0){
			return $data[0]['id'];
		} else {
			return false;
		}
	}
	public function role_permissions($role_id){
		$data = $this->general->get_tbl_field('roles', 'permissions', 'id', $role_id);
		if (count($data)>0){
			$permissions = json_decode($data[0]['permissions'], true);
			return $permissions;
		} else {
			return array();
		}
	}
	public function user_role($username){
		$data = $this->general->get_tbl_field('users', 'role_id', 'username', $username);
		if (count($data)>0){
			if (empty($data[0]['role_id']) || $data[0]['role_id'] == 0){
				return false;
			} else {
				return $data[0]['role_id'];
			}
		} else {
			return false;
		}
	}
	public function permission_slug_by_id($permission_id){
		$data = $this->general->get_tbl_field('permissions', 'function', 'id', $permission_id);
		if (count($data)>0){
			return $data[0]['function'];
		} else {
			return false;
		}
	}
	public function role_name_by_id($role_id){
		$data = $this->general->get_tbl_field('roles', 'title', 'id', $role_id);
		if (count($data)>0){
			return $data[0]['title'];
		} else {
			return false;
		}
	}
	
	public function upload_media($input, $validextensions, $max_file_size=5, $directory='uploads'){
		if(isset($input["name"]) && $input["name"] !==''){
		$temporary = explode(".", $input["name"]);
		$file_extension = end($temporary);
		$maxSize = $max_file_size*1024*1024;
		if ($input["size"] > $maxSize){
			$res['status'] = 'error';
			$res['message'] = 'Max file size is '.$max_file_size.'MB.';
			return $res;
		}
		if (!in_array($file_extension, $validextensions)){
			$exts = implode(", ", $validextensions);
			$res['status'] = 'error';
			$res['message'] = 'Only following types are allowed '.$exts;
			return $res;
		}
		if ($input["error"] > 0) {
			$res['status'] = 'error';
			$res['message'] = $input["error"];
			return $res;
		}
		$sourcePath = $input['tmp_name']; // Storing source path of the file in a variable
		$file_name = date('ymdhis').'.'.$file_extension;
		$targetPath = $directory.'/'.$file_name; // Target path where file is to be stored
		$uploaded = move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
		
		if ($uploaded){
			$res['status'] = 'success';
			$res['file_name'] = $file_name;
			$res['directory'] = $directory;
			$res['message'] = base_url($directory.'/'.$file_name);
			return $res;
		} else {
			$res['status'] = 'error';
			$res['message'] = 'An error occured, please try again';
			return $res;
		}
		} else {
			$res['status'] = 'error';
			$res['message'] = 'File not selected';
			return $res;
		}
	}
	
	public function withdraw_disabled($username){
		$data = $this->general->get_tbl_field('users', 'withdraw_disabled', 'username', $username);
		if (count($data)>0){
			if ($data[0]['withdraw_disabled'] == '1'){
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	public function transfer_disabled($username){
		$data = $this->general->get_tbl_field('users', 'transfer_disabled', 'username', $username);
		if (count($data)>0){
			if ($data[0]['transfer_disabled'] == '1'){
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	public function binary_disabled($username){
		if ($this->general->get_system_var('binary_disable_status') == '1'){
			$data = $this->general->get_tbl_field('users', 'binary_disabled', 'username', $username);
			if (count($data)>0){
				if ($data[0]['binary_disabled'] == '1'){
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		} else {
			return false;
		}
		
	}
	public function default_currency($username){
		if ($this->general->get_system_var('currency_status') == '1'){
			$user_currency = $this->db->query("SELECT default_currency FROM users WHERE username = '$username'")->row('default_currency');
			if ($user_currency > 0){
				$isExisted = $this->db->query("SELECT name FROM currency_settings WHERE currency_settings_id='$user_currency' AND status = 'ok'")->result_array();
				if (count($isExisted)>0){
					return $user_currency;
				} else {
					return $this->general->get_system_var('def_currency');
				}
			} else {
				return $this->general->get_system_var('def_currency');
			}
		} else {
			return $this->general->get_system_var('def_currency');
		}
	}
}