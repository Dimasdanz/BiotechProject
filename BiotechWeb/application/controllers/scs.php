<?php
class scs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->model('db_scs_log');
	}
	
	public function index(){
		$this->load->view('scs/scs_home');
	}
	
	public function log(){
		$data['scs_log'] = $this->db_scs_log->get_all();
		$this->load->view('scs/scs_log', $data);
	}
	
	public function setting(){
		$this->load->view('scs/scs_setting');
	}
}
