<div id="content-body" class="page-forgot">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="dialog" class="step1">
		<div id="step-mask"></div>
		<?= form_open('forgot/submit'); ?>
		<?php
			$forms = array(
				array(
					'name'		=> 'username',
					'maxlength'	=> '200',
					'class'		=> 'username',
					'value'		=> ''
				),
				array(
					'name'		=> 'question',
					'class'		=> 'question',
					'readonly'	=> 'readonly'
				),
				array(
					'name'		=> 'answer',
					'class'		=> 'answer',
					'maxlength'	=> '255'
				),
				array(
					'name'		=> 'password',
					'class'		=> 'password',
					'maxlength'	=> '50',
					'readonly'	=> 'readonly'
				)
			);
			form_helper_generate_form($forms);
		?>

		<a href="#next" class="b-next"></a>

		<?= form_submit(array(
				'id'		=> 'submit',
				'value'		=> '',
				'class'		=> 'submit'
			));
		?>

		<?= form_close() ?>
	</div>
</div>

<div style="z-index: 1500; opacity: 1; display: none; top: 287px; left: 682px;" aria-live="polite" role="alert" tracking="false" class="qtip qtip-default qtip-red qtip-pos-lc" id="qtip-0">
	<div style="background: transparent url('<?= base_url('/js/lib/jquery.qtip/arrow-tip.gif') ?>') no-repeat! important; border: 0px none ! important; width: 8px; height: 8px; line-height: 8px; top: 50%; margin-top: -4px; left: -8px; visibility:visible !important;" class="qtip-tip">&nbsp;</div>
	<div aria-atomic="true" class="qtip-content">กรุณาป้อน &quot;Username&quot;</div>
</div>

<div style="z-index: 1500; opacity: 1; display: none; top: 343px; left: 682px;" aria-live="polite" role="alert" tracking="false" class="qtip qtip-default qtip-red qtip-pos-lc" id="qtip-1">
	<div style="background: transparent url('<?= base_url('/js/lib/jquery.qtip/arrow-tip.gif') ?>') no-repeat! important; border: 0px none ! important; width: 8px; height: 8px; line-height: 8px; top: 50%; margin-top: -4px; left: -8px; visibility:visible !important;" class="qtip-tip">&nbsp;</div>
	<div aria-atomic="true" class="qtip-content">กรุณาป้อน &quot;คำตอบ&quot;</div>
</div>

<script type="text/javascript" src="<?= base_url('js/forgot.js') ?>"></script>
<script type="text/javascript">
	$(function(){
		var f = new Forgot();

		$('#submit').click(function(){
			setTimeout(function(){
				$(this).attr('disabled', 'disabled');
			}, 1);
		});
	});
</script>
