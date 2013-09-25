
<style type="text/css">
	#content-body { padding:250px 0px 50px 0px; min-height:350px; }

	.row { height:23px; }
	.row a,
	.row div.booked {
		display: block; width:18px; height:15px; float:left; margin-right:2px;
		color:white; text-align:center;
		font-family:'thaisans_neue_blackregular'; font-size:11px; line-height:14px;
		background:transparent url('<?= base_url('images/th/seat/seat_a.gif') ?>') no-repeat;
	}
	.row a:hover { text-decoration:none; }

	.row a span {
		display: block; width:18px; height:15px;
		background:transparent url('<?= base_url('images/th/seat/ico-tick.png') ?>') no-repeat center center;
	}
	.row div.booked span {
		display: block; width:18px; height:15px;
		background:transparent url('<?= base_url('images/th/seat/ico-man.png') ?>') no-repeat center center;
	}

	#stage {
		position: absolute; top:172px; left:74px; width:872px; height:72px;
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
		<?= form_hidden('booking_round', $booking_round) ?>
		<?= form_hidden('zone_name', $zone_name) ?>
		<div id="btn-round" class="btn-group" data-toggle="buttons-radio">
			<button type="submit" value="1" name="round" class="btn btn-large <?= ($booking_round==1)?'active':'' ?>">รอบที่ 1</button>
			<button type="submit" value="2" name="round" class="btn btn-large <?= ($booking_round==2)?'active':'' ?>">รอบที่ 2</button>
		</div>

		<div id="stage"></div>

		<div id="seat-container">
			<?=
				$this->load->view('includes/seat/a',array(
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
	});
</script>