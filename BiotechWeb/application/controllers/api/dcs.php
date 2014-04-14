<?php if(!defined('BASEPATH'))	exit('No direct script access allowed');

class dcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('db_dcs_log');
		$this->load->model('db_dcs_users');
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
		if($data != null){
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

	public function dcs_get_server(){
		header("Content-type: text/json");
		$status = intval(read_file("assets/device/dcs/status.txt"));
		$condition = intval(read_file("assets/device/dcs/condition.txt"));
		echo json_encode("<" . $status . ";" . $condition . ">");
	}

	public function dcs_lock(){
		write_file("assets/device/dcs/condition.txt", 1);
		$this->dcs_insert_log("Perangkat Terkunci");
	}

	public function dcs_insert_log($name, $param = true){
		$data = array(
			'name' => $name
		);
		$this->db_dcs_log->insert($data);
		if($param){
			//$this->send_notification($name);
		}
	}
	
	public function dcs_send_notification($message){
		$this->load->model('db_dcs_device');
		$url = 'https://android.googleapis.com/gcm/send';
		
		$device = $this->db_dcs_device->get_all();
		
		$registration_ids = array();
		
		foreach($device as $device_id){
			array_push($registration_ids, $device_id->gcm_id);
		}
		
		$fields = array(
			'data' => array(
				'notification_message' => $message,
				'notification_time' => date('H:i:s')
			),
			'registration_ids' => $registration_ids
		);
		
		$headers = array(
			'Authorization: key=' . 'AIzaSyCNvec01uSRgGsz7IW9ei6zSfkfCcGXTwY',
			'Content-Type: application/json'
		);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		
		curl_close($ch);
		echo $result;
	}

	/* Android API */
	public function dcs_login(){
		$this->load->model('db_dcs_users');
		
		$username = $this->db_dcs_users->get_single($this->input->post('user_id'));
		if($username){
			if($this->input->post('password') == $username->password){
				$response['response'] = 1;
				$response['user_id'] = $username->user_id;
			}else{
				$response['response'] = 0;
			}
		}else{
			$response['response'] = 2;
		}
		/*
		 * Response
		 * 0 = Login false
		 * 1 = Login true
		 * 2 = Login invalid (no username with that ID)
		 */
		echo json_encode($response);
	}
	
	public function dcs_register_device(){
		$this->load->model('db_dcs_device');
		$user_id = $this->input->post('user_id');
		$gcm_id = $this->input->post('gcm_id');
		
		$data = array(
			'user_id' => $user_id,
			'gcm_id' => $gcm_id
		);
		$this->db_dcs_device->insert($data);
		$response['response'] = 1;
		echo json_encode($response);
	}
	
	/* Response Cheat Sheet
	 * Response = 0 -> Device Locked
	 * Response = 1 -> Change Device Status ON
	 * Response = 2 -> Change Device Status OFF
	 * Response = 3 -> Change Password Attempts
	 * Response = 4 -> Device Unlocked 
	 */
	public function dcs_status(){
		$status = (read_file("assets/device/dcs/status.txt") == 1 ? true : false);
		$password_attempts = intval(read_file("assets/device/dcs/password_attempts.txt"));
		$condition = (read_file("assets/device/dcs/condition.txt") == 1 ? true : false);
		$val = array(
			'status' => $status, 
			'password_attempts' => $password_attempts,
			'condition' => $condition
		);
		echo json_encode($val);
	}

	public function dcs_change_status(){
		if(read_file("assets/device/dcs/condition.txt") == 1){
			$response['response'] = 0;
			echo json_encode($response);
			exit;
		}
		if($this->input->post('status') == "true"){
			$status = 1;
			$this->dcs_insert_log('Perangkat Dihidupkan', false);
			$response['response'] = 1;
		}else{
			$status = 0;
			$this->dcs_insert_log('Perangkat Dimatikan', false);
			$response['response'] = 2;
		}
		write_file("assets/device/dcs/status.txt", $status);
		echo json_encode($response);
	}

	public function dcs_change_attempts(){
		if(read_file("assets/device/dcs/condition.txt") == 1){
			$response['response'] = 0;
			echo json_encode($response);
			exit;
		}
		write_file("assets/device/dcs/password_attempts.txt", $this->input->post('password_attempts'));
		$response['response'] = 3;
		echo json_encode($response);
	}

	public function dcs_unlock(){
		write_file("assets/device/dcs/condition.txt", "0");
		$this->dcs_insert_log('Perangkat Terbuka', false);
		$response['response'] = 4;
		echo json_encode($response);
	}

	public function dcs_get_log_date(){
		$data = $this->db_dcs_log->get_date();
		$response['date'] = array();
		foreach($data as $row){
			array_push($response['date'], date('d F Y', strtotime($row->date)));
		}
		echo json_encode($response);
	}

	public function dcs_get_detail_log(){
		$param = $this->input->post('date');
		$data = $this->db_dcs_log->get_date_detail($param);
		$response['name'] = array();
		$response['time'] = array();
		foreach($data as $row){
			array_push($response['name'], $row->name);
			array_push($response['time'], date('h:i:s', strtotime($row->time)));
		}
		echo json_encode($response);
	}

	public function dcs_get_users(){
		$this->load->library('pagination');
		$config = array(
			'base_url' => base_url() . '/api/dcs/dcs_get_user', 'total_rows' => $this->db_dcs_users->users_count(),
			'per_page' => 5, 'uri_segment' => 4
		);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$offset = $page == 0 ? 0 : ($page - 1) * $config["per_page"];
		$data = $this->db_dcs_users->fetch_user($config['per_page'], $offset);
		$response['userid'] = array();
		$response['username'] = array();
		$response['userpass'] = array();
		if($data != null){
			$response['response'] = 1;
			foreach($data as $row){
				array_push($response['userid'], $row->user_id);
				array_push($response['username'], $row->name);
				array_push($response['userpass'], $row->password);
			}
		}else{
			$response['response'] = 0;
		}
		echo json_encode($response);
	}

	public function dcs_insert_user(){
		$name = $this->input->post('name');
		$password = $this->input->post('password');
		if($name == "" or $password == ""){
			$response['response'] = 0;
			echo json_encode($response);
		}else{
			$data = array(
					'user_id' => $this->db_dcs_users->get_id(),
					'name' => $name,
					'password' => $password
			);
			$this->db_dcs_users->insert($data);
				
			$response['response'] = 1;
			echo json_encode($response);
		}
	}

	public function dcs_update_user(){
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$password = $this->input->post('password');
		$data = array(
			'name' => $name, 
			'password' => $password
		);
		$this->db_dcs_users->update($id, $data);
		
		$response['response'] = 1;
		echo json_encode($response);
	}

	public function dcs_delete_user(){
		$id = $this->input->post('id');
		$this->db_dcs_users->delete($id);
		
		$response['response'] = 1;
		echo json_encode($response);
	}
}