<?php

	if(isset($_GET['order_direction'])){
		$order_direction = $_GET['order_direction'];
	}
	else{
		$order_direction = 'asc';
	}

	switch_order_direction($order_direction);

	echo get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('template' => 'admin'),
			'Posts'
		) . 
		get_block_link(
			'editor.php?mode=create&type=post',
			$array = array('template' => 'admin'),
			'Add'
		)
	);

	echo get_block_div(
		$array = array('template' => 'admin'),
		get_posts_admin('post', 'content_name', $order_direction)
	);
	
	function get_posts_admin(string $content_type, string $order_by, string $order_direction){
		global $DDB, $folder, $page, $LINKS;
		$to_display = '';
		$table_content = '';

		$content_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_type = :content_type ORDER BY :order_by :order_direction');
		$content_request -> execute(array(':content_type' => $content_type,':order_by' => $order_by,':order_direction' => $order_direction));

		$users_request = $DDB -> prepare('SELECT user_display_name FROM at_users WHERE user_id = :user_id');

		while($content = $content_request -> fetch()){

			$users_request -> execute(array(':user_id' => $content['content_author_id']));
			$user = $users_request -> fetch();
				
			$table_content .=
				get_block_table_row(
					$array = array('template' => 'admin'),
					get_block_table_data(
						$array = array('class' => 'spoiler_container', 'template' => 'admin'),
						$content['content_title'] . '</br>' .
						get_block_div(
							$array = array('class' => 'spoiler', 'template' => 'admin'),
							get_block_link(
								$LINKS['URL'] . '/index.php?type=' . $content['content_type'] . '&content=' . $content['content_slug'],
								$array = array('template' => 'admin'),
								'Display'
							) . ' | ' .
							get_block_modal(
								$array = array('id' => $content['content_slug'], 'template' => 'admin'),
								'Quick dit',
								get_block_form(
									$array = array('action' => 'uploads.php', 'method' => 'post', 'template' => 'admin'),
									$content['content_date_created'] .
									get_block_input(
										$array = array('type' => 'hidden', 'name' => 'content_id', 'value' => $content['content_id'], 'required' => 'required', 'template' => 'admin')
									) .
									get_block_label(
										$array = array('for' => 'content_slug', 'template' => 'admin'),
										'Slug'
									) .
									get_block_input(
										$array = array('type' => 'text', 'name' => 'content_slug', 'value' => $content['content_slug'], 'required' => 'required', 'template' => 'admin')
									) .
									get_block_label(
										$array = array('for' => 'description', 'template' => 'admin'),
										'Description'
									) .
									get_block_input(
										$array = array('type' => 'text', 'name' => 'description', 'value' => $content['content_title'], 'required' => 'required', 'template' => 'admin')
									) .
									get_block_label(
										$array = array('for' => 'author', 'template' => 'admin'),
										'Author'
									) .
									get_block_input(
										$array = array('type' => 'hidden', 'name' => 'author_id', 'value' => $content['content_author_id'], 'required' => 'required', 'template' => 'admin')
									) .
									get_block_input(
										$array = array('type' => 'text', 'name' => 'author', 'value' => $user_display_name, 'readonly' => 'readonly', 'required' => 'required', 'template' => 'admin')
									) .
									get_block_input(
										$array = array('type' => 'submit', 'name' => 'delete', 'value' => 'Delete', 'template' => 'admin')
									) .
									get_block_input(
										$array = array('type' => 'submit', 'name' => 'update', 'value' => 'Save', 'template' => 'admin')
									)
								)
							) . ' | ' .
							get_block_link(
								$LINKS['URL'] . '/admin/'. $folder . '/editor.php?content_type=' . $content_type . '&content_to_edit=' . $content['content_id'],
								$array = array('template' => 'admin'),
								'Edit'
							) . ' | ' .
							get_block_link(
								'#',
								$array = array('template' => 'admin'),
								'Delete'
							)
						)
					) .
					get_block_table_data(
						$array = array('template' => 'admin'),
						$user['user_display_name']
					) .
					get_block_table_data(
						$array = array('template' => 'admin'),
						''
					) .
					get_block_table_data(
						$array = array('template' => 'admin'),
						$content['content_date_created']
					) .
					get_block_table_data(
						$array = array('template' => 'admin'),
						$content['content_date_modified']
					)
				);
		}

		$to_display .= 
			get_block_table(
				$array = array('class' => 'table-' . $content_type, 'template' => 'admin'),
				get_block_table_row(
					$array = array('template' => 'admin'),
					get_block_table_heading(
						$array = array('template' => 'admin'),
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=content_title&order_direction=' . $order_direction,
							$array = array('template' => 'admin'),
							'Title<i class="' . $order_direction . '"></i>'
						),
						'',
						'',
						'',
						''
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=content_author&order_direction=' . $order_direction,
							$array = array('template' => 'admin'),
							'Author<i class="' . $order_direction . '"></i>'
						)
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						'Classes'
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=content_date_created&order_direction=' . $order_direction,
							$array = array('template' => 'admin'),
							'Creation date<i class="' . $order_direction . '"></i>'
						)
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=content_date_modified&order_direction=' . $order_direction,
							$array = array('template' => 'admin'),
							'Last modification date<i class="' . $order_direction . '"></i>'
						)
					)
				) .
				$table_content
			);

		$content_request -> closeCursor();
		$users_request -> closeCursor();

		return $to_display;
	}