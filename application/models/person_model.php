<?php
Class Person_model extends CI_Model
{
	public function __construct() {
		parent::__construct();

		$this->lang->load("form_validation",language_helper_is_th($this)?'thai':'english');
	}


	function login($username, $password){
		$this->db->select('id, username, thName, enName, type');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->limit(1);

		$query = $this->db->get('person');

		if($query->num_rows() == 1) {
			set_user_session($this, $query->first_row('array'));
			return $query->result();
		} else {
			return false;
		}
	}

	function insert(){
		$this->db->select('username');
		$this->db->where('username', $this->input->post('username'));
		$query = $this->db->get('person');
		$this->db->limit(1);

		if($query->num_rows() > 0)
			throw new Exception('username "'.$this->input->post('username').'" is exists.');

		$formData = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'question' => $this->input->post('question'),
			'answer' => $this->input->post('answer'),
			'code' => $this->input->post('code'),
			'thName' => $this->input->post('thName'),
			'enName' => $this->input->post('enName'),
			'nickName' => $this->input->post('nickName'),
			'sex' => $this->input->post('sex'),
			'birthDate' => $this->input->post('birth_year').'-'.$this->input->post('birth_month').'-'.$this->input->post('birth_date'),
			'address' => $this->input->post('address'),
			'tel' => $this->input->post('tel'),
			'email' => $this->input->post('email'),
			'job' => $this->input->post('job'),
			'job_area' => $this->input->post('job_area'),
			'favorite_artist' => $this->input->post('favorite_artist')
		);

		$this->db->set('createDate', 'NOW()', false);
		$this->db->insert('person', $formData);
	}

	function update(){
		$user_id = get_user_session_id($this);
		$this->db->where('id', $user_id);

		$formData = array(
			'question' => $this->input->post('question'),
			'answer' => $this->input->post('answer'),
			'code' => $this->input->post('code'),
			'thName' => $this->input->post('thName'),
			'enName' => $this->input->post('enName'),
			'nickName' => $this->input->post('nickName'),
			'sex' => $this->input->post('sex'),
			'birthDate' => $this->input->post('birth_year').'-'.$this->input->post('birth_month').'-'.$this->input->post('birth_date'),
			'address' => $this->input->post('address'),
			'tel' => $this->input->post('tel'),
			'email' => $this->input->post('email'),
			'job' => $this->input->post('job'),
			'job_area' => $this->input->post('job_area'),
			'favorite_artist' => $this->input->post('favorite_artist')
		);
		$password_old = $this->input->post('password_old');
		$password_new = $this->input->post('password_new');
		if(!empty($password_old) && !empty($password_new))
			$formData['password'] = $password_new;

		$this->db->set('updateDate', 'NOW()', false);
		$this->db->update('person', $formData);
	}

	function get_register_rules(){
		return array(
			array(
				'field'		=> 'username',
				'label'		=> 'User name',
				'rules'		=> 'trim|required|min_length[5]|max_length[12]|xss_clean|callback_check_register_username'
			),
			array(
				'field'		=> 'password',
				'label'		=> language_helper_is_th($this)?'รหัสผ่าน':'Password',
				'rules'		=> 'trim|required|min_length[6]|max_length[50]|xss_clean|matches[passwordConf]|md5'
			),
			array(
				'field'		=> 'passwordConf',
				'label'		=> language_helper_is_th($this)?'ยืนยัน รหัสผ่าน':'Confirm Password',
				'rules'		=> 'trim|required|md5'
			),
			array(
				'field'		=> 'question',
				'label'		=> language_helper_is_th($this)?'คำถามกันลืมรหัสผ่าน':'Security Question',
				'rules'		=> 'trim|required'
			),
			array(
				'field'		=> 'answer',
				'label'		=> language_helper_is_th($this)?'คำตอบ':'Answer',
				'rules'		=> 'trim|required|max_length[255]'
			),
			array(
				'field'		=> 'code',
				'label'		=> language_helper_is_th($this)?'รหัสบัตรประชาชน':'ID-Card',
				'rules'		=> 'trim|required|integer|exact_length[13]'
			),
			array(
				'field'		=> 'thName',
				'label'		=> language_helper_is_th($this)?'ชื่อ - นามสกุล':'Name - Surname',
				'rules'		=> 'trim|required|max_length[255]'
			),
			array(
				'field'		=> 'enName',
				'label'		=> language_helper_is_th($this)?'ชื่อ - นามสกุล (ภาษาอังกฤษ)':'Name - Surname (English Language)',
				'rules'		=> 'trim|required|max_length[255]'
			),
			array(
				'field'		=> 'nickName',
				'label'		=> language_helper_is_th($this)?'ชื่อเล่น':'Nickname',
				'rules'		=> 'trim|required|max_length[100]'
			),
			array(
				'field'		=> 'sex',
				'label'		=> language_helper_is_th($this)?'เพศ':'Sex',
				'rules'		=> 'trim|required|max_length[1]'
			),
			array(
				'field'		=> 'birth_date',
				'label'		=> 'วัน',
				'rules'		=> 'trim|required'
			),
			array(
				'field'		=> 'birth_month',
				'label'		=> 'เดือน',
				'rules'		=> 'trim|required'
			),
			array(
				'field'		=> 'birth_year',
				'label'		=> 'ปี',
				'rules'		=> 'trim|required'
			),
			array(
				'field'		=> 'address',
				'label'		=> language_helper_is_th($this)?'ที่อยุ่ปัจจุบัน':'Address',
				'rules'		=> 'trim|required|max_length[1000]'
			),
			array(
				'field'		=> 'tel',
				'label'		=> language_helper_is_th($this)?'เบอร์ติดต่อ':'Phone Number',
				'rules'		=> 'trim|required|integer|exact_length[10]'
			),
			array(
				'field'		=> 'email',
				'label'		=> 'E-mail',
				'rules'		=> 'trim|required|valid_email|max_length[255]'
			),
			array(
				'field'		=> 'job',
				'label'		=> language_helper_is_th($this)?'อาชีพ':'Career',
				'rules'		=> 'trim|max_length[255]'
			),
			array(
				'field'		=> 'job_area',
				'label'		=> language_helper_is_th($this)?'สถานที่ทำงาน/เรียน':'Work place/Institution',
				'rules'		=> 'trim|max_length[255]'
			),
			array(
				'field'		=> 'favorite_artist',
				'label'		=> language_helper_is_th($this)?'ศิลปินคนโปรด':'Favorite artist/band',
				'rules'		=> 'trim|required|max_length[255]'
			)
		);
	}

	function get_profile_rules(){
		return array(
			array(
				'field'		=> 'password_old',
				'label'		=> language_helper_is_th($this)?'รหัสผ่านเดิม':'Old Password',
				'rules'		=> 'trim|xss_clean|md5|callback_check_profile_pass_old'
			),
			array(
				'field'		=> 'password_new',
				'label'		=> language_helper_is_th($this)?'รหัสผ่านใหม่':'New Password',
				'rules'		=> 'trim|min_length[6]|max_length[50]|xss_clean|md5|callback_check_profile_pass_new'
			),
			array(
				'field'		=> 'question',
				'label'		=> 'คำถามกันลืมรหัสผ่าน',
				'rules'		=> 'trim|required'
			),
			array(
				'field'		=> 'answer',
				'label'		=> language_helper_is_th($this)?'คำตอบ':'Answer',
				'rules'		=> 'trim|required|max_length[255]'
			),
			array(
				'field'		=> 'code',
				'label'		=> language_helper_is_th($this)?'รหัสบัตรประชาชน':'ID-Card',
				'rules'		=> 'trim|required|integer|exact_length[13]'
			),
			array(
				'field'		=> 'thName',
				'label'		=> language_helper_is_th($this)?'ชื่อ - นามสกุล':'Name - Surname',
				'rules'		=> 'trim|required|max_length[255]'
			),
			array(
				'field'		=> 'enName',
				'label'		=> language_helper_is_th($this)?'ชื่อ - นามสกุล (ภาษาอังกฤษ)':'Name - Surname (English Language)',
				'rules'		=> 'trim|required|max_length[255]'
			),
			array(
				'field'		=> 'nickName',
				'label'		=> language_helper_is_th($this)?'ชื่อเล่น':'Nickname',
				'rules'		=> 'trim|required|max_length[100]'
			),
			array(
				'field'		=> 'sex',
				'label'		=> 'เพศ',
				'rules'		=> 'trim|required|max_length[1]'
			),
			array(
				'field'		=> 'birth_date',
				'label'		=> 'วัน',
				'rules'		=> 'trim|required'
			),
			array(
				'field'		=> 'birth_month',
				'label'		=> 'เดือน',
				'rules'		=> 'trim|required'
			),
			array(
				'field'		=> 'birth_year',
				'label'		=> 'ปี',
				'rules'		=> 'trim|required'
			),
			array(
				'field'		=> 'address',
				'label'		=> language_helper_is_th($this)?'ที่อยุ่ปัจจุบัน':'Address',
				'rules'		=> 'trim|required|max_length[1000]'
			),
			array(
				'field'		=> 'tel',
				'label'		=> language_helper_is_th($this)?'เบอร์ติดต่อ':'Phone Number',
				'rules'		=> 'trim|required|integer|exact_length[10]'
			),
			array(
				'field'		=> 'email',
				'label'		=> 'E-mail',
				'rules'		=> 'trim|required|valid_email|max_length[255]'
			),
			array(
				'field'		=> 'job',
				'label'		=> language_helper_is_th($this)?'อาชีพ':'Career',
				'rules'		=> 'trim|max_length[255]'
			),
			array(
				'field'		=> 'job_area',
				'label'		=> language_helper_is_th($this)?'สถานที่ทำงาน/เรียน':'Work place/Institution',
				'rules'		=> 'trim|max_length[255]'
			),
			array(
				'field'		=> 'favorite_artist',
				'label'		=> language_helper_is_th($this)?'ศิลปินคนโปรด':'Favorite artist/band',
				'rules'		=> 'trim|required|max_length[255]'
			)
		);
	}

}