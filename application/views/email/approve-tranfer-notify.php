<div style="background:#000000; width:800px; height:1378px;">
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
							<strong style="color:white;">ยืนยันการแจ้งโอนเงิน</strong>
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
							<div> รหัสจอง : <span> <?= $code ?></span></div> 
							<div> วันที่โอน : <span> <?= $pay_date ?></span></div>  
							<div> จำนวนเงินที่โอน : <span> <?= $pay_money ?></span></div> 
							<div> ธนาคารที่โอน : <span> <?= $bank_name ?></span></div> 
						</td>
						<td width="190"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="40"></td>
		</tr>
		<tr>
			<td height="40">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
					<tr>
						<td width="190"></td>
						<td align="center" style="background-color:#18171c; color:#ffffff;">
							<p>ทางทีมงานจะดำเนินการตรวจสอบข้อมูลการโอนเงินของท่าน</p>
							<p>และดำเนินการอัพเดทสถานะการโอนเงินของท่าน ภายใน 48 ชม </p>
							<p>(ไม่นับวัดหยุดราชการ)</p>
						</td>
						<td width="190"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="40"></td>
		</tr>
		<tr>
			<td height="50" align="center">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
					<tr>
						<td width="190"></td>
						<td align="center" style="background-color:#DDDF00;">
							<p>ท่านสามารถตรวจสอบสถานะการโอนเงินได้</p>
							<p>จากปุ่ม "ตรวจสอบสถานะบัตร"</p>
						</td>
						<td width="190"></td>
					</tr>
					<tr>
						<td width="190"></td>
						<td align="center" style="color:red;">
							<p>* กรุณาตรวจสอบข้อมูลให้ถูกต้องก่อนกดปุ่ม "ยืนยัน"</p>
						</td>
						<td width="190"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="100">&nbsp;
			<hr />
			</td>
		</tr>
		<tr>
			<td height="28">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
					<tr>
						<td width="190"></td>
						<td align="center" style="background-color:#18171c;">
							<strong style="color:white;">Payment Confirmation</strong>
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
							<div> Booking Id : <span> <?= $code ?></span></div> 
							<div> Date of transfer : <span> <?= $pay_date ?></span></div>  
							<div> Amount : <span> <?= $pay_money ?></span></div> 
							<div> Bank  : <span> <?= $bank_name ?></span></div> 
						</td>
						<td width="190"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="40"></td>
		</tr>
		<tr>
			<td height="40">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
					<tr>
						<td width="190"></td>
						<td align="center" style="background-color:#18171c; color:#ffffff;">
							<p>The system will verify your payment information </p>
							<p>and will update your payment status within 48 hours </p>
							<p>(except on public holiday)</p>
						</td>
						<td width="190"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="40"></td>
		</tr>
		<tr>
			<td height="50" align="center">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
					<tr>
						<td width="190"></td>
						<td align="center" style="background-color:#DDDF00;">
							<p>You can track you payment status </p>
							<p>at "Booking Status"</p>
						</td>
						<td width="190"></td>
					</tr>
					<tr>
						<td width="190"></td>
						<td align="center" style="color:red;">
							<p>* Please make sure that you have completed all the fields correctly before submitting.</p>
						</td>
						<td width="190"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="190">&nbsp;</td>
		</tr>
		<tr>
			<td height="30" align="right"><span style="color:#444444"><?= language_helper_is_th($this)?'ติดต่อสอบถาม':'Contact' ?> 02-938-5959</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
</div>