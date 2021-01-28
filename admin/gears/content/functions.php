<?php

	function get_content($content_type, $order_by, $order_direction){
		global $bdd, $folder, $page, $LINKS;
		$to_display = '';
		$table_content = '';

		$content_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_type = :content_type ORDER BY :order_by :order_direction');
		$content_request -> execute(array(':content_type' => $content_type,':order_by' => $order_by,':order_direction' => $order_direction));

		$users_request = $bdd -> prepare('SELECT user_display_name FROM at_users WHERE user_id = :user_id');

		while($content = $content_request -> fetch()){

			$users_request -> execute(array(':user_id' => $content['content_author']));
			$user = $users_request -> fetch();
				
			$table_content = $table_content . 
				get_block_table_row(
					get_block_table_data(
						$content['content_title'] . '</br>' .
						get_block_div(
							get_block_link(
								$LINKS['URL'] . '/index.php?type=' . $content['content_type'] . '&content=' . $content['content_slug'],
								'Display',
								'',
								'',
								'',
								''
							) . '|' .
							get_block_link(
								'#',
								'Edit',
								'',
								'',
								'',
								''
							) . '|' .
							get_block_link(
								'#',
								'Delete',
								'',
								'',
								'',
								''
							),
							'',
							'spoiler',
							''
						),
						'',
						'spoiler-container',
						''
					) .
					get_block_table_data(
						$user['user_display_name'],
						'',
						'',
						''
					) .
					get_block_table_data(
						'',
						'',
						'',
						''
					) .
					get_block_table_data(
						'',
						'',
						'',
						''
					) .
					get_block_table_data(
						$content['content_date_created'],
						'',
						'',
						''
					) .
					get_block_table_data(
						$content['content_date_modified'],
						'',
						'',
						''
					),
					'',
					'',
					''
				);
		}

		$to_display = $to_display . 
			get_block_table(
				get_block_table_row(
					get_block_table_heading(
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=content_title&order_direction=' . $order_direction,
							'Title<i class="' . $order_direction . '"></i>',
							'',
							'',
							'',
							''
						),
						'',
						'',
						''
					) .
					get_block_table_heading(
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=content_author&order_direction=' . $order_direction,
							'Author<i class="' . $order_direction . '"></i>',
							'',
							'',
							'',
							''
						),
						'',
						'',
						''
					) .
					get_block_table_heading(
						'Classes',
						'',
						'',
						''
					) .
					get_block_table_heading(
						'Tags',
						'',
						'',
						''
					) .
					get_block_table_heading(
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=content_date_created&order_direction=' . $order_direction,
							'Creation date<i class="' . $order_direction . '"></i>',
							'',
							'',
							'',
							''
						),
						'',
						'',
						''
					) .
					get_block_table_heading(
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=content_date_modified&order_direction=' . $order_direction,
							'Last modification date<i class="' . $order_direction . '"></i>',
							'',
							'',
							'',
							''
						),
						'',
						'',
						''
					),
					'',
					'',
					''
				) .
				$table_content,
				'table-' . $content_type,
				'',
				''
			);

		$content_request -> closeCursor();
		$users_request -> closeCursor();

		return $to_display;
	}


	function get_terms($term_type, $order_by, $order_direction){
		global $bdd, $folder, $page;
		$terms_request = $bdd -> prepare('SELECT * FROM at_terms WHERE term_type = :term_type ORDER BY :order_by :order_direction');

		echo '<table class="full">
		<tr>
			<th><a href="'.'/admin/'.$folder.'/'.$page.'.php?order_by=term_name&order_direction='.$order_direction.'">Name<i class="icon '.$order_direction.'"></i></a></th>
			<th><a href="'.'/admin/'.$folder.'/'.$page.'.php?order_by=content_author&order_direction='.$order_direction.'">Slug<i class="icon '.$order_direction.'"></i></a></th>
			<th>Description</th>
		</tr>';

		$terms_request -> execute(array(':term_type' => $term_type,':order_by' => $order_by,':order_direction' => $order_direction));

		while($term = $terms_request -> fetch()){
			echo '<tr>
				<td class="spoiler-container">'.$term['term_name'].'</br><div class="spoiler"><a title="Display" href="#">Display</a> | <a title="Edit" href="#">Edit</a> | <a title="Delete" href="classes.php?term_to_delete='.$term['term_id'].'" class="warning">Delete</a></div></td>
				<td>'.$term['term_slug'].'</td>
				<td>'.$term['term_description'].'</td>
			</tr>';
		}

		$terms_request -> closeCursor();
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

		$term_slug = str_replace(' ','-', strtolower($term_slug));

		$terms_add_request -> execute(array(':term_name' => $term_name, ':term_slug' => $term_slug, ':term_type' => $term_type, ':term_description' => $term_description, ':term_parent_id' => $term_parent_id));
		$terms_add_request -> closeCursor();
	}


	function term_edit(){
		
	}


	function term_delete($term_id){
		global $bdd;
		$term_delete_request = $bdd -> prepare('DELETE FROM at_terms WHERE term_id =  :term_id');
		$term_delete_request -> execute(array(':term_id' => $term_id));
		$term_delete_request -> closeCursor();
	}
	

	function get_menus(){
		global $bdd;

		$menu_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_type = "menu"');
		$menu_request -> execute();

		while($menu = $menu_request -> fetch()){
			echo '<button class="accordion">'.$menu['content_title'].'</button>
			<div class="panel">
				<form>';
					get_subs_menus($menu['content_id']);
			echo '<button type="submit" class="tiny float-right">Save</button>
				</form>
			</div>';
		}
		$menu_request -> closeCursor();	
	}

	function get_subs_menus($menu_parent_id){
		global $bdd;

		$sub_menu_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_parent_id = :menu_parent_id and content_type = "menu-element"');
		$sub_menu_request -> execute(array(':menu_parent_id' => $menu_parent_id));
		
		while($sub_menu = $sub_menu_request -> fetch()){
			echo '<li id="menu-item-'.$sub_menu['content_id'].'">'.$sub_menu['content_title'];
			if($sub_menu['has_children'] == 1){
				get_sub_menus($sub_menu['content_id']);
			}
			echo '</li>';
		}

		$sub_menu_request -> closeCursor();
	}
	
	
	function get_content_for_menus($content_type){
		global $bdd;
		
		$content_for_menus_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_type = :content_type');
		$content_for_menus_request -> execute(array(':content_type' => $content_type));
		
		while($content_for_menu = $content_for_menus_request -> fetch()){
			echo '<input type="checkbox" id="'.$content_for_menu['content_slug'].'" name="'.$content_for_menu['content_slug'].'"><label for="'.$content_for_menu['content_slug'].'">'.$content_for_menu['content_title'].'</label></br>';
		}
	}
	
	function get_terms_for_menus($term_type){
		global $bdd;
		
		$content_for_menus_request = $bdd -> prepare('SELECT * FROM at_terms WHERE term_type = :term_type');
		$content_for_menus_request -> execute(array(':term_type' => $term_type));
		
		while($content_for_menu = $content_for_menus_request -> fetch()){
			echo '<input type="checkbox" id="'.$content_for_menu['term_slug'].'" name="'.$content_for_menu['term_slug'].'"><label for="'.$content_for_menu['term_slug'].'">'.$content_for_menu['term_name'].'</label></br>';
		}
	}
	
	function get_medias($content_type, $order_by, $order_direction, $display_mode){
		global $bdd;
	}