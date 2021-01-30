<?php

	function get_block_link($destination, $content, $title, $target, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($destination == ''){
					$destination = '#';
				}
				if($target != ''){
					$target = ' target="' . $target . '"';
				}
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<a href="' . $destination . '"' . $target . $id . $additional_classes . '>' . $content . '</a>';
				break;
		}
	}