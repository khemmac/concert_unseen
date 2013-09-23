<?php
Class Cache_model extends CI_Model
{
	function get_cache_path(){
		return set_realpath(APPPATH.'cache/zone');
	}

	function is_available($zone_id, $seat_id){
		/*
		$cache_path = $this->get_cache_path();
		$files = scandir($base_path);
		foreach($files AS $f){
			echo $f;
		}
		*/
		$this->db->select('id');
		$this->db->where('id', $seat_id);
		$this->db->where('booking_id IS NULL');
		$query = $this->db->get('seat');

		//echo $this->db->last_query();

		$available = ($query->num_rows()==1);
		return $available;
	}

	function update_seat($zone_id){

	}

}
