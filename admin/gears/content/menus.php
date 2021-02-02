<?php

	echo
	get_block_div(
		get_block_title(
			1,
			'Menus',
			'',
			'',
			'',
			''
		) .
		get_block_div(
			get_block_div(
				get_block_div(
					get_block_title(
						2,
						'Create a new menu',
						'',
						'',
						'',
						''
					) .
					get_block_div(
						'<form><input type="text" placeholder="Menu name" class="full"><button type="submit" class="float-right">Create</button></form>',
						'',
						'',
						'',
						''
					) .
					get_block_title(
						'3',
						'Add elements',
						'',
						'',
						'',
						''
					) .
					get_block_div(
						get_block_accordion(
							'Pages',
							get_content_for_menus('page'),
							'',
							'',
							'',
							''
						) .
						get_block_accordion(
							'Posts',
							get_content_for_menus('post'),
							'',
							'',
							'',
							''
						) .
						get_block_accordion(
							'Links',
							''/*get_links_for_menus('link')*/,
							'',
							'',
							'',
							''
						) .
						get_block_accordion(
							'Classes',
							get_terms_for_menus('class'),
							'',
							'',
							'',
							''
						),
						'',
						'accordion_group',
						'',
						''
					),
					'',
					'',
					'',
					''
				),
				'',
				'column',
				'',
				''
			) .
			get_block_div(
				get_block_section(
					get_block_title(
						2,
						'Organise your menu',
						'',
						'',
						'',
						''
					) .
					get_block_div(
						get_menus(),
						'',
						'accordion_group menus-wrapper',
						'',
						''
					),
					'',
					'',
					'',
					''
				),
				'',
				'column',
				'',
				''
			),
			'',
			'row',
			'',
			''
		),
		'',
		'',
		'',
		''
	);