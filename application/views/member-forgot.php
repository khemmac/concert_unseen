<style type="text/css">
	#content-body { padding-top:130px; min-height:450px; }

	.form-forgot {
	  	margin:0 auto;
	    width: 555px;
	    padding: 19px 29px 19px;
	    background-color: #f5f5f5;
	    border: 1px solid #e5e5e5;
	    -webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
	    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		box-shadow: 0 1px 2px rgba(0,0,0,.05);

		position:relative;
	}

	#step-mask {
		position:absolute; bottom:12px; left:20px; width:569px; height:196px;
		background-color:#f5f5f5; z-index:300;
	}

	.b-next { position:absolute; top:10px; left:250px; }

	ul#sub-menu { margin:0px; padding:0px; list-style:none; }
	ul#sub-menu li { float:left; margin-right:10px; }

</style>
<div id="content-body" class="page-forgot">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="dialog" class="step1">
		<?= form_open('forgot/submit', array('class'=>'form-forgot form-horizontal')); ?>
		<div id="step-mask">
			<a href="#next" class="b-next btn btn-primary">ถัดไป</a>
		</div>
		<fieldset>
		<legend class="text-center">ลืมรหัสผ่าน</legend>
		<?php
			$forms = array(
				array(
					'name'		=> 'username',
					'maxlength'	=> '200',
					'class'		=> 'username',
					'value'		=> '',
					'label'		=> 'Username'
				),
				array(
					'name'		=> 'question',
					'class'		=> 'question',
					'readonly'	=> 'readonly',
					'disabled'	=> 'disabled',
					'label'		=> 'คำถาม'
				),
				array(
					'name'		=> 'answer',
					'class'		=> 'answer',
					'maxlength'	=> '255',
					'label'		=> 'คำตอบ'
				),
				array(
					'name'		=> 'password',
					'class'		=> 'password',
					'maxlength'	=> '50',
					'readonly'	=> 'readonly',
					'label'		=> 'Password'
				)
			);
			form_helper_generate_bootstrap($forms);
		?>
		<div class="text-center">
		<?= form_submit(array(
				'id'		=> 'submit',
				'value'		=> 'ตกลง',
				'class'		=> 'submit btn btn-primary'
			));
		?>

		</div>
		<fieldset>
		<?= form_close() ?>
	</div>
</div>

<div style="z-index: 1500; opacity: 1; display: none; top: 234px; left: 631px;" aria-live="polite" role="alert" tracking="false" class="qtip qtip-default qtip-red qtip-pos-lc" id="qtip-0">
	<div style="background: transparent url('<?= base_url('/js/lib/jquery.qtip/arrow-tip.gif') ?>') no-repeat! important; border: 0px none ! important; width: 8px; height: 8px; line-height: 8px; top: 50%; margin-top: -4px; left: -8px; visibility:visible !important;" class="qtip-tip">&nbsp;</div>
	<div aria-atomic="true" class="qtip-content">กรุณาป้อน &quot;Username&quot;</div>
</div>

<div style="z-index: 1500; opacity: 1; display: none; top: 333px; left: 631px;" aria-live="polite" role="alert" tracking="false" class="qtip qtip-default qtip-red qtip-pos-lc" id="qtip-1">
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
