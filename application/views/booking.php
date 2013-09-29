<style type="text/css">
	#content-body { padding:220px 0px 50px 0px; min-height:400px; }
</style>

<div id="content-body" class="page-booking">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<div class="header">
			<h4 style="position:absolute; top:120px; left:80px;">คุณ <?= $person['thName'] ?></h4>
			<h4 style="position:absolute; top:160px; left:80px;">เลขที่บัตรประชาชน <?= $person['code'] ?></h4>
			<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered"
				style="width:200px; position:absolute; right:80px; top:120px;">
				<tr class="warning"><td class="text-error" style="text-align:center;"><strong>รหัสการจอง</strong></td></tr>
				<tr><td style="text-align:center;"><?= $booking_data['code'] ?></td></tr>
			</table>
		</div>
		<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" style="width:850px; margin:0 auto;">
			<tr class="info">
				<td style="width:70px; text-align: center;" class="no"><strong>รายการ</strong></td>
				<td style="width:127px; text-align: center;" class="zone"><strong>โซนที่นั่ง</strong></td>
				<td style="width:133px; text-align: center;" class="seat-count"><strong>จำนวนที่นั่ง</strong></td>
				<td style="width:133px; text-align: center;" class="item-price"><strong>ราคาต่อหน่วย</strong></td>
				<td style="width:80px; text-align: center;" class="price"><strong>ราคา</strong></td>
				<td style="width:133px; text-align: center;" class="status"><strong>สถานะ</strong></td>
			</tr>
<?php
	function get_seat_by_zone($seat_list, $z_name){
		$r = array();
		foreach($seat_list AS $o_seat){
			if($o_seat['zone_name']==$z_name)
				array_push($r, $o_seat['seat_name']);
		}
		return $r;
	}
	function get_zone_price($seat_list, $z_name){
		foreach($seat_list AS $o_seat){
			if($o_seat['zone_name']==$z_name)
				return $o_seat['price'];
		}
		return 0;
	}

	$has_discount = cal_helper_valid_discount_code($booking_data['discount_code']);

	$sum_price = cal_helper_get_sum_price($booking_list);
	$card_fee = cal_helper_get_card_fee($booking_list);
	$discount = cal_helper_get_discount($booking_list, $has_discount);
	$total = cal_helper_get_total_price($booking_list, $has_discount);
	foreach($zone_list AS $key_z => $z):
		$seat_list = get_seat_by_zone($booking_list, $z);
		$zone_price = get_zone_price($booking_list, $z);

?>
			<tr class="tbody <?= ($key_z==0)?'first':'' ?>">
				<td style="text-align:center;"><?= $key_z+1 ?></td>
				<td style="text-align:center;"><?= strtoupper($z) ?></td>
				<!--td class="seat-no"><?= strtoupper(implode(', ', $seat_list)) ?></td-->
				<td style="text-align:center;"><?= count($seat_list) ?></td>
				<td style="text-align:right;"><?= number_format($zone_price) ?></td>
				<td style="text-align:right;"><?= number_format($zone_price * count($seat_list)) ?></td>
				<?php if($key_z==0): ?>
					<td style="text-align:center; vertical-align:middle;" rowspan="<?= count($zone_list) + (4+((!empty($discount) && $discount>0)?1:0)) ?>" valign="middle" style="padding:5px;">
						กรุณาชำระเงิน<br />ภายในวันที่
						<?= util_helper_format_date(util_helper_add_one_day($booking_data['booking_date'])) ?>
						<br />ก่อนเวลา <?= util_helper_format_time(util_helper_add_one_day($booking_data['booking_date'])) ?>
					</td>
				<?php endif; ?>
			</tr>
