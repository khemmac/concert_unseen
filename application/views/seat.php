
<style type="text/css">
	#content-body { padding:250px 0px 50px 0px; min-height:350px; }

	.row { height:23px; }
	.row a,
	.row div.booked {
		display: block; width:18px; height:15px; float:left; margin-right:3px;
		color:white; text-align:center;
		font-family:'thaisans_neue_blackregular'; font-size:11px; line-height:14px;
		background:transparent url('<?= base_url('images/th/seat/seat_a.gif') ?>') no-repeat;
	}
	.row a:hover { text-decoration:none; }

	#stage {
		position: absolute; top:172px; left:50px; width:872px; height:72px;
		background:transparent url('<?= base_url('images/th/seat/stage.png'); ?>') no-repeat;
	}

	#btn-round {
		position:absolute; top:120px; left:144px;
	}

</style>
<div id="content-body" class="page-seat">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<?= form_open(); ?>
		<?= form_hidden('booking_id', $booking_id) ?>
		<div id="btn-round" class="btn-group" data-toggle="buttons-radio">
			<button type="submit" value="1" name="round" class="btn btn-large <?= ($booking_round==1)?'active':'btn-primary' ?>">รอบที่ 1</button>
			<button type="submit" value="2" name="round" class="btn btn-large <?= ($booking_round==2)?'active':'btn-primary' ?>">รอบที่ 2</button>
		</div>

		<div id="stage"></div>

		<?=
			$this->load->view('includes/seat/a',array(
				'booking_round'=>$booking_round
			), TRUE)
		?>
		<p class="text-center" style="margin-top:30px;">
			<a href="<?= site_url('zone') ?>" id="b-continue" class="btn btn-primary">ทำรายการต่อ</a>
			<a href="<?= site_url('zone') ?>" id="b-back" class="btn">ย้อนกลับ</a>
		</p>
		<?= form_close(); ?>
	</div>
</div>

<?php
	/*$zone_name = $zone['name'];
?>
<div id="content-body" class="page-seat">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<div id="zone-info">
			<ul>
				<li>Zone&nbsp;&nbsp;&nbsp;&nbsp;<?= strtoupper($zone['zone']) ?></li>
				<li>Class&nbsp;&nbsp;&nbsp;<?= strtoupper($zone['class']) ?></li>
				<li>Blog&nbsp;&nbsp;&nbsp;&nbsp;<?= strtoupper($zone['blog']) ?></li>
			</ul>
		</div>

		<?= form_open('seat/submit'); ?>
		<?= form_hidden('booking_id', $booking_id) ?>
		<?= form_hidden('zone_id', $zone['id']) ?>
		<?= form_hidden('zone_name', $zone['name']) ?>
			<div id="seat-container" style="background-image: url('<?= base_url('images/seat/plan/'.$zone_name.'.png'); ?>')">
				<div id="chair-container">
					<?=$this->load->view('includes/partials/seat-chair','', TRUE)?>
				</div>
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
			<li><a href="<?= site_url('zone') ?>" title="เลือกโซนที่นั่งอื่นๆ" class="b-back-zone"></a></li>
		</ul>

		<div id="stage"></div>
	</div>
</div>
<?=$this->load->view('includes/seat/'.$zone_name,'', TRUE)?>

<script type="text/javascript" src="<?= base_url('js/seat.js') ?>"></script>
<script type="text/javascript">
	$(function(){
		var seat = new Seat({
			limit:<?= $zone['limit'] ?>,
			current:<?= $zone['current_booking_count'] ?>
		});
	});
</script>
<?php */ ?>
<script type="text/javascript" src="<?= base_url('js/seat.js') ?>"></script>
<script type="text/javascript">
	$(function(){
		var seat = new Seat();
		$('#btn-round button').unbind('click').bind('click', function(e){
			//e.preventDefault();

		});
	});
</script>