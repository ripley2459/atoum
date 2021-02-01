<?php

	echo
	get_block_div(
		get_block_title(
			1,
			'Users',
			'',
			'',
			'',
			''
		) .
		get_block_div(
			get_users('user_name', 'desc'),
			'',
			'',
			'',
			''
		),
		'',
		'',
		'',
		''
	);