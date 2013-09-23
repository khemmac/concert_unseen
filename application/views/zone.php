<div id="content-body" class="page-zone">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="content">
		<img usemap="#zone-map" src="<?= base_url("/images/zone/plan-presale.gif") ?>" style="width:590px; height:624px; position:absolute; left:32px;" />
		<map name="zone-map">
			<area shape="polygon" coords="165,234,217,234,217,286,166,285" href="<?= site_url('seat_u/a1') ?>" title="A1">

			<area shape="polygon" coords="507,295,548,290,550,309,508,308" href="<?= site_url('seat/n1f') ?>" title="N1F">
			<area shape="polygon" coords="508,314,550,314,549,334,508,327" href="<?= site_url('seat/n1g') ?>" title="N1G">
			<area shape="polygon" coords="505,332,546,339,544,358,503,345" href="<?= site_url('seat/n1h') ?>" title="N1H">
			<area shape="polygon" coords="501,350,541,362,532,381,496,363" href="<?= site_url('seat/n1i') ?>" title="N1I">
			<area shape="polygon" coords="491,368,531,386,521,403,487,379" href="<?= site_url('seat/n1j') ?>" title="N1J">
			<area shape="polygon" coords="484,382,518,407,506,421,476,391" href="<?= site_url('seat/n1k') ?>" title="N1K">
			<area shape="polygon" coords="472,396,503,425,496,431,468,400" href="<?= site_url('seat/n1l') ?>" title="N1L">

			<area shape="polygon" coords="477,430,488,423,495,432,485,440" href="<?= site_url('seat/e1a') ?>" title="E1A">
			<area shape="polygon" coords="442,432,478,433,485,442,460,459" href="<?= site_url('seat/e1b') ?>" title="E1B">
			<area shape="polygon" coords="407,443,436,429,456,460,423,477" href="<?= site_url('seat/e1c') ?>" title="E1C">
<!--
			<area shape="polygon" coords="352,400,363,395,375,424,362,429" href="<?= site_url('seat/e1d') ?>" title="E1D">
			<area shape="polygon" coords="337,405,348,401,359,431,345,435" href="<?= site_url('seat/e1e') ?>" title="E1E">
-->
			<area shape="polygon" coords="357,459,374,455,383,491,366,494" href="<?= site_url('seat/e1f') ?>" title="E1F">
			<area shape="polygon" coords="341,463,357,460,365,494,348,496" href="<?= site_url('seat/e1g') ?>" title="E1G">
			<area shape="polygon" coords="323,465,340,463,344,498,328,499" href="<?= site_url('seat/e1h') ?>" title="E1H">



			<area shape="polygon" coords="274,416,289,415,290,445,276,446" href="<?= site_url('seat/e1i') ?>" title="E1I">
			<area shape="polygon" coords="258,415,273,416,273,446,258,446" href="<?= site_url('seat/e1i') ?>" title="E1J">
			<area shape="polygon" coords="243,415,257,416,256,447,240,446" href="<?= site_url('seat/e1k') ?>" title="E1K">
			<area shape="polygon" coords="228,414,242,415,238,445,222,443" href="<?= site_url('seat/e1l') ?>" title="E1L">
			<area shape="polygon" coords="212,411,226,413,220,444,204,441" href="<?= site_url('seat/e1m') ?>" title="E1M">
			<area shape="polygon" coords="197,407,210,411,203,440,187,436" href="<?= site_url('seat/e1n') ?>" title="E1N">
			<area shape="polygon" coords="181,401,195,406,185,436,170,431" href="<?= site_url('seat/e1o') ?>" title="E1O">
			<area shape="polygon" coords="167,396,180,401,168,431,152,425" href="<?= site_url('seat/e1p') ?>" title="E1P">
			<area shape="polygon" coords="120,408,135,385,149,385,165,395,150,424" href="<?= site_url('seat/e1q') ?>" title="E1Q">
			<area shape="polygon" coords="132,385,118,407,96,392,103,385" href="<?= site_url('seat/e1r') ?>" title="E1R">
			<area shape="polygon" coords="100,384,94,392,86,384,93,377" href="<?= site_url('seat/e1s') ?>" title="E1S">
			<area shape="polygon" coords="104,352,110,357,84,384,79,378" href="<?= site_url('seat/s1a') ?>" title="S1A">
			<area shape="polygon" coords="93,340,103,349,76,375,66,362" href="<?= site_url('seat/s1b') ?>" title="S1B">
			<area shape="polygon" coords="54,343,87,327,93,336,63,358" href="<?= site_url('seat/s1c') ?>" title="S1C">
			<area shape="polygon" coords="44,321,80,311,85,323,52,340" href="<?= site_url('seat/s1d') ?>" title="S1D">
			<area shape="polygon" coords="38,301,75,296,78,308,44,318" href="<?= site_url('seat/s1e') ?>" title="S1E">
			<area shape="polygon" coords="36,279,74,280,74,291,38,296" href="<?= site_url('seat/s1e') ?>" title="S1F">
			<area shape="polygon" coords="38,259,73,264,72,274,33,273" href="<?= site_url('seat/s1g') ?>" title="S1G">
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

		<div id="remark-info"></div>

		<div id="booking-info" style="border:0px solid #f00; position:absolute; top:330px; right:16px; width:271px; height:117px;">
			<table cellpadding="2" cellspacing="0" border="0" style="color:white;">
				<tr>
					<td align="right">โซน :</td>
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
					<td align="right">ที่นั่ง :</td>
					<td><?= (count($seats)>0)?strtoupper(implode(', ', $seats)):'-' ?></td>
				</tr>
				<tr>
					<td align="right">ราคารวม :</td>
					<td><?= number_format($price) ?> B.-</td>
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
