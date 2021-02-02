<?php

	if(isset($_GET['operation']) && $_GET['operation'] == 'add'){
		$user_name = $_POST['user_name'];
		$user_password = $_POST['user_password'];
		$user_email = $_POST['user_email'];
		$user_display_name = $_POST['user_display_name'];
		$user_first_name = $_POST['user_first_name'];
		$user_last_name = $_POST['user_last_name'];
		$user_biography = $_POST['user_biography'];

		add_user($user_name, $user_password, $user_email, $user_display_name, $user_first_name, $user_last_name, $user_biography);

		header('location: users.php');
	}
	
	echo get_block_div(
		get_block_title(
			2,
			$array = array(),
			'Add user'
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
				'user_name',
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
				'Email',
				'user_email',
				'',
				'',
				''
			) .
			get_block_input_text(
				'',
				'user_email',
				'',
				$array = array('required' => 'required'),
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
			$array = array('action' => 'add.php?operation=add', 'method' => 'post'),
			'',
			''
		),
		'',
		'',
		'',
		''
	);