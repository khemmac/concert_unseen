<?php
Class Seat_model extends CI_Model
{
	function load_booking_seat($booking_id){
		$result_data = array(
			'zones'=>array(),
			'seats'=>array(),
			'price'=>0
		);
		if(!is_user_session_exist($this))
			return $result_data;

		$user_id = get_user_session_id($this);
		$tb_booking = $this->db->dbprefix('booking');
		$tb_zone = $this->db->dbprefix('zone');
		$tb_seat = $this->db->dbprefix('seat');
		$sql = "SELECT
s.zone_id, z.name AS zone_name
, s.round
, s.id AS seat_id, s.name AS seat_name
, s.booking_id, b.person_id, b.status
, z.price
FROM ".$tb_seat." s
JOIN ".$tb_zone." z ON s.zone_id=z.id
JOIN ".$tb_booking." b ON s.booking_id=b.id AND b.person_id=? AND b.status=1
WHERE s.booking_id=?
ORDER BY round ASC, seat_id ASC";
		$query = $this->db->query($sql, array($user_id, $booking_id));

		return $query->result_array();
	}

}