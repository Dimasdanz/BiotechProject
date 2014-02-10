<?php
class db_scs_log extends CI_Model{
	function get_all(){
		$q = $this->db->get('scs_log');
		return $q->result();
	}
	
	function get_today(){
		$this->db->where('date(time)', date('Y-m-d'));
		$q = $this->db->get('scs_log');
		return $q->result();
	}
	
	function get_last_log(){
		$this->db->order_by('scs_id', 'desc');
		$q = $this->db->get('scs_log');
		return $q->row();
	}
	
	function insert($data){
		$this->db->insert('scs_log', $data);
	}
}