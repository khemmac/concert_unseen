<style type="text/css">

  .form-discount {
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

<div id="content-body" class="page-login">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

		<?= form_open('', array('class'=>'form-discount')); ?>
		<?= form_hidden('booking_id', $booking_id) ?>
		<fieldset class="text-center">
		<legend>
			<img src="<?= base_url('images/th/common/ptt_logo.gif') ?>" width="144" height="67" /><br />
			กรุณากรอกรหัส PTT-Bluecard
		</legend>
		<?=
			form_helper_generate_item(array(
				'name'			=> 'discount_code',
				'maxlength'		=> '16',
				'value'			=> '',
				'class'			=> 'input-medium text-center',
				'label'	=>	'Username'
			));
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
				<a href="<?= site_url('zone') ?>" class="btn">ยกเลิก</a>
			</div>
		</div>
		<?= form_close() ?>

</div>
<script type="text/javascript">
	$(function(){
		$('.page-login #submit').click(function(){
			setTimeout(function(){
				$(this).attr('disabled', 'disabled');
			}, 1);
		});

		setTimeout(function(){
			$('input[name="discount_code"]').focus();
		}, 100);
	});
</script>
