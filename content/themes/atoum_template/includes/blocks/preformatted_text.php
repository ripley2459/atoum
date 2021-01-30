<?php

	function get_block_preformatted_text($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<pre' . $id . $additional_classes . '>' . $content . '</pre>';
				break;
		}
	}