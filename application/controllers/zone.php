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
			redirect('index?popup=zone-booked-limit-popup');
			return;
		}

		// prepare booking data
		$booking_id = $this->booking_model->prepare($user_id);


		$booking_data = $this->seat_model->load_booking_seat($booking_id);
		// populate data
		$result = array(
			'booking_id'=>$booking_id,
			'rounds'=>array(),
			'price'=>0
		);
		foreach($booking_data AS $b_data){
			$cur_round = $b_data['round'];

			$exist_round = false;
			foreach($result['rounds'] AS $r_key => $r_value){
				if($cur_round==$r_key){
					$exist_round = true; break;
				}
			}
			if(!$exist_round)
				$result['rounds'][$cur_round] = array(
					'zones'=>array(),
					'seats'=>array()
				);



			$exist = false;
			foreach($result['rounds'][$cur_round]['zones'] AS $r_zone){
				if($b_data['zone_name']==$r_zone){
					$exist = true; break;
				}
			}
			if(!$exist)
				array_push($result['rounds'][$cur_round]['zones'], $b_data['zone_name']);

			array_push($result['rounds'][$cur_round]['seats'], $b_data['seat_name']);

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


		if(count($booking_data)>0){
			// submit booking
			$success = $this->booking_model->confirm_booking($user_id, $booking_id, null);
			if($success)
				redirect('booking/'.$booking_id);
			else
				redirect('zone');
		}
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
		$tb_booking = $this->db->dbprefix('booking');
		$tb_zone = $this->db->dbprefix('zone');
		$tb_seat = $this->db->dbprefix('seat');

		$this->db->query('alter table '.$tb_seat.' DROP FOREIGN KEY r_unseen_zone_seat_1_M');
		$this->db->query('alter table '.$tb_seat.' DROP FOREIGN KEY r_unseen_booking_seat_1_M;');
		$this->db->query('TRUNCATE TABLE '.$tb_zone);
		$this->db->query('TRUNCATE TABLE '.$tb_seat);
		$this->db->query('TRUNCATE TABLE '.$tb_booking);
		$this->db->query('Alter table '.$tb_seat.' add Constraint r_unseen_zone_seat_1_M'
						.' Foreign Key (zone_id) references '.$tb_zone.' (id) on delete  restrict on update  restrict;');
		$this->db->query('Alter table '.$tb_seat.' add Constraint r_unseen_booking_seat_1_M'
						.' Foreign Key (booking_id) references '.$tb_booking.' (id) on delete  restrict on update  restrict;');

		// price array
		$price_1 = array('a1','a2','a3');
		$price_2 = array('b1','b2','b3');
		$price_3 = array('c1','c2','c3');
		$price_4 = array('d1','d2','d3');
		$price_5 = array('e1','e2','e3');

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
						$this->db->set('createDate', 'NOW()', false);
						$this->db->insert('seat');
					}
				}
			}
			//break;
		}

		// UPDATE RESERVE SEAT
		$this->db->insert('booking', array(
			'id'=>1,
			'person_id'=>9999999
		));
		$reserve_ids_str = '25,26,27,28,29,30,31,32,33,34,35,36,37,293,294,295,296,297,298,299,300,301,302,303,304,305,551,552,553,554,555,556,557,558,559,560,561,562,563,793,794,795,796,797,798,799,800,801,802,803,804,805,806,807,808,1273,1274,1275,1276,1277,1278,1279,1280,1281,1282,1283,1284,1285,1286,1287,1709,1710,1711,1712,1713,1714,1715,1716,1717,1718,1719,1720,1721,1722,1723,1724,2429,2430,2431,2432,2433,2434,2435,2436,2437,2438,2439,2440,2441,2442,2443,2444,2918,2919,2920,2921,2922,2923,2924,2925,2926,2927,2928,2929,2930,2931,134,135,136,137,1033,1034,1035,1036,1037,1038,1039,1040,1041,1042,1043,1044,1045,1046,1047,1048,1491,1492,1493,1494,1495,1496,1497,1498,1499,1500,1501,1502,1503,1504,1505,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1959,1960,1961,1962,1963,1964,2445,2446,2447,2448,2449,2450,2451,2452,2453,2454,2455,2456,2457,2458,2459,2460,2933,2934,2935,2936,2937,2938,2939,2940,2941,2942,2943,2944,2945,2946,3421,3422,3423,3424,3425,3426,3427,3428,3429,3430,3431,3432,3433,3434,3435,3436,2669,2670,2671,2672,2673,2674,2675,2676,2677,2678,2679,2680,2681,2682,2683,2684,3136,3137,3138,3139,3140,3141,3142,3143,3144,3145,3146,3147,3148,3149,3645,3646,3647,3648,3649,3650,3651,3652,3653,3654,3655,3656,3657,3658,3659,3660,3638,3639,3640,3641,3642,3643,3644,2685,2686,2687,2688,2689,2690,2691,2692,2693,2694,2695,2696,2697,2698,2699,2700,3150,3151,3152,3153,3154,3155,3156,3157,3158,3159,3160,3161,3162,3163,3164,3661,3662,3663,3664,3665,3666,3667,3668,3669,3670,3671,3672,3673,3674,3675,3676,3817,3818,3819,3820,3821,3822,3823,3824,3825,3826,3827,3828,3829,4379,4380,4381,4382,4383,4384,4385,4386,4387,4388,4389,4390,4391,4603,4604,4605,4606,4607,4608,4609,4610,4611,4612';
		$reserve_ids_arr = explode(',', $reserve_ids_str);
		$this->db->where_in('id', $reserve_ids_arr);
		$this->db->set('is_booked', 1);
		$this->db->set('booking_id', 1);
		$this->db->update('seat');

		$this->db->trans_complete();
	}



}