<?php
class db_gcs_plants extends CI_Model{
	function get_all(){
		$q = $this->db->get('gcs_plants');
		return $q->result();
	}
	
	function get_single($plant_id){
		$this->db->where('plant_id', $plant_id);
		$q = $this->db->get('gcs_plants');
		return $q->row();
	}
	
	function insert($data){
		$this->db->insert('gcs_plants', $data);
	}
	
	function update($plant_id,$data){
		$this->db->where('plant_id', $plant_id);
		$this->db->update('gcs_plants', $data);
	}
	
	function delete($plant_id){
		$this->db->where('plant_id', $plant_id);
		$this->db->delete('gcs_plants');
	}
}
?>