<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class gcs extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect(base_url() . 'login', 'refresh');
		}
		$this->load->model('db_gcs_plants');
		$this->load->model('db_gcs_log');
	}

	public function index(){
		$data = array(
			'content' => 'gcs/gcs_home',
			'contentData' => array(
				'' 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function plants(){
		$selected_plant = read_file("assets/device/gcs/selected_plant.txt");
		$data = array(
			'content' => 'gcs/gcs_plants',
			'contentData' => array(
				'selected_plant' => $this->db_gcs_plants->get_single($selected_plant),
				'gcs_plants' => $this->db_gcs_plants->get_all() 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function log(){
		$data = array(
			'content' => 'gcs/gcs_log',
			'contentData' => array(
				'gcs_log' => $this->db_gcs_log->get_all() 
			) 
		);
		$this->load->view('template/layout', $data);
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
			redirect(base_url() . 'gcs/plants', 'refresh');
		}else{
			$data = array(
				'name' => $name,
				'lux' => $lux,
				'humidity' => $humidity 
			);
			$this->db_gcs_plants->insert($data);
			$this->session->set_flashdata('success', 'New Plant has been added');
			redirect(base_url() . 'gcs/plants', 'refresh');
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
			redirect(base_url() . 'gcs/plants', 'refresh');
		}else{
			$data = array(
				'name' => $name,
				'lux' => $lux,
				'humidity' => $humidity 
			);
			$this->db_gcs_plants->update($id, $data);
			$this->session->set_flashdata('success', 'New Plant has been added');
			redirect(base_url() . 'gcs/plants', 'refresh');
		}
	}

	public function delete(){
		$this->db_gcs_plants->delete($this->input->post('plant_id'));
		$this->session->set_flashdata('success', 'Plant has been deleted');
		redirect(base_url() . 'gcs/plants', 'refresh');
	}

	public function select(){
		$plant_id = $this->input->post('plant_id');
		$selected_plant = $this->db_gcs_plants->get_single($plant_id);
		switch($selected_plant->humidity){
			case 'dry':
				$upper = 30;
				$lower = 0;
				break;
			case 'humid':
				$upper = 70;
				$lower = 31;
				break;
			case 'wet':
				$upper = 100;
				$lower = 71;
				break;
		}
		write_file("assets/device/gcs/lux_target.txt", $selected_plant->lux);
		write_file("assets/device/gcs/humidity_upper_threshold.txt", $upper);
		write_file("assets/device/gcs/humidity_lower_threshold.txt", $lower);
		write_file("assets/device/gcs/selected_plant.txt", $plant_id);
		$this->session->set_flashdata('success', 'Plant has been selected');
		redirect(base_url() . 'gcs/plants', 'refresh');
	}
}