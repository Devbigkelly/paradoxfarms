<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
		$this->data['system_name'] = $this->general->get_system_var('system_name');
		$this->data['email'] = $this->general->get_system_var('email');
		$this->data['phone'] = $this->general->get_system_var('phone');
		$this->data['address'] = $this->general->get_system_var('address');
	}
	public function index(){
		$this->data['title'] = $this->data['system_name'];
		$this->data['sub'] = 'the_blend';
		$this->load->view('front/index', $this->data);
	}
	public function test(){
		echo $this->ranking_model->rank_clr('adasd');
	}
	
	public function sms(){
		$to = '923009401968';
		
		$this->load->library('mobile_number');
		$mobile = new mobile_number();
		$vl = $mobile->is_valid_number($to);
		if ($vl){
			echo 'yes';
		} else {
			echo 'no';
		}
		echo $mobile->region_code($to);
		echo $mobile->system_number($to);
		
		
	}
}
