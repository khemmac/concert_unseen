<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	//secure your snippet from external access
	function cal_helper_get_sum_price($seat_list){
		$r = 0;
		foreach($seat_list AS $o_seat){
			$r += $o_seat['price'];
		}
		return $r;
	}

	function cal_helper_get_card_fee($seat_list){
		return count($seat_list) * 20;
	}
	function cal_helper_get_discount($booking_type, $seat_list){
		$r = 0;
		$sum_price = cal_helper_get_sum_price($seat_list);
		if($booking_type==3){
			if(count($seat_list)>=100)
				$r = $sum_price * 15 / 100;
			else if(count($seat_list)>=50)
				$r = $sum_price * 10 / 100;
			else if(count($seat_list)>=30)
				$r = $sum_price * 5 / 100;
		}else if($booking_type==2){
			$r = count($seat_list)*500;
		}
		return $r;
	}
	function cal_helper_get_total_price($booking_type, $seat_list){
		return cal_helper_get_sum_price($seat_list) + cal_helper_get_card_fee($seat_list) - cal_helper_get_discount($booking_type, $seat_list);
	}
	function cal_helper_get_discount_detail($booking_type, $seat_list){
		$r = '';
		if($booking_type==3){
			if(count($seat_list)>=100)
				return '15%';
			else if(count($seat_list)>=50)
				return '10%';
			else if(count($seat_list)>=30)
				return '5%';
		}
		return $r;
	}