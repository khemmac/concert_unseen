<style type="text/css">
	#content-body { padding:90px 0px 50px 0px; }

	.form-register {
		margin:0px auto;
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

	span.error { color:red; padding-left:3px; }

	#birth_year { width:70px; }

	ul#form-button { margin:0px; padding:0px; list-style:none; }
	ul#form-button li { float:left; margin-right:10px; }

</style>
<div id="content-body">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<h3 style="text-align:center; font-family:'thaisans_neuebold';">กรุณากรอกข้อมูลเพื่อสมัครสมาชิก</h3>
	<div id="form">
		<?= form_open('', array('class'=>'form-register form-horizontal')); ?>
		<?php
			$days = array();
			for($i=1;$i<=31;$i++)
				$days[$i] = $i;

			$year_start = 2013;
			$years = array();
			for($i=$year_start;$i>=$year_start-89;$i--)
				$years[$i] = language_helper_is_th($this)?($i+543):$i;

			$this->load->model('person_model','',TRUE);
			$rules = $this->person_model->get_register_rules();
			function get_label($name, $rules){
				foreach ($rules as $key => $value) {
					if($value['field']==$name){
						$asterisk = (strpos($value['rules'],'required')!==false)?'<span class="error">*</span>':'';
						return $value['label'].$asterisk;
					}
				}
			}

			$forms = array(
				array(
					'name'		=> 'username',
					'maxlength'	=> '20',
					'label'		=>	get_label('username', $rules)
				),
				array(
					'name'		=> 'password',
					'type'		=> 'password',
					'maxlength'	=> '50',
					'label'		=>	get_label('password', $rules)
				),
				array(
					'name'		=> 'passwordConf',
					'type'		=> 'password',
					'maxlength'	=> '50',
					'label'		=>	get_label('passwordConf', $rules)
				),
				array(
					'name'		=> 'question',
					'class'		=> 'input-xlarge',
					'type'		=> 'dropdown',
					'options'	=> array('สัตว์เลี้ยงตัวแรกของคุณชื่ออะไร?'=>language_helper_is_th($this)?'สัตว์เลี้ยงตัวแรกของคุณชื่ออะไร?':'Your first pet\'s name?',
										'เพื่อนสนิทสมัยวัยรุ่นของคุณชื่ออะไร?'=>language_helper_is_th($this)?'เพื่อนสนิทสมัยวัยรุ่นของคุณชื่ออะไร?':'What is your teenage best friend\'s name?',
										'อาหารจานแรกที่คุณหัดทำคืออะไร?'=>language_helper_is_th($this)?'อาหารจานแรกที่คุณหัดทำคืออะไร?':'What is the first dish you cooked?',
										'คุณขึ้นเครื่องบินไปที่ไหนครั้งแรก?'=>language_helper_is_th($this)?'คุณขึ้นเครื่องบินไปที่ไหนครั้งแรก?':'What is the destination you fly to?'
									),
					'label'		=>	get_label('question', $rules)
				),
				array(
					'name'		=> 'answer',
					'maxlength'	=> '255',
					'label'		=>	get_label('answer', $rules)
				),
				array(
					'name'		=> 'code',
					'maxlength'	=> '13',
					'label'		=>	get_label('code', $rules)
				),
				array(
					'name'		=> 'thName',
					'class'		=> 'input-xlarge',
					'maxlength'	=> '255',
					'label'		=>	get_label('thName', $rules)
				),
				array(
					'name'		=> 'enName',
					'class'		=> 'input-xlarge',
					'maxlength'	=> '255',
					'label'		=>	'ชื่อ - นามสกุล<br />(ภาษาอังกฤษ)'
				),
				array(
					'name'		=> 'nickName',
					'class'		=> 'input-small',
					'maxlength'	=> '100',
					'label'		=>	get_label('nickName', $rules)
				),
				array(
					'name'		=> 'sex',
					'class'		=> 'input-small',
					'type'		=> 'dropdown',
					'options'	=> array('M'=>language_helper_is_th($this)?'ชาย':'Male', 'F'=>language_helper_is_th($this)?'หญิง':'Female'),
					'label'		=>	get_label('sex', $rules)
				),
				array(
					'layout_type'	=> 'row',
					'label'		=>	'วัน/เดือน/ปีเกิด',
					'items'			=> array(
						array(
							'name'		=> 'birth_date',
							'class'		=> 'birth_date span1',
							'type'		=> 'dropdown',
							'options'	=> $days
						),
						array(
							'name'		=> 'birth_month',
							'class'		=> 'birth_month span2',
							'type'		=> 'dropdown',
							'options'	=> array('1'=>language_helper_is_th($this)?'มกราคม':'January',
												'2'=>language_helper_is_th($this)?'กุมภาพันธ์':'Febuary',
												'3'=>language_helper_is_th($this)?'มีนาคม':'March',
												'4'=>language_helper_is_th($this)?'เมษายน':'April',
												'5'=>language_helper_is_th($this)?'พฤษภาคม':'May',
												'6'=>language_helper_is_th($this)?'มิถุนายน':'June',
												'7'=>language_helper_is_th($this)?'กรกฎาคม':'July',
												'8'=>language_helper_is_th($this)?'สิงหาคม':'August',
												'9'=>language_helper_is_th($this)?'กันยายน':'September',
												'10'=>language_helper_is_th($this)?'ตุลาคม':'October',
												'11'=>language_helper_is_th($this)?'พฤศจิกายน':'November',
												'12'=>language_helper_is_th($this)?'ธันวาคม':'December'
											)
						),
						array(
							'name'		=> 'birth_year',
							'class'		=> 'birth_year span1',
							'type'		=> 'dropdown',
							'options'	=> $years,
							'value'		=> $year_start-5
						)
					)
				),
				array(
					'name'		=> 'address',
					'maxlength'	=> '1000',
					'label'		=>	get_label('address', $rules)
				),
				array(
					'name'		=> 'tel',
					'maxlength'	=> '10',
					'label'		=>	get_label('tel', $rules)
				),
				array(
					'name'		=> 'email',
					'maxlength'	=> '255',
					'label'		=>	get_label('email', $rules)
				),
				array(
					'name'		=> 'job',
					'maxlength'	=> '255',
					'label'		=>	get_label('job', $rules)
				),
				array(
					'name'		=> 'job_area',
					'maxlength'	=> '255',
					'label'		=>	get_label('job_area', $rules)
				),
				array(
					'name'		=> 'favorite_artist',
					'class'		=> 'favorite_artist',
					'label'		=>	get_label('favorite_artist', $rules)
				)
			);

			form_helper_generate_bootstrap($forms);
		?>
		<div class="control-group">
			<div class="controls">
				<ul id="form-button">
					<li>
						<?= form_submit(array(
								'id'		=> 'submit',
								'value'		=> 'บันทึก',
								'class'		=> 'submit btn btn-primary'
							));
						?>
					</li>
					<li><a href="<?= site_url('index') ?>" class="btn">กลับหน้าหลัก</a></li>
				</ul>
			</div>
		</div>
		<?= form_close() ?>
	</div>

</div>
<script type="text/javascript">
	$(function(){
		// number only
		$('input[name=code]').numeric({ decimal: false, negative: false });

		$('#submit').click(function(){
			var bd = $('select[name=birth_date]').val(),
				bm = $('select[name=birth_month]').val(),
				by = $('select[name=birth_year]').val();
			if(!common.form.isValidDate(by,bm,bd)){
				alert(language_helper_is_th($this)?'วันที่ผิดพลาด กรุณาตรวจสอบอีกครั้ง':'Date is invalid please try again.');
				return false;
			}

			setTimeout(function(){
				$(this).attr('disabled', 'disabled');
			}, 1);
		});

		// number only
		$('input[name=tel]').numeric({ decimal: false, negative: false });
	});
</script>
