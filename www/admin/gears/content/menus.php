<?php

	$order_direction = 'asc';

	echo
	get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('template' => 'admin'),
			'Menus'
		) .
		get_block_div(
			$array = array('class' => 'row', 'template' => 'admin'),
			get_block_div(
				$array = array('class' => 'column', 'template' => 'admin'),
				get_block_title(
					2,
					$array = array('template' => 'admin'),
					'Create a menu'
				) .
				get_block_form(
					$array = array('action' => 'menus.php', 'method' => 'post', 'template' => 'admin'),
					get_block_label(
						$array = array('for' => 'menu_name', 'template' => 'admin'),
						'Name'
					) .
					get_block_input(
						$array = array('type' => 'text', 'name' => 'menu_name', 'required' => 'required', 'template' => 'admin')
					) .
					get_block_input(
						$array = array('type' => 'submit', 'name' => 'submit', 'value' => 'Create', 'template' => 'admin')
					)
				) .
				get_block_title(
					3,
					$array = array('template' => 'admin'),
					'Add elements'
				) .
				get_block_div(
					$array = array('class' => 'accordion_group', 'template' => 'admin'),
					get_block_accordion(
						$array = array('template' => 'admin'),
						'Pages',
						get_content_for_menus('page')
					) .
					get_block_accordion(
						$array = array('template' => 'admin'),
						'Posts',
						get_content_for_menus('post')
					) .
					get_block_accordion(
						$array = array('template' => 'admin'),
						'Links',
						/* get_content_for_menus('link') */'LINKS'
					) .
					get_block_accordion(
						$array = array('template' => 'admin'),
						'Classes',
						get_terms_for_menus('class')
					)
				)
			) .
			get_block_div(
				$array = array('class' => 'column', 'template' => 'admin'),
				get_block_title(
					2,
					$array = array('template' => 'admin'),
					'Organise your menu'
				) .
				get_block_div(
					$array = array('template' => 'admin'),
					get_block_title(
						2,
						$array = array('template' => 'admin'),
						'Your classes'
					)
				)
			)
		)
	);