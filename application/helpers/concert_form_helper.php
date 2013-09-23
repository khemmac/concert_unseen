<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	function form_helper_generate_bootstrap($bs_forms, $form_db_value = array()){
		foreach ($bs_forms as $key => $bs_form) {
			$label = '';
			if(array_key_exists('label', $bs_form)){
				$label = $bs_form['label'];
				unset($bs_form['label']);
			}

			if(array_key_exists('layout_type', $bs_form) && $bs_form['layout_type']=='row'){
				echo PHP_EOL.'<div class="control-group">
<label class="control-label">'.$label.'</label>
<div class="controls controls-row">';
				foreach ($bs_form['items'] as $item_key => $item_value) {
					form_helper_generate_item($item_value, $form_db_value);
				}
				echo '</div></div>';
			}else{
				echo PHP_EOL.'<div class="control-group">
<label class="control-label" for="'.$bs_form['name'].'">'.$label.'</label>
<div class="controls">';
				form_helper_generate_item($bs_form, $form_db_value);
				echo '</div></div>';
			}
		}
	}

	function form_helper_generate_item($value, $form_db_value = array()){
		$form_error = form_error($value['name']);
		if(!empty($form_error)){
			$value['qtip-data'] = $form_error;
		}

		if(array_key_exists('name', $value))
			$value['id'] = $value['name'];

		// เช็คว่าถ้ามี set value จาก form_validator หรือไม่
		$validator_set_value = set_value($value['name']);
		$__set_value = null;
		if(!empty($validator_set_value))
			$__set_value = $validator_set_value;
		// เช็คว่ามีค่าจาก database ส่งมาหรือไม่
		else if(!empty($form_db_value) && !empty($form_db_value[$value['name']]))
			$__set_value = $form_db_value[$value['name']];

		if(!empty($value['type']) && $value['type']=='password'){
			echo form_password($value);
		}else if(!empty($value['type']) && $value['type']=='upload'){
			echo form_upload($value);
		}else if(!empty($value['type']) && $value['type']=='dropdown'){
			if(!empty($__set_value))
				$value['value'] = $__set_value;

			$dd_option = '';
			if(array_key_exists('class', $value))
				$dd_option .= 'class="'.$value['class'].'"';
			if(array_key_exists('id', $value))
				$dd_option .= 'id="'.$value['id'].'"';

			if(!empty($value['value']))
				echo form_dropdown($value['name'], $value['options'], $value['value'], $dd_option);
			else
				echo form_dropdown($value['name'], $value['options'],'', $dd_option);
		}else{
			if(!empty($__set_value))
				$value['value'] = $__set_value;
			echo form_input($value);
		}
	}

	function form_helper_generate_form($forms, $form_db_value = array()) {
		foreach ($forms as $key => $value) {
			form_helper_generate_item($value, $form_db_value);
		}
	}