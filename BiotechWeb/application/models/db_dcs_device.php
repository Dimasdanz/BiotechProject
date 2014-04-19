<?php
class db_dcs_device extends CI_Model{
	function get_all(){
		$q = $this->db->get('dcs_device');
		return $q->result();
	}
	
	function get_single($id){
		$this->db->where('user_id', $id);
		$q = $this->db->get('dcs_device');
		if($q->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function insert($data){
		$this->db->insert('dcs_device', $data);
	}
	
	function delete($id){
		$this->db->where('user_id', $id);
		$this->db->delete('dcs_device');
	}
}