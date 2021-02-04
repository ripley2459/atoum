<?php

	function get_block_accordion(array $attributes, $title, $content){
		switch($template){
			default:
				return
				get_block_div(
					$attributes,
					get_block_div(
						$array = array('class' => 'accordion_trigger', 'template' => 'admin'),
						$title
					) .
					get_block_div(
						$array = array('class' => 'accordion_panel', 'template' => 'admin'),
						$content
					)
				);
				break;			
		}
	}