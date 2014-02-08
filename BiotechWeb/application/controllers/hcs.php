<?php
class hcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
	}
	
	public function index(){
		$this->load->view('hcs/hcs_home');
	}
	
	public function log(){
		$this->load->view('hcs/hcs_log');
	}
}