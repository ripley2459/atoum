<?php

	$BLOCK = $LINKS['THEMES'] . $THEME . '/includes/blocks/';

	include $BLOCK . 'accordion.php';
	include $BLOCK . 'button.php';
	include $BLOCK . 'div.php';
	include $BLOCK . 'form.php';
	include $BLOCK . 'horizontal_rule.php';
	include $BLOCK . 'image.php';
	include $BLOCK . 'line_break.php';
	include $BLOCK . 'link.php';
	include $BLOCK . 'list.php';
	include $BLOCK . 'paragraph.php';
	include $BLOCK . 'preformatted_text.php';
	include $BLOCK . 'section.php';
	include $BLOCK . 'table.php';
	include $BLOCK . 'title.php';

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
