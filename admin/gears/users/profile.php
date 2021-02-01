<?php

	/* get_user_profile($user); */
	
	echo get_block_div(
		get_block_title(
			2,
			'Profile options',
			'',
			'',
			'',
			''
		) .
		get_block_form(
			get_block_label(
				'Name',
				'user_name',
				'',
				'',
				''
			) .
			get_block_input_text(
				'',
				'',
				'',
				$array = array('placeholder' => 'A tiny text', 'required' => 'required'),
				'',
				''
			) .
			get_block_label(
				'Password',
				'user_password',
				'',
				'',
				''
			) .
			get_block_input_text(
				'',
				'user_password',
				'',
				$array = array('password' => 'password', 'required' => 'required'),
				'',
				''
			) .
			get_block_label(
				'First name',
				'user_first_name',
				'',
				'',
				''
			) .
			get_block_input_text(
				'',
				'user_first_name',
				'',
				$array = array(),
				'',
				''
			) .
			get_block_label(
				'Last name',
				'user_last_name',
				'',
				'',
				''
			) .
			get_block_input_text(
				'',
				'user_last_name',
				'',
				$array = array(),
				'',
				''
			) .
			get_block_label(
				'Display name',
				'user_display_name',
				'',
				'',
				''
			) .
			get_block_input_text(
				'',
				'user_display_name',
				'',
				$array = array('required' => 'required'),
				'',
				''
			) .
			get_block_label(
				'Biography',
				'user_biography',
				'',
				'',
				''
			) .
			get_block_input_text(
				'',
				'user_biography',
				'',
				$array = array(),
				'',
				''
			) .
			get_block_button(
				'Save',
				'submit',
				'',
				'',
				'',
				'',
				''
			),
			'',
			'',
			$array = array('action' => 'profile.php', 'method' => 'post'),
			'',
			''
		),
		'',
		'',
		'',
		''
	);