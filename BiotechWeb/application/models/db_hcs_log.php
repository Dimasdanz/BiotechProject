<?php
class db_hcs_log extends CI_Model{
	function get_all(){
		$q = $this->db->get('hcs_log');
		return $q->result();
	}
	
	function get_today(){
		$this->db->where('date(time)', date('Y-m-d'));
		$q = $this->db->get('hcs_log');
		return $q->result();
	}
	
	function get_last_log_lamp1(){
		$this->db->order_by('hcs_id', 'desc');
		$q = $this->db->get('hcs_log');
		return $q->row();
	}
	
	function insert($data){
		$this->db->insert('hcs_log', $data);
	}
}