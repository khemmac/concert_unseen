<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	//secure your snippet from external access
	function set_user_session($_this, $data) {
		$_this->session->set_userdata('session_concert', $data);
	}
	function get_user_session($_this){
		return $_this->session->userdata('session_concert');
	}
	function get_user_session_id($_this){
		$s_data = get_user_session($_this);
		if(!empty($s_data))
			return $s_data['id'];
		else
			return 0;
	}
	function is_user_session_exist($_this){
		$sess_user_id = get_user_session_id($_this);
		return (!empty($sess_user_id) && $sess_user_id>0);
	}
	function delete_user_session($_this){
		$_this->session->unset_userdata('session_concert');

		$_this->session->sess_destroy();
	}