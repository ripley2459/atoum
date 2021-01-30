<?php

	function get_block_table($content, $id, $additional_classes, $template){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<table' . $id . $additional_classes . '>' . $content . '</table>';
				break;
		}
	}

	function get_block_table_row($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<tr' . $id . $additional_classes . '>' . $content . '</tr>';
				break;
		}
	}

	function get_block_table_heading($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<th' . $id . $additional_classes . '>' . $content . '</th>';
				break;
		}
	}
	
	function get_block_table_data($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<td' . $id . $additional_classes . '>' . $content . '</td>';
				break;
		}
	}