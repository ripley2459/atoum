<?php

	function get_block_line_break(array $attributes){
		switch($template){
			default:
				return '<hr' . get_id_classes($attributes) . '>';
				break;
		}
	}