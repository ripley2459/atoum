<?php

	if(isset($_POST['submit']) && $_POST['user_password'] == $_POST['user_password2']){
		echo $_POST['user_password'];
		echo $_POST['user_password2'];
		
		$user_id = 1;
		$user_username = $_POST['user_username'];
		$user_password = $_POST['user_password'];
		$user_email = $_POST['user_email'];
		$user_display_name = $_POST['user_display_name'];
		$user_first_name = $_POST['user_first_name'];
		$user_last_name = $_POST['user_last_name'];
		$user_biography = $_POST['user_biography'];

		user_edit($user_id, $user_username, $user_password, $user_email, $user_display_name, $user_first_name, $user_last_name, $user_biography);

		header('location: profile.php');
	}
	else{
		$user = get_user_profile();
	}

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
				$array = array('type' => 'text', 'name' => 'user_username', 'password' => 'password', 'value' => $user['user_username'], 'required' => 'required', 'template' => 'admin')
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
				$array = array('type' => 'text', 'name' => 'user_email', 'value' => $user['user_email'], 'required' => 'required', 'template' => 'admin')
			) .
			get_block_label(
				$array = array('for' => 'user_display_name', 'template' => 'admin'),
				'Display name'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_display_name', 'value' => $user['user_display_name'], 'template' => 'admin')
			) .
			
			get_block_div(
				$array = array('class' => 'row', 'template' => 'admin'),
				get_block_div(
					$array = array('class' => 'column', 'template' => 'admin'),
					get_block_label(
						$array = array('for' => 'user_first_name', 'template' => 'admin'),
						'First name'
					) .
					get_block_input(
						$array = array('type' => 'text', 'name' => 'user_first_name', 'value' => $user['user_first_name'], 'template' => 'admin')
					)
				).
				get_block_div(
					$array = array('class' => 'column', 'template' => 'admin'),
					get_block_label(
						$array = array('for' => 'user_last_name', 'template' => 'admin'),
						'Last name'
					) .
					get_block_input(
						$array = array('type' => 'text', 'name' => 'user_last_name', 'value' => $user['user_last_name'], 'template' => 'admin')
					)
				)
			) .
			get_block_label(
				$array = array('for' => 'user_biography', 'template' => 'admin'),
				'User biography'
			) .
			get_block_input(
				$array = array('type' => 'text', 'name' => 'user_biography', 'value' => $user['user_biography'], 'template' => 'admin')
			) .
			get_block_input(
				$array = array('type' => 'submit', 'name' => 'submit','template' => 'admin')
			)
		),
	);