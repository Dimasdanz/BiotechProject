<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class hcs extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}

	public function hcs_lamp_value($param){
		header("Content-type: text/json");
		$val = intval(read_file("assets/device/hcs/" . $param . ".txt"));
		echo json_encode($val);
	}

	public function hcs_get_lamp(){
		header("Content-type: text/json");
		$val = intval(read_file("assets/device/hcs/lamp_1.txt"));
		$val .= ";" . intval(read_file("assets/device/hcs/lamp_2.txt"));
		$val .= ";" . intval(read_file("assets/device/hcs/lamp_3.txt"));
		$val .= ";" . intval(read_file("assets/device/hcs/lamp_4.txt"));
		echo json_encode($val);
	}
}