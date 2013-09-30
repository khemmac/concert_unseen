<?php

function get_seat_by_zone($seat_list, $z_name){
		$r = array();
		foreach($seat_list AS $o_seat){
			if($o_seat['zone_name']==$z_name)
				array_push($r, $o_seat['seat_name']);
		}
		return $r;
	}
	function get_zone_price($seat_list, $z_name){
		foreach($seat_list AS $o_seat){
			if($o_seat['zone_name']==$z_name)
				return $o_seat['price'];
		}
		return 0;
	}

class Pdf extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// load model
		$this->load->model('booking_model','',TRUE);

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
	}

	public function print_booking_complete(){
		if(!is_user_session_exist($this))
			redirect('member/login?rurl='.uri_string());
		$user_id = get_user_session_id($this);

		$booking_id = $this->uri->segment(3);

		if(empty($booking_id) || !is_numeric($booking_id))
			redirect('booking/check');

		$data = $this->booking_model->prepare_print_data($user_id, $booking_id);
		$person = $data['person'];
		$zone_list = $data['zone_list'];
		$booking_data = $data['booking_data'];
		$booking_list = $data['booking_list'];

		$pdf_name = 'boostplus_'.$booking_data['code'];

		//require_once('../libraries/tcpdf/config/lang/eng.php');
		require_once('./application/libraries/tcpdf/tcpdf.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Boostplus');
		$pdf->SetTitle($pdf_name);

		// set header and footer fonts
		$pdf->setHeaderFont(Array('angsanaupc', 'B', 20));

		// set default header data
		$pdf->SetHeaderData('print-logo.png', 40, 'หลักฐานการชำระเงิน', 'www.boostplus.co.th');
		// remove default header/footer
		//$pdf->setPrintHeader(false);
		//$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(4, 32, 4, 0);//PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(3);//PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(0);//PDF_MARGIN_FOOTER);

		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 1);//(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$pdf->setLanguageArray('thai');

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('angsanaupc', '', 16);

		// add a page
		$pdf->AddPage();

		// ***** USER INFO *****
		$pdf->SetFont('angsanaupc', 'B', 19);
$tbl = '<table cellspacing="0" cellpadding="3" border="0">
    <tr>
        <td rowspan="4" width="20" width="20"></td>
        <td width="305">คุณ '.$person['thName'].'</td>
        <td rowspan="4" width="10"></td>
        <td rowspan="4" align="center">
        	<table cellspaceing="0" cellpadding="3" border="1">
        		<tr><td style="background-color:#eeeeee;">รหัสการจอง<br />'.$booking_data['code'].'</td></tr>
        	</table>
        </td>
    </tr>
    <tr>
        <td>รหัสบัตรประชาชน '.$person['code'].'</td>
    </tr>
    <tr>
        <td>อีเมล์ '.$person['email'].'</td>
    </tr>
    <tr>
        <td>โทรศัพท์ '.$person['tel'].'</td>
    </tr>
