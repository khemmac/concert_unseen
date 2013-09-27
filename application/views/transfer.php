<style type="text/css">
	#content-body { padding-top:130px; min-height:520px; }

	.form-transfer {
	  	margin:0 auto;
	    width: 555px;
	    padding: 19px 29px 19px;
	    background-color: #f5f5f5;
	    border: 1px solid #e5e5e5;
	    -webkit-border-radius: 5px;
	       -moz-border-radius: 5px;
	            border-radius: 5px;
	    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	       -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	            box-shadow: 0 1px 2px rgba(0,0,0,.05);
	}

	.form-horizontal .control-group {
		margin-bottom: 10px;
	}

	#transfer_year { width:70px; }

	ul#form-button { margin:0px; padding:0px; list-style:none; }

</style>
<div id="content-body" class="page-transfer">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="form">
		<?= form_open_multipart('','class="form-transfer form-horizontal"'); ?>
		<?php
			$days = array();
			for($i=1;$i<=31;$i++)
				$days[$i] = $i;


			$years = array();
			for($i=2013;$i>=2013;$i--)
				$years[$i] = language_helper_is_th($this)?($i+543):$i;

			$hours = array();
			for($i=0;$i<24;$i++){
				$v = str_pad($i, 2, '0', STR_PAD_LEFT);
				$hours[$v] = $v;
			}
			$minutes = array();
			for($i=0;$i<60;$i++){
				$v = str_pad($i, 2, '0', STR_PAD_LEFT);
				$minutes[$v] = $v;
			}

			$forms = array(
				array(
					'name'		=> 'code',
					'maxlength'	=> '7',
					'class'		=> 'code',
					'label'		=> 'รหัสจอง'
				),
				array(
					'layout_type'	=> 'row',
					'label'		=>	'วันที่โอนเงิน',
					'items'			=> array(
						array(
							'name'		=> 'transfer_date',
							'class'		=> 'span1',
							'type'		=> 'dropdown',
							'options'	=> $days
						),
						array(
							'name'		=> 'transfer_month',
							'class'		=> 'span2',
							'type'		=> 'dropdown',
							'options'	=> array('9'=>'กันยายน','10'=>'ตุลาคม')
						),
						array(
							'name'		=> 'transfer_year',
							'class'		=> 'span1',
							'type'		=> 'dropdown',
							'options'	=> $years
						)
					)
				),
				array(
					'layout_type'	=> 'row',
					'label'		=>	'เวลาโอนเงิน',
					'items'			=> array(
						array(
							'name'		=> 'transfer_hh',
							'class'		=> 'span1',
							'type'		=> 'dropdown',
							'options'	=> $hours
						),
						array(
							'name'		=> 'transfer_mm',
							'class'		=> 'span1',
							'type'		=> 'dropdown',
							'options'	=> $minutes
						)
					)
				),
				array(
					'layout_type'	=> 'row',
					'label'		=>	'จำนวนเงินที่โอน',
					'items'			=> array(
						array(
							'name'		=> 'pay_money',
							'maxlength'	=> '50',
							'class'		=> 'span2'
						),
						array(
							'name'		=> 'pay_money_satang',
							'maxlength'	=> '2',
							'class'		=> 'span1'
						)
					)
				),
				array(
					'name'		=> 'bank_name',
					'class'		=> 'bank_name',
					'type'		=> 'dropdown',
					'options'	=> array(
						'ธนาคารกรุงเทพ'=>language_helper_is_th($this)?'ธนาคารกรุงเทพ':'Bangkok Bank',
						'ธนาคารกสิกรไทย'=>language_helper_is_th($this)?'ธนาคารกสิกรไทย':'K-Bank',
						'ธนาคารไทยพาณิชย์'=>language_helper_is_th($this)?'ธนาคารไทยพาณิชย์':'SCB'
					),
					'label'		=> 'ธนาคารที่โอน'
				),
				array(
					'name'		=> 'userfile',
					'type'		=> 'upload',
					'class'		=> 'slip',
					'label'		=> 'หลักฐานการโอนเงิน'
				)
			);

			form_helper_generate_bootstrap($forms);
		?>
		<ul id="form-button">
			<li class="text-center">
				<?= form_submit(array(
						'id'		=> 'b-submit',
						'value'		=> 'แจ้งการโอนเงิน',
						'class'		=> 'btn btn-primary'
					));
				?>
			</li>
		</ul>
		<?= form_close() ?>
	</div>

</div>
<script type="text/javascript">
	$(function(){
		$('#b-submit').click(function(e){
			var bd = $('select[name=transfer_date]').val(),
				bm = $('select[name=transfer_month]').val(),
				by = $('select[name=transfer_year]').val();
			if(!common.form.isValidDate(by,bm,bd)){
				alert('วันที่ผิดพลาด กรุณาตรวจสอบอีกครั้ง');
				return false;
			}
		});


		// number only
		$('input[name=pay_money]').numeric({ decimal: false, negative: false });
		$('input[name=pay_money_satang]').numeric({ decimal: false, negative: false });

		//common.popup.show(null, '#transfer-confirm-popup');

	});
</script>
