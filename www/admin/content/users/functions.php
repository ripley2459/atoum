<?php

	function get_user_profile(){
		global $DDB;
		
		$user_id = 1;

		$users_profile_request = $DDB -> prepare('SELECT * FROM at_users WHERE user_id = :user_id');
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
		global $DDB;
		$user_edit_request = $DDB -> prepare('UPDATE at_users SET user_username = :user_username, user_password = :user_password, user_email = :user_email, user_display_name = :user_display_name, user_first_name = :user_first_name, user_last_name = :user_last_name, user_biography = :user_biography WHERE user_id = :user_id');
		$user_edit_request -> execute(array(':user_username' => $user_username, ':user_password' => $user_password, ':user_email'=> $user_email, ':user_display_name' => $user_display_name, ':user_first_name' => $user_first_name, ':user_last_name' => $user_last_name, ':user_biography' => $user_biography, ':user_id' => $user_id));
		$user_edit_request -> closeCursor();
	}

	function add_user($user_username, $user_password, $user_email, $user_display_name, $user_first_name, $user_last_name, $user_biography){
		global $DDB;
		$add_user_request = $DDB -> prepare('INSERT INTO at_users (user_username, user_password, user_email, user_display_name, user_first_name, user_last_name, user_biography) VALUES (:user_username, :user_password, :user_email, :user_display_name, :user_first_name, :user_last_name, :user_biography)');
		$add_user_request -> execute(array(':user_username' => $user_username, ':user_password' => $user_password, ':user_email' => $user_email, ':user_display_name' => $user_display_name, ':user_first_name' => $user_first_name, ':user_last_name' => $user_last_name, ':user_biography' => $user_biography));
		
		$add_user_request -> closeCursor();
	}