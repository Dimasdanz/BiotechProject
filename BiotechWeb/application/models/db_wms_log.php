<?php
class db_wms_log extends CI_Model{
	function get_all(){
		$q = $this->db->get('wms_log');
		return $q->result();
	}
	
	function get_today(){
		$this->db->where('date(time)', date('Y-m-d'));
		$q = $this->db->get('wms_log');
		return $q->result();
	}
	
	function get_last_log(){
		$this->db->order_by('wms_id', 'desc');
		$q = $this->db->get('wms_log');
		return $q->row();
	}
	
	function insert($data){
		$this->db->insert('wms_log', $data);
	}
}