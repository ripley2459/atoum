<?php

	include BLOCKS . 'accordion.php';
	include BLOCKS . 'button.php';
	include BLOCKS . 'div.php';
	include BLOCKS . 'form.php';
	include BLOCKS . 'horizontal_rule.php';
	include BLOCKS . 'image.php';
	include BLOCKS . 'line_break.php';
	include BLOCKS . 'link.php';
	include BLOCKS . 'list.php';
	include BLOCKS . 'modal.php';
	include BLOCKS . 'paragraph.php';
	include BLOCKS . 'table.php';
	include BLOCKS . 'tabs.php';
	include BLOCKS . 'title.php';

	function get_id_classes(array $attributes){
		$id_classes = '';

		if(array_key_exists('id', $attributes)){
			$id_classes .= ' id="' . $attributes['id'] . '"';
		}

		if(array_key_exists('class', $attributes)){
			$id_classes .= ' class="' . $attributes['class'] . '"';
		}

		if(array_key_exists('for', $attributes)){
			$id_classes .= ' for="' . $attributes['for'] . '"';
		}

		return $id_classes;
	}

	function get_attributes_values(array $attributes){
		$attributes_values = '';

		if(array_key_exists('name', $attributes)){
			$attributes_values .= ' name="' . $attributes['name'] . '"';
		}

		if(array_key_exists('alt', $attributes)){
			$attributes_values .= ' alt="' . $attributes['alt'] . '"';
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

		if(array_key_exists('onclick', $attributes)){
			$attributes_values .= ' onclick="' . $attributes['onclick'] . '"';
		}

		if(array_key_exists('autocomplete', $attributes)){
			$attributes_values .= ' autocomplete="' . $attributes['autocomplete'] . '"';
		}

		if(array_key_exists('novalidate', $attributes)){
			$attributes_values .= ' ' . $attributes['novalidate'];
		}

		if(array_key_exists('readonly', $attributes)){
			$attributes_values .= ' ' . $attributes['readonly'];
		}

		if(array_key_exists('accept-charset', $attributes)){
			$attributes_values .= ' accept-charset="' . $attributes['accept-charset'] . '"';
		}

		if(array_key_exists('rel', $attributes)){
			$attributes_values .= ' ' . $attributes['rel'];
		}

		if(array_key_exists('maxlength', $attributes)){
			$attributes_values .= ' maxlength="' . $attributes['maxlength'] . '"';
		}
		
		if(array_key_exists('minlength', $attributes)){
			$attributes_values .= ' minlength="' . $attributes['minlength'] . '"';
		}

		if(array_key_exists('target', $attributes)){
			$attributes_values .= ' target="' . $attributes['target'] . '"';
		}

		if(array_key_exists('value', $attributes)){
			$attributes_values .= ' value="' . $attributes['value'] . '"';
		}

		if(array_key_exists('required', $attributes)){
			$attributes_values .= ' ' . $attributes['required'];
		}

		return $attributes_values;
	}
	
	function add_classes(array $attributes, string $classes_to_add){
		if(array_key_exists('class', $attributes)){
			return ' class="' . $attributes['class'] . ' ' . $classes_to_add . '"';
		}
		else{
			return ' class="' . $classes_to_add . '"';
		}
	}