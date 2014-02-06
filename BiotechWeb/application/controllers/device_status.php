<?php
class device_status extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	
	public function dcs(){
		$this->load->view('dcs/dcs_device_status');
	}
}