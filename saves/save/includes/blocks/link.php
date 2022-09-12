<?php

	function get_block_link(string $destination, array $attributes, string $content){
		switch($template){
			default:
				if($destination == ''){
					$destination = '#';
				}
				return '<a href="' . $destination . '"' . get_id_classes($attributes) . get_attributes_values($attributes) . '>' . $content . '</a>';
				break;
		}
	}