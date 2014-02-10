<?php
class scs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
	}
	
	public function index(){
		$this->load->view('scs/scs_home');
	}
	
	public function log(){
		$this->load->view('scs/scs_log');
	}
	
	public function setting(){
		$this->load->view('scs/scs_setting');
	}
}