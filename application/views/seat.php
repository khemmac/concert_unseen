
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

	.row a.loader {
		text-indent:-3000px;
		background:#ffffff url('<?= base_url('images/th/seat/ajax-loader.gif') ?>') no-repeat center center !important;
	}

	.row a span {
		display: block; width:18px; height:15px;
		background:transparent url('<?= base_url('images/th/seat/ico-tick.png') ?>') no-repeat center 0px;
	}
	.row div.booked span {
		display: block; width:18px; height:15px;
		background:transparent url('<?= base_url('images/th/seat/ico-man.png') ?>') no-repeat center 0px;
	}

	.zone-b .row a,
	.zone-b .row div {
		margin-right:1px;
		background:transparent url('<?= base_url('images/th/seat/seat_b.gif') ?>') no-repeat;
	}
	.zone-c .row a,
	.zone-c .row div {
		margin-right:1px;
		background:transparent url('<?= base_url('images/th/seat/seat_c.gif') ?>') no-repeat;
	}
	.zone-d .row a,
	.zone-d .row div {
		background:transparent url('<?= base_url('images/th/seat/seat_d.gif') ?>') no-repeat;
	}
	.zone-e .row a,
	.zone-e .row div {
		background:transparent url('<?= base_url('images/th/seat/seat_e.gif') ?>') no-repeat;
	}

	#stage {
		position: absolute; top:172px; left:74px; width:872px; height:72px;
		background:transparent url('<?= base_url('images/th/seat/stage.png'); ?>') no-repeat;
	}

	#btn-round {
		position:absolute; top:108px; left:106px;
	}

</style>
<div id="content-body" class="page-seat">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<?= form_open(); ?>
		<?= form_hidden('booking_id', $booking_id) ?>
		<?= form_hidden('booking_round', $booking_round) ?>
		<?= form_hidden('zone_name', $zone_name) ?>
		<div id="btn-round" class="btn-group" data-toggle="buttons-radio">
			<button type="submit" value="1" name="round" class="btn btn-large <?= ($booking_round==1)?'active':'' ?> text-center">
				รอบที่ 1<br />
          		19 ตุลาคม 2556
			</button>
			<button type="submit" value="2" name="round" class="btn btn-large <?= ($booking_round==2)?'active':'' ?> text-center">
				รอบที่ 2<br />
          		20 ตุลาคม 2556
			</button>
		</div>

		<div id="stage"></div>

		<div id="seat-container">
			<?=
				$this->load->view('includes/seat/'.$zone_name,array(
					'booking_id'=>$booking_id,
					'booking_round'=>$booking_round
				), TRUE)
			?>
		</div>

		<p class="text-center" style="margin-top:30px;">
			<a href="<?= site_url('zone') ?>" id="b-continue" class="btn btn-primary">ทำรายการต่อ</a>
			<a href="<?= site_url('zone') ?>" id="b-back" class="btn">ย้อนกลับ</a>
		</p>
		<?= form_close(); ?>
	</div>
</div>
<script type="text/javascript" src="<?= base_url('js/seat.js') ?>"></script>
<script type="text/javascript">
	$(function(){
		var seat = new Seat();
		$('#btn-round button').unbind('click').bind('click', function(e){
			//e.preventDefault();
		});

		<?php
			$referrer = $this->agent->referrer();
			if(!strpos($referrer, '/seat/')):
		?>
		// alert warining
		bootbox.alert('<p class="text-center">กรุณาเลือกรอบการแสดงก่อนทำการจองที่นั่ง</p>');
		<?php endif ?>;
	});
</script>