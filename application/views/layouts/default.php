<?php
	$sv = '?v=1.5';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Pragma" content="no-cache" />
	<title>ขโมยซีน CONCERT - THE UNSEEN SHOW LIVE IN ท่าพระจันทร์</title>
	<script type="text/javascript">
		var __base_url = '<?= base_url() ?>',
			__site_url = '<?= site_url('/') ?>',
			__not_show_term = <?= (get_cookie('not_show_term_popup')==1)?'true':'false' ?>;
	</script>

	<script type="text/javascript" src="<?= base_url('/js/lib/jquery-1.8.3.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('/js/lib/jquery.bgiframe.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('/js/lib/jquery.numeric.js') ?>"></script>

	<script type="text/javascript" src="<?= base_url('/js/lib/jquery.qtip/jquery.qtip.min.js') ?>"></script>
	<link href="<?= base_url('/js/lib/jquery.qtip/jquery.qtip.min.css') ?>" type="text/css" rel="stylesheet" />

	<link href="<?= base_url('/css/fonts/ThaiSansNeue/font.css'.$sv) ?>" type="text/css" charset="utf-8" rel="stylesheet" />
	<link href="<?= base_url('/css/fonts/THKrub/font.css'.$sv) ?>" type="text/css" charset="utf-8" rel="stylesheet" />
	<link href="<?= base_url('/css/'.(language_helper_is_en($this)?'en':'th').'/style.css'.$sv) ?>" type="text/css" charset="utf-8" rel="stylesheet" />
	<link href="<?= base_url('/css/'.(language_helper_is_en($this)?'en':'th').'/menu.css'.$sv) ?>" type="text/css" rel="stylesheet" />

	<!-- boostrap -->
	<link href="<?= base_url('/css/bootstrap/css/bootstrap.min.css'.$sv) ?>" type="text/css" charset="utf-8" rel="stylesheet" />
	<script type="text/javascript" src="<?= base_url('/css/bootstrap/js/bootstrap.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('/css/bootstrap/js/bootbox.min.js') ?>"></script>
	<!-- end boostrap -->

	<script type="text/javascript" src="<?= base_url('/js/common.js'.$sv) ?>"></script>

</head>

<body>
	<div id="container">
		<!--
		<?=$this->load->view('includes/inc-language-menu','', TRUE)?>
		-->
		<?=$this->load->view('includes/inc-member-menu','', TRUE)?>
		<?=$view?>
		<span id="footer" style="position:absolute; bottom:20px; right:30px; display:block; height:16px; font-size:14px; color:#808184;">ติดต่อสอบถาม 02-938-5959</span>
	</div>

<?php
	$popup = $this->input->get('popup');
	if(!empty($popup)):
		$msg = '';
		$type = 'alert';
		if($popup=='zone-booked-limit-popup')
			$msg = 'ท่านสามารถจองบัตรได้เพียง 1 ครั้งเท่านั้น';
?>
<script type="text/javascript"> $(function(){
	<?php if($type=='alert'): ?>
	bootbox.alert('<?= $msg ?>');
	<?php endif; ?>
	});
</script>
<?php endif; ?>
</body>
</html>