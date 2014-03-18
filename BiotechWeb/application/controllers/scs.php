<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class scs extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect('/login', 'refresh');
		}
		$this->load->model('db_scs_log');
	}

	public function index(){
		$data = array(
			'content' => 'scs/scs_home',
			'contentData' => array(
				'' 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function log(){
		$data = array(
			'content' => 'scs/scs_log',
			'contentData' => array(
				'scs_log' => $this->db_scs_log->get_all() 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function setting(){
		$data = array(
			'content' => 'scs/scs_setting',
			'contentData' => array(
				'' 
			) 
		);
		$this->load->view('template/layout', $data);
	}
}
