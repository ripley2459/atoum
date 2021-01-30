<?php

	function get_block_title($level, $content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<h' . $level . $id . $additional_classes . '>' . $content . '</h' . $level . '>';
				break;
		}
	}