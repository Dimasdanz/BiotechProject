<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dashboard extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect('/login','refresh');
		}
	}
	
	public function index(){
		$data = array(
			'content' => 'main/dashboard',
			'contentData' => array(
				''
			)
		);
		$this->load->view('template/layout', $data);
	}
	
	public function error_404(){
		$this->load->view('main/error_404');
	}
}

?>