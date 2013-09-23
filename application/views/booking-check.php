<div id="content-body" class="page-booking-check">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="dialog">
		<?= form_open(); ?>
		<?php
			$forms = array(
				array(
					'name'		=> 'code',
					'maxlength'	=> '14',
					'class'		=> 'code',
					'value'		=> ''
				)
			);
			form_helper_generate_form($forms);
		?>
		<?= form_submit(array(
				'id'		=> 'submit',
				'value'		=> '',
				'class'		=> 'submit'
			));
		?>
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
	});
</script>
