<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class wms extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect('/login', 'refresh');
		}
		$this->load->model('db_wms_log');
	}

	public function index(){
		$data = array(
			'content' => 'wms/wms_home',
			'contentData' => array(
				'water_tank_height' => intval(read_file("assets/device/wms/water_tank_height.txt")) 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function log(){
		$data = array(
			'content' => 'wms/wms_log',
			'contentData' => array(
				'wms_log' => $this->db_wms_log->get_all() 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function setting(){
		$data = array(
			'content' => 'wms/wms_setting',
			'contentData' => array(
				'height' => intval(read_file("assets/device/wms/water_tank_height.txt")) 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function change_water_tank_height(){
		$this->form_validation->set_rules('height', 'Tinggi Tangki Air', 'trim|required|numeric|xss_clean|less_than[250]');
		
		$height = $this->input->post('height');
		
		if($this->form_validation->run() == FALSE){
			$msg = validation_errors();
			$this->session->set_flashdata('error', $msg);
			redirect(base_url() . 'wms/setting', 'refresh');
		}else{
			write_file("assets/device/wms/water_tank_height.txt", $height);
			$this->session->set_flashdata('success', 'Tinggi Tangki Air telah disimpan');
			redirect(base_url() . 'wms/setting', 'refresh');
		}
	}
}
