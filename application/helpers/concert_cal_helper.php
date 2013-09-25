<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	// code 1
	// 55558800 ลด 10%
	// 55559900 ลด 10%
	function cal_helper_valid_discount_code($code){
		return preg_match('/^(55558800|55559900)/', $code);
	}

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
	function cal_helper_get_discount($seat_list, $has_discount){
		$r = 0;
		if($has_discount){
			$sum_price = cal_helper_get_sum_price($seat_list);
			$r = $sum_price * 10 / 100;
		}
		return $r;
	}
	function cal_helper_get_total_price($seat_list, $has_discount){
		return cal_helper_get_sum_price($seat_list)
				+ cal_helper_get_card_fee($seat_list) - cal_helper_get_discount($seat_list, $has_discount);
	}