<style type="text/css">
	#content-body { padding:220px 0px 50px 0px; min-height:400px; }
</style>
<div id="content-body" class="page-booking-complete">
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
					<td style="text-align:center;" rowspan="<?= count($zone_list) + (4+((!empty($discount) && $discount>0)?1:0)) ?>" valign="middle" align="center" style="padding:5px;">
					<?php if($booking_data['status']==4): ?>
						ชำระเงินแล้ว
						<br />วันที่ <?= util_helper_format_date(util_helper_parse_date($booking_data['pay_date'])) ?>
						<br />เวลา <?= util_helper_format_time(util_helper_parse_date($booking_data['pay_date'])) ?>
					<?php elseif($booking_data['status']==3): ?>
						เจ้าหน้าที่กำลังตรวจสอบการโอนเงินของท่าน
					<?php elseif($booking_data['status']==2): ?>
						กรุณาชำระเงิน<br />ภายในวันที่
						<?= util_helper_format_date(util_helper_add_one_day($booking_data['booking_date'])) ?>
						<br />ก่อนเวลา <?= util_helper_format_time(util_helper_add_one_day($booking_data['booking_date'])) ?>
					<?php else: ?>
						-
					<?php endif; ?>
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

<?php if($booking_data['status']==4): ?>
		<table cellpadding="4" cellspacing="0" border="0" style="width:850px; margin:0 auto;">
			<tr>
				<td><h4 class="text-center">การชำระเงินเสร็จสิ้น ขอบคุณที่ใช้บริการ</h4>
				</td>
			</tr>
			<tr>
				<td align="center">
						กรุณาพิมพ์หลักฐานฉบับนี้ไว้ พร้อมบัตรประชาชนตัวจริง เพื่อนำมารับบัตร
						<br />ในวันงานคอนเสิร์ตขโมยซีนวันที่ 19/10/2013
						<br />เวลาและสถานที่จะแจ้งให้ทราบอีกครั้ง
				</td>
			</tr>
			<tr>
				<td align="center" valign="bottom" style="height:60px;">
					<a href="<?= site_url('pdf/print_booking_complete/'.$booking_data['id']).'?print=1' ?>" class="btn btn-primary" target="_blank">PRINT</a>
					<a href="<?= site_url('pdf/print_booking_complete/'.$booking_data['id']) ?>" class="btn btn-primary">SAVE</a>
				</td>
			</tr>
		</table>
<?php endif; ?>

	</div>
</div>
