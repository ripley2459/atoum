<?php

	function get_block_modal(array $attributes, string $content_button, string $content_modal){
		switch($attributes['template']){
			default:
				if(!array_key_exists('class', $attributes)){
					$attributes['class'] = '';
				}

				return
					get_block_button(
						$array = array('onclick' => 'openModal(\'' . $attributes['id'] . '\')', 'template' => 'admin'),
						$content_button
					) .
					'<div id="' . $attributes['id'] . '" class="'. $attributes['class'] . ' modal">
						<div class="modal-content">
							<span onclick="closeModal(' . $attributes['id'] . ')" class="close">&times;</span>' .
							$content_modal .
						'</div>
					</div>';
				break;
		}
	}
	
	
/*

<button onclick="openModal(2)">Open Modal 2</button>

<div id="2" class="modal">
  <div class="modal-content">
    <span onclick="closeModal(2)" class="close">&times;</span>
    <p>Some text in the Modal..2</p>
  </div>
</div>

*/