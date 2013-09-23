<div id="content-body" class="page-zone-early">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<img usemap="#zone-map" src="<?= base_url("/images/zone/plan-early.gif") ?>" style="width:590px; height:623px; position:absolute; left:32px;" />
		<a href="<?= site_url('seat_early/'.$booking_id) ?>" title="A3"
			style="display:block; position:absolute; top:238px; left:308px; width:36px; height:28px;"></a>

		<?= form_open('zone_early/submit'); ?>
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
		<?= form_hidden('rurl', 'zone_early') ?>
		<ul class="submit-clear-container">
			<li><?= form_submit(array(
				'id'		=> 'submit-clear',
				'value'		=> '',
				'class'		=> 'submit-clear'
			)); ?></li>
		</ul>
		<?= form_close() ?>

		<div id="remark-info">
			<div style="position:absolute; top:15px; left:0px; width:185px; height:26px; background:transparent url('<?= base_url('images/zone/price.gif') ?>') no-repeat;">
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