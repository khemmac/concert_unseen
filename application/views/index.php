<style type="text/css">
	#content-body { padding-top:40px; }
	<?php if(!is_user_session_exist($this)): ?>
	.page-index {
		background:transparent url('<?= base_url('images/th/home/bg_prelogin.jpg') ?>') no-repeat 15px 72px;
	}
	<?php else: ?>
	.page-index {
		background:transparent url('<?= base_url('images/th/home/bg_postlogin.jpg') ?>') no-repeat 0px 106px;
	}
	<?php endif; ?>
</style>
<div id="content-body" class="page-index">
	<!--
	<div style="width:883px; height:37px; position:absolute; bottom:109px; left:60px; background:transparent url('<?= base_url('images/th/home/bottom-text.png') ?>') no-repeat;"></div>
	-->
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>
	<?php
		if(!is_user_session_exist($this)):
	?>
	<div id="content">
		<object width="354" height="284" style="position:absolute; top:201px; left:594px;">
            <param name="movie" value="http://www.youtube.com/v/GGHF7i0Pi48?>?autoplay=1&version=3&amp;hl=en_US&amp;rel=0">
            </param>
            <param name="allowFullScreen" value="true">
            </param>
            <param name="allowscriptaccess" value="always">
            </param>
            <param name="wmode" value="transparent">
            </param>
            <embed width="354" height="284" src="http://www.youtube.com/v/GGHF7i0Pi48?autoplay=1&version=3&amp;hl=en_US&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="transparent">
            </embed>
        </object>
	<?php
		if(!is_user_session_exist($this)):
	?>
		<?php if(false)://(!period_helper_close_booking()): // ถ้ายังไม่ปิด ?>
		<a href="<?= site_url('member/login') ?>"
			style="position:absolute; bottom:50px; left:264px; display:block; text-indent:-3000px; background:transparent url('<?= base_url('images/'.(language_helper_is_en($this)?'en':'th').'/home/buttons.gif') ?>') no-repeat 0px -104px; width:482px; height:53px;"
			>ซื้อบัตร Presale</a>
		<?php else: // ถ้ายังไม่ปิด ?>
		<a href="<?= site_url('member/login') ?>"
			style="position:absolute; bottom:218px; left:440px; display:block; text-indent:-3000px; background:transparent url('<?= base_url('images/th/home/b-login.png') ?>') no-repeat 0px 0px; width:140px; height:55px;"
			>LOGIN</a>
		<?php endif; ?>
	<?php endif; ?>
	</div>
<div style="position:absolute; bottom:5px; left:10px;">
    <!-- hitwebcounter Code START -->
    <a href="javascript:void(0);">
        <img src="http://hitwebcounter.com/counter/counter.php?page=5085738&style=0025&nbdigits=5&type=ip&initCount=0" title="k-pop fastival" Alt="Counter HTML Coding"   border="0" >
    </a>
    <br/>
    <!-- hitwebcounter.com -->
    <!--
    <a href="http://www.hitwebcounter.com/" title="Welcome Hits"
    target="_blank" style="font-family: Arial, Helvetica, sans-serif;
    font-size: 10px; color: #6E6A68; text-decoration: none ;"><em>Welcome Hits</em>
    </a>-->


</div>
	<?php else: ?>

	<?php endif; ?>
</div>

<script type="text/javascript">
	$(function(){
		if(!__not_show_term)
			common.showConditionPopup();
	});
</script>