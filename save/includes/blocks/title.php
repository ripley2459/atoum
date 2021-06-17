<?php

	function get_block_title($level, array $attributes, $content){
		switch($attributes['template']){
			default:
				return '<h' . $level . get_id_classes($attributes) . '>' . $content . '</h' . $level . '>';
				break;
		}
	}