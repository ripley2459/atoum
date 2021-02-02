<?php

	function get_block_section(array $attributes, $content){
		switch($attributes['template']){
			default:

				return '<section' . get_id_classes($attributes) . '>' . $content . '</section>';
				break;
		}
	}