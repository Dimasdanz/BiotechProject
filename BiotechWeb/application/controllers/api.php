<?php
class api extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('db_gcs_log');
		$this->load->model('db_scs_log');
		$this->load->model('db_wms_log');
	}
	
	public function dcs_status(){
		$data['status'] = (read_file("assets/device/dcs/status.txt") == 1 ? "Armed" : "Disarmed");
		$data['password_attempts'] = read_file("assets/device/dcs/password_attempts.txt");
		$data['condition'] = (read_file("assets/device/dcs/condition.txt") == 1 ? "Locked" : "Unlocked");
		$this->load->view('dcs/dcs_device_status', $data);
	}
	
	public function gcs_temperature(){
		header("Content-type: text/json");
		$log = $this->db_gcs_log->get_last_log();
		$x = strtotime($log->time)*1000;
		$y = intval($log->temperature);
		$ret = array($x, $y);
		echo json_encode($ret);
	}
	
	public function gcs_lux(){
		header("Content-type: text/json");
		$log = $this->db_gcs_log->get_last_log();
		$x = strtotime($log->time)*1000;
		$y = intval($log->lux);
		$ret = array($x, $y);
		echo json_encode($ret);
	}
	
	public function hcs_lamp_value($param){
		header("Content-type: text/json");
		$val = intval(read_file("assets/device/hcs/".$param.".txt"));
		echo json_encode($val);
	}
	
	public function scs_today_temperature(){
		header("Content-type: text/json");
		$ret = array();
		foreach($this->db_scs_log->get_today() as $row){
			$log[0] = strtotime($row->time)*1000;
			$log[1] = floatval($row->temperature);
			array_push($ret, $log);
		}
		echo json_encode($ret);
	}
	
	public function scs_today_smoke(){
		header("Content-type: text/json");
		$ret = array();
		foreach($this->db_scs_log->get_today() as $row){
			$log[0] = strtotime($row->time)*1000;
			$log[1] = intval($row->smoke);
			array_push($ret, $log);
		}
		echo json_encode($ret);
	}
	
	public function scs_temperature(){
		header("Content-type: text/json");
		$log = $this->db_scs_log->get_last_log();
		$x = strtotime($log->time)*1000;
		$y = floatval($log->temperature);
		$ret = array($x, $y);
		echo json_encode($ret);
	}
	
	public function scs_smoke(){
		header("Content-type: text/json");
		$log = $this->db_scs_log->get_last_log();
		$x = strtotime($log->time)*1000;
		$y = intval($log->smoke);
		$ret = array($x, $y);
		echo json_encode($ret);
	}
	
	public function scs_insert_log(){
		$temp = $this->input->post('temp');
		$smoke = $this->input->post('smoke');
		$data = array(
			'temperature'=>$temp,
			'smoke'=>$smoke
		);
		$this->db_scs_log->insert($data);
	}
	
	public function wms_water_level(){
		header("Content-type: text/json");
		$log = $this->db_wms_log->get_last_log();
		$y = intval($log->water_level);
		echo json_encode($y);
	}
	
	public function wms_turbidity(){
		header("Content-type: text/json");
		$log = $this->db_wms_log->get_last_log();
		$x = strtotime($log->time)*1000;
		$y = intval($log->turbidity);
		$ret = array($x, $y);
		echo json_encode($ret); 
	}
	
	public function test(){
		$log = $this->db_scs_log->get_last_log();
		echo date('H:i:s', (strtotime($log->time)));
	}
}
