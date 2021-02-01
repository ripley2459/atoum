<?php

	function get_attributes_values($attributes){
		$attributes_values = '';
		
		if(array_key_exists('name', $attributes)){
			$attributes_values = $attributes_values . " name=" . $attributes['name'];
		}

		if(array_key_exists('action', $attributes)){
			$attributes_values = $attributes_values . " action=" . $attributes['action'];
		}

		if(array_key_exists('target', $attributes)){
			$attributes_values = $attributes_values . " target=" . $attributes['target'];
		}

		if(array_key_exists('method', $attributes)){
			$attributes_values = $attributes_values . " method=" . $attributes['method'];
			if($attributes['method'] == 'post'){
				if(array_key_exists('enctype', $attributes)){
					$attributes_values = $attributes_values . " enctype=" . $attributes['enctype'];
				}
			}
		}

		if(array_key_exists('autocomplete', $attributes)){
			$attributes_values = $attributes_values . " autocomplete=" . $attributes['autocomplete'];
		}

		if(array_key_exists('novalidate', $attributes)){
			$attributes_values = $attributes_values . " " . $attributes['novalidate'];
		}

		if(array_key_exists('accept-charset', $attributes)){
			$attributes_values = $attributes_values . " accept-charset=" . $attributes['accept-charset'];
		}

		if(array_key_exists('rel', $attributes)){
			$attributes_values = $attributes_values . " " . $attributes['rel'];
		}
		
		if(array_key_exists('required', $attributes)){
			$attributes_values = $attributes_values . " " . $attributes['required'];
		}

		return $attributes_values;
	}

	function get_block_form($content, $id, $additional_classes, array $attributes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				
				$attributes_values = get_attributes_values($attributes);
				
				return '<form' . $id . $additional_classes . $attributes_values . '>' . $content . '</form';
				break;
		}
	}
	
	function get_block_label($content, $for, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($for != ''){
					$for = ' for= "' . $for . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				
				return '<label' . $for . $additional_classes . '>' . $content . '</label>';
				break;
		}		
	}
	
	function get_block_input_text($id, $name, $additional_classes, array $attributes, $template, $custom){
		switch($template){
			default:
				$text_type= 'text';
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($name != ''){
					$name = ' name= "' . $name . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}

				$attributes_values = get_attributes_values($attributes);

				if(array_key_exists('password', $attributes)){
					$text_type= 'password';
				}

				return '<input type="' . $text_type .'"' . $id . $name . $additional_classes . $attributes_values . '>';
				break;
		}
	}