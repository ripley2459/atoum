<?php

	function get_block_list_unordered($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<ul' . $id . $additional_classes . '>' . $content . '</ul>';
				break;
		}
	}

	function get_block_list_element($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<li' . $id . $additional_classes . '>' . $content . '</li>';
				break;
		}
	}