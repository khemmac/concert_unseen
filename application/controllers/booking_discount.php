<?php
class Booking_discount extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		$this->load->model('seat_model','',TRUE);
		$this->load->model('booking_model','',TRUE);

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

		$has_booked = $this->booking_model->has_booked($user_id);
		if($has_booked){
			redirect('index?popup=zone-booked-limit-popup');
			return;
		}
		$booking_data = $this->seat_model->load_booking_seat($booking_id);
		if(count($booking_data)<=0)
			redirect('zone/'.$booking_id.'?popup=zone-blank-seat-popup');

		$rules = array(
			array(
				'field'		=> 'discount_code',
				'label'		=> 'รหัส PTT-Bluecard',
				'rules'		=> 'trim|required|is_numeric|integer|exact_length[16]|xss_clean|callback_check_discount_code'
			)
		);
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() == FALSE)
		{
			$this->phxview->RenderView('booking-discount', array(
				'booking_id'=>$booking_id
			));
			$this->phxview->RenderLayout('default');
		} else {
			// submit booking
			if(count($booking_data)>0){
				$success = $this->booking_model->confirm_booking($user_id, $booking_id, $this->input->post('discount_code'));

				if($success)
					redirect('booking/'.$booking_id);
				else
					redirect('zone');
			}
			else
				redirect('zone/'.$booking_id.'?popup=zone-blank-seat-popup');
		}

	}

	public function check_discount_code($code)
	{

		if(cal_helper_valid_discount_code($code)) {
			return true;
		} else {
			$this->form_validation->set_message('check_discount_code', '%s ไม่ถูกต้อง');
			return false;
		}
	}


}