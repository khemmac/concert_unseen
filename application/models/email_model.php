<?php
Class Email_model extends CI_Model
{
	protected function send_mailer($reciever, $subject, $body){
		require("./application/libraries/phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet		= "utf-8";
		$mail->Host			= "ssl://smtp.gmail.com";
		$mail->Port			= "465";
		$mail->SMTPAuth		= true;
		$mail->Username		= "sbs.mtv.2013@gmail.com";
		$mail->Password		= "boost1234";

		$mail->From			= "sbs.mtv.2013@gmail.com";
		$mail->FromName		= "Boostplus";
		$mail->AddAddress($reciever);
		$mail->AddBCC('khemmac@hotmail.com');
		$mail->AddBCC('khemmac@gmail.com');
		$mail->AddBCC('aon.iti10@gmail.com');
		$mail->AddBCC('aon_iti10@hotmail.com');
		$mail->AddBCC('SBS.mtv.2013@gmail.com');
		$mail->IsHTML(true);
		$mail->Subject		=  $subject;
		$mail->Body			= $body;
		$result = $mail->send();
	}

	public function send_register_success($user_data){
		$reciever = $user_data['email'];
		$subject = 'ยินดีต้อนรับผู้จองบัตร Early Bird & Presale';
		$body = $this->load->view('email/register-success', $user_data, true);
		$this->send_mailer($reciever, $subject, $body);
	}

	public function send_profile_success($user_data){
		$reciever = $user_data['email'];
		$subject = 'ข้อมูลการแก้ไขรหัสผ่าน SBS MTV 2013';
		$body = $this->load->view('email/profile-success', $user_data, true);
		$this->send_mailer($reciever, $subject, $body);
	}

	public function send_forgot_success($user_data){
		$reciever = $user_data['email'];
		$subject = 'ลืมรหัสผ่าน SBS MTV 2013';
		$body = $this->load->view('email/forgot-success', $user_data, true);
		$this->send_mailer($reciever, $subject, $body);
	}

	public function send_booking_submit($user_id, $booking_id){
		$data = $this->booking_model->prepare_print_data($user_id, $booking_id);
		$reciever = $data['person']['email'];
		$subject = 'หลักฐานการจองบัตรคอนเสิร์ต SBS MTV 2013';
		$body = $this->load->view('email/booking-submit-success', $data, true);
		$this->send_mailer($reciever, $subject, $body);
	}

	public function test(){
		require("./application/libraries/phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet		= "utf-8";
		$mail->Host			= "ssl://smtp.gmail.com";
		$mail->Port			= "465";
		$mail->SMTPAuth		= true;
		$mail->Username		= "sbs.mtv.2013@gmail.com";
		$mail->Password		= "boost1234";

		$mail->From			= "sbs.mtv.2013@gmail.com";
		$mail->FromName		= "Boostplus";
		$mail->IsHTML(true);

		for($i=1;$i<=3;$i++){
			$mail->AddAddress('khemmac@gmail.com');
			$mail->Subject		=  'test multiple '.$i;
			$mail->Body			= 'test multiple body '.$i;
			$result = $mail->send();

			$mail->ClearAddresses();
		}
	}
	
	public function approve_tranfer($user_data){
		$reciever = $user_data['email'];
		$subject = 'ยืนยันการแจ้งโอนเงิน';
		$body = $this->load->view('email/approve-tranfer-notify', $user_data, true);
		$this->send_mailer($reciever, $subject, $body);
		$res = array("success"=>true);
		return $res;
	}
}
