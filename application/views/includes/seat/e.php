<!-- zone 1 -->
<?php
	// fix load a1
	$this->db->select('id,name,is_booked,booking_id,(booking_id='.$this->db->escape($booking_id).') AS is_own');
	$this->db->where('round', $booking_round);
	$this->db->where("zone_id IN (13,14,15)");
	$q = $this->db->get('seat');
	$seat_db_list = $q->result_array();

	$rows_1 = seat_helper_get_all_rows($seat_db_list, 'e1');
	$rows_2 = seat_helper_get_all_rows($seat_db_list, 'e2');
	$rows_3 = seat_helper_get_all_rows($seat_db_list, 'e3');
?>
<table cellpadding="1" cellspacing="0" border="0" style="width:932px; margin: 0 auto;" class="zone-e">
	<tr>
		<td></td>
		<td><div class="text-center"><h5>E1</h5></div></td>
		<td><div class="text-center"><h5>E2</h5></div></td>
		<td><div class="text-center"><h5>E3</h5></div></td>
	</tr>
	<?php
	$zone_0 = zone_helper_get_zone('e1');
	$cnt = 0;
	foreach($zone_0['seat'] AS $row_name => $row_seat_text):
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
			<div style="margin:0 auto; width:338px;">
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
		$cnt++;
	endforeach;
	?>

</table>