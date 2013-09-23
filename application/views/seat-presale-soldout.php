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

		<ul class="b-back-ctnr" style="left:397px;">
			<li><a href="<?= site_url('zone_presale') ?>" title="เลือกโซนที่นั่งอื่นๆ" class="b-back-zone">&nbsp;</a></li>
		</ul>
	</div>
	<div id="content-soldout" style="height: 538px; position: absolute; top: 105px; width: 1000px; background:transparent url('<?= base_url('images/seat/presale/tag-soldout.png') ?>') no-repeat center 20px;">
	</div>
</div>

<script type="text/javascript" src="<?= base_url('js/seat.js') ?>"></script>
<script type="text/javascript">
	$(function(){
		//common.combo.create($('select[name=seat_count]'),		'sexy-combo-seat_count');
	});
</script>
