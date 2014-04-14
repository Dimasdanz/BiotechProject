<?php
class db_dcs_device extends CI_Model{
	function get_all(){
		$q = $this->db->get('dcs_device');
		return $q->result();
	}
	
	function insert($data){
		$this->db->insert('dcs_device', $data);
	}
}