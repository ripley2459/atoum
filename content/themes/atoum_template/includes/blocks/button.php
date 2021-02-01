<?php

	function get_block_button($content, $type, $on_click, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class="' . $additional_classes . '"';
				}
				if($type != ''){
					$type = ' type= "' . $type . '"';
				}
				if($on_click != ''){
					$on_click = ' onclick= "' . $on_click . '"';
				}
				return '<button' . $type . $on_click . $id . $additional_classes . '>' . $content . '</button>';
				break;		
		}
	}