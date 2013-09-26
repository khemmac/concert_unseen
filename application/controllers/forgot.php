<?php
class Forgot extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		// load model
		$this->load->model('person_model','',TRUE);
		$this->load->model('email_model','',TRUE);

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function index(){
		if(is_user_session_exist($this))
			redirect('index');

		$this->phxview->RenderView('member-forgot');
		$this->phxview->RenderLayout('default');
	}

	function load_question(){
		$username = $this->input->post('username');

		if(empty($username)){
			echo json_encode(array(
				'success'=>false,
				'error_code'=>1 // no user
			));
			return;
		}

		$this->db->set_dbprefix('');
		$this->db->select('id,username,question');
		$query = $this->db->get_where('person', array('username'=>$username));

		if($query->num_rows()>0){
			$res_data = $query->first_row('array');
			$q = $res_data['question'];

			if(language_helper_is_en($this)){
				if($q == 'สัตว์เลี้ยงตัวแรกของคุณชื่ออะไร?')
					$q = 'Your first pet\'s name?';
				else if($q == 'สัตว์เลี้ยงตัวแรกของคุณชื่ออะไร?')
					$q = 'What is your teenage best friend\'s name?';
				else if($q == 'อาหารจานแรกที่คุณหัดทำคืออะไร?')
					$q = 'What is the first dish you cooked?';
				else if($q == 'คุณขึ้นเครื่องบินไปที่ไหนครั้งแรก?')
					$q = 'What is the destination you fly to?';
				$res_data['question'] = $q;
			}

			echo json_encode(array(
				'success'=>true,
				'data'=>$res_data
			));
		}else
			echo json_encode(array(
				'success'=>false,
				'error_code'=>2 // user not found
			));
	}

	function check_answer(){
		$username = $this->input->post('username');
		$answer = $this->input->post('answer');

		if(empty($username)){
			echo json_encode(array(
				'success'=>false,
				'error_code'=>1 // no user
			));
			return;
		}
		if(empty($answer)){
			echo json_encode(array(
				'success'=>false,
				'error_code'=>2 // no answer
			));
			return;
		}

		$this->db->set_dbprefix('');
		$this->db->select('id,username,question,email');
		$this->db->limit(1);
		$query = $this->db->get_where('person', array(
			'username'=>$username,
			'answer'=>$answer
		));

		function generate_code(){
			$cde = '';
			for($i=0;$i<6;$i++)
				$cde.=substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 1);
			return $cde;
		}

		if($query->num_rows()>0){
			$result = $query->first_row('array');
			// generate new password
			$result['password_new'] = generate_code();

			// update new password
			$this->db->set_dbprefix('');
			$this->db->where('id', $result['id']);
			$this->db->set('password', md5($result['password_new']));
			$this->db->update('person');

			echo json_encode(array(
				'success'=>true,
				'data'=>$result
			));

			// send email new password
			$this->email_model->send_forgot_success($result);
		}else
			echo json_encode(array(
				'success'=>false,
				'error_code'=>3 // user not found
			));
	}

	function submit(){
		redirect('member/login');
	}


} // end class


