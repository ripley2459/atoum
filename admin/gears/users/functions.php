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
					get_block_table_data(
						$user['user_name'],
						'',
						'',
						'',
						''
					) .
					get_block_table_data(
						$user['user_display_name'],
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
		}
		
		$to_display = $to_display .
			get_block_table(
				get_block_table_row(
					get_block_table_heading(
						'Username',
						'',
						'',
						'',
						''
					) .
					get_block_table_heading(
						'Name',
						'',
						'',
						'',
						''
					),
					'',
					'',
					'',
					''
				) .
				$table_content,
				'',
				'',
				''
			);

		$users_request -> closeCursor();
		return $to_display;
	}
	
	function add_user($user_name, $user_password, $user_email, $user_display_name, $user_first_name, $user_last_name, $user_biography){
		global $bdd;
		$add_user_request = $bdd -> prepare('INSERT INTO at_users (user_name, user_password, user_email, user_display_name, user_first_name, user_last_name, user_biography) VALUES (:user_name, :user_password, :user_email, :user_display_name, :user_first_name, :user_last_name, :user_biography)');
		$add_user_request -> execute(array(':user_name' => $user_name, ':user_password' => $user_password, ':user_email' => $user_email, ':user_display_name' => $user_display_name, ':user_first_name' => $user_first_name, ':user_last_name' => $user_last_name, ':user_biography' => $user_biography));
		echo 'ok';
		
		$add_user_request -> closeCursor();
	}