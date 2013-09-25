<?php
class Schedule extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		
		//load model
		$this->load->model('tranfer_model','',TRUE);
		
		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function index(){
		$this->load->helper('path');
		$cache_path = set_realpath(APPPATH.'logs/schedule');

		$fname =  date('m-d-H-i-s').'.txt';
		$fh = fopen($cache_path . $fname, 'w');
		
	    $list =	$this->tranfer_model->clearBookingData();
		$str =  "";
		foreach($list as $o){
			$str .= json_encode($o)."\n";		
		}

		//$str =  "schedule task is down by technical";
		fwrite($fh, $str);
		fclose($fh);
		
		$res = array("success"=>true);
		echo json_encode($res);
	}

}