<?php

	function get_block_paragraph(array $attributes, $content){
		switch($attributes['template']){
			default:
				return '<p' . get_id_classes($attributes) . '>' . $content . '</p>';
				break;
		}
	}