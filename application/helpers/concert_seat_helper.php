<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	// ค้นค่า rows ทั้งหมดที่อยู่ภายใต้ zone ที่ส่งมา โดยเทียบกับ database
	function seat_helper_get_all_rows($seat_db_list, $zone_name){
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
							'is_own'=>$seat_db['is_own']
						));
						break;
					}
				}
			}
			array_push($result, $result_row);
		}
		return $result;
	}

	function seat_helper_find_seats_by_rowname($row_list, $row_name){
		foreach($row_list AS $row){
			if($row['name']==$row_name)
				return $row['seats'];
		}
	}

	function seat_helper_generate_seat($row_name, $seat){
		if(($seat['is_booked']==1 && $seat['is_own']==0)):
			echo '<div class="booked"><span></span></div>';
		else:
			echo '<a href="#'. $seat['id'] .'" title="'. strtoupper($row_name.$seat['text'])
					.'" id="b-'. $seat['id'] .'" class="'. (($seat['is_own']==1)?'active':'') .'">'
					.(($seat['is_own']==1)?'<span></span>':$seat['text']).'</a>'
				.form_checkbox(array(
					'name'=>'seat[]', 'id'=>$seat['id'], 'value'=>$seat['id'],
					'checked'=>($seat['is_own']==1),
					'style'=>'display:none;'
				));
		endif;
	}

	function seat_helper_generate_seat_row($rows_data, $row_name){
		$seat_list = (seat_helper_find_seats_by_rowname($rows_data, $row_name));
		if(count($seat_list)>0){
			foreach(seat_helper_find_seats_by_rowname($rows_data, $row_name) AS $seat):
				seat_helper_generate_seat($row_name, $seat);
			endforeach;
		}
	}
