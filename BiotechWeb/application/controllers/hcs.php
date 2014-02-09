<?php
class hcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
	}
	
	public function index(){
		$data['lamp_1'] = read_file("assets/device/hcs/lamp_1.txt");
		$data['lamp_2'] = read_file("assets/device/hcs/lamp_2.txt");
		$data['lamp_3'] = read_file("assets/device/hcs/lamp_3.txt");
		$data['lamp_4'] = read_file("assets/device/hcs/lamp_4.txt");
		$this->load->view('hcs/hcs_home', $data);
	}
	
	public function log(){
		$this->load->view('hcs/hcs_log');
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
		$lamp = str_replace('_', ' ', $lamp);
		$this->session->set_flashdata('success', ucfirst($lamp).' has been turned '.$string);
		redirect(base_url().'hcs', 'refresh');
	}
}