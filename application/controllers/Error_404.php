<?php
// default 404 controller
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_404 extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
		$this->data['system_name'] = $this->general->get_system_var('system_name');
		$this->data['email'] = $this->general->get_system_var('email');
		$this->data['phone'] = $this->general->get_system_var('phone');
		$this->data['address'] = $this->general->get_system_var('address');
	}
	public function index(){
		// if 404, selecting specific role to display error
		if ($this->session->userdata('isLogin') == true){
			if ($this->session->userdata('user_group') == 'admin'){
				$this->data['file'] = 'error_404';
				$this->data['title'] = '404 Page not Fount';
				$this->data['page_title'] = '';
				$this->load->view('admin/index', $this->data);
			} else {
				$this->data['file'] = 'error_404';
				$this->data['title'] = '404 Page not Fount';
				$this->data['page_title'] = '';
				$this->load->view('backoffice/index', $this->data);
			}
		} else {
			
		}
	}
	
}
