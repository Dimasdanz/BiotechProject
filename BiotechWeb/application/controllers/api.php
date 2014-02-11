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
		$y = intval($log->temperature); //change this from device
		$ret = array($x, $y);
		echo json_encode($ret);
	}
	
	public function gcs_lux(){
		header("Content-type: text/json");
		$log = $this->db_gcs_log->get_last_log();
		$x = strtotime($log->time)*1000;
		$y = intval($log->lux); //change this from device
		$ret = array($x, $y);
		echo json_encode($ret);
	}
	
	public function scs_temperature(){
		header("Content-type: text/json");
		$log = $this->db_scs_log->get_last_log();
		$x = strtotime($log->time)*1000;
		$y = intval($log->temperature); //change this from device
		$ret = array($x, $y);
		echo json_encode($ret);
	}
	
	public function scs_smoke(){
		header("Content-type: text/json");
		$log = $this->db_scs_log->get_last_log();
		$x = strtotime($log->time)*1000;
		$y = intval($log->smoke); //change this from device
		$ret = array($x, $y);
		echo json_encode($ret);
	}
	
	public function wms_water_level(){
		header("Content-type: text/json");
		$log = $this->db_wms_log->get_last_log();
		$y = intval($log->water_level); //change this from device
		echo json_encode($y); 
	}
	
	public function wms_turbidity(){
		header("Content-type: text/json");
		$log = $this->db_wms_log->get_last_log();
		$x = strtotime($log->time)*1000;
		$y = intval($log->turbidity); //change this from device
		$ret = array($x, $y);
		echo json_encode($ret); 
	}
	
	public function test(){
		echo $this->db->last_query();
		print_r($this->db_gcs_log->get_last_log());
	}


}
