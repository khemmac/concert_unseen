<style type="text/css">
	#content-body { padding:120px 0px 50px 0px; min-height:400px; }

	h2 {
		font-family:'thaisans_neue_blackregular';
	}
</style>

<div id="content-body" class="page-booking">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" style="width:450px; margin:0 auto;">
			<tr class="success">
				<td style="text-align: center;" colspan="2"><h2>ยืนยันการแจ้งโอนเงิน</h2></td>
			</tr>
			<tr>
				<td style="text-align: right;"><strong>รหัสจอง :</strong></td>
				<td><?= $booking_data['code'] ?></td>
			</tr>
			<tr>
				<td style="text-align: right;"><strong>วันที่โอน :</strong></td>
				<td><?= $booking_data['pay_date'] ?></td>
			</tr>
			<tr>
				<td style="text-align: right;"><strong>จำนวนเงินที่โอน :</strong></td>
				<td><?= number_format($booking_data['pay_money'],2) ?></td>
			</tr>
			<tr>
				<td style="text-align: right;"><strong>ธนาคารที่โอน :</strong></td>
				<td><?= $booking_data['bank_name'] ?></td>
			</tr>
		</table>
		<br /><br />
		<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" style="width:450px; margin:0 auto;">
			<tr class="info">
				<td style="text-align: center;">
					ทางทีมงานจะดำเนินการตรวจสอบข้อมูลการโอนเงินของท่าน
					<br />และดำเนินการอัพเดทสถานะการโอนเงินของท่าน ภายใน 48 ชม
					<br />(ไม่นับวัดหยุดราชการ)
				</td>
			</tr>
		</table>
		<br /><br />
		<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" style="width:450px; margin:0 auto;">
			<tr class="warning">
				<td style="text-align: center;">
					ท่านสามารถตรวจสอบสถานะการโอนเงินได้
					<br />จากปุ่ม "ตรวจสอบสถานะบัตร"
				</td>
			</tr>
		</table>
		<br /><br />
		<div class="text-center">
			<a href="<?= site_url('booking/check') ?>" class="btn">ตกลง</a>
		</div>
	</div>
</div>
