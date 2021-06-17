<?php

	function get_block_button(array $attributes, $content){
		switch($template){
			default:
				return '<button' . get_id_classes($attributes) . get_attributes_values($attributes) . '>' . $content . '</button>';
				break;		
		}
	}