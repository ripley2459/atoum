<?php

	function get_block_preformatted_text(array $attributes, $content){
		switch($template){
			default:
				return '<pre' . get_id_classes($attributes) . '>' . $content . '</pre>';
				break;
		}
	}