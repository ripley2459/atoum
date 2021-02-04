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
		$array = array('template' => 'admin'),
		get_block_title(
			2,
			$array = array('template' => 'admin'),
			'Add user'
		) .
		get_block_form(
			$array = array('action' => 'add.php?operation=add', 'method' => 'post', 'template' => 'admin'),
			get_block_label(
				$array = array('for' => 'user_name', 'template' => 'admin'),
				'Username'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_name', 'password' => 'password', 'required' => 'required', 'template' => 'admin')
			) .
			get_block_label(
				$array = array('for' => 'user_password', 'template' => 'admin'),
				'Password'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_password', 'password' => 'password', 'required' => 'required', 'template' => 'admin')
			) .
			get_block_label(
				$array = array('for' => 'user_email', 'template' => 'admin'),
				'Email'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_email', 'password' => 'password', 'required' => 'required', 'template' => 'admin')
			) .
			get_block_label(
				$array = array('for' => 'user_first_name', 'template' => 'admin'),
				'First name'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_first_name', 'template' => 'admin')
			) .
			get_block_label(
				$array = array('for' => 'user_last_name', 'template' => 'admin'),
				'Last name'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_last_name', 'template' => 'admin')
			) .
			get_block_label(
				$array = array('for' => 'user_display_name', 'template' => 'admin'),
				'Display name'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_display_name', 'template' => 'admin')
			) .
			get_block_label(
				$array = array('for' => 'user_biography', 'template' => 'admin'),
				'User biography'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_biography', 'template' => 'admin')
			) .
			get_block_input(
				$array = array('type' => 'submit', 'template' => 'admin')
			)
		)
	);