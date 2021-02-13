<?php

	function get_block_form(array $attributes, string $content){
		switch($attributes['template']){
			default:

				return '<form' . get_id_classes($attributes) . get_attributes_values($attributes) . '>' . $content . '</form>';
				break;
		}
	}

	function get_block_label(array $attributes, string $content){
		switch($attributes['template']){
			default:
				
				return '<label' . get_id_classes($attributes) . get_attributes_values($attributes) . '>' . $content . '</label>';
				break;
		}		
	}

	function get_block_input(array $attributes){
		switch($attributes['template']){
			default:

				return '<input' . get_input_type($attributes) . get_id_classes($attributes) . get_attributes_values($attributes) . '>';
				break;
		}
	}
	
	function get_input_type(array $attributes){

		$type = 'text';

		if(array_key_exists('type', $attributes)){
			$type = $attributes['type'];
		}
		
		return ' type="' . $type . '"';
	}