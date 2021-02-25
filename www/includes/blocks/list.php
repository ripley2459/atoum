<?php

	function get_block_list_unordered(array $attributes, $content){
		switch($attributes['template']){
			default:
				return '<ul' . get_id_classes($attributes) . '>' . $content . '</ul>';
				break;
		}
	}

	function get_block_list_element(array $attributes, $content){
		switch($attributes['template']){
			default:
				return '<li' . get_id_classes($attributes) . '>' . $content . '</li>';
				break;
		}
	}