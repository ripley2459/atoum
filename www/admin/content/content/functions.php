<?php

	function get_content($content_type, $order_by, $order_direction){
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









































	function get_terms_list($term_type){
		global $DDB;
		$terms_list_request = $DDB -> prepare('SELECT * FROM at_terms WHERE term_type = :term_type');
		$terms_list_request -> execute(array(':term_type' => $term_type));
		
		echo '<select id="parent" name="parent" class="full">
			<option value="0">None</option>';
		while($terms = $terms_list_request -> fetch()){
				echo '<option value="'.$terms['term_id'].'">'.$terms['term_name'].'</option>';
		}
		echo '</select>';
	}


	function switch_order_direction($order_direction){		
		global $order_direction;
		switch($order_direction){
			case 'asc':
				$order_direction = 'desc';
				break;
			case 'desc':
				$order_direction =  'asc';
				break;
			default:
				$order_direction = 'asc';
		}
	}


	function term_add($term_name, $term_slug, $term_type, $term_description, $term_parent_id){
		global $DDB;
		$terms_add_request = $DDB -> prepare('INSERT INTO at_terms (term_name, term_slug, term_type, term_description, term_parent_id) VALUES (:term_name, :term_slug, :term_type, :term_description, :term_parent_id)');

		$terms_add_request -> execute(array(':term_name' => $term_name, ':term_slug' => $term_slug, ':term_type' => $term_type, ':term_description' => $term_description, ':term_parent_id' => $term_parent_id));
		$terms_add_request -> closeCursor();
	}
	

	function get_menus(){
		global $DDB;
		$to_display = '';

		$menu_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_type = "menu"');
		$menu_request -> execute();

		while($menu = $menu_request -> fetch()){
			$to_display = $to_display .
				get_block_accordion(
					$menu['content_title'],
					get_block_list_unordered(
						get_subs_menus($menu['content_id']),
						$menu['content_slug'],
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
		return $to_display;
		$menu_request -> closeCursor();
	}

	function get_subs_menus($menu_parent_id){
		global $DDB;
		$to_display = '';

		$sub_menu_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_parent_id = :menu_parent_id and content_type = "menu-element"');
		$sub_menu_request -> execute(array(':menu_parent_id' => $menu_parent_id));
		
		while($sub_menu = $sub_menu_request -> fetch()){
/* 			if($sub_menu['content_has_children'] == 1){
				$sub_sub_menus = $sub_sub_menus . 
				get_block_list_unordered(
					get_sub_menus($sub_menu['content_id']),
					'',
					'sub-menu',
					'',
					''
				);
			} */
			
			$to_display = $to_display .
				get_block_list_element(
					$sub_menu['content_title'],
					'menu-item-' . $sub_menu['content_id'],
					'',
					'',
					''
				);
		}

		return $to_display;
		$sub_menu_request -> closeCursor();
	}
	
	
	function get_content_for_menus($content_type){
		global $DDB;
		$to_display = '';
		
		$content_for_menus_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_type = :content_type');
		$content_for_menus_request -> execute(array(':content_type' => $content_type));
		
		while($content_for_menu = $content_for_menus_request -> fetch()){
			$to_display =
				$to_display .
				get_block_label(
					$array = array('for' => $content_for_menu['content_slug'], 'template' => 'admin'),
					get_block_input(
						$array = array('type' => 'checkbox', 'name' => $content_for_menu['content_slug'], 'template' => 'admin')
					) .
					' ' . $content_for_menu['content_title']
				);
		}
		
		return $to_display;
	}
	
	function get_terms_for_menus($term_type){
		global $DDB;
		$to_display = '';
		
		$content_for_menus_request = $DDB -> prepare('SELECT * FROM at_terms WHERE term_type = :term_type');
		$content_for_menus_request -> execute(array(':term_type' => $term_type));
		
		while($content_for_menu = $content_for_menus_request -> fetch()){
			$to_display =
				$to_display .
				get_block_label(
					$array = array('for' => $content_for_menu['term_slug'], 'template' => 'admin'),
					get_block_input(
						$array = array('type' => 'checkbox', 'name' => $content_for_menu['term_slug'], 'template' => 'admin')
					) .
					' ' . $content_for_menu['term_name']
				);
		}
		
		return $to_display;
	}
	
	function get_medias($content_type, $order_by, $order_direction, $display_mode){
		global $DDB;
	}




	function content_add($content_title, $content_slug, $content_author_id, $content_type, $content_status, $content_parent_id, $content_has_children, $content_content){
		global $DDB;
		$content_add_request = $DDB -> prepare('INSERT INTO at_content (content_title, content_slug, content_author_id, content_type, content_status, content_parent_id, content_has_children, content_content) VALUES (:content_title, :content_slug, :content_author_id, :content_type, :content_status, :content_parent_id, :content_has_children, :content_content)');

		$content_add_request -> execute(array(':content_title' => $content_title, ':content_slug' => $content_slug, ':content_author_id' => $content_author_id, ':content_type' => $content_type, ':content_status' => $content_status, ':content_parent_id' => $content_parent_id, ':content_has_children' => $content_has_children, ':content_content' => $content_content));
		$content_add_request -> closeCursor();
	}
	
	function get_content_to_edit($content_id, $content_type){
		global $DDB;
		$content_to_edit_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_type = :content_type and content_id = :content_id');
		$content_to_edit_request -> execute(array(':content_type' => $content_type, ':content_id' => $content_id));
		$content = $content_to_edit_request -> fetch();
		$content = array(
			'content_title' => $content['content_title'],
			'content_slug' => $content['content_slug'],
			'content_author_id' => $content['content_author_id'],
			'content_date_created' => $content['content_date_created'],
			'content_date_modified' => $content['content_date_modified'],
			'content_type' => $content['content_type'],
			'content_status' => $content['content_status'],
			'content_parent_id' => $content['content_parent_id'],
			'content_has_children' => $content['content_has_children'],
			'content_content' => $content['content_content']
		);
		return $content;
		$content_to_edit_request -> closeCursor();
	}
	
	
	
	
	
	
	
	
	
	