<?php

	echo
	get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('template' => 'admin'),
			'Users'
		) .
		get_block_div(
			$array = array('template' => 'admin'),
			get_users('user_name', 'desc')
		),
	);