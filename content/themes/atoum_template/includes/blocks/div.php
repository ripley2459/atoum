<?php

	function get_block_div(array $attributes, $content){
		switch($attributes['template']){
			default:

				return '<div' . get_id_classes($attributes) . '>' . $content . '</div>';
				break;
		}
	}