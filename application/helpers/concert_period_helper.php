<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	//secure your snippet from external access

	function period_helper_close_booking() {
		$cur_time = strtotime("now");
		return ($cur_time >= strtotime('2013-10-02 12:00:00'));
	}

	function period_helper_close_system() {
		$cur_time = strtotime("now");
		return ($cur_time >= strtotime('2013-10-18 18:00:00'));
	}