<?php
class hcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->model('db_hcs_log');
	}
	
	public function index(){
		$data['lamp_1'] = read_file("assets/device/hcs/lamp_1.txt");
		$data['lamp_2'] = read_file("assets/device/hcs/lamp_2.txt");
		$data['lamp_3'] = read_file("assets/device/hcs/lamp_3.txt");
		$data['lamp_4'] = read_file("assets/device/hcs/lamp_4.txt");
		$data['today_log'] = $this->db_hcs_log->get_today();
		$this->load->view('hcs/hcs_home', $data);
	}
	
	public function log(){
		$data['hcs_log'] = $this->db_hcs_log->get_all();
		$this->load->view('hcs/hcs_log', $data);
	}
	
	public function change_status(){
		$lamp = $this->input->post('lamp');
		$status = $this->input->post('status');
		switch ($status) {
			case '0':
				$string = 'off';
				break;
			case '1':
				$string = 'on';
				break;
		}
		write_file("assets/device/hcs/".$lamp.".txt", $status);
		$lamp = str_replace('_', ' ', ucfirst($lamp));
		$data = array(
			'lamp' => $lamp,
			'condition'=>ucfirst($string)
		);
		$this->db_hcs_log->insert($data);
		$this->session->set_flashdata('success', $lamp.' has been turned '.$string);
		redirect(base_url().'hcs', 'refresh');
	}
}