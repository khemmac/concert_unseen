<?php
Class Tranfer_model extends CI_Model
{

	function insert(){
		$this->db->select('username');
		$this->db->where('username', $this->input->post('username'));
		$query = $this->db->get('person');
		$this->db->limit(1);

		if($query->num_rows() > 0)
			throw new Exception('username "'.$this->input->post('username').'" is exists.');

		$formData = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'question' => $this->input->post('question'),
			'answer' => $this->input->post('answer'),
			'code' => $this->input->post('code'),
			'thName' => $this->input->post('thName'),
			'enName' => $this->input->post('enName'),
			'nickName' => $this->input->post('nickName'),
			'sex' => $this->input->post('sex'),
			'birthDate' => $this->input->post('birth_year').'-'.$this->input->post('birth_month').'-'.$this->input->post('birth_date'),
			'address' => $this->input->post('address'),
			'tel' => $this->input->post('tel'),
			'email' => $this->input->post('email'),
			'job' => $this->input->post('job'),
			'job_area' => $this->input->post('job_area'),
			'favorite_artist' => $this->input->post('favorite_artist')
		);

		$this->db->set('createDate', 'NOW()', false);
		$this->db->insert('person', $formData);
	}

	function loadBooking(){
		$user_id = get_user_session_id($this);
		$this->db->select('code');
		$this->db->where('person_id', $user_id);
		$this->db->where('code', $this->input->post('code'));
		$where = "status in(2,9)";
		$this->db->where($where); //2=ยืนยันการจอง
		return $this->db->get('booking');
	}

	function money_tranfer($img_name=""){
		/*$result = $this->loadBooking();
		if($result->num_rows() == 0) {
			$err = array('success'=>false,'msg'=>'code "'.$this->input->post('code').'" is tranfed or not exists.');
			//echo json_encode($err);
			//throw new Exception('code "'.$this->input->post('code').'" is not exists.');
			return $err;
		}*/

		$formData = array(
			//'code' => $this->input->post('code'),
			'pay_date' => $this->input->post('transfer_year').'-'.$this->input->post('transfer_month').'-'.$this->input->post('transfer_date').' '.$this->input->post('transfer_hh').':'.$this->input->post('transfer_mm').':00',
			'pay_money' => $this->input->post('pay_money').'.'.$this->input->post('pay_money_satang'),
			'bank_name' => $this->input->post('bank_name'),
			'bank_ref_id' => null,
			'payment_type' => '1', //0=Credit ,1=Tranfer
			'status' => '3', //1=ระหว่าจอง ,2=ยืนยันการจอง ,3=แจ้งโอนเงินแล้ว ,4=ยืนยันการโอนเงิน ,99=เลยเวลา
			'slip' =>  $img_name
		);

		$res = array('success'=>true,'msg'=>'');
		$this->db->set('updateDate', 'NOW()', false);
		$this->db->where('code', $this->input->post('code'));
		$this->db->update('booking', $formData);
		//return $res;
	}

	function loadBookingContents($ids=""){
		$query = $this->db->Query("select b.*,p.thName person_name,p.email,p.tel from booking b inner join person p on b.person_id=p.id where b.code in('".$ids."')");
		return $query->result_array();
	}

	function clearBookingData(){
		$sql="select 
				*
				from
				booking 
				where 
				(UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(createDate) >= 8*60*60 and type=2 and status in(1,2))
				OR
				(UNIX_TIMESTAMP(NOW()) >= UNIX_TIMESTAMP('2013-09-20 18:00:00') and type=3 and status in(1,2))
				";
				
				/*(UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(createDate) >= 6*60*60 and type=1 and status in(1,2))
				OR*/
				
		$query = $this->db->Query($sql);
		$list = $query->result_array();
		$results = array();
		foreach($list as $o){
			$ids = $o["id"];
			$queryUpdate = $this->db->Query("update seat set booking_id=null,is_booked=0,updateDate=NOW() where booking_id = $ids");
			$queryDelete = $this->db->Query("delete from booking where id = $ids");
			array_push($results,$o);
		}
		
		return $results;
	}

}