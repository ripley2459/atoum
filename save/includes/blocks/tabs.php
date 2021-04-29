<?php

	function get_block_tabs(array $attributes, array $buttons, array $contents){
		$tabs = '';
		switch($template){
			default:
				foreach ($buttons as $button) {
					$tabs .=
					get_block_button(
						$array = array('class' => 'tab_button', 'template' => 'admin'),
						$button
					);
				}
				foreach ($contents as $content) {
					$tabs .=
					get_block_div(
						$array = array('class' => 'tab_content', 'template' => 'admin'),
						$content
					);
				}
				return $tabs;
				break;		
		}
	}