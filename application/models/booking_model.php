<?php
Class Booking_model extends CI_Model
{

	function has_booked($user_id){
		$this->db->select('count(id) AS cnt');
		$this->db->where('person_id', $user_id);
		$this->db->where('status >', 1);
		$query = $this->db->get('booking');

		$cnt = $query->first_row()->cnt;

		return ($cnt>=1);
	}

	function do_book($user_id, $booking_id, $seat_id){
		$tb_seat = $this->db->dbprefix('seat');
		$tb_booking = $this->db->dbprefix('seat');
		$sql = "UPDATE ".$tb_seat." SET booking_id=?, is_booked=1 WHERE id=?";
		$query = $this->db->query($sql, array($booking_id, $seat_id));
		return $this->db->affected_rows();
	}

	function undo_book($user_id, $booking_id, $seat_id){
		$tb_seat = $this->db->dbprefix('seat');
		$tb_booking = $this->db->dbprefix('booking');
		$sql = "UPDATE ".$tb_seat." SET booking_id=NULL, is_booked=0
WHERE id=? AND booking_id=(SELECT b.id FROM ".$tb_booking." b WHERE b.person_id=? AND b.status=1 AND b.id=? LIMIT 1)";
		$query = $this->db->query($sql, array($seat_id, $user_id, $booking_id));
		return $this->db->affected_rows();
	}

	function prepare($user_id){
		$this->db->select('id');
		$this->db->limit(1);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get_where('booking', array(
			'person_id'=>$user_id,
			'status'=>1
		));
		if($query->num_rows()>0){
			$res = $query->first_row('array');
			return $res['id'];
		}
/*
		function generate_code($booking_id){
			$round_code = 'E';
			if($booking_type==1)
				$round_code = 'E';
			else if($booking_type==2)
				$round_code = 'P';
			else if($booking_type==3)
				$round_code = 'F';
			$trail_code = '';
			for($i=0;$i<4;$i++)
				$trail_code.=substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 1);

			return date('d') . $round_code . $trail_code;
		}

		$code_result = '';
		while(empty($code_result)){
			$code_result = generate_code($booking_type);
			$query = $this->db->get_where('booking', array('code'=>$code_result));

			if($query->num_rows()>0)
				$code_result = '';
		}
*/
		$this->db->set('createDate', 'NOW()', false);
		$this->db->insert('booking', array(
			'person_id'=>$user_id,
			//'code'=> $code_result,
			'total_money'=>0,
			'status'=>1
		));
		return $this->db->insert_id();
	}

	// data
	function prepare_print_data($user_id, $booking_id){
		// load profile data
		$this->db->select('thName,code,email,tel');
		$this->db->where('id', $user_id);
		$this->db->limit(1);
		$query = $this->db->get('person');
		$person_data = $query->first_row('array');

		// load booking data
		$this->db->where('id', $booking_id);
		$this->db->limit(1);
		$query = $this->db->get('booking');
		$booking_data = $query->first_row('array');

		//print_r($booking_data);

		// seat data
		$tb_zone = $this->db->dbprefix('zone');
		$tb_seat = $this->db->dbprefix('seat');
		$tb_booking = $this->db->dbprefix('booking');
		$sql = "SELECT
s.zone_id, z.name AS zone_name
, s.id AS seat_id, s.name AS seat_name
, s.booking_id, b.person_id, b.status
, z.price
FROM ".$tb_seat." s
JOIN ".$tb_zone." z ON s.zone_id=z.id
JOIN ".$tb_booking." b ON s.booking_id=b.id AND b.person_id=?
WHERE  s.booking_id=?
ORDER BY seat_id ASC";
		$query = $this->db->query($sql, array($user_id, $booking_id));
		$booking_list = $query->result_array();
		$zone_distinct_list = array();
		foreach($booking_list AS $b_obj){
			$exist = false;
			foreach($zone_distinct_list AS $z){
				if($b_obj['zone_name']==$z){
					$exist = true; break;
				}
			}
			if(!$exist)
				array_push($zone_distinct_list, $b_obj['zone_name']);
		}

		return array(
			'person'=>$person_data,
			'zone_list'=>$zone_distinct_list,
			'booking_data'=>$booking_data,
			'booking_list'=>$booking_list
		);
	}

}
