<?php

	function get_block_image($source, array $attributes){
		switch($template){
			default:
				if($source == ''){
					$source = '#';
				}
				return '<img src="' . $source . '"' . get_id_classes($attributes) . '/>';
				break;
		}
	}