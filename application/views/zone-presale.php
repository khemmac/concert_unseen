<div id="content-body" class="page-zone-early">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<img usemap="#zone-map" src="<?= base_url("/images/zone/plan-presale.gif") ?>" style="width:590px; height:624px; position:absolute; left:32px;" />
		<map name="zone-map">
			<area shape="rectrangle" coords="165,235,216,285" href="<?= site_url('seat_presale/a1') ?>" title="A1">
			<area shape="polygon" coords="220,235,259,234,260,248,278,285,221,285" href="<?= site_url('seat_presale/a2') ?>" title="A2">
			<area shape="polygon" coords="330,235,370,235,368,285,314,284,331,245" href="<?= site_url('seat_presale/a4') ?>" title="A4">
			<area shape="rectrangle" coords="372,235,424,285" href="<?= site_url('seat_presale/a5') ?>" title="A5">
			<area shape="polygon" coords="122,349,162,290,163,389,136,372" href="<?= site_url('seat_presale/d1') ?>" title="D1">

			<area shape="polygon" coords="122,349,162,290,163,389,136,372" href="<?= site_url('seat_presale/d1') ?>" title="D1">
			<area shape="polygon" coords="165,289,166,376,204,349,204,288" href="<?= site_url('seat_presale/b1') ?>" title="B1">
			<area shape="polygon" coords="205,288,207,334,232,321,276,289" href="<?= site_url('seat_presale/b2') ?>" title="B2">
			<area shape="polygon" coords="240,342,241,334,286,304,307,305,350,336,350,342" href="<?= site_url('seat_presale/b3') ?>" title="B3">
			<area shape="polygon" coords="315,289,384,288,384,337,351,317" href="<?= site_url('seat_presale/b4') ?>" title="B4">
			<area shape="polygon" coords="386,287,424,288,424,376,387,349" href="<?= site_url('seat_presale/b5') ?>" title="B5">
			<area shape="polygon" coords="427,291,428,389,455,370,468,350" href="<?= site_url('seat_presale/d2') ?>" title="D2">

			<area shape="polygon" coords="239,398,165,401,166,381,214,347,240,345" href="<?= site_url('seat_presale/c1') ?>" title="C1">
			<area shape="polygon" coords="243,346,243,399,348,398,346,345" href="<?= site_url('seat_presale/c2') ?>" title="C2">
			<area shape="polygon" coords="348,345,380,349,425,382,424,401,350,398" href="<?= site_url('seat_presale/c3') ?>" title="C3">
		</map>

		<?= form_open('zone_presale/submit'); ?>
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
		<?= form_hidden('rurl', 'zone_presale') ?>
		<ul class="submit-clear-container">
			<li><?= form_submit(array(
				'id'		=> 'submit-clear',
				'value'		=> '',
				'class'		=> 'submit-clear'
			)); ?></li>
		</ul>
		<?= form_close() ?>

		<div id="remark-info">
			<div style="position:absolute; top:15px; left:-35px; width:248px; height:106px; background:transparent url('<?= base_url('images/zone/remark-presale.png') ?>') no-repeat;">
			</div>
		</div>

		<div id="booking-info" style="border:0px solid #f00; position:absolute; top:330px; right:16px; width:271px; height:117px;">
			<table cellpadding="2" cellspacing="0" border="0" style="color:white;">
				<tr>
					<td align="right"><?= language_helper_is_th($this)?'โซน':'Zone' ?> :</td>
					<td>
<?php
	if(count($zones)>0):
		$zones_arr = array();
		foreach($zones AS $z):
			$zone_data = zone_helper_get_zone($z);
			array_push($zones_arr, anchor('seat_presale/'.$z, strtoupper($z), 'title="'.$z.'"'));
		endforeach;
		echo implode(', ', $zones_arr);
	endif;
?>
					</td>
				</tr>
				<tr>
					<td align="right"><?= language_helper_is_th($this)?'บัตร':'Tickets' ?> :</td>
					<td><?= (count($seats)>0)?count($seats):'-' ?> <?= language_helper_is_th($this)?'ใบ':'items' ?> :</td>
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