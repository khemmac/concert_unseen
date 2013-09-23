<?php
Class Early_model extends CI_Model
{

	function is_reserved($user_id){
		$this->db->select('person_id');
		$this->db->limit(1);
		$query = $this->db->get_where('reserve_early', array('person_id'=>$user_id));
		$reserved = ($query->num_rows()==1);
		return $reserved;
	}

	function reserve($user_id, $amount){
		$this->db->set('person_id', $user_id);
		$this->db->set('amount', $amount);
		$this->db->set('create_date', 'NOW()', FALSE);
		$this->db->insert('reserve_early');
	}

}
