<!-- zone 1 -->
<?php
	// fix load a1
	$this->db->select('id,name,is_booked,booking_id,(booking_id='.$this->db->escape($booking_id).') AS is_own');
	$this->db->where('round', $booking_round);
	$this->db->where("zone_id IN (7,8,9)");
	$q = $this->db->get('seat');
	$seat_db_list = $q->result_array();

	$rows_1 = seat_helper_get_all_rows($seat_db_list, 'c1');
	$rows_2 = seat_helper_get_all_rows($seat_db_list, 'c2');
	$rows_3 = seat_helper_get_all_rows($seat_db_list, 'c3');
?>
<table cellpadding="1" cellspacing="0" border="0" style="width:980px; margin: 0 auto;" class="zone-c">
	<tr>
		<td></td>
		<td><div class="text-center"><h5>C1</h5></div></td>
		<td><div class="text-center"><h5>C2</h5></div></td>
		<td><div class="text-center"><h5>C3</h5></div></td>
	</tr>
	<?php
	$zone_0 = zone_helper_get_zone('c1');
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
			<div style="margin:0 auto; width:<?= ($cnt%2==0)?'267':'285' ?>px;">
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