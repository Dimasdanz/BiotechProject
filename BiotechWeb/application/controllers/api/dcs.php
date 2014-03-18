<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('db_dcs_log');
		$this->load->model('db_dcs_users');
	}
	
	public function dcs_status(){
		$status = (read_file("assets/device/dcs/status.txt") == 1 ? "Aktif" : "Non-Aktif");
		$password_attempts = read_file("assets/device/dcs/password_attempts.txt");
		$condition = (read_file("assets/device/dcs/condition.txt") == 1 ? "Terkunci" : "Tidak Terkunci");
		$val = array(
			$status,
			$password_attempts,
			$condition 
		);
		echo json_encode($val);
	}

	public function dcs_today_log(){
		$data['today_log'] = $this->db_dcs_log->get_today();
		$this->load->view('dcs/dcs_today_log', $data);
	}

	public function dcs_check_password(){
		$input = $this->input->post('password');
		$user_id = substr($input, 0, 3);
		$password = substr($input, 3, (strlen($input) - 4));
		$data = $this->db_dcs_users->get_single($user_id);
		if($data != NULL){
			if($password == $data->password){
				write_file("assets/device/dcs/result.txt", 1);
				$this->dcs_insert_log($data->name);
				echo 1;
			}else{
				write_file("assets/device/dcs/result.txt", 0);
				echo 0;
			}
		}else{
			write_file("assets/device/dcs/result.txt", 0);
			echo 0;
		}
	}

	public function dcs_get_value($param){
		header("Content-type: text/json");
		$status = intval(read_file("assets/device/dcs/" . $param . ".txt"));
		echo json_encode("<" . $status . ">");
	}

	public function dcs_lock(){
		write_file("assets/device/dcs/condition.txt", 1);
		$this->dcs_insert_log("Perangkat Terkunci");
	}

	public function dcs_insert_log($name){
		$data = array(
			'name' => $name 
		);
		$this->db_dcs_log->insert($data);
	}
}