<?php
class Export_excel extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function index(){
		echo 'Index of export_excel controller';
	}

	function booked_seat(){
		require './application/libraries/PHPExcel/PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Concert Unseen")
									 ->setLastModifiedBy("Concert Unseen")
									 ->setTitle("ที่นั่ง แบ่งตาม zone")
									 ->setSubject("ที่นั่ง แบ่งตาม zone")
									 ->setDescription("ที่นั่ง แบ่งตาม zone")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Concert");

		$objPHPExcel->getActiveSheet()->setTitle('รอบที่ 1');
		$objPHPExcel->createSheet()->setTitle('รอบที่ 2');


		$chars = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
		// get all zone
		$q = $this->db->get('zone');
		$zones = $q->result();
		foreach($zones AS $z_key => $z){
			//echo '<h3>'.$z->name .'</h3><hr />';

			for($round=1;$round<=2;$round++){
				// prepare indexes
				$col_index = $chars[$z_key];
				$sheet_index = $round-1;

				$current_sheet = $objPHPExcel->setActiveSheetIndex($sheet_index);

				// cellcolor
				$bg_color = '';
				switch ($z->name[0]) {
					case 'a': $bg_color='EC2227'; break;
					case 'b': $bg_color='4764AF'; break;
					case 'c': $bg_color='62BB46'; break;
					case 'd': $bg_color='60489D'; break;
					case 'e': $bg_color='F26522'; break;
				}

				// add header data
				$cell_index = $col_index.'1';
				$current_sheet->setCellValue($cell_index, strtoupper($z->name));
				$cell_style = $current_sheet->getStyle($cell_index);
				$cell_style->applyFromArray(
					array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => $bg_color)
						),
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
						),
						'font' => array(
							'bold' => true
						)
					)
				);

				//echo 'ROUND : '.$round.'<hr />';
				$tb_booking = $this->db->dbprefix('booking');
				$this->db->where('booking_id IN (SELECT id FROM '.$tb_booking.' WHERE status>1)');
				$q_s = $this->db->get_where('seat', array(
					'zone_id'=> $z->id,
					'is_booked'=>1,
					'round'=>$round
				));
				$seats = $q_s->result();
				foreach($seats AS $s_key => $seat){
					// prepare indexes
					$row_index = $s_key+2;
					//echo $seat->name.'<br />';
					$seat_cell_index = $col_index.$row_index;
					$current_sheet->setCellValue($seat_cell_index, strtoupper($seat->name));
					$seat_cell_style = $current_sheet->getStyle($seat_cell_index);
					$seat_cell_style->applyFromArray(
						array(
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							)
						)
					);
				}
			}
		}


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		//header('Content-Disposition: attachment;filename="daily_account_'.substr($cur_date, 0, 10).'.xls"');
		header('Content-Disposition: attachment;filename="booked_seat_'.gmdate('D, d M Y H:i:s').'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;

	}

	function booking(){
		require './application/libraries/PHPExcel/PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Concert Unseen")
									 ->setLastModifiedBy("Concert Unseen")
									 ->setTitle("ที่จอง")
									 ->setSubject("ที่จอง")
									 ->setDescription("ที่จอง")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Concert");

		$current_sheet = $objPHPExcel->getActiveSheet();
		$current_sheet->setTitle('รายละเอียดการจอง');


		// add header data
		$chars = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
		$header_field = array(
			'code'=>'รหัสจอง',
			'thName'=>'ชื่อ สกุล',
			'citizen'=>'รหัสบัตรประชาชน',
			'email'=>'อีเมล์',
			'tel'=>'เบอร์โทร',
			'count_seat'=>'จำนวนที่นั่ง',
			'round1'=>'รอบที่ 1',
			'round2'=>'รอบที่ 2'
		);
		$header_index = 0;
		foreach($header_field AS $key=>$value){
			$col_index = $chars[$header_index++];
			$cell_index = $col_index.'1';
			$cell_style = $current_sheet->getStyle($cell_index);
			$current_sheet->setCellValue($cell_index, $value);
			$cell_style->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '62BB46')
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					),
					'font' => array(
						'bold' => true
					)
				)
			);
		}
		// end add header data

		$sql = 'select
p.thName,
p.code AS citizen,
p.email,
p.tel,
(select count(s.id) from unseen_seat s where s.booking_id=b.id) AS count_seat,
b.* from unseen_booking b
left join person p on b.person_id=p.id
where b.status=4 and b.person_id NOT IN (2)';
		$q = $this->db->query($sql);
		$q_result = $q->result_array();
		$q->free_result();

		$sql = 'select s.* from unseen_seat s where s.booking_id in (
select
b.id from unseen_booking b
left join person p on b.person_id=p.id
where b.status=4
)';
		$q = $this->db->query($sql);
		$q_result_seat = $q->result_array();
		$q->free_result();

		for($i=0;$i<count($q_result);$i++){
			$b = $q_result[$i];

			// add booking content
			$header_index = 0;
			foreach($header_field AS $key=>$value){
				$col_index = $chars[$header_index++];
				$cell_index = $col_index.($i+2);

				if($key=='round1' || $key=='round2'){
					// add seat content
					$seat_arr = array();
					for($j=0;$j<count($q_result_seat);$j++){
						$s = $q_result_seat[$j];
						if($b['id']==$s['booking_id'] && $s['round']==(($key=='round1')?1:2)){
							array_push($seat_arr, $s['name']);
						}
					}
					$current_sheet->setCellValue($cell_index, implode(', ', $seat_arr));
					// end add seat content
					continue;
				};
				$current_sheet->setCellValueExplicit($cell_index, $b[$key], PHPExcel_Cell_DataType::TYPE_STRING);

				if($key=='count_seat' || $key=='citizen'){
					$cell_style = $current_sheet->getStyle($cell_index);
					$cell_style->applyFromArray(
						array(
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							)
						)
					);
				}

			}
			// end add booking content

		}

		// Adjust cell format
		foreach(range('A','H') as $columnID) {
		    $current_sheet->getColumnDimension($columnID)->setAutoSize(true);
		}


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		//header('Content-Disposition: attachment;filename="daily_account_'.substr($cur_date, 0, 10).'.xls"');
		header('Content-Disposition: attachment;filename="booking_'.gmdate('D, d M Y H:i:s').'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

}