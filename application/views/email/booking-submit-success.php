<div style="width:800px;">
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
			<td align="center"><h1>หลักฐานการจองบัตร SBS MTV 2013</h1></td>
		</tr>
		<tr>
			<td align="center">
				<table cellpadding="5" cellspacing="0" width="80%" border="0">
					<tr>
						<td>คุณ <?= $person['thName'] ?></td>
						<td align="center" rowspan="2"><strong style="font-weight:bold;">รหัสการจอง</strong><br /><?= $booking_data['code'] ?></td>
					</tr>
					<tr>
						<td>รหัสบัตรประชาชน <?= $person['code'] ?></td>
					</tr>
					<tr>
						<td colspan="2">อีเมล์ <?= $person['email'] ?></td>
					</tr>
					<tr>
						<td colspan="2">เบอร์โทรศัพท์ <?= $person['tel'] ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td height="30"></td></tr>
		<tr>
			<td align="center">
				<table cellpadding="4" cellspacing="0" width="90%" border="1">
					<tr>
						<td style="color:white; background-color:black; font-weight: bold; background-color:#18171c;" align="center">รายการ</td>
						<td style="color:white; background-color:black; font-weight: bold; background-color:#18171c;" align="center">โซนที่นั่ง</td>
						<td style="color:white; background-color:black; font-weight: bold; background-color:#18171c;" align="center">จำนวนที่นั่ง</td>
						<td style="color:white; background-color:black; font-weight: bold; background-color:#18171c;" align="center">ราคาต่อหน่วย</td>
						<td style="color:white; background-color:black; font-weight: bold; background-color:#18171c;" align="center">ราคา</td>
						<td style="color:white; background-color:black; font-weight: bold; background-color:#18171c;" align="center">สถานะ</td>
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

	$sum_price = cal_helper_get_sum_price($booking_list);
	$card_fee = cal_helper_get_card_fee($booking_list);
	$discount = cal_helper_get_discount($booking_data['type'], $booking_list);
	$total = cal_helper_get_total_price($booking_data['type'], $booking_list);
	foreach($zone_list AS $key_z => $z):
		$seat_list = get_seat_by_zone($booking_list, $z);
		$zone_price = get_zone_price($booking_list, $z);
?>
					<tr>
						<td align="center"><?= $key_z+1 ?></td>
						<td align="center"><?= strtoupper($z) ?></td>
						<td align="center"><?= count($seat_list) ?></td>
						<td align="center"><?= number_format($zone_price) ?></td>
						<td align="center"><?= number_format($zone_price * count($seat_list)) ?></td>
					<?php if($key_z==0): ?>
						<td align="center" valign="middle" rowspan="<?= count($zone_list) + (4+((!empty($discount) && $discount>0)?1:0)) ?>" valign="top" style="padding:5px;">
							กรุณาชำระเงิน
							<?php if($booking_data['type']==3): ?>
							<br />ภายในวันที่ 20/09/2013
							<br />ก่อนเวลา 18.00
							<?php elseif($booking_data['type']==2): ?>
							<br />ภายในวันที่ <?= util_helper_format_date(util_helper_add_six_hour(new DateTime())) ?>
							<br />ก่อนเวลา <?= util_helper_format_time(util_helper_add_six_hour(new DateTime())) ?>
							<?php else: ?>
							<br />ภายในวันที่ <?= util_helper_format_date(util_helper_add_four_hour(new DateTime())) ?>
							<br />ก่อนเวลา <?= util_helper_format_time(util_helper_add_four_hour(new DateTime())) ?>
							<?php endif; ?>
						</td>
					<?php endif; ?>
					</tr>
