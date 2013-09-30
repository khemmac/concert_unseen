<?php
	$p=(isset($_GET['page']))?$_GET['page']:uri_string();
?>
<?php if(is_user_session_exist($this)): ?>
<ul id="menu-2" class="menu-main">
	<li><a href="<?= site_url('index') ?>" class="menu-boost">BOOST PLUS</a></li>
	<li><a href="https://www.facebook.com/boostplus" target="_blank" class="menu-facebook">FACEBOOK</a></li>
	<li><a href="<?= site_url('zone_entrance') ?>" class="menu-1">จำหน่ายบัตร</a></li>
	<li><a href="<?= site_url('transfer') ?>" class="menu-2">ยืนยันการชำระเงิน</a></li>
	<li><a href="<?= site_url('booking/check') ?>" class="menu-3">ตรวจสอบสถานะ</a></li>
	<li><a href="#condition" class="menu-4">เงื่อนไข</a></li>
</ul>
<?php elseif($p=='member/register' || $p=='member/register_success'): ?>
<ul id="menu-3" class="menu-main">
	<li><a href="<?= site_url('index') ?>" class="menu-boost"></a></li>
	<li><a href="https://www.facebook.com/boostplus" target="_blank" class="menu-facebook">FACEBOOK</a></li>
	<li class="menu-register"></li>
</ul>
<?php else: ?>
<ul id="menu-1" class="menu-main">
	<li><a href="<?= site_url('index') ?>" class="menu-boost"></a></li>
	<li><a href="https://www.facebook.com/boostplus" target="_blank" class="menu-facebook">FACEBOOK</a></li>
	<li><a href="#condition" class="menu-1"></a></li>
	<li><a href="<?= site_url('plan') ?>" class="menu-2"></a></li>
	<li><a href="<?= site_url('contact') ?>" class="menu-3"></a></li>
</ul>
<?php endif; ?>