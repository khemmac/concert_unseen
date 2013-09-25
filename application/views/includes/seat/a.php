<!-- zone 1 -->
<?php
	// fix load a1
	$this->db->select('id,name,is_booked,booking_id,(booking_id='.$this->db->escape($booking_id).') AS is_own');
	$this->db->where('round', $booking_round);
	$this->db->where("zone_id IN (1,2,3)");
	$q = $this->db->get('seat');
	$seat_db_list = $q->result_array();

	$rows_a1 = seat_helper_get_all_rows($seat_db_list, 'a1');
	$rows_a2 = seat_helper_get_all_rows($seat_db_list, 'a2');
	$rows_a3 = seat_helper_get_all_rows($seat_db_list, 'a3');

	//print_r($result);
?>
<table cellpadding="2" cellspacing="0" border="0" style="width:960px; margin: 0 auto;">
	<tr>
		<td></td>
		<td><div class="text-center"><h5>A1</h5></div></td>
		<td><div class="text-center"><h5>A2</h5></div></td>
		<td><div class="text-center"><h5>A3</h5></div></td>
	</tr>
	<?php
	$zone_0 = zone_helper_get_zone('a1');
	foreach($zone_0['seat'] AS $row_name => $row_seat_text):
	?>
	<tr>
		<td align="center" style="width:20px;"><?= $row_name ?></td>
		<td class="row zone-a1">
			<div style="float:right;">
			<?php
				seat_helper_generate_seat_row($rows_a1, $row_name);
			?>
			</div>
		</td>
		<td class="row zone-a2">
			<div style="margin:0 auto; width:275px;">
			<?php
				seat_helper_generate_seat_row($rows_a2, $row_name);
			?>
			</div>
		</td>
		<td class="row zone-a3">
			<?php
				seat_helper_generate_seat_row($rows_a3, $row_name);
			?>
		</td>
	</tr>
	<?php
	endforeach;
	?>

</table>