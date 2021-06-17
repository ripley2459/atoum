<?php

	if(isset($_POST['submit']) && $_POST['user_password'] == $_POST['user_password2']){
		$user_username = $_POST['user_username'];
		$user_password = $_POST['user_password'];
		$user_email = $_POST['user_email'];
		$user_display_name = '';
		$user_first_name = '';
		$user_last_name = '';
		$user_biography = '';

		add_user($user_username, $user_password, $user_email, $user_display_name, $user_first_name, $user_last_name, $user_biography);

		header('location: users.php');
	}
	
	echo get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			2,
			$array = array('template' => 'admin'),
			'Profile options'
		) .
		get_block_form(
			$array = array('action' => 'add.php', 'method' => 'post', 'template' => 'admin'),
			get_block_label(
				$array = array('for' => 'user_name', 'template' => 'admin'),
				'Username'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_username', 'password' => 'password', 'required' => 'required', 'template' => 'admin')
			) .
			get_block_div(
				$array = array('class' => 'row', 'template' => 'admin'),
				get_block_div(
					$array = array('class' => 'column', 'template' => 'admin'),
					get_block_label(
						$array = array('for' => 'user_password', 'template' => 'admin'),
						'Password'
					) .
					get_block_input(
						$array = array('type' => 'password', 'name' => 'user_password', 'minlength' => 8, 'required' => 'required', 'template' => 'admin')
					)
				).
				get_block_div(
					$array = array('class' => 'column', 'template' => 'admin'),
					get_block_label(
						$array = array('for' => 'user_password2', 'template' => 'admin'),
						'Confirm password'
					) .
					get_block_input(
						$array = array('type' => 'password', 'name' => 'user_password2', 'minlength' => 8, 'required' => 'required', 'template' => 'admin')
					)
				)
			) .
			get_block_label(
				$array = array('for' => 'user_email', 'template' => 'admin'),
				'Email'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_email', 'required' => 'required', 'template' => 'admin')
			) .
			get_block_input(
				$array = array('type' => 'submit', 'name' => 'submit', 'value' => 'Add', 'template' => 'admin')
			)
		),
	);