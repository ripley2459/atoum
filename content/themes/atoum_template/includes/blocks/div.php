<?php

	function get_block_div($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<div' . $id . $additional_classes . '>' . $content . '</div>';
				break;
		}
	}