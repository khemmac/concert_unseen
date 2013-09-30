<?php
class Common extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function not_show_term_popup(){
		$this->load->helper('cookie');

		set_cookie(array(
            'name'   => 'not_show_term_popup',
            'value'  => 1,
            'expire' => time()+60*60*24*30
        ));

		echo '1';
	}

	function show_term_popup(){
		$this->load->helper('cookie');

		delete_cookie('not_show_term_popup');

		echo '1';
	}

}