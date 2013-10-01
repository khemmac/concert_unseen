<?php
class Seat extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		// load model
		$this->load->model('cache_model','',TRUE);
		$this->load->model('booking_model','',TRUE);
		$this->load->model('seat_model','',TRUE);

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function index(){
		if(period_helper_close_booking()){
			redirect('index');
			return;
		}

		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());

		$user_id = get_user_session_id($this);
		$user_obj = get_user_session($this);

		$has_booked = $this->booking_model->has_booked($user_id);
		if($has_booked){
			redirect('index?popup=zone-booked-limit-popup');
			return;
		}

		$booking_round = $this->input->post('round');
		if(empty($booking_round)) $booking_round = 1;

		// prepare booking data
		$booking_id = $this->booking_model->prepare($user_id);

		$zone_name = $this->uri->segment(2);

		// find zone
		if(empty($zone_name))
			redirect('zone');

		$this->phxview->RenderView('seat', array(
			'booking_round'=>$booking_round,
			'booking_id'=>$booking_id,
			'zone_name'=>$zone_name
		));
		$this->phxview->RenderLayout('default');

		//$this->benchmark->mark('overall_end');

		/////////////////// echo 'overall : '.$this->benchmark->elapsed_time('overall_start', 'overall_end').'<hr />';
	}

	function add(){
		if(!is_user_session_exist($this)){
			echo json_encode(array( 'success'=>false, 'error_code'=>1 )); // ไม่มี session
			return;
		}

		$user_id = get_user_session_id($this);
		$booking_id = $this->input->post('booking_id');
		$seat_id = $this->input->post('seat_id');

		if(empty($seat_id)){
			echo json_encode(array( 'success'=>false, 'error_code'=>99 )); // parameter ไม่ครบ
			return;
		}

		// is seat available
		if($this->cache_model->is_available($seat_id)){

			$affect_row = $this->booking_model->do_book($user_id, $booking_id, $seat_id);

			if($affect_row==1){
				// UPDATE CACHE
				//$this->cache_model->update_seat($zone_id);
				echo json_encode(array( 'success'=>true ));
			}else
				echo json_encode(array( 'success'=>false, 'error_code'=>999 )); // ไม่สามารถ update ได้
		}else{
			echo json_encode(array( 'success'=>false, 'error_code'=>2 )); // ที่นั่งไม่ว่าง
			return;
		}
	}

	function remove(){
		if(!is_user_session_exist($this)){
			echo json_encode(array( 'success'=>false, 'error_code'=>1 )); // ไม่มี session
			return;
		}

		$user_id = get_user_session_id($this);
		$booking_id = $this->input->post('booking_id');
		$seat_id = $this->input->post('seat_id');

		if(empty($seat_id)){
			echo json_encode(array( 'success'=>false, 'error_code'=>99 )); // parameter ไม่ครบ
			return;
		}

		$affect_row = $this->booking_model->undo_book($user_id, $booking_id, $seat_id);

		if($affect_row==1){
			// UPDATE CACHE
			//$this->cache_model->update_seat($zone_id);
			echo json_encode(array( 'success'=>true ));
		}else
			echo json_encode(array( 'success'=>false, 'error_code'=>999 )); // ไม่สามารถ update ได้
	}

	function submit(){
		redirect('zone');
/*
		if(!is_user_session_exist($this))
			redirect('member/login');
		$user_id = get_user_session_id($this);

		$zone_id= $this->input->post('zone_id');
		$zone_name = $this->input->post('zone_name');
		// check zone
		if(empty($zone_id) || empty($zone_name))
			redirect('zone');

		$seat_array = $this->input->post('seat');
		// check seat
		if(empty($seat_array) || count($seat_array)==0)
			redirect('seat/'.$zone_name);

		// check can book (check limit)
		$canbook = $this->booking_model->can_book($user_id, $zone_id, $seat_array);

		if($canbook){
			redirect('seat/'.$zone_name.'?popup=seat-limit-popup');
			return;
		}else{
			// call sp
			$sql = "CALL sp_booking (?,?,?)";
			$parameters = array($user_id, $zone_id, implode(',', $seat_array));
			$query = $this->db->query($sql, $parameters);

			redirect('zone');
		}
*/
	}

	function fetch(){
		if(!is_user_session_exist($this)){
			echo '100'; // no login
			return;
		}
		$user_id = get_user_session_id($this);
		$user_obj = get_user_session($this);

		$zone_name = $this->input->post('zone_name');

		// find zone
		if(empty($zone_name) && zone_helper_valid_zone_group($zone_name)){
			echo '101'; // no zone
			return;
		}

		// check booking id
		$booking_id = $this->input->post('booking_id');
		if(empty($booking_id)){
			echo '102'; // no booking_id
			return;
		}

		// check booking id
		$booking_round = $this->input->post('booking_round');
		if(empty($booking_round)){
			echo '103'; // no round
			return;
		}

		echo $this->load->view('includes/seat/'.$zone_name,array(
			'booking_id'=>$booking_id,
			'booking_round'=>$booking_round
		), TRUE);
	}


}