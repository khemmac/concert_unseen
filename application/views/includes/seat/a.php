<!-- zone 1 -->
<?php
	// fix load a1
	$this->db->where('round', $booking_round);
	$this->db->where("zone_id IN (1,2,3)");
	$q = $this->db->get('seat');
	$seat_db_list = $q->result_array();

	// ค้นค่า rows ทั้งหมดที่อยู่ภายใต้ zone ที่ส่งมา โดยเทียบกับ database
	function get_all_rows($seat_db_list, $zone_name){
		$zone_master = zone_helper_get_zone($zone_name);

		$result = array();
		foreach($zone_master['seat'] AS $row_name => $row_seat_text){

			$result_row = array(
				'name'=>$row_name,
				'seats'=>array()
			);

			$row_seat_list = zone_helper_split_seat($row_seat_text);
			foreach($row_seat_list AS $row_seat_index){

				$seat_name = $row_name.$row_seat_index;

				// check seat name match
				foreach($seat_db_list AS $seat_db){
					if($seat_db['name']==$seat_name){
						array_push($result_row['seats'], array(
							'id'=>$seat_db['id'],
							'name'=>$seat_db['name'],
							'text'=>$row_seat_index,
							'is_booked'=>$seat_db['is_booked'],
							'is_own'=>0
						));
						break;
					}
				}
			}
			array_push($result, $result_row);
		}
		return $result;
	}

	function find_seats($row_list, $row_name){
		foreach($row_list AS $row){
			if($row['name']==$row_name)
				return $row['seats'];
		}
	}

	$rows_a1 = get_all_rows($seat_db_list, 'a1');
	$rows_a2 = get_all_rows($seat_db_list, 'a2');
	$rows_a3 = get_all_rows($seat_db_list, 'a3');

	//print_r($result);
?>
<table cellpadding="2" cellspacing="0" border="0" style="width:960px; margin: 0 auto;" id="seat-container">
	<?php
	$zone_0 = zone_helper_get_zone('a1');
	foreach($zone_0['seat'] AS $row_name => $row_seat_text):
	?>
	<tr>
		<td align="center" style="width:20px;"><?= $row_name ?></td>
		<td class="row zone-a1">
			<div style="float:right;">
			<?php
				foreach(find_seats($rows_a1, $row_name) AS $seat):
					if(($seat['is_booked']==1 && $seat['is_own']==0)):
						echo '<div class="booked"></div>';
					else:
					?>
						<a href="#<?= $seat['id'] ?>" title="<?= strtoupper($row_name.$seat['text']) ?>" id="b-<?= $seat['id'] ?>" class="<?= ($seat['is_own']==1)?'active':'' ?>"><?= $seat['text'] ?></a>
						<?= form_checkbox(array(
							'name'=>'seat[]', 'id'=>$seat['id'], 'value'=>$seat['id'],
							'checked'=>($seat['is_own']==1),
							'style'=>'display:none;'
						)) ?>
					<?php
					endif;
					//echo '<a href="#'.$seat['id'].'">'.$seat['text'].'</a>';
				endforeach;
			?>
			</div>
		</td>
		<td class="row zone-a2">
			<div style="margin:0 auto; width:275px;">
			<?php
				foreach(find_seats($rows_a2, $row_name) AS $seat):
					echo '<a href="#'.$seat['id'].'">'.$seat['text'].'</a>';
				endforeach;
			?>
			</div>
		</td>
		<td class="row zone-a3">
			<?php
				foreach(find_seats($rows_a3, $row_name) AS $seat):
					echo '<a href="#'.$seat['id'].'">'.$seat['text'].'</a>';
				endforeach;
			?>
		</td>
	</tr>
	<?php
	endforeach;
	?>

</table>