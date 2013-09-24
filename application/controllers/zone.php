<?php
class Zone extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		// load model
		$this->load->model('booking_model','',TRUE);
		$this->load->model('seat_model','',TRUE);

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function close(){
		$this->phxview->RenderView('zone-close');
		$this->phxview->RenderLayout('default');
	}

	function index(){
		if(period_helper_close_booking()){
			redirect('zone/close');
			return;
		}

		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());
		$user_id = get_user_session_id($this);
		$user_obj = get_user_session($this);

		$has_booked = $this->booking_model->has_booked($user_id);
		if($has_booked){
			redirect('home?popup=zone-booked-limit-popup');
			return;
		}

		$reach_limit = $this->booking_model->reach_limit($user_id);
		if($reach_limit){
			redirect('booking/check?popup=seat-limit-popup');
			return;
		}

		// prepare booking data
		$booking_id = $this->booking_model->prepare($user_id);


		$booking_data = $this->seat_model->load_booking_seat($booking_id);
		// populate data
		$result = array(
			'booking_id'=>$booking_id,
			'zones'=>array(),
			'seats'=>array(),
			'price'=>0
		);
		foreach($booking_data AS $b_data){
			$exist = false;
			foreach($result['zones'] AS $r_zone){
				if($b_data['zone_name']==$r_zone){
					$exist = true; break;
				}
			}
			if(!$exist)
				array_push($result['zones'], $b_data['zone_name']);

			array_push($result['seats'], $b_data['seat_name']);

			$result['price']+=$b_data['price'];
		}

		$this->phxview->RenderView('zone', $result);
		$this->phxview->RenderLayout('default');
	}

	function submit(){
		if(!is_user_session_exist($this))
			redirect('member/login');
		$user_id = get_user_session_id($this);

		$booking_id = $this->input->post('booking_id');
		$booking_data = $this->seat_model->load_booking_seat($booking_id);



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
			$sql = "SELECT id FROM booking WHERE code=?";
			$query = $this->db->query($sql, array($code_result));

			if($query->num_rows()>0)
				$code_result = '';
		}


		if(count($booking_data)<30)
			redirect('zone/'.$booking_id.'?popup=zone-fanzone-minimum-popup');
		if(count($booking_data)>0)
			redirect('booking/'.$booking_id);
		else
			redirect('zone/'.$booking_id.'?popup=zone-blank-seat-popup');
	}

	function clear(){
		if(!is_user_session_exist($this))
			redirect('member/login');
		$user_id = get_user_session_id($this);

		$r_url = $this->input->post('rurl');
		if(empty($r_url)) $r_url='zone';

		$booking_id = $this->input->post('booking_id');
		if(!is_numeric($booking_id))
			redirect($r_url);

		$this->db->where('booking_id', $booking_id);
		$this->db->where('booking_id=(SELECT id FROM '.$this->db->dbprefix('booking')
									.' WHERE person_id='.$this->db->escape($user_id).' LIMIT 1)');
		$this->db->update('seat', array(
			'booking_id'=>NULL,
			'is_booked'=>0
		));

		redirect($r_url);
	}
	// development only
	function generate(){
		function split_seat($s){
			$result = array();
			$spitted_seat = explode(',', $s);
			foreach($spitted_seat as $value){
				$ordered_seat = explode('-', $value);
				$ordered_start = $ordered_seat[0];
				if(!empty($ordered_seat[1])){
					$ordered_end = $ordered_seat[1];
					for($i=$ordered_start; $i<=$ordered_end; $i++){
						array_push($result, $i);
					}
				}else{
					array_push($result, $ordered_start);
				}
			}
			return $result;
		}

		$this->db->trans_start();
		$tb_zone = $this->db->dbprefix('zone');
		$tb_seat = $this->db->dbprefix('seat');
		$this->db->query('alter table '.$tb_seat.' DROP FOREIGN KEY r_unseen_zone_seat_1_M');
		$this->db->query('TRUNCATE TABLE '.$tb_zone);
		$this->db->query('TRUNCATE TABLE '.$tb_seat);
		$this->db->query('Alter table '.$tb_seat.' add Constraint r_unseen_zone_seat_1_M'
						.' Foreign Key (zone_id) references '.$tb_zone.' (id) on delete  restrict on update  restrict;');

		// price array
		$price_1 = array('a1','a2','a3');

		$zones = zone_helper_get_zone();
		foreach($zones AS $zone){
			$zone_name = $zone['name'];

			$price = 0;
			if(in_array($zone_name, $price_1))
				$price = 2200;
			else if(in_array($zone_name, $price_2))
				$price = 1800;
			else if(in_array($zone_name, $price_3))
				$price = 1500;
			else if(in_array($zone_name, $price_4))
				$price = 1000;
			else if(in_array($zone_name, $price_5))
				$price = 800;
			$this->db->set('name', $zone_name);
			$this->db->set('price', $price);
			$this->db->set('createDate', 'NOW()', false);
			$this->db->insert('zone');

			$zone_id = $this->db->insert_id();
			echo '<h3>ZONE ID : '.$zone_id.'</h3>';

			echo $zone_name.'<hr />';
			for($i=1;$i<=2;$i++){
				echo '------- ROUND '.$i.'<hr />';
				foreach($zone['seat'] AS $row_name => $row_seat_list){
					$row_seat = split_seat($row_seat_list);
					foreach($row_seat AS $row_seat_key => $row_seat_value)
					{
						$seat_name = $row_name.$row_seat_value;
						echo $seat_name.'<hr />';
						$this->db->set('zone_id', $zone_id);
						$this->db->set('round', $i);
						$this->db->set('name', $seat_name);
						$this->db->set('is_booked', 0);
						$this->db->set('is_soldout', 0);
						$this->db->set('createDate', 'NOW()', false);
						$this->db->insert('seat');
					}
				}
			}
			//break;
		}

		$this->db->trans_complete();
	}



}