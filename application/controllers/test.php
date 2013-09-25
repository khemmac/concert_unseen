<?php
class Test extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		// load model
		$this->load->model('email_model','',TRUE);
		$this->load->model('booking_model','',TRUE);

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function index(){
		echo 'Index of test controller';
	}

	function send_mail(){
		//$this->email_model->send_booking_submit(22, 44);
/*
		$this->email_model->send_register_success(array(
			'username'=>'ssssss',
			'password'=>'bbbbbbbb',
			'email'=>'khemmac@gmail.com'
		));
*/
		$this->email_model->send_profile_success(array(
					'username'=>'khemmac',
					'password'=>'123456',
					'email'=>'khemmac@gmail.com'
				));
		echo 'success';
	}

	function send_mails(){
		$this->email_model->test();
		echo '<br />success';
	}

	function check_port(){
		$fp = fsockopen('ssl://smtp.googlemail.com', 465, $errno, $errstr, 5);
		if (!$fp) {
			// port is closed or blocked
			echo 'ERROR NO : '.$errno;
			echo '<hr />';
			echo 'ERROR MSG : '.$errstr;
		} else {
			// port is open and available
			echo 'PORT IS OPEN';
			fclose($fp);
		}
	}

	function render_mail(){
		//$data = $this->booking_model->prepare_print_data(1, 1);

		$this->load->view('email/forgot-success');
	}

	function booking_prepare(){
		$user_id = get_user_session_id($this);

		$booking_id = $this->booking_model->prepare($user_id);

		echo $booking_id;
	}

	function booking_remove(){
		$booking_id = $this->input->get('id');
		$this->db->where('booking_id', $booking_id);
		$this->db->set('booking_id', NULL);
		$this->db->set('is_booked', 0);
		$this->db->update('seat');

		$this->db->where('id', $booking_id);
		$this->db->delete('booking');

		echo 'success';
	}

	function fix_booking_total_money(){
		$query = $this->db->get('booking');
		$list = $query->result_array();
		//foreach()
	}

}