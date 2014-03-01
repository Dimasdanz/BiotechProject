<?php
class gcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect(base_url().'login','refresh');
		}
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->model('db_gcs_plants');
		$this->load->model('db_gcs_log');
	}
	
	public function index(){
		$this->load->view('gcs/gcs_home');
	}
	
	public function plants(){
		$selected_plant = read_file("assets/device/gcs/selected_plant.txt"); 
		$data['selected_plant'] = $this->db_gcs_plants->get_single($selected_plant);
		$data['gcs_plants'] = $this->db_gcs_plants->get_all();
		$this->load->view('gcs/gcs_plants', $data);
	}
	
	public function log(){
		$data['gcs_log'] = $this->db_gcs_log->get_all();
		$this->load->view('gcs/gcs_log', $data);
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
			redirect(base_url().'gcs/plants', 'refresh');
		}else{
			$data = array(
					'name'=> $name,
					'lux'=> $lux,
					'humidity'=>$humidity
			);
			$this->db_gcs_plants->insert($data);
			$this->session->set_flashdata('success', 'New Plant has been added');
			redirect(base_url().'gcs/plants', 'refresh');
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
			redirect(base_url().'gcs/plants', 'refresh');
		}else{
			$data = array(
					'name'=> $name,
					'lux'=> $lux,
					'humidity'=>$humidity
			);
			$this->db_gcs_plants->update($id, $data);
			$this->session->set_flashdata('success', 'New Plant has been added');
			redirect(base_url().'gcs/plants', 'refresh');
		}
	}
	
	public function delete(){
		$this->db_gcs_plants->delete($this->input->post('plant_id'));
		$this->session->set_flashdata('success', 'Plant has been deleted');
		redirect(base_url().'gcs/plants', 'refresh');
	}
	
	public function select(){
		$plant_id = $this->input->post('plant_id');
		$selected_plant = $this->db_gcs_plants->get_single($plant_id);
		switch ($selected_plant->humidity) {
			case 'dry':
				$upper = 300;
				$lower = 0;
			break;
			case 'humid':
				$upper = 700;
				$lower = 301;
			break;
			case 'wet':
				$upper = 1023;
				$lower = 701;
			break;
		}
		write_file("assets/device/gcs/lux_target.txt", $selected_plant->lux);
		write_file("assets/device/gcs/humidity_upper_threshold.txt", $upper);
		write_file("assets/device/gcs/humidity_lower_threshold.txt", $lower);
		write_file("assets/device/gcs/selected_plant.txt", $plant_id);
		$this->session->set_flashdata('success', 'Plant has been selected');
		redirect(base_url().'gcs/plants', 'refresh');
	}
}