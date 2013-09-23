<div style="background:#000000 url(<?= base_url('images/email/bg-register.jpg') ?>); width:800px; height:650px;">
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
							<strong style="color:white;"><?= language_helper_is_th($this)?'ผลการลงทะเบียนของคุณ':'Your registration result' ?></strong>
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
							<?php if(language_helper_is_th($this)): ?>
							ยินดีต้อนรับผู้จองบัตร Early Bird &amp; Presale
							<br />
							Username และ Password ของท่านคือ
							<?php else: ?>
							Welcome to Early Bird &amp; Presale
							<br />
							Your Username and Password are
							<?php endif; ?>
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
			<td height="30" align="right"><span style="color:#444444"><?= language_helper_is_th($this)?'ติดต่อสอบถาม':'Contact' ?> 02-938-5959</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
</div>