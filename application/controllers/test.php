<?php
class Test extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		// load model
		$this->load->model('email_model','',TRUE);
		$this->load->model('booking_model','',TRUE);

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function index(){
		echo 'Index of test controller';
	}

	function send_mail(){
		//$this->email_model->send_booking_submit(22, 44);
/*
		$this->email_model->send_register_success(array(
			'username'=>'ssssss',
			'password'=>'bbbbbbbb',
			'email'=>'khemmac@gmail.com'
		));
*/
		$this->email_model->send_profile_success(array(
					'username'=>'khemmac',
					'password'=>'123456',
					'email'=>'khemmac@gmail.com'
				));
		echo 'success';
	}

	function send_mails(){
		$this->email_model->test();
		echo '<br />success';
	}

	function check_port(){
		$fp = fsockopen('ssl://smtp.googlemail.com', 465, $errno, $errstr, 5);
		if (!$fp) {
			// port is closed or blocked
			echo 'ERROR NO : '.$errno;
			echo '<hr />';
			echo 'ERROR MSG : '.$errstr;
		} else {
			// port is open and available
			echo 'PORT IS OPEN';
			fclose($fp);
		}
	}

	function render_mail(){
		//$data = $this->booking_model->prepare_print_data(1, 1);

		$this->load->view('email/forgot-success');
	}

	function booking_prepare(){
		$user_id = get_user_session_id($this);

		$booking_id = $this->booking_model->prepare($user_id);

		echo $booking_id;
	}

	function booking_remove(){
		$booking_id = $this->input->get('id');
		$this->db->where('booking_id', $booking_id);
		$this->db->set('booking_id', NULL);
		$this->db->set('is_booked', 0);
		$this->db->update('seat');

		$this->db->where('id', $booking_id);
		$this->db->delete('booking');

		echo 'success';
	}

	function fix_booking_total_money(){
		$query = $this->db->get('booking');
		$list = $query->result_array();
		//foreach()
	}

	function upload(){

		if (empty($_FILES['slip']['name']))
		{
			$this->form_validation->set_rules('slip', 'หลักฐานการโอนเงิน', 'required');
		}
		if($this->form_validation->run()==FALSE)
			echo 'FALSE';
		else
			echo 'TRUE';
		$rules = array(
					array(
						'field'		=> 'code',
						'label'		=> 'รหัสจอง',
						'rules'		=> 'trim|required|exact_length[7]|xss_clean||callback_check_code_valid'
					)
				);
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() == FALSE) {
			$this->phxview->RenderView('test');
			$this->phxview->RenderLayout('empty');
		} else {
			/*
			$ids = $this->input->post('code');
			$img_name ="";
			if(isset($_FILES['slip']['name'])){
				$date = new DateTime();
				$time = $date->getTimestamp();
				$path = $_FILES['slip']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$img_name = $time.'.'.$ext;
				move_uploaded_file($_FILES['slip']['tmp_name'],$file_path.$img_name);
			}
			*/


		}
	}

	function upload_submit(){
		$file_path = FCPATH."fileuploads/";

		echo $file_path.'<hr />';

		function convertBytes( $value ) {
    if ( is_numeric( $value ) ) {
        return $value;
    } else {
        $value_length = strlen( $value );
        $qty = substr( $value, 0, $value_length - 1 );
        $unit = strtolower( substr( $value, $value_length - 1 ) );
        switch ( $unit ) {
            case 'k':
                $qty *= 1024;
                break;
            case 'm':
                $qty *= 1048576;
                break;
            case 'g':
                $qty *= 1073741824;
                break;
        }
        return $qty;
    }
}

		$config['upload_path'] = $file_path;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		//$config['max_size']	= '50M';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';

		$this->load->library('upload');
		$this->upload->initialize($config);

$maxFileSize = convertBytes( ini_get( 'upload_max_filesize' ) );
		echo $maxFileSize;

		if (!$this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			//$this->load->view('upload_form', $error);
			echo '<hr />ERROR<hr />';
			print_r($error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			//$this->load->view('upload_success', $data);
			echo '<hr />SUCCESS<hr />';
			print_r($data);
		}
	}

	function upload_limit(){
		ini_set('post_max_size', '50M');
		ini_set('upload_max_filesize', '30M');
		echo ini_get( 'upload_max_filesize' );
		phpinfo();
	}

}