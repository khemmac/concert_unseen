<style type="text/css">
	#content-body { padding:0px 0px 50px 0px; }

	#remark-info { position:absolute; top:133px; right:50px; width:260px; }
	.page-zone h4,
	.page-zone h5 { text-align:center; font-family:'thaisans_neuebold'; margin:0px; }

	#booking-info { border:0px solid #f00;
		position:absolute; top:133px; left:50px; width: 250px;
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

	.link-zone-c1 { width:90px; height:122px; top:366px; left:345px; line-height:125px !important; }
	.link-zone-c2 { width:85px; height:121px; top:371px; left:448px; line-height:125px !important; }
	.link-zone-c3 { width:90px; height:122px; top:366px; left:546px; line-height:125px !important; }

	.link-zone-d1 { width:65px; height:105px; top:528px; left:360px; line-height:108px !important; }
	.link-zone-d2 { width:77px; height:97px; top:535px; left:452px; line-height:108px !important; }
	.link-zone-d3 { width:65px; height:105px; top:528px; left:556px; line-height:108px !important; }

	.link-zone-e1 { width:69px; height:60px; top:639px; left:362px; line-height:61px !important; }
	.link-zone-e2 { width:92px; height:57px; top:643px; left:445px; line-height:61px !important; }
	.link-zone-e3 { width:69px; height:60px; top:639px; left:551px; line-height:61px !important; }

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

		<a href="<?= site_url('seat/c') ?>" class="link-zone link-zone-c1">C1</a>
		<a href="<?= site_url('seat/c') ?>" class="link-zone link-zone-c2">C2</a>
		<a href="<?= site_url('seat/c') ?>" class="link-zone link-zone-c3">C3</a>

		<a href="<?= site_url('seat/d') ?>" class="link-zone link-zone-d1">D1</a>
		<a href="<?= site_url('seat/d') ?>" class="link-zone link-zone-d2">D2</a>
		<a href="<?= site_url('seat/d') ?>" class="link-zone link-zone-d3">D3</a>

		<a href="<?= site_url('seat/e') ?>" class="link-zone link-zone-e1">E1</a>
		<a href="<?= site_url('seat/e') ?>" class="link-zone link-zone-e2">E2</a>
		<a href="<?= site_url('seat/e') ?>" class="link-zone link-zone-e3">E3</a>
		<!--map name="zone-map">
			<area shape="polygon" coords="165,234,217,234,217,286,166,285" href="<?= site_url('seat_a') ?>" title="A">
		</map-->

		<div id="remark-info">
			<table cellpadding="2" cellspacing="0" border="0" width="100%"><tr><td>
			<table cellpadding="2" cellspacing="0" class="table table-bordered" width="100%">
				<tr class="info">
					<td colspan="3"><h4>Remark</h4></td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE A</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#EC2227; margin:0 auto;"></div></td>
					<td style="text-align:right;">2,200 Baht&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE B</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#4764AF; margin:0 auto;"></div></td>
					<td style="text-align:right;">1,800 Baht&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE C</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#62BB46; margin:0 auto;"></div></td>
					<td style="text-align:right;">1,500 Baht&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE D</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#60489D; margin:0 auto;"></div></td>
					<td style="text-align:right;">1,000 Baht&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:center;">ZONE E</td>
					<td style="width:32px;"><div style="width:28px; height:20px; background-color:#F26522; margin:0 auto;"></div></td>
					<td style="text-align:right;">800 Baht&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
			</table>
			</td></tr>
			<tr>
				<td style="text-align: center;">
					<?= form_open('zone/submit', array('id'=>'form-zone')); ?>
					<?= form_hidden('booking_id', $booking_id) ?>
					<ul class="submit-container">
						<li><?= form_submit(array(
							'id'		=> 'submit-zone',
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
							'value'		=> 'ยกเลิกการจอง',
							'class'		=> 'submit-clear btn btn-block'
						)); ?></li>
					</ul>
					<?= form_close() ?>
				</td>
			</tr>
			</table>
		</div>

		<div id="booking-info">
			<table cellpadding="2" cellspacing="0" width="100%" class="table table-bordered">
				<tr class="info">
					<td colspan="2"><h4>รายละเอียดการจอง</h4></td>
				</tr>
<?php
	if(count($rounds)>0):
	foreach($rounds AS $r_key=>$r_value):
		$zones = $r_value['zones'];
		$seats = $r_value['seats'];
?>
				<tr class="warning"><td colspan="2"><h5>
				<?php if($r_key==1): ?>
					รอบที่ 1 วันที่ 19 ตุลาคม 2556
				<?php elseif($r_key==2): ?>
					รอบที่ 2 วันที่ 20 ตุลาคม 2556
				<?php endif; ?>
				</h5></td></tr>
				<tr>
					<td style="width:80px; text-align:right;">โซน :</td>
					<td>
<?php
	if(count($zones)>0):
		$zones_arr = array();
		foreach($zones AS $z):
			array_push($zones_arr, anchor('seat/'.substr($z, 0, 1), strtoupper($z), 'title="'.$z.'"'));
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
<?php
	endforeach;
	endif;
?>
				<tr>
					<td style="text-align:right;">ราคารวม :</td>
					<td><?= number_format($price) ?> บาท</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$('#submit-zone').click(function(e){
			e.preventDefault();
			bootbox.dialog('คุณมี PTT-Bluecard หรือไม่?', [{
				label: "&nbsp;&nbsp;&nbsp;&nbsp;มี&nbsp;&nbsp;&nbsp;&nbsp;",
				class: "btn-success btn-large",
				callback: function() {
					window.location.href = '<?= site_url('booking_discount/'.$booking_id) ?>';
				}
			},{
				label: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ไม่มี&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
				class: "btn",
				callback: function() {
					$('form#form-zone').submit();
				}
			}]);
		});

		$('#submit-clear').click(function(e){
			e.preventDefault();
			bootbox.confirm("ท่านต้องการยกเลิกการจองหรือไม่", function(result) {
				if(result)
					$('form#form-clear').submit();
			});
		});
	});
</script>
