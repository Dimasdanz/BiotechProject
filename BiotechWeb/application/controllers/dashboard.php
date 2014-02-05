<?php
class dashboard extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->view('dashboard');
		$this->load->view('template/footer');
	}
}
?>