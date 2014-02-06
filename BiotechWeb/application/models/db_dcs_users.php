<?php
class db_dcs_users extends CI_Model{
	function get_id(){
		$this->db->select('user_id');
		$this->db->order_by('user_id', 'desc');
		$q = $this->db->get('dcs_user');
		$id = $q->row();
		if(empty($id)){
			return '001';
		}else{
			$id = str_pad($id->user_id + 1, 3, 0, STR_PAD_LEFT);
			return $id;
		}
	}
	
	function get_all(){
		$q = $this->db->get('dcs_user');
		return $q->result();
	}
	
	function get_single($user_id){
		$this->db->where('user_id', $user_id);
		$q = $this->db->get('dcs_user');
		return $q->row();
	}
	
	function insert($data){
		$this->db->insert('dcs_user', $data);
	}
	
	function update($user_id,$data){
		$this->db->where('user_id', $user_id);
		$this->db->update('dcs_user', $data);
	}
	
	function delete($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('dcs_user');
	}
}
?>