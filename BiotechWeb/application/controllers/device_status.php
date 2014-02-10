<?php
class device_status extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	
	public function dcs(){
		$data['status'] = (read_file("assets/device/dcs/status.txt") == 1 ? "Armed" : "Disarmed");
		$data['password_attempts'] = read_file("assets/device/dcs/password_attempts.txt");
		$data['condition'] = (read_file("assets/device/dcs/condition.txt") == 1 ? "Locked" : "Unlocked");
		$this->load->view('dcs/dcs_device_status', $data);
	}
}