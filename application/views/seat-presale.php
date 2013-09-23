<?php
	$zone_name = $zone['name'];
?>
<div id="content-body" class="page-seat-early">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>


	<?php
		$img = base_url('images/seat/presale/'.$zone['name'].'.png');
		$propotion = array(
				'top'=>30,
				'left'=>309,
				'width'=>384,
				'height'=>379
			);
			/*
		if($zone['name']=='a1'):
			$propotion = array(
				'top'=>30,
				'left'=>309,
				'width'=>384,
				'height'=>379
			);
		elseif($zone['name']=='a2'):
			$propotion = array(
				'top'=>35,
				'left'=>233,
				'width'=>576,
				'height'=>528
			);
		endif;
			 */
	?>

	<div id="content" style="background:transparent url('<?= $img ?>') no-repeat center 30px;">

		<?= form_open('seat_presale/submit'); ?>
		<?= form_hidden('booking_id', $booking_id) ?>
		<?= form_hidden('zone_id', $zone['id']) ?>
		<?= form_hidden('zone_name', $zone['name']) ?>
		<div id="seat-container" style="text-align:center; color:white; width:<?= $propotion['width'] ?>px;
			height:<?= $propotion['height'] ?>px;
			top:<?= $propotion['top'] ?>px;
			left:<?= $propotion['left'] ?>px;
			">
			<h1 style="font-size:50px;"><?= strtoupper($zone['name']) ?></h1>
			<h2 style="font-size:30px;">STANDING</h2>

			ซื้อจำนวน
			<select name="seat_count">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
			</select>
			ใบ
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
			<li><a href="<?= site_url('zone_presale') ?>" title="เลือกโซนที่นั่งอื่นๆ" class="b-back-zone">&nbsp;</a></li>
		</ul>
	</div>
</div>

<script type="text/javascript" src="<?= base_url('js/seat.js') ?>"></script>
<script type="text/javascript">
	$(function(){
		//common.combo.create($('select[name=seat_count]'),		'sexy-combo-seat_count');
	});
</script>
