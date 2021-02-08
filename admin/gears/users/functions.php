<?php

	function get_users($order_by, $order_direction){
		global $bdd, $content;
		$to_display = '';
		$table_content = '';
		$users_request = $bdd -> prepare('SELECT * FROM at_users ORDER BY :order_by :order_direction');
		$users_request -> execute(array(':order_by' => $order_by, ':order_direction' => $order_direction));

		while($user = $users_request -> fetch()){
			$table_content = $table_content .
				get_block_table_row(
					$array = array('template' => 'admin'),
					get_block_table_data(
						$array = array('template' => 'admin'),
						$user['user_username'] .
						get_block_div(
							$array = array('template' => 'admin'),
							''
						)
					) .
					get_block_table_data(
						$array = array('template' => 'admin'),
						$user['user_display_name']
					) .
					get_block_table_data(
						$array = array('template' => 'admin'),
						$user['user_email']
					)
				);
		}

		$to_display = $to_display .
			get_block_table(
				$array = array('template' => 'admin'),
				get_block_table_row(
					$array = array('template' => 'admin'),
					get_block_table_heading(
						$array = array('template' => 'admin'),
						'Username'
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						'Name'
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						'Email'
					)
				) .
				$table_content
			);

		$users_request -> closeCursor();
		return $to_display;
	}

	function get_user_profile(){
		global $bdd;
		
		$user_id = 1;

		$users_profile_request = $bdd -> prepare('SELECT * FROM at_users WHERE user_id = :user_id');
		$users_profile_request -> execute(array(':user_id' => $user_id));
		
		$user = $users_profile_request -> fetch();
		
		$user = array(
			'user_id' => $user['user_id'],
			'user_username' => $user['user_username'],
			'user_password' => $user['user_password'],
			'user_email' => $user['user_email'],
			'user_display_name' => $user['user_display_name'],
			'user_first_name' => $user['user_first_name'],
			'user_last_name' => $user['user_last_name'],
			'user_biography' => $user['user_biography'],
		);

		return $user;
		$users_profile_request -> closeCursor();
	}

	function user_edit($user_id, $user_username, $user_password, $user_email, $user_display_name, $user_first_name, $user_last_name, $user_biography){
		global $bdd;
		$user_edit_request = $bdd -> prepare('UPDATE at_users SET user_username = :user_username, user_password = :user_password, user_email = :user_email, user_display_name = :user_display_name, user_first_name = :user_first_name, user_last_name = :user_last_name, user_biography = :user_biography WHERE user_id = :user_id');
		$user_edit_request -> execute(array(':user_username' => $user_username, ':user_password' => $user_password, ':user_email'=> $user_email, ':user_display_name' => $user_display_name, ':user_first_name' => $user_first_name, ':user_last_name' => $user_last_name, ':user_biography' => $user_biography, ':user_id' => $user_id));
		$user_edit_request -> closeCursor();
	}

	function add_user($user_name, $user_password, $user_email, $user_display_name, $user_first_name, $user_last_name, $user_biography){
		global $bdd;
		$add_user_request = $bdd -> prepare('INSERT INTO at_users (user_name, user_password, user_email, user_display_name, user_first_name, user_last_name, user_biography) VALUES (:user_name, :user_password, :user_email, :user_display_name, :user_first_name, :user_last_name, :user_biography)');
		$add_user_request -> execute(array(':user_name' => $user_name, ':user_password' => $user_password, ':user_email' => $user_email, ':user_display_name' => $user_display_name, ':user_first_name' => $user_first_name, ':user_last_name' => $user_last_name, ':user_biography' => $user_biography));
		echo 'ok';
		
		$add_user_request -> closeCursor();
	}