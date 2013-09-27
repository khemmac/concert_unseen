<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


	function zone_helper_get_zone($zone_name = null) {
		$zone = array(
			array(
				'name'=>'a1',
				'seat'=>array(
					'ก'=>'1-12',
					'ข'=>'1-12',
					'ค'=>'1-13',
					'ฅ'=>'1-13',
					'ฆ'=>'1-13',
					'ง'=>'1-14',
					'จ'=>'1-14',
					'ฉ'=>'1-14',
					'ช'=>'1-14',
					'ฌ'=>'1-14',
				)
			),
			array(
				'name'=>'a2',
				'seat'=>array(
					'ก'=>'13-25',
					'ข'=>'13-25',
					'ค'=>'14-26',
					'ฅ'=>'14-26',
					'ฆ'=>'14-26',
					'ง'=>'15-27',
					'จ'=>'15-27',
					'ฉ'=>'15-27',
					'ช'=>'15-27',
					'ฌ'=>'15-27',
				)
			),
			array(
				'name'=>'a3',
				'seat'=>array(
					'ก'=>'26-37',
					'ข'=>'26-37',
					'ค'=>'27-39',
					'ฅ'=>'27-39',
					'ฆ'=>'27-39',
					'ง'=>'28-41',
					'จ'=>'28-41',
					'ฉ'=>'28-41',
					'ช'=>'28-41',
					'ฌ'=>'28-41',
				)
			),
			//// B //////////////////////////////////////////////////////
			array(
				'name'=>'b1',
				'seat'=>array(
					'ญ'=>'1-16',
					'ฏ'=>'1-16',
					'ฐ'=>'1-16',
					'ฑ'=>'1-16',
					'ฒ'=>'1-16',
					'ณ'=>'1-16',
					'ด'=>'1-16',
					'ต'=>'1-16',
					'ถ'=>'1-16',
					'ท'=>'1-16',
					'ธ'=>'1-16',
					'น'=>'1-16',
					'บ'=>'1-16',
					'ป'=>'1-16',
					'ผ'=>'1-16'
				)
			),
			array(
				'name'=>'b2',
				'seat'=>array(
					'ญ'=>'17-31',
					'ฏ'=>'17-30',
					'ฐ'=>'17-31',
					'ฑ'=>'17-30',
					'ฒ'=>'17-31',
					'ณ'=>'17-30',
					'ด'=>'17-31',
					'ต'=>'17-30',
					'ถ'=>'17-31',
					'ท'=>'17-30',
					'ธ'=>'17-31',
					'น'=>'17-30',
					'บ'=>'17-31',
					'ป'=>'17-30',
					'ผ'=>'17-31'
				)
			),
			array(
				'name'=>'b3',
				'seat'=>array(
					'ญ'=>'32-47',
					'ฏ'=>'31-46',
					'ฐ'=>'32-47',
					'ฑ'=>'31-46',
					'ฒ'=>'32-47',
					'ณ'=>'31-46',
					'ด'=>'32-47',
					'ต'=>'31-46',
					'ถ'=>'32-47',
					'ท'=>'31-46',
					'ธ'=>'32-47',
					'น'=>'31-46',
					'บ'=>'32-47',
					'ป'=>'31-46',
					'ผ'=>'32-47'
				)
			),
			//// C //////////////////////////////////////////////////////
			array(
				'name'=>'c1',
				'seat'=>array(
					'ฝ'=>'1-16',
					'พ'=>'1-16',
					'ฟ'=>'1-16',
					'ภ'=>'1-16',
					'ม'=>'1-16',
					'ย'=>'1-16',
					'ร'=>'1-16',
					'ล'=>'1-16',
					'ว'=>'1-16',
					'ศ'=>'1-16',
					'ษ'=>'1-16',
					'ส'=>'1-16',
					'ห'=>'1-16',
					'ฬ'=>'1-16',
					'อ'=>'1-16',
					'ฮ'=>'1-16'
				)
			),
			array(
				'name'=>'c2',
				'seat'=>array(
					'ฝ'=>'17-30',
					'พ'=>'17-31',
					'ฟ'=>'17-30',
					'ภ'=>'17-31',
					'ม'=>'17-30',
					'ย'=>'17-31',
					'ร'=>'17-30',
					'ล'=>'17-31',
					'ว'=>'17-30',
					'ศ'=>'17-31',
					'ษ'=>'17-30',
					'ส'=>'17-31',
					'ห'=>'17-30',
					'ฬ'=>'17-31',
					'อ'=>'17-30',
					'ฮ'=>'17-31'
				)
			),
			array(
				'name'=>'c3',
				'seat'=>array(
					'ฝ'=>'31-46',
					'พ'=>'32-47',
					'ฟ'=>'31-46',
					'ภ'=>'32-47',
					'ม'=>'31-46',
					'ย'=>'32-47',
					'ร'=>'31-46',
					'ล'=>'32-47',
					'ว'=>'31-46',
					'ศ'=>'32-47',
					'ษ'=>'31-46',
					'ส'=>'32-47',
					'ห'=>'31-46',
					'ฬ'=>'32-47',
					'อ'=>'31-46',
					'ฮ'=>'32-47'
				)
			),
			//// D //////////////////////////////////////////////////////
			array(
				'name'=>'d1',
				'seat'=>array(
					'A'=>'1-13',
					'B'=>'1-13',
					'C'=>'1-13',
					'D'=>'1-13',
					'E'=>'1-11',
					'F'=>'1-11',
					'G'=>'1-11',
					'H'=>'1-11',
					'I'=>'1-11',
					'J'=>'1-11',
					'K'=>'1-11',
					'L'=>'1-11'
				)
			),
			array(
				'name'=>'d2',
				'seat'=>array(
					'B'=>'14-26',
					'C'=>'14-26',
					'D'=>'14-26',
					'E'=>'12-22',
					'F'=>'12-24',
					'G'=>'12-24',
					'H'=>'12-24',
					'I'=>'12-24',
					'J'=>'12-24',
					'K'=>'12-24',
					'L'=>'12-24'
				)
			),
			array(
				'name'=>'d3',
				'seat'=>array(
					'A'=>'14-26',
					'B'=>'27-39',
					'C'=>'27-39',
					'D'=>'27-39',
					'E'=>'23-33',
					'F'=>'25-35',
					'G'=>'25-35',
					'H'=>'25-35',
					'I'=>'25-35',
					'J'=>'25-35',
					'K'=>'25-35',
					'L'=>'25-35'
				)
			),
			//// E //////////////////////////////////////////////////////
			array(
				'name'=>'e1',
				'seat'=>array(
					'M'=>'1-12',
					'N'=>'1-12',
					'O'=>'1-12',
					'P'=>'1-12',
					'Q'=>'1-12',
					'R'=>'1-12',
					'S'=>'1-12'
				),
				'max_col' => 16
			),
			array(
				'name'=>'e2',
				'seat'=>array(
					'M'=>'13-28',
					'N'=>'13-28',
					'O'=>'13-28',
					'P'=>'13-28',
					'Q'=>'13-28',
					'R'=>'13-28',
					'S'=>'13-28'
				),
				'max_col' => 31-17+1
			),
			array(
				'name'=>'e3',
				'seat'=>array(
					'M'=>'29-40',
					'N'=>'29-40',
					'O'=>'29-40',
					'P'=>'29-40',
					'Q'=>'29-40',
					'R'=>'29-40',
					'S'=>'29-40'
				)
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
