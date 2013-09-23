<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	function language_helper_current($_this){
		return 'th';
		$_this->load->helper('cookie');
		$lang = get_cookie('concert_language');
		if(!empty($lang))
			return get_cookie('concert_language');
		else
			return 'th';
	}

	function language_helper_is_th($_this) {
		$lang = language_helper_current($_this);
		return $lang=='th';
	}

	function language_helper_is_en($_this) {
		$lang = language_helper_current($_this);
		return $lang=='en';
	}