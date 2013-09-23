<div id="content-body" class="page-zone-early-soldout">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
<?php if(true)/*($is_reserved)*/: ?>
		<img src="<?= base_url("/images/zone/plan-early-soldout.gif") ?>"
			style="width:590px; height:623px; position:absolute; top:115px; left:203px;" />
<?php else: ?>
		<img src="<?= base_url("/images/zone/plan-early-soldout.gif") ?>"
			style="width:590px; height:623px; position:absolute; top:115px; left:28px;" />
		<div style="position:absolute; top:130px; left:656px; padding:30px 10px 0px 10px; text-align: center;
			width:284px; height:304px; color:white; font-size:12px; background:transparent url('<?= base_url('images/zone/early-text-bg.png') ?>') no-repeat;">
			ขณะนี้บัตรในรอบ Early bird ได้ถูกจองเต็มจำนวนแล้ว
สำหรับผู้ที่พลาดโอกาส ท่านสามารถลงทะเบียนเพื่อรับสิทธิ์ ในการสำรองทีนั่ง
ในกรณีที่มีผู้สละสิทธิ์การจอง ท่านจะได้รับสิทธิ์ในการจองที่นั่ง
โดยเลือกจำนวนที่นั่งที่ต้องการ
และกดปุ่ม waiting list ด้านล่าง
			<br />
			<br />
			<?= form_open('zone_early/soldout_submit') ?>
			<select name="amount">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
			</select>
			<br />
			<br />
			<input type="submit" value="waiting list" />
			<?= form_close() ?>
		</div>
<?php endif; ?>
	</div>
</div>