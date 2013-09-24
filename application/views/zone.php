<style type="text/css">
	#content-body { padding:0px 0px 50px 0px; }

	#remark-info { position:absolute; top:133px; left:50px; width: 250px; }
	.page-zone h4 { text-align:center; font-family:'thaisans_neuebold'; margin:0px; }

	#booking-info { border:0px solid #f00;
		position:absolute; top:133px; right:50px; width:260px;
	}

	a.link-zone {
		display:block; position:absolute; zoom: 1;
		font-family:'thaisans_neuebold'; font-size:20px; line-height:81px;
		color:#FFFFFF; text-decoration:none; text-align:center; border:0px solid #000;
	}
	a.link-zone:hover { text-decoration:none; }

	.link-zone-a1 { width:81px; height:81px; top:147px; left:354px; }
	.link-zone-a2 { width:77px; height:77px; top:150px; left:451px; }
	.link-zone-a3 { width:81px; height:81px; top:147px; left:544px; }

	.link-zone-b1 { width:90px; height:122px; top:235px; left:344px; line-height:125px !important; }
	.link-zone-b2 { width:85px; height:115px; top:240px; left:447px; line-height:125px !important; }
	.link-zone-b3 { width:90px; height:122px; top:235px; left:544px; line-height:125px !important; }

	ul.submit-container,
	ul.submit-clear-container { margin:0px; padding:0px; list-style:none; }

</style>
<div id="content-body" class="page-zone">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<img usemap="#zone-map" src="<?= base_url("/images/th/zone/plan.png") ?>"
			style="width:291px; height:613px; position:absolute; top:106px; left:345px;" />
		<a href="<?= site_url('seat/a') ?>" class="link-zone link-zone-a1">A1</a>
		<a href="<?= site_url('seat/a') ?>" class="link-zone link-zone-a2">A2</a>
		<a href="<?= site_url('seat/a') ?>" class="link-zone link-zone-a3">A3</a>

		<a href="<?= site_url('seat/b') ?>" class="link-zone link-zone-b1">B1</a>
		<a href="<?= site_url('seat/b') ?>" class="link-zone link-zone-b2">B2</a>
		<a href="<?= site_url('seat/b') ?>" class="link-zone link-zone-b3">B3</a>
		<map name="zone-map">
			<area shape="polygon" coords="165,234,217,234,217,286,166,285" href="<?= site_url('seat_a') ?>" title="A">
		</map>

		<div id="remark-info">

			<table cellpadding="2" cellspacing="0" class="table table-bordered" width="100%">
				<tr>
					<td colspan="3"><h4>Remark</h4></td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE A</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#EC2227; margin:0 auto;"></div></td>
					<td>2,200 Baht</td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE B</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#4764AF; margin:0 auto;"></div></td>
					<td>1,800 Baht</td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE C</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#62BB46; margin:0 auto;"></div></td>
					<td>1,500 Baht</td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE D</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#60489D; margin:0 auto;"></div></td>
					<td>1,000 Baht</td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE E</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#F26522; margin:0 auto;"></div></td>
					<td>800 Baht</td>
				</tr>
			</table>
		</div>

		<div id="booking-info">
			<table cellpadding="2" cellspacing="0" border="0" width="100%"><tr><td>
			<table cellpadding="2" cellspacing="0" width="100%" class="table table-bordered">
				<tr>
					<td colspan="2"><h4>รายละเอียดการจอง</h4></td>
				</tr>
				<tr>
					<td style="width:80px; text-align:right;">โซน :</td>
					<td>
<?php
	if(count($zones)>0):
		$zones_arr = array();
		foreach($zones AS $z):
			$zone_data = zone_helper_get_zone($z);
			if($z=='a3')
				array_push($zones_arr, anchor('seat_early/'.$booking_id, strtoupper($z), 'title="'.$z.'"'));
			else if($zone_data['type']=='u')
				array_push($zones_arr, anchor('seat_u/'.$z.'/'.$booking_id, strtoupper($z), 'title="'.$z.'"'));
			else
				array_push($zones_arr, anchor('seat/'.$z.'/'.$booking_id, strtoupper($z), 'title="'.$z.'"'));
		endforeach;
		echo implode(', ', $zones_arr);
	endif;
?>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;">ที่นั่ง :</td>
					<td><?= (count($seats)>0)?strtoupper(implode(', ', $seats)):'-' ?></td>
				</tr>
				<tr>
					<td style="text-align:right;">ราคารวม :</td>
					<td><?= number_format($price) ?> B.-</td>
				</tr>
			</table>
			</td></tr>
			<tr>
				<td style="text-align: center;">
					<?= form_open('zone/submit'); ?>
					<?= form_hidden('booking_id', $booking_id) ?>
					<ul class="submit-container">
						<li><?= form_submit(array(
							'id'		=> 'submit',
							'value'		=> 'ซื้อบัตร',
							'class'		=> 'submit btn btn-large btn-primary btn-block'
						)); ?></li>
					</ul>
					<?= form_close() ?>

					<?= form_open('zone/clear', array('id'=>'form-clear')); ?>
					<?= form_hidden('booking_id', $booking_id) ?>
					<?= form_hidden('rurl', 'zone') ?>
					<ul class="submit-clear-container">
						<li><?= form_submit(array(
							'id'		=> 'submit-clear',
							'value'		=> 'ล้างการจอง',
							'class'		=> 'submit-clear btn btn-block'
						)); ?></li>
					</ul>
					<?= form_close() ?>
				</td>
			</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#submit-clear').click(function(e){
			e.preventDefault();
			bootbox.confirm("ท่านต้องการยกเลิกการจองหรือไม่", function(result) {
				if(result)
					$('form#form-clear').submit();
			});
		});
	});
</script>
