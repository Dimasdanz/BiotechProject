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
	
	function reset_password($username, $data){
		$this->db->where('username', $username);
		$this->db->update('admin', $data);
	}
	
	function delete($username){
		$this->db->where('username', $username);
		$this->db->delete('admin');
	}
}
?>