<?php
class dcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
	}
	
	public function index(){
		$this->load->view('dcs/dcs_home');
	}
	
	public function users(){
		$this->load->view('dcs/dcs_user');
	}
	
	public function log(){
		$this->load->view('dcs/dcs_log');
	}
	
	public function setting(){
		$this->load->view('dcs/dcs_setting');
	}
}