<?php
class Language extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function index(){
		redirect('language/th');
	}

	function th(){
		$this->load->helper('cookie');

		set_cookie(array(
            'name'   => 'concert_language',
            'value'  => 'th',
            'expire' => time()+60*60*24*30
        ));

		$rurl = 'index';
		$this->load->library('user_agent');
		if ($this->agent->is_referral())
			$rurl = $this->agent->referrer();

		redirect($rurl);
	}

	function en(){
		$this->load->helper('cookie');

		set_cookie(array(
            'name'   => 'concert_language',
            'value'  => 'en',
            'expire' => time()+60*60*24*30
        ));

		$rurl = 'index/sbs2013';
		$this->load->library('user_agent');
		if ($this->agent->is_referral())
			$rurl = $this->agent->referrer();

		redirect($rurl);
	}

}