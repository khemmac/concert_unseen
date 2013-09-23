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
		$sql = "SELECT
s.zone_id, z.name AS zone_name
, s.id AS seat_id, s.name AS seat_name
, s.booking_id, b.person_id, b.status
, z.price
FROM seat s
JOIN zone z ON s.zone_id=z.id
JOIN booking b ON s.booking_id=b.id AND b.person_id=? AND b.status=1
WHERE s.booking_id=?
ORDER BY seat_id ASC";
		$query = $this->db->query($sql, array($user_id, $booking_id));

		return $query->result_array();
	}

	function load_seat_by_zone($zone_name){
		if(!is_user_session_exist($this))
			return $result_data;

		$user_id = get_user_session_id($this);
		$sql = "SELECT
s.zone_id, z.name AS zone_name
, s.id AS seat_id, s.name AS seat_name
, s.is_booked, s.booking_id, s.is_soldout
, b.person_id, b.status
FROM seat s
LEFT JOIN booking b ON s.booking_id=b.id
JOIN zone z ON s.zone_id=z.id
WHERE s.zone_id=(SELECT z.id FROM zone z WHERE z.name=? LIMIT 1)
ORDER BY s.id ASC";

		$query = $this->db->query($sql, array($zone_name));
		return $query->result_array();
	}

	function seat_available($seat_id){
		if(!is_user_session_exist($this))
			return $result_data;

		$user_id = get_user_session_id($this);
	}


}