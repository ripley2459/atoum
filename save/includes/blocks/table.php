<?php

	function get_block_table(array $attributes, $content){
		switch($template){
			default:
				return '<table' . get_id_classes($attributes) . '>' . $content . '</table>';
				break;
		}
	}

	function get_block_table_row(array $attributes, $content){
		switch($template){
			default:
				return '<tr' . get_id_classes($attributes) . '>' . $content . '</tr>';
				break;
		}
	}

	function get_block_table_heading(array $attributes, $content){
		switch($template){
			default:
				return '<th' . get_id_classes($attributes) . '>' . $content . '</th>';
				break;
		}
	}

	function get_block_table_data(array $attributes, $content){
		switch($template){
			default:
				return '<td' . get_id_classes($attributes) . '>' . $content . '</td>';
				break;
		}
	}