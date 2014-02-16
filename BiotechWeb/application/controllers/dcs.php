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
		$this->load->view('dcs/dcs_home');
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
		$data['status'] = read_file("assets/device/dcs/status.txt");
		$data['password_attempts'] = read_file("assets/device/dcs/password_attempts.txt");
		$data['condition'] = read_file("assets/device/dcs/condition.txt");
		$this->load->view('dcs/dcs_setting',$data);
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
			redirect(base_url().'dcs/users', 'refresh');
		}else{
			$data = array(
					'user_id' => $id,
					'name'=> $name,
					'password'=> $password
			);
			$this->db_dcs_users->insert($data);
			$this->session->set_flashdata('success', 'New User has been added');
			redirect(base_url().'dcs/users', 'refresh');
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
			redirect(base_url().'dcs/users', 'refresh');
		}else{
			$data = array(
				'name'=> $name,
				'password'=> $password
			);
			$this->db_dcs_users->update($id, $data);
			$this->session->set_flashdata('success', $name.' has been updated');
			redirect(base_url().'dcs/users', 'refresh');
		}
	}
	
	public function delete(){
		$this->db_dcs_users->delete($this->input->post('user_id'));
		$this->session->set_flashdata('success', 'User has been deleted');
		redirect(base_url().'dcs/users', 'refresh');
	}
	
	public function change_attempt(){
		if(read_file("assets/device/dcs/condition.txt") == 1){
			$this->session->set_flashdata('message', array('danger', 'Please unlock the device first'));
			redirect(base_url().'dcs/setting', 'refresh');
			return;
		}
		
		$this->form_validation->set_rules('password_attempts', 'Password Attempts', 'trim|required|numeric|xss_clean');
		$password_attempts = $this->input->post('password_attempts');
		
		if($this->form_validation->run() == FALSE){
			$msg = array('danger', validation_errors());
			$this->session->set_flashdata('message', $msg);
			redirect(base_url().'dcs/setting', 'refresh');
		}else{
			write_file("assets/device/dcs/password_attempts.txt", $password_attempts);
			$this->session->set_flashdata('message', array('success', 'Password Attempts has been changed'));
			redirect(base_url().'dcs/setting', 'refresh');
		}
	}
	
	public function change_status(){
		if(read_file("assets/device/dcs/condition.txt") == 1){
			$this->session->set_flashdata('message', array('danger', 'Please unlock the device first'));
			redirect(base_url().'dcs/setting', 'refresh');
			return;
		}
		if($this->input->post('status') == 'on'){
			$status = 1;
		}else{
			$status = 0;
		}
		write_file("assets/device/dcs/status.txt", $status);
		$this->session->set_flashdata('message', array('success', 'Device has been turned '.$this->input->post('status')));
		redirect(base_url().'dcs/setting', 'refresh');
	}
	
	public function unlock(){
		write_file("assets/device/dcs/condition.txt", "0");
		$this->session->set_flashdata('message', array('success', 'Device has been unlocked'));
		redirect(base_url().'dcs/setting', 'refresh');
	}
}