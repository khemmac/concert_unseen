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

}