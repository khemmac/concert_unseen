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
		/*
		$booking_type = 3;

		$this->benchmark->mark('overall_start');

		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());

		$user_id = get_user_session_id($this);
		$user_obj = get_user_session($this);

		$has_booked = $this->booking_model->has_booked($user_id, $booking_type);
		if($has_booked){
			redirect('sbs2013?popup=zone-booked-limit-popup');
			return;
		}

		$zone_name = $this->uri->segment(2);

		$zone = zone_helper_get_zone($zone_name);

		// find zone
		if(empty($zone_name) || empty($zone))
			redirect('zone');

		// check booking id
		$booking_id = $this->uri->segment(3);
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
				redirect('seat/'.$zone_name.'/'.$booking_id);
				return;
			}
		}else{
			// prepare booking data
			$booking_id = $this->booking_model->prepare($user_id, $booking_type);
			redirect('seat/'.$zone_name.'/'.$booking_id);
			return;
		}

		$zone_data = array();

		// populating result data
		$zone_data['limit']=$this->booking_model->get_booking_limit();
		$zone_data['current_booking_count'] = $this->booking_model->count_book($user_id);
		$zone_data['zone'] = $zone['name'][0];
		$zone_data['class'] = $zone['name'][1];
		$zone_data['blog'] = $zone['name'][2];
		$zone_data['name'] = $zone['name'];
		$zone_data['max_col'] = $zone['max_col'];

		$this->benchmark->mark('get_db_start');
		// get seat from db
		$db_seats = $this->seat_model->load_seat_by_zone($zone_name);
		$zone_data['id'] = $db_seats[0]['zone_id'];
		$booking_seats = $this->seat_model->load_booking_seat($booking_id);

		$last_index = 0;
		foreach($db_seats AS $k_seat => $seat){
			$is_own = 0;
			for($i=$last_index;$i<count($booking_seats);$i++){
				$o_seat = $booking_seats[$i];
				if($seat['seat_id']==$o_seat['seat_id']){
					$is_own = ($o_seat['status']==1 && $seat['person_id']==$user_id);
					$last_index++;
					break;
				}
			}
			$db_seats[$k_seat]['is_own'] = $is_own;
		}

		$this->benchmark->mark('get_db_end');

		/////////////////// echo 'get_db : '.$this->benchmark->elapsed_time('get_db_start', 'get_db_end').'<hr />';

		$this->benchmark->mark('populate_seat_start');

		// private function
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
		//$row_seat = split_seat($zone['seat']['q']);
		//$pos_seat = split_seat($zone['seat']['q']);
		//print_r(split_seat($zone['seat']['q']));
		//echo '<hr />';
		//print_r(split_seat($zone['position']['q']));
		//return;

		$zone_data['seats'] = array();

		foreach($zone['seat'] AS $row_name => $row_seat){
			if(empty($row_seat) || strlen(trim($row_seat))<=0)
				continue;

			$zone_data['seats'][$row_name] = array();
			foreach ($zone['position'] AS $p_row_name => $position_seat) {
				// check row is match
				if($row_name==$p_row_name){
					// ข้อมูลที่นั่งในแถว
					$row_seat = split_seat($row_seat);
					// ข้อมูลที่ตำแหน่งที่นั่ง
					$pos_seat = split_seat($position_seat);

					for($i=1;$i<=$zone_data['max_col'];$i++){
						$position_match = false;
						$result_no = -1;
						$result_position = $i;

						foreach($row_seat AS $row_seat_key => $row_seat_value)
						{
							// $row_seat_key คือ index ของตำแหน่งที่นั่ง
							// $row_seat_value คือ ตำแหน่งที่นั่ง

							if(empty($pos_seat[$row_seat_key])){
								echo 'Could not find position at : '.$row_name.' - '.$row_seat_key;
								echo '<br />';
								echo 'ROW ('.$row_name.') : ';
								print_r($row_seat);
								echo '<hr />';
								echo 'POSITION ('.$row_name.') : ';
								print_r($pos_seat);
							}

							if($i==$pos_seat[$row_seat_key]){
								$position_match = true;
								$result_no = $row_seat_value;
								$result_position = $pos_seat[$row_seat_key];
								break;
							}
						}
						array_push($zone_data['seats'][$row_name], array(
							'no'=>$result_no,
							'position'=>$result_position
						));
					}
					break;
				}
			}
		}
		$this->benchmark->mark('populate_seat_end');
		/////////////////// echo 'populate_seat : '.$this->benchmark->elapsed_time('populate_seat_start', 'populate_seat_end').'<hr />';

		foreach($db_seats AS $db_seat){
			$db_seat_name = $db_seat['seat_name'];
			$db_row_name = substr($db_seat_name, 0, 1);

			foreach($zone_data['seats'] AS $row_name => $row_seats){
				if($db_row_name==$row_name){
					foreach($row_seats AS $seat_key => $seat){
						if($seat['no']!=-1){
							if($db_seat_name==$row_name.$seat['no']){
								$zone_data['seats'][$row_name][$seat_key]['id'] = $db_seat['seat_id'];
								$zone_data['seats'][$row_name][$seat_key]['is_booked'] = $db_seat['is_booked'];
								$zone_data['seats'][$row_name][$seat_key]['is_soldout'] = $db_seat['is_soldout'];
								$zone_data['seats'][$row_name][$seat_key]['is_own'] = $db_seat['is_own'];
								break;
							}
						}
					}
					break;
				}
			}
		}
*/
		$this->phxview->RenderView('seat', array(
			//'booking_id'=>$booking_id,
			//'zone'=>$zone_data
		));
		$this->phxview->RenderLayout('default');

		$this->benchmark->mark('overall_end');

		/////////////////// echo 'overall : '.$this->benchmark->elapsed_time('overall_start', 'overall_end').'<hr />';
	}

	function add(){
		if(!is_user_session_exist($this)){
			echo json_encode(array( 'success'=>false, 'error_code'=>1 )); // ไม่มี session
			return;
		}

		$user_id = get_user_session_id($this);
		$booking_id = $this->input->post('booking_id');
		$zone_id= $this->input->post('zone_id');
		$seat_id = $this->input->post('seat_id');

		if(empty($zone_id) || empty($seat_id)){
			echo json_encode(array( 'success'=>false, 'error_code'=>99 )); // parameter ไม่ครบ
			return;
		}

		// is seat available
		if($this->cache_model->is_available($zone_id, $seat_id)){

			$this->booking_model->do_book($user_id, $booking_id, $zone_id, $seat_id);

			// UPDATE CACHE
			$this->cache_model->update_seat($zone_id);

			echo json_encode(array( 'success'=>true ));
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
		$zone_id= $this->input->post('zone_id');
		$seat_id = $this->input->post('seat_id');

		if(empty($zone_id) || empty($seat_id)){
			echo json_encode(array( 'success'=>false, 'error_code'=>99 )); // parameter ไม่ครบ
			return;
		}

		$this->booking_model->undo_book($user_id, $booking_id, $zone_id, $seat_id);
		// UPDATE CACHE
		$this->cache_model->update_seat($zone_id);

		echo json_encode(array( 'success'=>true ));
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
			echo '<script type="text/javascript">self.location.href="'.site_url('member/login').'";</script>';
			return;
		}

		$user_id = get_user_session_id($this);
		$user_obj = get_user_session($this);

		// check booking type
		$booking_type = 1;
		if($user_obj['type']==2)
			$booking_type = 3;
		else if(period_helper_presale())
			$booking_type = 2;

		$zone_name = $this->input->post('zone_name');

		$zone = zone_helper_get_zone($zone_name);

		// find zone
		if(empty($zone_name) || empty($zone)){
			echo '<script type="text/javascript">self.location.href="'.site_url('zone').'";</script>';
			return;
		}

		// check booking id
		$booking_id = $this->input->post('booking_id');
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
				echo '<script type="text/javascript">self.location.href="'.site_url('seat/'.$zone_name.'/'.$booking_id).'";</script>';
				return;
			}
		}else{
			// prepare booking data
			$booking_id = $this->booking_model->prepare($user_id, $booking_type);
			echo '<script type="text/javascript">self.location.href="'.site_url('seat/'.$zone_name.'/'.$booking_id).'";</script>';
			return;
		}

		$zone_data = array();

		// populating result data
		$zone_data['limit']=$this->booking_model->get_booking_limit();
		$zone_data['current_booking_count'] = $this->booking_model->count_book($user_id);
		$zone_data['zone'] = $zone['name'][0];
		$zone_data['class'] = $zone['name'][1];
		$zone_data['blog'] = $zone['name'][2];
		$zone_data['name'] = $zone['name'];
		$zone_data['max_col'] = $zone['max_col'];

		// get seat from db
		$db_seats = $this->seat_model->load_seat_by_zone($zone_name);
		$zone_data['id'] = $db_seats[0]['zone_id'];
		$booking_seats = $this->seat_model->load_booking_seat($booking_id);

		$last_index = 0;
		foreach($db_seats AS $k_seat => $seat){
			$is_own = 0;
			for($i=$last_index;$i<count($booking_seats);$i++){
				$o_seat = $booking_seats[$i];
				if($seat['seat_id']==$o_seat['seat_id']){
					$is_own = ($o_seat['status']==1 && $seat['person_id']==$user_id);
					$last_index++;
					break;
				}
			}
			$db_seats[$k_seat]['is_own'] = $is_own;
		}

		// private function
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
		$zone_data['seats'] = array();

		foreach($zone['seat'] AS $row_name => $row_seat){
			if(empty($row_seat) || strlen(trim($row_seat))<=0)
				continue;

			$zone_data['seats'][$row_name] = array();
			foreach ($zone['position'] AS $p_row_name => $position_seat) {
				// check row is match
				if($row_name==$p_row_name){
					// ข้อมูลที่นั่งในแถว
					$row_seat = split_seat($row_seat);
					// ข้อมูลที่ตำแหน่งที่นั่ง
					$pos_seat = split_seat($position_seat);

					for($i=1;$i<=$zone_data['max_col'];$i++){
						$position_match = false;
						$result_no = -1;
						$result_position = $i;

						foreach($row_seat AS $row_seat_key => $row_seat_value)
						{
							// $row_seat_key คือ index ของตำแหน่งที่นั่ง
							// $row_seat_value คือ ตำแหน่งที่นั่ง

							if(empty($pos_seat[$row_seat_key])){
								echo 'Could not find position at : '.$row_name.' - '.$row_seat_key;
								echo '<br />';
								echo 'ROW ('.$row_name.') : ';
								print_r($row_seat);
								echo '<hr />';
								echo 'POSITION ('.$row_name.') : ';
								print_r($pos_seat);
							}

							if($i==$pos_seat[$row_seat_key]){
								$position_match = true;
								$result_no = $row_seat_value;
								$result_position = $pos_seat[$row_seat_key];
								break;
							}
						}
						array_push($zone_data['seats'][$row_name], array(
							'no'=>$result_no,
							'position'=>$result_position
						));
					}
					break;
				}
			}
		}
		foreach($db_seats AS $db_seat){
			$db_seat_name = $db_seat['seat_name'];
			$db_row_name = substr($db_seat_name, 0, 1);

			foreach($zone_data['seats'] AS $row_name => $row_seats){
				if($db_row_name==$row_name){
					foreach($row_seats AS $seat_key => $seat){
						if($seat['no']!=-1){
							if($db_seat_name==$row_name.$seat['no']){
								$zone_data['seats'][$row_name][$seat_key]['id'] = $db_seat['seat_id'];
								$zone_data['seats'][$row_name][$seat_key]['is_booked'] = $db_seat['is_booked'];
								$zone_data['seats'][$row_name][$seat_key]['is_soldout'] = $db_seat['is_soldout'];
								$zone_data['seats'][$row_name][$seat_key]['is_own'] = $db_seat['is_own'];
								break;
							}
						}
					}
					break;
				}
			}
		}
		echo $this->load->view('includes/partials/seat-chair',array(
			'booking_id'=>$booking_id,
			'zone'=>$zone_data
		), TRUE);
	}


}