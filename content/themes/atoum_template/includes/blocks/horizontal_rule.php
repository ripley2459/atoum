<?php

	function get_block_horizontal_rule(array $attributes){
		switch($template){
			default:
				return '<hr' . get_id_classes($attributes) . '>';
				break;
		}
	}