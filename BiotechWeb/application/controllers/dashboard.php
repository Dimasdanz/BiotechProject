<?php
class dashboard extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect('/login','refresh');
		}
	}
	
	public function index(){
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->view('main/dashboard');
		$this->load->view('template/footer');
	}
}
?>