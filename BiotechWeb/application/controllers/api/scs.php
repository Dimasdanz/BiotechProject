<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class scs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('db_scs_log');
	}

	public function scs_today_temperature(){
		header("Content-type: text/json");
		$ret = array();
		foreach($this->db_scs_log->get_today() as $row){
			$log[0] = strtotime($row->time) * 1000;
			$log[1] = floatval($row->temperature);
			array_push($ret, $log);
		}
		echo json_encode($ret);
	}

	public function scs_today_smoke(){
		header("Content-type: text/json");
		$ret = array();
		foreach($this->db_scs_log->get_today() as $row){
			$log[0] = strtotime($row->time) * 1000;
			$log[1] = intval($row->smoke);
			array_push($ret, $log);
		}
		echo json_encode($ret);
	}

	public function scs_realtime_value(){
		header("Content-type: text/json");
		$smoke = floatval(read_file("assets/device/scs/smoke.txt"));
		$temp = floatval(read_file("assets/device/scs/temp.txt"));
		$val = array(
			$smoke,
			$temp 
		);
		echo json_encode($val);
	}

	public function scs_temperature(){
		header("Content-type: text/json");
		$log = $this->db_scs_log->get_last_log();
		$x = strtotime($log->time) * 1000;
		$y = floatval($log->temperature);
		$ret = array(
			$x,
			$y 
		);
		echo json_encode($ret);
	}

	public function scs_smoke(){
		header("Content-type: text/json");
		$log = $this->db_scs_log->get_last_log();
		$x = strtotime($log->time) * 1000;
		$y = intval($log->smoke);
		$ret = array(
			$x,
			$y 
		);
		echo json_encode($ret);
	}

	public function scs_insert_log(){
		$temp = $this->input->post('temp');
		$smoke = $this->input->post('smoke');
		write_file("assets/device/scs/temp.txt", $temp);
		write_file("assets/device/scs/smoke.txt", $smoke);
		$data = array(
			'temperature' => $temp,
			'smoke' => $smoke 
		);
		$this->db_scs_log->insert($data);
	}
}