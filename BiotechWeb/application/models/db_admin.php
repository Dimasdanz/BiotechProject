<?php
class db_admin extends CI_Model{
	function get_all(){
		$q = $this->db->get('admin');
		return $q->result();
	}
	
	function get_single($username){
		$this->db->where('username', $username);
		$q = $this->db->get('admin');
		return $q->row();
	}
	
	function insert($data){
		$this->db->insert('admin', $data);
	}
	
	function delete($data){
		$this->db->where('username', $data);
		$this->db->delete('admin');
	}
}
?>