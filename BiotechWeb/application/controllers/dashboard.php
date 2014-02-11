<?php
class dashboard extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect('/login','refresh');
		}
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->model('db_scs_log');
	}
	
	public function index(){
		$last_log = $this->db_scs_log->get_last_log();
		$data['last_log'] = $last_log;
		if($last_log->smoke != NULL){
			if($last_log->smoke <= 200 and $last_log->smoke >=100){
				$data['smoke_indicator'] = 'Baik';
			} else if($last_log->smoke <= 500 and $last_log->smoke >=201){
				$data['smoke_indicator'] = 'Normal';
			} else $data['smoke_indicator'] = 'Bahaya';
		} else $data['smoke_indicator'] = '-';
		if($last_log->temperature != NULL){
			if($last_log->temperature <= 24 and $last_log->temperature >=20){
				$data['temp_indicator'] = 'Baik';
			} else if($last_log->temperature <= 35 and $last_log->temperature >=25){
				$data['temp_indicator'] = 'Normal';
			} else $data['temp_indicator'] = 'Bahaya';
		} else $data['temp_indicator'] = '-';
		$this->load->view('main/dashboard', $data);
	}
}

?>