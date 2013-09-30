<!-- zone 1 -->
<?php
	// fix load a1
	$this->db->select('id,name,is_booked,booking_id,(booking_id='.$this->db->escape($booking_id).') AS is_own');
	$this->db->where('round', $booking_round);
	$this->db->where("zone_id IN (10,11,12)");
	$q = $this->db->get('seat');
	$seat_db_list = $q->result_array();

	$rows_1 = seat_helper_get_all_rows($seat_db_list, 'd1');
	$rows_2 = seat_helper_get_all_rows($seat_db_list, 'd2');
	$rows_3 = seat_helper_get_all_rows($seat_db_list, 'd3');
?>
<table cellpadding="1" cellspacing="0" border="0" style="width:932px; margin: 0 auto;" class="zone-d">
	<tr>
		<td></td>
		<td><div class="text-center"><h5>D1</h5></div></td>
		<td><div class="text-center"><h5>D2</h5></div></td>
		<td><div class="text-center"><h5>D3</h5></div></td>
	</tr>
	<tr>
		<td>AA</td>
		<td class="row">
			<div style="float:right;">
			<?php for($i=1;$i<=13;$i++) echo '<div class="booked"><span></span></div>'; ?>
			</div>
		</td>
		<td class="row">
			<div style="margin:0 auto; width:276px;">
			<?php for($i=14;$i<=26;$i++) echo '<div class="booked"><span></span></div>'; ?>
			</div>
		</td>
		<td class="row">
			<?php for($i=27;$i<=39;$i++) echo '<div class="booked"><span></span></div>'; ?>
		</td>
	</tr>
	<?php
	$zone_0 = zone_helper_get_zone('d1');
	$cnt = 0;
	foreach($zone_0['seat'] AS $row_name => $row_seat_text):
		if($row_name=='E'):
			echo '<tr><td colspan="3" style="height:10px;"></td></tr>';
		endif;
	?>
	<tr>
		<td align="center" style="width:20px;"><?= $row_name ?></td>
		<td class="row">
			<div style="float:right;">
			<?php
				seat_helper_generate_seat_row($rows_1, $row_name);
			?>
			</div>
		</td>
		<td class="row">
			<div style="margin:0 auto; width:<?= ($cnt==4)?'233':'276' ?>px;">
			<?php
				seat_helper_generate_seat_row($rows_2, $row_name);
			?>
			</div>
		</td>
		<td class="row">
			<?php
				seat_helper_generate_seat_row($rows_3, $row_name);
			?>
		</td>
	</tr>
	<?php
		if($row_name=='E'):
			echo '<tr><td colspan="3" style="height:10px;"></td></tr>';
		endif;
		$cnt++;
	endforeach;
	?>

</table>