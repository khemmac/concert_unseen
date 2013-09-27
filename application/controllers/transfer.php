<?php
class Transfer extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		//load model
		$this->load->model('tranfer_model','',TRUE);
		$this->load->model("email_model",'',TRUE);
		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function complete(){
		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());

		$booking_code = $this->uri->segment(3);
		if(empty($booking_code))
			redirect('index');

		$b_content = $this->tranfer_model->loadBookingContents($booking_code);

		if(count($b_content)<=0)
			redirect('index');

		$this->phxview->RenderView('transfer-complete', array(
			'booking_data'=>$b_content[0]
		));
		$this->phxview->RenderLayout('default');
	}

	function index(){
		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());
		$file_path = FCPATH."fileuploads/";
		$rules = array(
					array(
						'field'		=> 'code',
						'label'		=> 'รหัสจอง',
						'rules'		=> 'trim|required|exact_length[7]|xss_clean||callback_check_code_valid'
					),
					array(
						'field'		=> 'pay_money',
						'label'		=> 'จำนวนเงินที่โอน',
						'rules'		=> 'trim|required|numeric'
					),
					array(
						'field'		=> 'pay_money_satang',
						'label'		=> 'จำนวนเงินที่โอน (สตางค์)',
						'rules'		=> 'trim|required|numeric|exact_length[2]'
					)
				);
		if (empty($_FILES['userfile']['name']))
		{
			$this->form_validation->set_rules('userfile', 'หลักฐานการโอนเงิน', 'required');
		}
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run() == FALSE) {
			$this->phxview->RenderView('transfer');
			$this->phxview->RenderLayout('default');
		} else {
			//$ids = $this->input->post('code');
			$code = $this->input->post('code');
			$booking_id = 0;
			$this->db->select('id');
			$this->db->where('code IS NOT NULL');
			$this->db->where('LENGTH(code)=7');
			$this->db->limit(1);
			$q = $this->db->get_where('booking', array('code'=>$code));

			if($q->num_rows()<=0){
				redirect('index');
				return;
			}else{
				$r = $q->first_row('array');
				$booking_id = $r['id'];
			}

			$img_name ="";
/*
			if(isset($_FILES['slip']['name'])){
				$date = new DateTime();
				$time = $date->getTimestamp();
				$path = $_FILES['slip']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$img_name = $time.'.'.$ext;
				move_uploaded_file($_FILES['slip']['tmp_name'],$file_path.$img_name);
				//$this->ReSizeImage($file_path.$img_name,1100,700,$_FILES['slip']);
			}
*/
			// new image method
			$date = new DateTime();
			$time = $date->getTimestamp();

			$config['upload_path'] = $file_path;
			$config['file_name'] = $time;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';

			$this->load->library('upload');
			$this->upload->initialize($config);
			if (!$this->upload->do_upload())
			{
				$this->form_validation->set_rules('userfile', 'หลักฐานการโอนเงิน', 'required');
				$this->phxview->RenderView('transfer');
				$this->phxview->RenderLayout('default');
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
				return;
			}
			else
			{
				$upload_data = $this->upload->data();
				$img_name = $upload_data['file_name'];
			}
			// END new image method

			$this->tranfer_model->money_tranfer($booking_id, $img_name);
			$list = $this->tranfer_model->loadBookingContents($code);
			foreach($list as $o){
				$obj = array("email"=>$o["email"]
							,"code" =>$o["code"]
							,"pay_date"=>$o["pay_date"]
							,"pay_money"=>$o["pay_money"]
							,"bank_name"=>$o["bank_name"]);
				$this->email_model->approve_tranfer($obj);
			}
			redirect('transfer/complete/'.$code);
		}
	}

 	function check_code_valid(){
		$result = $this->tranfer_model->loadBooking();
		//if(!empty($result)){
		if($result->num_rows() > 0) {
			return true;
		}else{
			$this->form_validation->set_message('check_code_valid', 'ไม่พบข้อมูลรหัสจองนี้!');
			return false;
		}
	}

	function ReSizeImage($target,$w,$h,$tmp){
		 if(strtolower($this->extention($tmp['name']))=='.jpg'){
			 $image_full = imagecreatefromjpeg($tmp['tmp_name']);
		 }else if(strtolower($this->extention($tmp['name']))=='.gif'){
			 $image_full = imagecreatefromgif($tmp['tmp_name']);
		 }else if(strtolower($this->extention($tmp['name']))=='.png'){
			 $image_full = imagecreatefrompng($tmp['tmp_name']);
		 }

		$image_small = imagecreatetruecolor($w,$h);

		list($width, $height, $type, $attr) = getimagesize($tmp['tmp_name']);

		imagecopyresampled($image_small,$image_full,0,0,0,0,$w,$h,$width,$height);

		if(strtolower($this->extention($tmp['name']))=='.jpg'){
			imagejpeg($image_small,$target);

		 }else if(strtolower($this->extention($tmp['name']))=='.gif'){
			imagegif($image_small,$target);
		 }else if(strtolower($this->extention($tmp['name']))=='.png'){
			imagepng($image_small,$target);
		 }

		imagedestroy($image_full);
		imagedestroy($image_small);

	 }

	function extention($filename){
	   $exten = strtolower(strrchr($filename, '.'));
	   $file_extention = array('.jpg','.gif','.png');
	   if(!in_array($exten,$file_extention)){
		return false ;
	   }else{
		return $exten ;
	   }
	}

}
