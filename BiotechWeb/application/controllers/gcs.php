<?php
class gcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->model('db_gcs_plants');
	}
	
	public function index(){
		$this->load->view('gcs/gcs_home');
	}
	
	public function plants(){
		$data['gcs_plants'] = $this->db_gcs_plants->get_all();
		$this->load->view('gcs/gcs_plants', $data);
	}
	
	public function log(){
		$this->load->view('gcs/gcs_home');
	}
	
	public function setting(){
		$this->load->view('gcs/gcs_home');
	}
	
	public function insert(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha|xss_clean');
		$this->form_validation->set_rules('lux', 'Lux Threshold', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('humidity', 'Humidity', 'trim|required|xss_clean');
	
		$name = $this->input->post('name');
		$lux = $this->input->post('lux');
		$humidity = $this->input->post('humidity');
	
		if($this->form_validation->run() == FALSE){
			$msg = validation_errors();
			$this->session->set_flashdata('error', $msg);
			redirect('/gcs/plants', 'refresh');
		}else{
			$data = array(
					'name'=> $name,
					'lux'=> $lux,
					'humidity'=>$humidity
			);
			$this->db_gcs_plants->insert($data);
			$this->session->set_flashdata('success', 'New Plant has been added');
			redirect('/gcs/plants', 'refresh');
		}
	}
	
	public function update(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha|xss_clean');
		$this->form_validation->set_rules('lux', 'Lux Threshold', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('humidity', 'Humidity', 'trim|required|xss_clean');
	
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$lux = $this->input->post('lux');
		$humidity = $this->input->post('humidity');
	
		if($this->form_validation->run() == FALSE){
			$msg = validation_errors();
			$this->session->set_flashdata('error', $msg);
			redirect('/gcs/plants', 'refresh');
		}else{
			$data = array(
					'name'=> $name,
					'lux'=> $lux,
					'humidity'=>$humidity
			);
			$this->db_gcs_plants->update($id, $data);
			$this->session->set_flashdata('success', 'New Plant has been added');
			redirect('/gcs/plants', 'refresh');
		}
	}
	
	public function delete(){
		$this->db_gcs_plants->delete($this->input->post('plant_id'));
		$this->session->set_flashdata('success', 'Plant has been deleted');
		redirect('/gcs/plants', 'refresh');
	}
}