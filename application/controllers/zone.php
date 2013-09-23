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

		$booking_type = 3;

		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());
		$user_id = get_user_session_id($this);
		$user_obj = get_user_session($this);

		$has_booked = $this->booking_model->has_booked($user_id, $booking_type);
		if($has_booked){
			redirect('sbs2013?popup=zone-booked-limit-popup');
			return;
		}

		$reach_limit = $this->booking_model->reach_limit($user_id);
		if($reach_limit){
			redirect('booking/check?popup=seat-limit-popup');
			return;
		}

		// check condition
		$booking_id = $id = end($this->uri->segments);
		if(is_numeric($booking_id)){
			// load booking
			$this->db->limit(1);
			$query = $this->db->get_where('booking', array(
				'id'=>$booking_id,
				'status'=>1
			));
			if($query->num_rows()<=0){
				// prepare booking data
				$booking_id = $this->booking_model->prepare($user_id, $booking_type);
				redirect('zone/'.$booking_id);
				return;
			}
		}else{
			// prepare booking data
			$booking_id = $this->booking_model->prepare($user_id, $booking_type);
			redirect('zone/'.$booking_id);
			return;
		}


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

		if($user_obj['type']==2){
			$this->phxview->RenderView('zone-fanzone', $result);
		}else{
			$this->phxview->RenderView('zone', $result);
		}
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
		$this->db->update('seat', array(
			'booking_id'=>NULL,
			'is_booked'=>0
		));

		if($r_url=='zone_presale')
			redirect($r_url);
		else
			redirect($r_url.'/'.$booking_id);
	}
/* // development only
	function generate(){
		function split_seat($s){
			$result = array();
			$pitted_seat = explode(',', $s);
			foreach($pitted_seat as $value){
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
		$this->db->query('alter table seat DROP FOREIGN KEY r_zone_seart_1_M');
		$this->db->query('TRUNCATE TABLE zone');
		$this->db->query('TRUNCATE TABLE seat');
		$this->db->query('Alter table seat add Constraint r_zone_seart_1_M Foreign Key (zone_id) references zone (id) on delete  restrict on update  restrict;');

		// price array
		$price_1 = array('a3');
		$price_2 = array('a2','a4');
		$price_3 = array('b2','b3','b4');
		$price_4 = array('b1','b5','c1','c2','c3',
					'e1f','e1g','e1h','e1i','e1j','e1k','e1l','e1m','e1n');
		$price_5 = array('a1','a5','d1','d2',
					'e1d','e1e','e1o','e1p',
					'e1a','e1b','e1c','e1q','e1r','e1s',
					'e2h','e2i','e2j','e2k','e2l','e2m','e2n','e2o');
		$price_6 = array('n1f','n1g','n1h','n1i','n1j','n1k','n1l',
					'e2e','e2f','e2g','e2p','e2q','e2r',
					's1a','s1b','s1c','s1d','s1e','s1f','s1g',
					'e2a','e2b','e2c','e2d','e2s','e2t','e2u','e2v');
		$price_7 = array('n2h','n2i','n2j','n2k','n2l',
					's2a','s2b','s2c','s2d','s2e',
					'e3a','e3b','e3c','e3d','e3e','e3f','e3g','e3h','e3i','e3j','e3k','e3l','e3m','e3n','e3o','e3p','e3q','e3r');

		$zones = zone_helper_get_zone();
		foreach($zones AS $zone){
			$zone_name = $zone['name'];

			$price = 0;
			if(in_array($zone_name, $price_1))
				$price = 6000;
			else if(in_array($zone_name, $price_2))
				$price = 5000;
			else if(in_array($zone_name, $price_3))
				$price = 4500;
			else if(in_array($zone_name, $price_4))
				$price = 3500;
			else if(in_array($zone_name, $price_5))
				$price = 2500;
			else if(in_array($zone_name, $price_6))
				$price = 1500;
			else if(in_array($zone_name, $price_7))
				$price = 900;
			$this->db->set('name', $zone_name);
			$this->db->set('price', $price);
			$this->db->set('type', $zone['type']);
			$this->db->set('createDate', 'NOW()', false);
			$this->db->insert('zone');

			$zone_id = $this->db->insert_id();
			echo '<h3>'.$zone_id.'</h3>';

			echo $zone_name.'<hr />';
			foreach($zone['seat'] AS $row_name => $row_seat){
				//$zone_data['seats'][$row_name] = array();
				foreach ($zone['position'] as $p_row_name => $position_seat) {
					// check row is match
					if($row_name==$p_row_name){
						$row_seat = split_seat($row_seat);
						$pos_seat = split_seat($position_seat);
						foreach($row_seat AS $row_seat_key => $row_seat_value)
						{
							if($zone['type']=='u')
								$seat_name = $row_seat_value;
							else
								$seat_name = $row_name.$row_seat_value;
							echo $seat_name.'<hr />';
							$this->db->set('zone_id', $zone_id);
							$this->db->set('name', $seat_name);
							$this->db->set('is_booked', 0);
							$this->db->set('is_soldout', 0);
							$this->db->set('createDate', 'NOW()', false);
							$this->db->insert('seat');
							//array_push($zone_data['seats'][$row_name], array(
							//	'no'=>$row_seat_value,
							//	'position'=>$pos_seat[$row_seat_key]
							//));
						}
						break;
					}
				}
			}
			//break;
		}

		$this->db->trans_complete();
	}
*/


}