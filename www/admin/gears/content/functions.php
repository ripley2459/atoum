<?php

	function get_content($content_type, $order_by, $order_direction){
		global $bdd, $folder, $page, $LINKS;
		$to_display = '';
		$table_content = '';

		$content_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_type = :content_type ORDER BY :order_by :order_direction');
		$content_request -> execute(array(':content_type' => $content_type,':order_by' => $order_by,':order_direction' => $order_direction));

		$users_request = $bdd -> prepare('SELECT user_display_name FROM at_users WHERE user_id = :user_id');

		while($content = $content_request -> fetch()){

			$users_request -> execute(array(':user_id' => $content['content_author_id']));
			$user = $users_request -> fetch();
				
			$table_content = $table_content . 
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

		$to_display = $to_display . 
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
						'Tags'
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

	function get_terms($term_type, $order_by, $order_direction){
		global $bdd, $folder, $page;
		$to_display = '';
		$table_content = '';

		$terms_request = $bdd -> prepare('SELECT * FROM at_terms WHERE term_type = :term_type ORDER BY :order_by :order_direction');
		$terms_request -> execute(array(':term_type' => $term_type,':order_by' => $order_by,':order_direction' => $order_direction));

		while($term = $terms_request -> fetch()){
			
			$table_content = $table_content .
			get_block_table_row(
				$array = array('template' => 'admin'),
				get_block_table_data(
					$array = array('class' => 'spoiler_container', 'template' => 'admin'),
					$term['term_name'] . '</br>' .
					get_block_div(
						$array = array('class' => 'spoiler', 'template' => 'admin'),
						get_block_link(
							'#',
							'Display',
							'',
							'',
							'',
							'',
							'',
							''
						) . ' | ' .
						get_block_link(
							'classes.php?term_to_edit=' . $term['term_id'],
							'Edit',
							'',
							'',
							'',
							'',
							'',
							''
						) . ' | ' .
						get_block_link(
							'classes.php?term_to_delete=' . $term['term_id'],
							'Delete',
							'',
							'',
							'',
							'warning',
							'',
							''
						)
					)
				) .
				get_block_table_data(
					$array = array('template' => 'admin'),
					$term['term_slug']
				) .
				get_block_table_data(
					$array = array('template' => 'admin'),
					$term['term_description']
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
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=term_name&order_direction=' . $order_direction,
							'Name<i class="' . $order_direction . '"></i>',
							'',
							'',
							'',
							'',
							'',
							''
						)
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=content_slug&order_direction=' . $order_direction,
							'Slug<i class="' . $order_direction . '"></i>',
							'',
							'',
							'',
							'',
							'',
							''
						)
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						'Description'
					)
				) .
				$table_content
			);

		$terms_request -> closeCursor();
		
		return $to_display;
	}












































	function get_terms_list($term_type){
		global $bdd;
		$terms_list_request = $bdd -> prepare('SELECT * FROM at_terms WHERE term_type = :term_type');
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
		global $bdd;
		$terms_add_request = $bdd -> prepare('INSERT INTO at_terms (term_name, term_slug, term_type, term_description, term_parent_id) VALUES (:term_name, :term_slug, :term_type, :term_description, :term_parent_id)');

		$terms_add_request -> execute(array(':term_name' => $term_name, ':term_slug' => $term_slug, ':term_type' => $term_type, ':term_description' => $term_description, ':term_parent_id' => $term_parent_id));
		$terms_add_request -> closeCursor();
	}


	function get_term_to_edit($term_id, $term_type){
		global $bdd;
		$term_to_edit_request = $bdd -> prepare('SELECT * FROM at_terms WHERE term_type = :term_type and term_id = :term_id');
		$term_to_edit_request -> execute(array(':term_type' => $term_type, ':term_id' => $term_id));
		$term = $term_to_edit_request -> fetch();
		$term = array(
			'term_name' => $term['term_name'],
			'term_slug' => $term['term_slug'],
			'term_parent_id' => $term['term_parent_id'],
			'term_description' => $term['term_description']
		);
		return $term;
		$term_to_edit_request -> closeCursor();
	}

	function term_edit($term_id, $term_name, $term_slug, $term_description, $term_parent_id){
		global $bdd;
		$term_edit_request = $bdd -> prepare('UPDATE at_terms SET term_name = :term_name, term_slug = :term_slug, term_description = :term_description, term_parent_id = :term_parent_id WHERE term_id = :term_id');
		$term_edit_request -> execute(array(':term_name' => $term_name, ':term_slug' => $term_slug, ':term_description'=> $term_description, ':term_parent_id' => $term_parent_id, ':term_id' => $term_id));
		$term_edit_request -> closeCursor();
	}

	function term_delete($term_id){
		global $bdd;
		$term_delete_request = $bdd -> prepare('DELETE FROM at_terms WHERE term_id =  :term_id');
		$term_delete_request -> execute(array(':term_id' => $term_id));
		$term_delete_request -> closeCursor();
	}
	

	function get_menus(){
		global $bdd;
		$to_display = '';

		$menu_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_type = "menu"');
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
		global $bdd;
		$to_display = '';

		$sub_menu_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_parent_id = :menu_parent_id and content_type = "menu-element"');
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
		global $bdd;
		$to_display = '';
		
		$content_for_menus_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_type = :content_type');
		$content_for_menus_request -> execute(array(':content_type' => $content_type));
		
		while($content_for_menu = $content_for_menus_request -> fetch()){
			$to_display = $to_display . '<input type="checkbox" id="'.$content_for_menu['content_slug'].'" name="'.$content_for_menu['content_slug'].'"><label for="'.$content_for_menu['content_slug'].'">'.$content_for_menu['content_title'].'</label></br>';
		}
		
		return $to_display;
	}
	
	function get_terms_for_menus($term_type){
		global $bdd;
		$to_display = '';
		
		$content_for_menus_request = $bdd -> prepare('SELECT * FROM at_terms WHERE term_type = :term_type');
		$content_for_menus_request -> execute(array(':term_type' => $term_type));
		
		while($content_for_menu = $content_for_menus_request -> fetch()){
			$to_display = $to_display . '<input type="checkbox" id="'.$content_for_menu['term_slug'].'" name="'.$content_for_menu['term_slug'].'"><label for="'.$content_for_menu['term_slug'].'">'.$content_for_menu['term_name'].'</label></br>';
		}
		
		return $to_display;
	}
	
	function get_medias($content_type, $order_by, $order_direction, $display_mode){
		global $bdd;
	}




	function content_add($content_title, $content_slug, $content_author_id, $content_type, $content_status, $content_parent_id, $content_has_children, $content_content){
		global $bdd;
		$content_add_request = $bdd -> prepare('INSERT INTO at_content (content_title, content_slug, content_author_id, content_type, content_status, content_parent_id, content_has_children, content_content) VALUES (:content_title, :content_slug, :content_author_id, :content_type, :content_status, :content_parent_id, :content_has_children, :content_content)');

		$content_add_request -> execute(array(':content_title' => $content_title, ':content_slug' => $content_slug, ':content_author_id' => $content_author_id, ':content_type' => $content_type, ':content_status' => $content_status, ':content_parent_id' => $content_parent_id, ':content_has_children' => $content_has_children, ':content_content' => $content_content));
		$content_add_request -> closeCursor();
	}
	
	function get_content_to_edit($content_id, $content_type){
		global $bdd;
		$content_to_edit_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_type = :content_type and content_id = :content_id');
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
	
	function content_delete(){
		
	}
	
	
	function add_file($file_name, $file_type, $file_path){
		global $bdd;
		$content_add_file = $bdd -> prepare('INSERT INTO at_content (content_title, content_slug, content_author_id, content_type, content_status, content_parent_id, content_has_children, content_content) VALUES (:content_title, :content_slug, :content_author_id, :content_type, :content_status, :content_parent_id, :content_has_children, :content_content)');

		$content_title = $file_name;
		$content_slug = str_replace(' ','-', strtolower($file_name));
		$content_author_id = 1;
		$content_type = $file_type;
		$content_status = 'uploaded';
		$content_parent_id = 0;
		$content_has_children = 0;
		$content_content = $file_path;

		$content_add_file -> execute(array(':content_title' => $content_title, ':content_slug' => $content_slug, ':content_author_id' => $content_author_id, ':content_type' => $content_type, ':content_status' => $content_status, ':content_parent_id' => $content_parent_id, ':content_has_children' => $content_has_children, ':content_content' => $content_content));
		$content_add_file -> closeCursor();
	}
	
	
	
	
	
	
	
	
	
	