<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class wms extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('db_wms_log');
	}

	public function wms_today_log(){
		$data['today_log'] = $this->db_wms_log->get_today();
		$this->load->view('wms/wms_today_log', $data);
	}

	public function wms_get_value(){
		header("Content-type: text/json");
		$val = intval(read_file("assets/device/wms/water_tank_height.txt"));
		echo json_encode($val);
	}

	public function wms_realtime_value(){
		header("Content-type: text/json");
		$turbidity = read_file("assets/device/wms/lux.txt");
		$water_level = intval(read_file("assets/device/wms/water_level.txt"));
		$val = array(
			$turbidity,
			$water_level 
		);
		echo json_encode($val);
	}

	public function wms_water_level(){
		header("Content-type: text/json");
		$log = $this->db_wms_log->get_last_log();
		$y = intval($log->water_level);
		echo json_encode($y);
	}

	public function wms_insert_log(){
		$water_level = intval(read_file("assets/device/wms/water_tank_height.txt")) - ($this->input->post('var1'));
		if($this->input->post('var2') > 200){
			$turbidity = 'Jernih';
		}else if($this->input->post('var2') > 150){
			$turbidity = 'Sedang';
		}else{
			$turbidity = 'Keruh';
		}
		$old_turbidity = read_file("assets/device/wms/lux.txt");
		write_file("assets/device/wms/water_level.txt", $water_level);
		write_file("assets/device/wms/lux.txt", $turbidity);
		if($old_turbidity != $turbidity){
			$data = array(
				'water_level' => $water_level,
				'turbidity' => $turbidity 
			);
			$this->db_wms_log->insert($data);
		}
	}
}