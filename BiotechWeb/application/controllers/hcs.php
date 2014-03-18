<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class hcs extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect(base_url() . 'login', 'refresh');
		}
		$this->load->model('db_hcs_log');
	}

	public function index(){
		$data = array(
			'content' => 'hcs/hcs_home',
			'contentData' => array(
				'lamp_1' => read_file("assets/device/hcs/lamp_1.txt"),
				'lamp_2' => read_file("assets/device/hcs/lamp_2.txt"),
				'lamp_3' => read_file("assets/device/hcs/lamp_3.txt"),
				'lamp_4' => read_file("assets/device/hcs/lamp_4.txt"),
				'today_log' => $this->db_hcs_log->get_today() 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function log(){
		$data = array(
			'content' => 'hcs/hcs_log',
			'contentData' => array(
				'hcs_log' => $this->db_hcs_log->get_all() 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function change_status(){
		$lamp = $this->input->post('lamp');
		$status = $this->input->post('status');
		switch($status){
			case '0':
				$string = 'off';
				break;
			case '1':
				$string = 'on';
				break;
		}
		write_file("assets/device/hcs/" . $lamp . ".txt", $status);
		$lamp = str_replace('_', ' ', ucfirst($lamp));
		$data = array(
			'lamp' => $lamp,
			'condition' => ucfirst($string) 
		);
		$this->db_hcs_log->insert($data);
		$this->session->set_flashdata('success', $lamp . ' has been turned ' . $string);
		redirect(base_url() . 'hcs', 'refresh');
	}
}