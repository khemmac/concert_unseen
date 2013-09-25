<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*




ญ
ฏ
ฐ
ฑ
ฒ
ณ
ด
ต
ถ
ท
ธ
น
บ
ป
ผ


ฝ
พ
ฟ
ภ
ม
ย
ร
ล
ว
ศ
ษ
ส
ห
ฬ
อ
ฮ
*/

	function zone_helper_get_zone($zone_name = null) {
		$zone = array(
			array(
				'name'=>'a1',
				'seat'=>array(
					'ก'=>'1-12',
					'ข'=>'1-12',
					'ค'=>'1-13',
					'ต'=>'1-13',
					'ฆ'=>'1-13',
					'ง'=>'1-14',
					'จ'=>'1-14',
					'ฉ'=>'1-14',
					'ช'=>'1-14',
					'ฌ'=>'1-14',
				),
				'max_col' => 14
			),
			array(
				'name'=>'a2',
				'seat'=>array(
					'ก'=>'13-25',
					'ข'=>'13-25',
					'ค'=>'14-26',
					'ต'=>'14-26',
					'ฆ'=>'14-26',
					'ง'=>'15-27',
					'จ'=>'15-27',
					'ฉ'=>'15-27',
					'ช'=>'15-27',
					'ฌ'=>'15-27',
				),
				'max_col' => 13
			),
			array(
				'name'=>'a3',
				'seat'=>array(
					'ก'=>'26-37',
					'ข'=>'26-37',
					'ค'=>'27-39',
					'ต'=>'27-39',
					'ฆ'=>'27-39',
					'ง'=>'28-41',
					'จ'=>'28-41',
					'ฉ'=>'28-41',
					'ช'=>'28-41',
					'ฌ'=>'28-41',
				),
				'max_col' => 14
			)
		);
		if(!empty($zone_name)){
			foreach($zone as $zone_item){
				if($zone_item['name']==$zone_name){
					return $zone_item;
				}
			}
		}else
			return $zone;
	}

	function zone_helper_split_seat($s){
		$result = array();
		$spitted_seat = explode(',', $s);
		foreach($spitted_seat as $value){
			$ordered_seat = explode('-', $value);
			$ordered_start = $ordered_seat[0];
			if(!empty($ordered_seat[1])){
				$ordered_end = $ordered_seat[1];
				for($i=$ordered_start; $i<=$ordered_end; $i++){
					array_push($result, $i);
				}
			}else{
				array_push($result, $ordered_start);
			}
		}
		return $result;
	}

	function zone_helper_valid_zone_group($z){
		return in_array($z, array('a','b','c','d','e'));
	}
