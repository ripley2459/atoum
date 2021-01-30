<?php

	function get_block_section($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<section' . $id . $additional_classes . '>' . $content . '</section>';
				break;
		}
	}