<?php
class Booking extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		// load model
		$this->load->model('email_model','',TRUE);
		$this->load->model('booking_model','',TRUE);
		$this->load->model('seat_model','',TRUE);

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function index(){
		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());
		$user_id = get_user_session_id($this);

		// check booking id
		$booking_id = end($this->uri->segments);
		if(!is_numeric($booking_id))
			redirect('zone');

		$result_data = $this->booking_model->prepare_print_data($user_id, $booking_id);

		$has_booked = $this->booking_model->has_booked($user_id, $result_data['booking_data']['type']);
		if($has_booked){
			redirect('sbs2013?popup=zone-booked-limit-popup');
			return;
		}

		$this->phxview->RenderView('booking', $result_data);
		$this->phxview->RenderLayout('default');
	}

	function booking_submit(){
		if(!is_user_session_exist($this))
			redirect('member/login');
		$user_id = get_user_session_id($this);

		$booking_id=$this->input->post('booking_id');

		$data = $this->booking_model->prepare_print_data($user_id, $booking_id);
		$card_fee = cal_helper_get_card_fee($data['booking_list']);
		$discount = cal_helper_get_discount($data['booking_data']['type'], $data['booking_list']);
		$total = cal_helper_get_total_price($data['booking_data']['type'], $data['booking_list']);

		// check limit
		$booking_id=$this->input->post('booking_id');
		$this->db->where('id', $booking_id);
		$this->db->where('person_id', $user_id);
		$this->db->set('booking_date','NOW()',false);
		$this->db->set('updateDate','NOW()',false);
		$this->db->set('total_money',$total.'.'.str_pad(substr($booking_id, -2), 2, '0', STR_PAD_LEFT));
		$this->db->update('booking', array(
			'status'=>2
		));

		// write booking log
		$this->load->helper('path');
		$cache_path = set_realpath(APPPATH.'logs/booking');

		try {
			$fname =  date('m-d').'.txt';
			$fh = fopen($cache_path . $fname, 'w');
			$log_str = '------ BOOKING SUBMIT ------'.PHP_EOL;
			$time_str = date('H-i-s');
			$log_str .= $time_str.' - id : '.$booking_id.PHP_EOL;
			$log_str .= $time_str.' - user : '.$user_id.PHP_EOL;
			$log_str .= $time_str.' - sql : '.$this->db->last_query().PHP_EOL;
			fwrite($fh, $log_str);
			fclose($fh);
		 } catch (Exception $e) {}

		if($this->db->affected_rows()==1){
			// send mail
			try {
				$this->email_model->send_booking_submit($user_id, $booking_id);
			} catch (Exception $e) {}

			redirect('booking/check?popup=booking-submit-complete-popup');
		}else{
			redirect('booking/'.$r_data['booking_id']);
		}

	}

	function complete(){
		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());
		$user_id = get_user_session_id($this);

		$booking_id = $this->uri->segment(3);

		if(empty($booking_id) || !is_numeric($booking_id))
			redirect('booking/check');

		$result_data = $this->booking_model->prepare_print_data($user_id, $booking_id);

		//echo '<hr />';
		//print_r($result_data);
		//return;

		$this->phxview->RenderView('booking-complete', $result_data);
		$this->phxview->RenderLayout('default');
	}

	function check(){
		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());
		$user_id = get_user_session_id($this);

		$this->form_validation->set_rules(array(
			array(
				'field'		=> 'code',
				'label'		=> 'รหัสจอง',
				'rules'		=> 'trim|required|exact_length[7]|xss_clean|callback_check_booking_code'
			)
		));

		if ($this->form_validation->run() == FALSE)
		{
			$this->phxview->RenderView('booking-check');
			$this->phxview->RenderLayout('default');
		}else{
			$this->db->select('id');
			$this->db->limit(1);
			$this->db->where(array(
				'person_id'=>$user_id,
				'code'=>$this->input->post('code')
			));
			$query = $this->db->get('booking');
			$result = $query->first_row('array');

			redirect('booking/complete/'.$result['id']);
		}
	}

	// call back for validator
	public function check_booking_code($code)
	{
		$user_id = get_user_session_id($this);

		$this->db->select('id,status');
		$this->db->limit(1);
		$this->db->where(array(
			'person_id'=>$user_id,
			'code'=>$this->input->post('code')
		));
		$query = $this->db->get('booking');

		if($query->num_rows()>0){
			$o = $query->first_row('array');
			$status = $o['status'];
			if($status==1){
				$this->form_validation->set_message('check_booking_code', 'ท่านต้องยืนยันการจองก่อนทำการตรวจสอบสถานะ');
				return false;
			}else if($status==99){
				$this->form_validation->set_message('check_booking_code', 'การจองนี้เลยเวลาชำระเงินไปแล้วค่ะ');
				return false;
			}else{
				return true;
			}
		}else{
			$this->form_validation->set_message('check_booking_code', 'ไม่พบรหัสการจอง');
			return false;
		}
	}

}