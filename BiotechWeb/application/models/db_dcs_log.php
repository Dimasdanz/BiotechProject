<?php
class db_dcs_log extends CI_Model{
	function get_all(){
		$this->db->order_by('time', 'desc');
		$q = $this->db->get('dcs_log');
		return $q->result();
	}
	
	function get_date(){
		$this->db->distinct();
		$this->db->select('date(time) as date');
		$this->db->order_by('time', 'desc');
		$q = $this->db->get('dcs_log');
		return $q->result();
	}
	
	function get_date_detail($param){
		$this->db->where('date(time)', date('Y-m-d', strtotime($param)));
		$this->db->order_by('time', 'desc');
		$q = $this->db->get('dcs_log');
		return $q->result();
	}
	
	function get_today(){
		$this->db->where('date(time)', date('Y-m-d'));
		$this->db->order_by('time', 'desc');
		$q = $this->db->get('dcs_log');
		return $q->result();
	}
	
	function insert($data){
		$this->db->insert('dcs_log', $data);
	}
}