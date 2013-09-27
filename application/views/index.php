<div id="content-body" class="page-index">
	<!--
	<div style="width:883px; height:37px; position:absolute; bottom:109px; left:60px; background:transparent url('<?= base_url('images/th/home/bottom-text.png') ?>') no-repeat;"></div>
	-->
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
	<?php
		if(!is_user_session_exist($this)):
	?>
		<?php if(false)://(!period_helper_close_booking()): // ถ้ายังไม่ปิด ?>
		<a href="<?= site_url('member/login') ?>"
			style="position:absolute; bottom:50px; left:264px; display:block; text-indent:-3000px; background:transparent url('<?= base_url('images/'.(language_helper_is_en($this)?'en':'th').'/home/buttons.gif') ?>') no-repeat 0px -104px; width:482px; height:53px;"
			>ซื้อบัตร Presale</a>
		<?php else: // ถ้ายังไม่ปิด ?>
		<a href="<?= site_url('member/login') ?>"
			style="position:absolute; bottom:117px; left:440px; display:block; text-indent:-3000px; background:transparent url('<?= base_url('images/th/home/b-login.png') ?>') no-repeat 0px 0px; width:140px; height:55px;"
			>LOGIN</a>
		<?php endif; ?>
	<?php endif; ?>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		if(!__not_show_term)
			common.showConditionPopup();
	});
</script>