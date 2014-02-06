<?php
class dcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->view('template/header');
		$this->load->view('template/topbar');
		$this->load->view('template/sidebar');
		$this->load->model('db_dcs_users');
		$this->load->model('db_dcs_log');
	}
	
	public function index(){
		$data['today_log'] = $this->db_dcs_log->get_today();
		$this->load->view('dcs/dcs_home', $data);
	}
	
	public function users(){
		$data['dcs_users'] = $this->db_dcs_users->get_all();
		$data['user_id'] = $this->db_dcs_users->get_id();
		$this->load->view('dcs/dcs_user', $data);
	}
	
	public function log(){
		$data['dcs_log'] = $this->db_dcs_log->get_all();
		$this->load->view('dcs/dcs_log', $data);
	}
	
	public function setting(){
		$this->load->view('dcs/dcs_setting');
	}
	
	public function test(){
		$this->db_dcs_users->get_id();
	}
	
	public function insert(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|numeric|xss_clean');
	
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$password = $this->input->post('password');
	
		if($this->form_validation->run() == FALSE){
			$msg = validation_errors();
			$this->session->set_flashdata('error', $msg);
			redirect('/dcs/users', 'refresh');
		}else{
			$data = array(
					'user_id' => $id,
					'name'=> $name,
					'password'=> $password
			);
			$this->db_dcs_users->insert($data);
			$this->session->set_flashdata('success', 'New User has been added');
			redirect('/dcs/users', 'refresh');
		}
	}
	
	public function update(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|numeric|xss_clean');
	
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$password = $this->input->post('password');
	
		if($this->form_validation->run() == FALSE){
			$msg = validation_errors();
			$this->session->set_flashdata('error', $msg);
			redirect('/dcs/users', 'refresh');
		}else{
			$data = array(
				'name'=> $name,
				'password'=> $password
			);
			$this->db_dcs_users->update($id, $data);
			$this->session->set_flashdata('success', $name.' has been updated');
			redirect('/dcs/users', 'refresh');
		}
	}
	
	public function delete(){
		$this->db_dcs_users->delete($this->input->post('user_id'));
		$this->session->set_flashdata('success', 'User has been deleted');
		redirect('/dcs/users', 'refresh');
	}
	
	public function insert_log(){
		$name = $this->input->post('name');
		$data = array('name'=>$name);
		$this->db_dcs_log->insert($data);
	}
}