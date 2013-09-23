<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	function util_helper_parse_date($dt_str){
		if(is_string($dt_str))
			return date_create($dt_str);
		else if(is_object($dt_str))
			return $dt_str;
		else
			return new DateTime();
	}

	function util_helper_add_one_day($dt_str) {

		$date = util_helper_parse_date($dt_str);
		date_add($date, date_interval_create_from_date_string('+ 1 days'));
		return $date;
	}

	function util_helper_add_four_hour($dt_str) {
		$date = util_helper_parse_date($dt_str);
		date_add($date, date_interval_create_from_date_string('+ 4 hours'));
		return $date;
	}

	function util_helper_add_six_hour($dt_str) {
		$date = util_helper_parse_date($dt_str);
		date_add($date, date_interval_create_from_date_string('+ 6 hours'));
		return $date;
	}

	function util_helper_format_date($dt){
		return date_format($dt, 'd/m/Y');
	}

	function util_helper_format_time($dt){
		return date_format($dt, 'H:i');
	}