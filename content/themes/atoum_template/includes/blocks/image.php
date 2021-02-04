<?php

	function get_block_image($source, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($source == ''){
					$source = '#';
				}
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<img src="' . $source . '"' . get_id_classes($attributes) . '/>';
				break;
		}
	}