<?php endforeach; ?>
			<tr>
				<td colspan="4" style="text-align:right;">ราคารวม</td>
				<td style="text-align:right;"><?= number_format($sum_price) ?></td>
			</tr>
			<tr>
				<td colspan="4" style="text-align:right;">เงินตรวจสอบโอน</td>
				<td style="text-align:right;">0.<?= str_pad(substr($booking_data['id'], -2), 2, '0', STR_PAD_LEFT) ?></td>
			</tr>
			<tr>
				<td colspan="4" style="text-align:right;">ค่าธรรมเนียมการออกบัตร (20 บาทต่อใบ)</td>
				<td style="text-align:right;"><?= number_format($card_fee) ?></td>
			</tr>
			<?php if(!empty($discount) && $discount>0): ?>
				<tr>
					<td colspan="4" style="text-align:right;">
						ส่วนลด 10%
					</td>
					<td style="text-align:right;"><?= number_format($discount) ?></td>
				</tr>
			<?php endif; ?>
			<tr class="tbody last">
				<td colspan="4" style="text-align:right;">ราคารวมทั้งหมด</td>
				<td style="text-align:right;"><strong><?= number_format($total) ?>.<?= str_pad(substr($booking_data['id'], -2), 2, '0', STR_PAD_LEFT) ?></strong></td>
			</tr>
		</table>

		<table cellpadding="3" cellspacing="0" class="table table-bordered" style="width:850px; margin:0 auto; margin-top:15px;">
		<?php
			$rounds = seat_helper_populate_round_data($booking_list);
			foreach($rounds AS $r_key => $r_val):
				$zone_list = array();
		?>
				<tr class="success"><td colspan="2"><h4 style="text-align:center;">
					<?php
						if($r_key==1)
							echo 'รอบที่ 1 วันที่ 19 ตุลาคม 2556 เวลา 19.00 น.';
						elseif($r_key==2)
							echo 'รอบที่ 2 วันที่ 20 ตุลาคม 2556 เวลา 19.00 น.';
					?>
				</h4></td></tr>
				<tr>
					<th style="text-align:center;">โซนที่นั่ง</th>
					<th style="text-align:center;">เลขที่นั่ง</th>
				</tr>
		<?php
				foreach($r_val AS $zone_key => $zone_val):
					$seat_list = array();
		?>
					<tr>
						<td  style="text-align:center;"><?= strtoupper($zone_key) ?></td>
						<td style="text-align:center;"><?= strtoupper(implode(', ', $zone_val)) ?></td>
					</tr>
		<?php
				endforeach;
			endforeach;
		?>
		</table>

		<table cellpadding="0" cellspacing="0" border="0" style="width:850px; margin:0 auto;">
			<tr class="tfoot-text">
				<td>
					<h4 style="margin:20px 0px 0px 20px; padding:0px;">เงื่อนไขการชำระเงิน</h4>
					<ol style="margin:5px 0px 0px 70px; padding:0px;">
						<li><?= language_helper_is_th($this)?'กรุณาชำระผ่านธนาคารดังต่อไปนี้ (ชื่อบัญชี บริษัท บูสท์ พลัส จำกัด / Boost Plus Co.,Ltd.)':'Please note that money transfers should be sent to (ชื่อบัญชี บริษัท บูสท์ พลัส จำกัด / Boost Plus Co.,Ltd.)' ?>
							<table cellpadding="2" cellspacing="0" border="0">
								<tr>
									<td valign="middle">
										&nbsp;<img src="<?= base_url('images/th/common/blank.gif') ?>" style="width:13px; height:17px; background:transparent url('<?= base_url('images/th/booking/bank-logo.gif') ?>') no-repeat 0px 0px;" />&nbsp;
									</td>
									<td><?= language_helper_is_th($this)?'
										ธนาคารกรุงเทพ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										สาขาลาดพร้าว
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										บัญชีกระแสรายวัน เลขที่บัญชี'
										:'Bangkok Bank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Latphrao
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Current account
										Account number' ?>
										129-3-16258-0
									</td>
								</tr>
								<tr>
									<td valign="middle">
										&nbsp;<img src="<?= base_url('images/th/common/blank.gif') ?>" style="width:13px; height:17px; background:transparent url('<?= base_url('images/th/booking/bank-logo.gif') ?>') no-repeat 0px -17px;" />&nbsp;
									</td>
									<td><?= language_helper_is_th($this)?'
										ธนาคารกสิกรไทย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										สาขาลาดพร้าวซอย10
										&nbsp;&nbsp;&nbsp;
										บัญชีกระแสรายวัน เลขที่บัญชี'
										:'K-Bank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Latphrao10
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;
										Current account
										Account number' ?>
										752-1-02075-4
									</td>
								</tr>
								<tr>
									<td valign="middle">
										&nbsp;<img src="<?= base_url('images/th/common/blank.gif') ?>" style="width:13px; height:17px; background:transparent url('<?= base_url('images/th/booking/bank-logo.gif') ?>') no-repeat 0px -34px;" />&nbsp;
									</td>
									<td><?= language_helper_is_th($this)?'
										ธนาคารไทยพาณิชย์&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										สาขาลาดพร้าวซอย10
										&nbsp;&nbsp;&nbsp;
										บัญชีกระแสรายวัน เลขที่บัญชี'
										:'SCB&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Latphrao10
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;
										Current account
										Account number' ?>
										047-3-03581-2
									</td>
								</tr>
							</table>
						</li>
						<li>กรุณาชำระเงินพร้อมแจ้งยืนยันการชำระเงินผ่านระบบ ภายใน 24 ชั่วโมง
							หากไม่แจ้งยืนยันการชำระเงินภายในเวลาดังกล่าว มิฉะนั้นจะถือว่าท่านสละสิทธิ์ในการจองบัตร รายละเอียดการจองของท่านจะถูกลบจากระบบ
							โดยทางผู้จัดจะไม่รับผิดชอบใดๆทั้งสิ้น
						</li>
						<li>กรุณานำหลักฐานการชำระเงินมายืนยันการแจ้งโอนเงิน ผ่านทาง <a href="http://www.boostplus.co.th" target="_blank">www.boostplus.co.th</a> ในหัวยืนยันการชำระเงิน
						</li>
						<li>
							หากแจ้งโอนเงินเรียบร้อยแล้ว กรุณาตรวจสอบสถานะการจอง หลังจากแจ้งโอนเงินในเวลาประมาณ 48 ชม. (ไม่นับวันหยุดราชการ)
						</li>
					</ol>
				</td>
			</tr>
			<tr>
				<td align="center"
					style="height:36px; width:719px; padding:10px 0px 10px 0px;" class="text-error">
					<?= language_helper_is_th($this)?
						'* หมายเหตุ สามารถตรวจสอบสถานะการโอนเงินได้ผ่านทางหัวข้อ &quot;ตรวจสอบสถานะ&quot;'
						:'* Your booking status can be tracking at "Payment status" / "Booking status"'
					?>
				</td>
			</tr>
			<tr align="center">
				<td>
					<a href="<?= site_url('zone_entrance') ?>" class="btn">ตกลง</a>
				</td>
			</tr>
		</table>

	</div>
</div>
<script type="text/javascript">
	$(function(){
		// show ของแถม popup
		bootbox.alert('<h5 class="text-center">ทำรายการเสร็จสิ้น</h5><p class="text-center">ท่านสามารถตรวจสอบรายละเอียดการจองได้ในอีเมล์ของท่าน</p>');
	});
</script>
