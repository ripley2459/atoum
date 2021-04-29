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
	
	function get_users($order_by, $order_direction){
		global $DDB, $content, $LINKS;

		$to_display = '';
		$table_content = '';

		$users_request = $DDB -> prepare('SELECT * FROM at_users ORDER BY :order_by :order_direction');
		$users_request -> execute(array(':order_by' => $order_by, ':order_direction' => $order_direction));

		while($user = $users_request -> fetch()){
			$table_content = $table_content .
				get_block_table_row(
					$array = array('template' => 'admin'),
					get_block_table_data(
						$array = array('class' => 'spoiler_container', 'template' => 'admin'),
						$user['user_username'] .
						get_block_div(
							$array = array('class' => 'spoiler', 'template' => 'admin'),
							get_block_link(
								$LINKS['URL'] . '/index.php?search_by=author&value=' . $user['user_username'],
								$array = array('template' => 'admin'),
								'Display'
							) . ' | ' .
							get_block_link(
								'#',
								$array = array('template' => 'admin'),
								'Revoke'
							)
						)
					) .
					get_block_table_data(
						$array = array('template' => 'admin'),
						$user['user_display_name']
					) .
					get_block_table_data(
						$array = array('template' => 'admin'),
						$user['user_registered']
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
						'Display name'
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						'Registration date'
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