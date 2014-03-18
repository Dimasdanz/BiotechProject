<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class gcs extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('db_dcs_log');
		$this->load->model('db_dcs_users');
		$this->load->model('db_gcs_log');
		$this->load->model('db_scs_log');
		$this->load->model('db_wms_log');
	}

	public function gcs_temperature(){
		header("Content-type: text/json");
		$log = $this->db_gcs_log->get_last_log();
		$x = strtotime($log->time) * 1000;
		$y = intval($log->temperature);
		$ret = array(
			$x,
			$y 
		);
		echo json_encode($ret);
	}

	public function gcs_lux(){
		header("Content-type: text/json");
		$log = $this->db_gcs_log->get_last_log();
		$x = strtotime($log->time) * 1000;
		$y = intval($log->lux);
		$ret = array(
			$x,
			$y 
		);
		echo json_encode($ret);
	}

	public function gcs_get_value(){
		$h_lower = intval(read_file("assets/device/gcs/humidity_lower_threshold.txt"));
		$h_upper = intval(read_file("assets/device/gcs/humidity_upper_threshold.txt"));
		$lux_target = intval(read_file("assets/device/gcs/lux_target.txt"));
		echo $h_lower . ";" . $h_upper . ";" . $lux_target;
	}

	public function gcs_insert_log(){
		$lux = $this->input->post('var1');
		$temp = $this->input->post('var2');
		$humidity = $this->input->post('var3');
		$air_humidity = $this->input->post('var4');
		write_file("assets/device/gcs/lux.txt", $lux);
		write_file("assets/device/gcs/temp.txt", $temp);
		write_file("assets/device/gcs/humidity.txt", $humidity);
		write_file("assets/device/gcs/air_humidity.txt", $air_humidity);
		$log = $this->db_gcs_log->get_last_log();
		if((time()) > (strtotime($log->time) + 60)){
			$data = array(
				'lux' => $lux,
				'temperature' => $temp 
			);
			$this->db_gcs_log->insert($data);
		}
	}

	public function gcs_today_temperature(){
		header("Content-type: text/json");
		$ret = array();
		foreach($this->db_gcs_log->get_today() as $row){
			$log[0] = strtotime($row->time) * 1000;
			$log[1] = floatval($row->temperature);
			array_push($ret, $log);
		}
		echo json_encode($ret);
	}

	public function gcs_today_lux(){
		header("Content-type: text/json");
		$ret = array();
		foreach($this->db_gcs_log->get_today() as $row){
			$log[0] = strtotime($row->time) * 1000;
			$log[1] = floatval($row->lux);
			array_push($ret, $log);
		}
		echo json_encode($ret);
	}

	public function gcs_realtime_value(){
		header("Content-type: text/json");
		$lux = intval(read_file("assets/device/gcs/lux.txt"));
		$temp = floatval(read_file("assets/device/gcs/temp.txt"));
		$humidity = intval(read_file("assets/device/gcs/humidity.txt"));
		$air_humidity = floatval(read_file("assets/device/gcs/air_humidity.txt"));
		$val = array(
			$lux,
			$temp,
			$humidity,
			$air_humidity 
		);
		echo json_encode($val);
	}
}