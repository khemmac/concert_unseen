<?php
class Member extends CI_Controller {


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
		redirect('member/login');
	}

	function login(){
		//$r_url = $this->input->post('rurl');

		//if(empty($r_url))
			$r_url = 'index';

		if(is_user_session_exist($this))
			redirect('index');

		$rules = array(
					array(
						'field'		=> 'username',
						'label'		=> 'Username',
						'rules'		=> 'trim|required|min_length[5]|max_length[12]|xss_clean'
					),
					array(
						'field'		=> 'password',
						'label'		=> 'Password',
						'rules'		=> 'trim|required|md5|xss_clean|callback_check_login_user_pass'
					)
				);

		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() == FALSE)
		{
			$this->phxview->RenderView('login');
			$this->phxview->RenderLayout('default');
		} else {
			// fix fanzone only
			$user_obj = get_user_session($this);

			$is_open = !period_helper_close_system();

			if(($user_obj['username']=='testsbs1' || $user_obj['username']=='testsbs2'
			|| $user_obj['username']=='testsbs3' || $user_obj['username']=='testsbs4'
			|| $user_obj['username']=='testsbs5'
			)){
				// ปล่อยผ่านได้
				redirect($r_url);
			}
			if($is_early){
				// ปล่อยผ่านได้
				redirect($r_url);
			}
			if($is_presale){
				// ปล่อยผ่านได้
				redirect($r_url);
			}
			if($is_fanzone){
				// ปล่อยผ่านได้
				redirect($r_url);
			}

			delete_user_session($this);
			redirect('sbs2013?popup=login-fanzone-only-popup');
			return;
		}
	}

	function logout(){
		delete_user_session($this);
		redirect('index');
	}

	function register(){
		if(is_user_session_exist($this))
			redirect('member/profile');

		$original_data = $_POST;

		$rules = $this->person_model->get_register_rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE)
		{
			$this->phxview->RenderView('member-register');
			$this->phxview->RenderLayout('default');
		}else{
			$this->person_model->insert();

			// send email
			$this->email_model->send_register_success($original_data);

			//if(period_helper_pre_register()){
				redirect('member/register_pre_success');
			//}else{
				// auto login
			//	$this->person_model->login($this->input->post('username'), $this->input->post('password'));
			//	redirect('member/register_success');
			//}
		}
	}

	function register_success(){
		$this->phxview->RenderView('member-register-success');
		$this->phxview->RenderLayout('default');
	}

	function register_pre_success(){
		$this->phxview->RenderView('member-register-pre-success');
		$this->phxview->RenderLayout('default');
	}

	function profile(){
		// get session id
		$user_id = 0;
		if(is_user_session_exist($this)){
			$user_id = get_user_session_id($this);
			$user_data = get_user_session($this);
		}else
			redirect('member/login?rurl='.uri_string());

		$original_data = $_POST;

		$rules = $this->person_model->get_profile_rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE)
		{
			$this->db->set_dbprefix('');
			$this->db->where('id', $user_id);
			$query = $this->db->get('person');

			$member_data = $query->first_row('array');
			$member_birth_date = getdate(strtotime($member_data['birthDate']));

			$member_data['birth_date'] = $member_birth_date['mday'];
			$member_data['birth_month'] = $member_birth_date['mon'];
			$member_data['birth_year'] = $member_birth_date['year'];

			$this->phxview->RenderView('member-profile', array(
				'form_db_value' => $member_data
			));
			$this->phxview->RenderLayout('default');
		}else{
			$this->person_model->update();

			$pwd = $original_data['password_new'];
			if(!empty($pwd)){
				// send email
				$this->email_model->send_profile_success(array(
					'username'=>$user_data['username'],
					'password'=>$pwd,
					'email'=>$original_data['email']
				));
			}

			redirect('member/profile_success');
		}
	}

	function profile_success(){
		$this->phxview->RenderView('member-profile-success');
		$this->phxview->RenderLayout('default');
	}

	// http://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#callbacks
	public function check_register_username($username)
	{
		$this->db->set_dbprefix('');
		$this->db->select('id');
		$this->db->where('username', $username);
		$this->db->limit(1);

		$query = $this->db->get('person');

		if($query->num_rows() > 0) {
			$this->form_validation->set_message('check_register_username', 'มีคนใช้ %s &quot;'.$username.'&quot; แล้ว ลองใช้ชื่ออื่น');
			return false;
		} else {
			return true;
		}
	}

	//http://www.codefactorycr.com/login-with-codeigniter-php.html
	public function check_login_user_pass($password)
	{
		$username = $this->input->post('username');
		$result = $this->person_model->login($username, $password);

		if(!empty($result)){
			return true;
		}else{
			$this->form_validation->set_message('check_login_user_pass', '&quot;Username&quot; หรือ &quot;รหัสผ่าน&quot; ไม่ถูกต้อง');
			return false;
		}
	}

	public function check_profile_pass_old($password)
	{
		if(empty($password))
			return true;

		$user_id = get_user_session_id($this);

		//query the database
		$this->db->set_dbprefix('');
		$this->db->select('id');
		$this->db->where('id', $user_id);
		$this->db->where('password', $password);
		$this->db->limit(1);

		$query = $this->db->get('person');

		if($query->num_rows()>0) {
			return true;
		}else{
			$this->form_validation->set_message('check_profile_pass_old', '&quot;%s&quot; ไม่ถูกต้อง');
			return false;
		}
	}

	public function check_profile_pass_new($password)
	{
		$password_old = $this->input->post('password_old');
		if(empty($password) && empty($password_old))
			return true;
		else if(empty($password) && !empty($password_old)){
			$this->form_validation->set_message('check_profile_pass_new', 'หากต้องการแก้ไขรหัสผ่าน กรุณาป้อน &quot;%s&quot;');
			return false;
		}else if(!empty($password)){
			if(empty($password_old)){
				$this->form_validation->set_message('check_profile_pass_new', 'กรุณาป้อน &quot;รหัสผ่านเดิม&quot;');
				return false;
			}else{
				return true;
			}
		}
	}

	function forgot(){
		redirect('forgot');
	}


} // end class


