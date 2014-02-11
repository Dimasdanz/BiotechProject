<?php
class wms extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->model('db_wms_log');
	}
	
	public function index(){
		$this->load->view('wms/wms_home');
	}
	
	public function log(){
		$data['wms_log'] = $this->db_wms_log->get_all();
		$this->load->view('wms/wms_log', $data);
	}
	
	public function setting(){
		$this->load->view('wms/wms_setting');
	}
}
