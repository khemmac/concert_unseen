<?php
	$zone_name = $zone['name'];
?>
<div id="content-body" class="page-seat-early">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">

		<?= form_open('seat_early/submit'); ?>
		<?= form_hidden('booking_id', $booking_id) ?>
		<?= form_hidden('zone_id', $zone['id']) ?>
		<?= form_hidden('zone_name', $zone['name']) ?>
			<div id="seat-container" style="background-image: url('<?= base_url('images/seat/plan-early-a3.png'); ?>')">
				<select name="seat_count">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
				</select>
			</div>
			<ul class="submit-container">
				<li><?= form_submit(array(
						'id'		=> 'submit',
						'value'		=> '',
						'class'		=> 'submit'
					)); ?></li>
			</ul>
		<?= form_close() ?>

		<ul class="b-back-ctnr">
			<li><a href="<?= site_url('zone_early/'.$booking_id) ?>" title="เลือกโซนที่นั่งอื่นๆ" class="b-back-zone">&nbsp;</a></li>
		</ul>
	</div>
</div>

<script type="text/javascript" src="<?= base_url('js/seat.js') ?>"></script>
<script type="text/javascript">
	$(function(){
		common.combo.create($('select[name=seat_count]'),		'sexy-combo-seat_count');
	});
</script>
