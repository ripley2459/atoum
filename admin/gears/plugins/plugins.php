<?php

	echo
	get_block_section(
		get_block_title(
				1,
				'Plugins',
				'',
				'',
				'',
				''
			) .
			get_block_div(
				get_plugins_wrapper(),
				'',
				'plugins-wrapper',
				'',
				''
			),
		'',
		'',
		'',
		''
	);