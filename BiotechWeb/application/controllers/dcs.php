<?php
class dcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->view('dcs/dcs_home');
	}
	
	public function user(){
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->view('dcs/dcs_user');
	}
	
	public function log(){
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->view('dcs/dcs_home');
	}
	
	public function setting(){
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->view('dcs/dcs_home');
	}
}