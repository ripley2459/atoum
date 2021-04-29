<?php

	function get_block_accordion(array $attributes, $title, $content){
		switch($template){
			default:
				return
				'<div class="accordion_container">
					<div' . get_id_classes($attributes) . '>
						<div class="accordion_trigger">' . $title . '</div>
						<div class="accordion_panel">' . $content . '</div>
					</div>
				</div>';
				break;			
		}
	}