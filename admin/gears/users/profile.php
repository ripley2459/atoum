<?php

	/* get_user_profile($user); */
	
	echo get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			2,
			$array = array('template' => 'admin'),
			'Profile options'
		) .
		get_block_form(
			$array = array('action' => 'profile.php', 'method' => 'post', 'template' => 'admin'),
			get_block_label(
				$array = array('for' => 'user_name', 'template' => 'admin'),
				'Username'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_name', 'password' => 'password', 'required' => 'required', 'template' => 'admin'),
			) .
			get_block_label(
				$array = array('for' => 'user_password', 'template' => 'admin'),
				'Password'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_password', 'password' => 'password', 'required' => 'required', 'template' => 'admin'),
			) .
			get_block_label(
				$array = array('for' => 'user_first_name', 'template' => 'admin'),
				'First name'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_first_name', 'template' => 'admin'),
			) .
			get_block_label(
				$array = array('for' => 'user_last_name', 'template' => 'admin'),
				'Last name'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_last_name', 'template' => 'admin'),
			) .
			get_block_label(
				$array = array('for' => 'user_display_name', 'template' => 'admin'),
				'Display name'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_display_name', 'template' => 'admin'),
			) .
			get_block_label(
				$array = array('for' => 'user_biography', 'template' => 'admin'),
				'User biography'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_biography', 'template' => 'admin'),
			) .
			get_block_button(
				'Save',
				'submit',
				'',
				'',
				'',
				'',
				''
			)
		),
	);