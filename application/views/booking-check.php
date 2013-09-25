<style type="text/css">

  .form-check {
  	position:absolute; top:200px; left:277px;
    width: 400px;
    padding: 19px 29px 19px;
    background-color: #f5f5f5;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
       -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
  }

	ul#sub-menu { margin:0px; padding:0px; list-style:none; }
	ul#sub-menu li { float:left; margin-right:10px; }

</style>
<div id="content-body" class="page-booking-check">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="dialog">
		<?= form_open('',  array('class'=>'form-check')); ?>
		<fieldset class="text-center" >
		<legend>ตรวจสอบสถานะหลังการแจ้งโอนเงิน</legend>
		<?php
			$forms = array(
				array(
					'name'		=> 'code',
					'maxlength'	=> '14',
					'class'		=> 'code text-center',
					'value'		=> '',
					'label'		=> 'รหัสจอง'
				)
			);
			form_helper_generate_bootstrap($forms);
		?>
		</fieldset>

		<div class="control-group">
			<div class="controls text-center">
				<?= form_submit(array(
						'id'		=> 'submit',
						'value'		=> 'ตกลง',
						'class'		=> 'submit btn btn-primary'
					));
				?>
				<a href="<?= site_url('index') ?>" class="btn">ยกเลิก</a>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#submit').click(function(){
			setTimeout(function(){
				$(this).attr('disabled', 'disabled');
			}, 1);
		});

		setTimeout(function(){
			$('input[name="code"]').focus();
		}, 100);
	});
</script>