</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
		// ***** END USER INFO *****

		$pdf->Ln();


		// ***** BODY LIST *****
		$pdf->SetLineWidth(0.2);
		$pdf->SetFont('', '', '16');
		$tbl = '';
		$tbl .= '<table cellpadding="3" cellspacing="0" width="100%" border="1">
					<tr>
						<td style="color:white; font-weight: bold; background-color:#18171c;" align="center">รายการ</td>
						<td style="color:white; font-weight: bold; background-color:#18171c;" align="center">โซนที่นั่ง</td>
						<td style="color:white; font-weight: bold; background-color:#18171c;" align="center">จำนวนที่นั่ง</td>
						<td style="color:white; font-weight: bold; background-color:#18171c;" align="center">ราคาต่อหน่วย</td>
						<td style="color:white; font-weight: bold; background-color:#18171c;" align="center">ราคา</td>
						<td style="color:white; font-weight: bold; background-color:#18171c;" align="center">สถานะ</td>
					</tr>';
	$has_discount = cal_helper_valid_discount_code($booking_data['discount_code']);

	$sum_price = cal_helper_get_sum_price($booking_list);
	$card_fee = cal_helper_get_card_fee($booking_list);
	$discount = cal_helper_get_discount($booking_list, $has_discount);
	$total = cal_helper_get_total_price($booking_list, $has_discount);
	foreach($zone_list AS $key_z => $z):
		$seat_list = get_seat_by_zone($booking_list, $z);
		$zone_price = get_zone_price($booking_list, $z);

		$tbl .= '<tr>
						<td style="background-color:white;" align="center">'.($key_z+1) .'</td>
						<td style="background-color:white;" align="center">'. strtoupper($z) .'</td>
						<td style="background-color:white;" align="center">'. count($seat_list) .'</td>
						<td style="background-color:white;" align="center">'. number_format($zone_price) .'</td>
						<td style="background-color:white;" align="center">'. number_format($zone_price * count($seat_list)) .'</td>';
					if($key_z==0):
						$tbl .= '<td style="background-color:white;" align="center" rowspan="'. (count($zone_list)+(4+((!empty($discount) && $discount>0)?1:0))) .'" valign="top" style="padding:5px;">';
						if($booking_data['status']==4):
							$tbl .= 'ชำระเงินแล้ว
							<br />วันที่ '.util_helper_format_date(util_helper_parse_date($booking_data['pay_date'])).'
							<br />เวลา '.util_helper_format_time(util_helper_parse_date($booking_data['pay_date']));
						elseif($booking_data['status']==3):
							$tbl .= 'เจ้าหน้าที่กำลังตรวจสอบการโอนเงินของท่าน';
						elseif($booking_data['status']==2):
							$tbl .= 'กรุณาชำระเงิน<br />ภายในวันที่';
							$tbl .= util_helper_format_date(util_helper_add_one_day($booking_data['booking_date']));
							$tbl .= '<br />ก่อนเวลา '.util_helper_format_time(util_helper_add_one_day($booking_data['booking_date']));
						else:
							$tbl .= '-';
						endif;
						$tbl.='</td>';
					endif;
		$tbl .= '</tr>';
	endforeach;

		$tbl .= '<tr>
						<td style="background-color:white;" align="right" colspan="4">ราคารวม</td>
						<td style="background-color:white;" align="center">'. number_format($sum_price) .'</td>
					</tr>
					<tr>
						<td style="background-color:white;" align="right" colspan="4">เงินตรวจสอบโอน</td>
						<td style="background-color:white;" align="center">0.'. str_pad(substr($booking_data['id'], -2), 2, '0', STR_PAD_LEFT) .'</td>
					</tr>
					<tr>
						<td style="background-color:white;" align="right" colspan="4">จำนวนเงินสำหรับทำบัตรแข็ง</td>
						<td style="background-color:white;" align="center">'.number_format($card_fee).'</td>
					</tr>';

		if(!empty($discount) && $discount>0){
			$tbl .= '<tr class="tbody">
						<td style="background-color:white;" align="right" colspan="4">ส่วนลด 10%</td>
						<td style="background-color:white;" align="center">'.number_format($discount).'</td>
				</tr>';
		}
		$tbl .= '<tr>
						<td style="background-color:white;" align="right" colspan="4">ราคารวมทั้งหมด</td>
						<td style="background-color:white;" align="center"><strong>'. number_format($total) .'.'. str_pad(substr($booking_data['id'], -2), 2, '0', STR_PAD_LEFT) .'</strong></td>
					</tr>
				</table>';
		//echo $tbl;
		$pdf->writeHTML($tbl, true, false, false, false, '');
		// ***** END BODY LIST *****


		$pdf->SetFont('', '');
		$pdf->SetFillColor(223, 128, 0);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->MultiCell(0, 0,
'กรุณาพิมพ์หลักฐานฉบับนี้ไว้ พร้อมบัตรประชาชนตัวจริง เพื่อนำมารับบัตร
ในวันงานคอนเสิร์ตขโมยซีนวันที่ 19/10/2013
เวลาและสถานที่จะแจ้งให้ทราบอีกครั้ง', 1, 'C', 1, 1);


		$pdf->SetY(-25);

		// ***** BARCODE *****
		// define barcode style
		$style = array(
			'position' => '',
			'align' => 'C',
			'stretch' => false,
			'fitwidth' => true,
			'cellfitalign' => 'R',
			'border' => true,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, //array(255,255,255),
			'text' => true,
			'font' => 'helvetica',
			'fontsize' => 8,
			'stretchtext' => 4
		);

		// Standard 2 of 5
		$pdf->write1DBarcode($booking_data['id'], 'S25', '', '', '', 18, 0.4, $style, 'N');
		// ***** END BARCODE *****


		// ***** SEATS DETAIL *****
		// add a page
		$pdf->AddPage();
		$pdf->SetLineWidth(0.2);
		$pdf->SetFont('', '', '16');
		$tbl = '';

		// populate rounds data
		$rounds = array();
		foreach($booking_list AS $b_data){
			$cur_round = $b_data['round'];

			$exist_round = false;
			foreach($rounds AS $r_key => $r_value){
				if($cur_round==$r_key){
					$exist_round = true; break;
				}
			}
			if(!$exist_round)
				$rounds[$cur_round] = array();

			// add zone
			if($b_data['round']==$cur_round){
				$cur_zone = $b_data['zone_name'];
				$exist = false;
				foreach($rounds[$cur_round] AS $r_zone_key => $r_zone_val){
					if($cur_zone==$r_zone_key){
						$exist = true; break;
					}
				}
				if(!$exist)
					$rounds[$cur_round][$cur_zone] = array();

				if($b_data['zone_name']==$cur_zone){
					array_push($rounds[$cur_round][$cur_zone], $b_data['seat_name']);
				}
			}
		}

		foreach($rounds AS $r_key => $r_val){
			$zone_list = array();
			if ($r_key==1)
				$tbl .= '<h3 style="text-align:center;">รอบที่ 1 วันที่ 19 ตุลาคม 2556 เวลา 19.00 น.</h3>';
			elseif ($r_key==2)
				$tbl .= '<h3 style="text-align:center;">รอบที่ 2 วันที่ 20 ตุลาคม 2556 เวลา 19.00 น.</h3>';
			$tbl .= '<table cellpadding="4" cellspacing="0" width="100%" border="1">
					<tr>
						<td style="color:white; font-weight: bold; background-color:#18171c;" align="center">โซนที่นั่ง</td>
						<td style="color:white; font-weight: bold; background-color:#18171c;" align="center">เลขที่นั่ง</td>
					</tr>';

			foreach($r_val AS $zone_key => $zone_val):
				$seat_list = array();

				$tbl .= '<tr>
							<td style="background-color:white;" align="center">'. strtoupper($zone_key) .'</td>
							<td style="background-color:white;" align="center">'. strtoupper(implode(', ', $zone_val)) .'</td>
						</tr>';
			endforeach;

			$tbl .= '</table>';
		}


		//echo $tbl;
		$pdf->writeHTML($tbl, true, false, false, false, '');
		// ***** END SEATS DETAIL *****

		// ***** BARCODE *****
		$pdf->SetY(-25);
		$pdf->write1DBarcode($booking_data['id'], 'S25', '', '', '', 18, 0.4, $style, 'N');
		// ***** END BARCODE *****


		// set javascript
		$is_print = $this->input->get('print');
		if($is_print=='1'){
			$pdf->IncludeJS('print(true);');
			$pdf->Output($pdf_name.'.pdf', 'I');
		}else{
			$pdf->Output($pdf_name.'.pdf', 'D');
		}
	}


}
?>
