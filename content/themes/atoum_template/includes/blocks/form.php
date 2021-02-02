<?php

	function get_block_form($content, array $attributes){
		switch($attributes['template']){
			default:

				return '<form' . get_id_classes($attributes) . get_attributes_values($attributes) . '>' . $content . '</form>';
				break;
		}
	}

	function get_block_label($content, array $attributes){
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
	
	function get_attributes_values(array $attributes){
		$attributes_values = '';

		if(array_key_exists('name', $attributes)){

			$attributes_values .= ' name="' . $attributes['name'] . '"';
		}

		if(array_key_exists('action', $attributes)){

			$attributes_values .= ' action="' . $attributes['action'] . '"';
		}

		if(array_key_exists('target', $attributes)){

			$attributes_values .= ' target="' . $attributes['target'] . '"';
		}

		if(array_key_exists('method', $attributes)){

			$attributes_values .= ' method="' . $attributes['method'] . '"';

			if($attributes['method'] == 'post'){

				if(array_key_exists('enctype', $attributes)){

					$attributes_values .= ' enctype="' . $attributes['enctype'] . '"';
				}
			}
		}
		
		if(array_key_exists('name', $attributes)){

			$attributes_values .= ' name="' . $attributes['name'] . '"';
		}

		if(array_key_exists('autocomplete', $attributes)){

			$attributes_values .= ' autocomplete="' . $attributes['autocomplete'] . '"';
		}

		if(array_key_exists('novalidate', $attributes)){

			$attributes_values .= ' ' . $attributes['novalidate'];
		}

		if(array_key_exists('accept-charset', $attributes)){

			$attributes_values .= ' accept-charset="' . $attributes['accept-charset'] . '"';
		}

		if(array_key_exists('rel', $attributes)){

			$attributes_values .= ' ' . $attributes['rel'];
		}

		if(array_key_exists('required', $attributes)){

			$attributes_values .= ' ' . $attributes['required'];
		}
		
		if(array_key_exists('value', $attributes)){

			$attributes_values .= ' value="' . $attributes['value'] . '"';
		}

		return $attributes_values;
	}
	
	function get_input_type(array $attributes){

		$type = 'text';

		if(array_key_exists('type', $attributes)){
			$type = $attributes['type'];
		}
		
		return ' type="' . $type . '"';
	}