<?php endforeach; ?>
					<tr>
						<td align="right" colspan="4">ราคารวม</td>
						<td align="center"><?= number_format($sum_price) ?></td>
					</tr>
					<tr>
						<td align="right" colspan="4">เงินตรวจสอบโอน</td>
						<td align="center">0.<?= str_pad(substr($booking_data['id'], -2), 2, '0', STR_PAD_LEFT) ?></td>
					</tr>
					<tr>
						<td align="right" colspan="4">ค่าธรรมเนียมการออกบัตร (20 บาทต่อใบ)</td>
						<td align="center"><?= number_format($card_fee) ?></td>
					</tr>
					<?php if(!empty($discount) && $discount>0): ?>
						<tr class="tbody">
							<td align="right" colspan="4">
								ส่วนลด
								<?php if($booking_data['type']==2): ?>
									(500 บาทต่อใบ)
								<?php elseif($booking_data['type']==3): ?>
									(<?= cal_helper_get_discount_detail($booking_data['type'], $booking_list) ?>)
								<?php endif; ?>
							</td>
							<td align="center"><?= number_format($discount) ?></td>
						</tr>
					<?php endif; ?>
					<tr>
						<td align="right" colspan="4">ราคารวมทั้งหมด</td>
						<td align="center"><strong><?= number_format($total) ?>.<?= str_pad(substr($booking_data['id'], -2), 2, '0', STR_PAD_LEFT) ?></strong></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="20"></td>
		</tr>
		<tr>
			<td align="center">
				<table cellpadding="5" cellspacing="0" border="0" width="95%">
					<tr>
						<td>
							<h3>เงื่อนไขการชำระเงิน</h3>
							<ol>
								<li>กรุณาชำระผ่านธนาคารดังต่อไปนี้ (ชื่อบัญชี บริษัท บูสท์ พลัส จำกัด / Boost Plus Co.,Ltd.)
									<ul>
										<li>ธนาคารกรุงเทพ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										สาขาลาดพร้าว
										&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;
										บัญชีกระแสรายวัน เลขที่บัญชี
										129-3-16258-0
										</li>
										<li>ธนาคารกสิกรไทย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										สาขาลาดพร้าวซอย10
										&nbsp;&nbsp;&nbsp;
										บัญชีกระแสรายวัน เลขที่บัญชี
										752-1-02075-4
										</li>
										<li>ธนาคารไทยพาณิชย์&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										สาขาลาดพร้าวซอย10
										&nbsp;&nbsp;&nbsp;
										บัญชีกระแสรายวัน เลขที่บัญชี
										047-3-03581-2
										</li>
									</ul>
								</li>
								<li>ชำระเงินภายใน
							<?php if($booking_data['type']==3): ?>
							วันที่ 20/09/2013 ก่อนเวลา 18.00 น.
							<?php elseif($booking_data['type']==2): ?>
							6 ชั่วโมง
							<?php else: ?>
							4 ชั่วโมง
							<?php endif; ?>
									หากไม่ชำระเงินภายในเวลาดังกล่าว มิฉะนั้นจะถือว่าท่านสละสิทธิ์ในการจองบัตร รายละเอียดการจองของท่านจะถูกลบจากระบบ
									โดยทางผู้จัดจะไม่รับผิดชอบใดๆทั้งสิ้น
								</li>
								<li>กรุณานำหลักฐานการชำระเงินมายืนยันการแจ้งโอนเงิน ผ่านทาง <a href="http://www.boostplus.co.th" target="_blank">www.boostplus.co.th</a> ในหัวข้อแจ้งโอนเงิน
								</li>
								<li>หากแจ้งโอนเงินเรียบร้อยแล้ว กรุณาตรวจสอบสถานะการจอง หลังจากแจ้งโอนเงินในเวลาประมาณ 48 ชม. (ไม่นับวันหยุดราชการ)</li>
							</ol>
						</td>
					</tr>
					<tr><td height="20"></td></tr>
				    <tr>
				    	<td style="background-color:#ffa01f;" align="center">* หมายเหตุ  สามารถตรวจสอบสถานะการโอนเงินได้ผ่านทางหัวข้อ &quot;ตรวจสอบสถานะบัตร&quot;</td>
				    </tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="30" align="right"><span style="color:#444444">ติดต่อสอบถาม 02-938-5959</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
<!--
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
			<td height="100">&nbsp;</td>
		</tr>
		<tr>
			<td height="28">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
					<tr>
						<td width="190"></td>
						<td align="center" style="background-color:#18171c;">
							<strong style="color:white;">ผลการลงทะเบียนของคุณ</strong>
						</td>
						<td width="190"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="30">&nbsp;</td>
		</tr>
		<tr>
			<td height="50" align="center">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
					<tr>
						<td width="190"></td>
						<td align="center" style="background-color:#ffffff;">
							ยินดีต้อนรับผู้จองบัตร Early Bird &amp; Presale นะคะ
							<br />
							Username และ Password ของท่านคือ
						</td>
						<td width="190"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="40">&nbsp;</td>
		</tr>
		<tr>
			<td height="50" align="center">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
					<tr>
						<td width="190"></td>
						<td align="center" style="background-color:#18171c;">
							<strong style="color:white;">Username : <?= $username ?></strong>
							<br /><br />
							<strong style="color:white;">Password : <?= $password ?></strong>
						</td>
						<td width="190"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="290">&nbsp;</td>
		</tr>
		<tr>
			<td height="30" align="right"><span style="color:#444444">ติดต่อสอบถาม 02-938-5959</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
-->
</div>