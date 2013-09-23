<div id="content-body" class="page-zone">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<img usemap="#zone-map" src="<?= base_url("/images/zone/plan-fanzone.gif") ?>" style="width:590px; height:624px; position:absolute; left:32px;" />
		<map name="zone-map">
			<area shape="polygon" coords="391,449,407,443,421,476,404,483" href="<?= site_url('seat/e1d') ?>" title="E1D">
			<area shape="polygon" coords="374,454,391,450,403,484,387,489" href="<?= site_url('seat/e1e') ?>" title="E1E">

			<area shape="polygon" coords="202,451,218,456,207,490,190,484" href="<?= site_url('seat/e1o') ?>" title="E1O">
			<area shape="polygon" coords="185,444,202,451,187,484,171,478" href="<?= site_url('seat/e1p') ?>" title="E1P">

			<area shape="polygon" coords="416,482,433,475,450,512,431,520" href="<?= site_url('seat/e2e') ?>" title="E2E">
			<area shape="polygon" coords="396,489,413,484,428,521,411,528" href="<?= site_url('seat/e2f') ?>" title="E2F">
			<area shape="polygon" coords="375,495,394,491,407,529,386,535" href="<?= site_url('seat/e2g') ?>" title="E2G">

			<area shape="polygon" coords="194,490,214,495,202,535,182,528" href="<?= site_url('seat/e2p') ?>" title="E2P">
			<area shape="polygon" coords="176,484,194,490,179,527,161,521" href="<?= site_url('seat/e2q') ?>" title="E2Q">
			<area shape="polygon" coords="156,475,175,481,157,519,139,510" href="<?= site_url('seat/e2r') ?>" title="E2R">
		</map>
		<?= form_open('zone/submit'); ?>
		<?= form_hidden('booking_id', $booking_id) ?>
		<ul class="submit-container">
			<li><?= form_submit(array(
				'id'		=> 'submit',
				'value'		=> '',
				'class'		=> 'submit'
			)); ?></li>
		</ul>
		<?= form_close() ?>

		<?= form_open('zone/clear', array('id'=>'form-clear')); ?>
		<?= form_hidden('booking_id', $booking_id) ?>
		<?= form_hidden('rurl', 'zone') ?>
		<ul class="submit-clear-container">
			<li><?= form_submit(array(
				'id'		=> 'submit-clear',
				'value'		=> '',
				'class'		=> 'submit-clear'
			)); ?></li>
		</ul>
		<?= form_close() ?>

		<div id="remark-info">
			<img src="<?= base_url('images/zone/remark-fanzone.png') ?>" border="0"
				style="position:absolute; top:-4px; left:-37px;" />
			<?php if(language_helper_is_th($this)): ?>
			<ul style="margin:0px; padding:0px; list-style:none; color:white; font-size:13px; position:absolute; top:100px; left:-33px; width:236px;">
				<li style="padding:2px 0px 2px 0px;">* ลดทันที 5 % เมื่อซื้อ 30 ใบ ขึ้นไป *</li>
				<li style="padding:2px 0px 2px 0px;">* ลดทันที 10 % เมื่อซื้อ 50 ใบ ขึ้นไป *</li>
				<li style="padding:2px 0px 2px 0px;">* ลดทันที 15 % เมื่อซื้อ 100 ใบ ขึ้นไป *</li>
			</ul>
			<?php else: ?>
			<ul style="margin:0px; padding:0px; list-style:none; color:white; font-size:11px; position:absolute; top:100px; left:-54px; width:280px;">
				<li style="padding:2px 0px 2px 0px;">Get 5% Discount when purchase more than 30 tickets</li>
				<li style="padding:2px 0px 2px 0px;">Get 10% Discount when purchase more than 50 tickets</li>
				<li style="padding:2px 0px 2px 0px;">Get 15% Discount when purchase more than 100 tickets</li>
			</ul>
			<?php endif; ?>
		</div>

		<div id="booking-info" style="border:0px solid #f00; position:absolute; top:330px; left:672px; width:271px; height:117px;">
			<table cellpadding="2" cellspacing="0" border="0" style="color:white;">
				<tr>
					<td align="right"><?= language_helper_is_th($this)?'โซน':'Zone' ?> :</td>
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
					<td align="right"><?= language_helper_is_th($this)?'ที่นั่ง':'Seats' ?> :</td>
					<td><?= number_format(count($seats)) ?>
						(<a href="#" class="concert-tooltip" title="<?= strtoupper(implode(', ', $seats)) ?>"><?= language_helper_is_th($this)?'รายละเอียด':'Detail' ?></a>)</td>
				</tr>
				<tr>
					<td align="right"><?= language_helper_is_th($this)?'ราคารวม':'Total' ?> :</td>
					<td><?= number_format($price) ?> <?= language_helper_is_th($this)?'บาท':'Baht' ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#submit-clear').click(function(e){
			e.preventDefault();
			var popId = '#zone-confirm-clear-popup';
			common.popup.show(null, popId);
			$(popId).find('a.ok').unbind('click').bind('click', function(e){
				e.preventDefault();
				$('form#form-clear').submit();
				return false;
			});
			return false;
			//return confirm('ท่านต้องการล้างการจองทั้งหมดหรือไม่');
		});
	});
</script>
