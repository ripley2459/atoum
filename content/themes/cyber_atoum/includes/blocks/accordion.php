<?php

	function get_block_accordion($title, $content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return
				get_block_div(
					get_block_div(
						$title,
						'',
						'accordion_trigger',
						'',
						''
					) .
					get_block_div(
						$content,
						'',
						'accordion_panel',
						'',
						''
					),
					$id,
					$additional_classes,
					'',
					''
				);
				break;			
		}
	}