<?php

	function get_post($content_type, $content_slug){
		global $DDB;

		$post_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_type = :content_type and content_slug = :content_slug');
		$post_request -> execute(array(':content_type' => $content_type, ':content_slug' => $content_slug));
		$post = $post_request -> fetch();
		
		$user_display_name_request = $DDB -> prepare('SELECT user_display_name FROM at_users WHERE user_id = :user_id');
		$user_display_name_request -> execute(array(':user_id' => $post['content_author_id']));
		$user = $user_display_name_request -> fetch();
		
		$post = array(
			'id' => $post['content_id'],
			'title' => $post['content_title'],
			'slug' => $post['content_slug'],
			'author_id' => $post['content_author_id'],
			'author_display_name' => $user['user_display_name'],
			'date_created' => $post['content_date_created'],
			'date_modified' => $post['content_date_modified'],
			'type' => $post['content_type'],
			'status' => $post['content_status'],
			'parent_id' => $post['content_parent_id'],
			'has_children' => $post['content_has_children'],
			'content' => $post['content_content']
		);

		return $post;

		$post_request -> closeCursor();
		$user_display_name_request -> closeCursor();
	}

	function get_posts($content_type){
		global $DDB, $posts;
	}

	function get_menu($menu){
		global $DDB;

		$menu_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_slug = :content_slug and content_type = "menu"');
		$menu_request -> execute(array(':content_slug' => $menu));
		$menu = $menu_request -> fetch();
		
		echo '<nav id="menu-'.$menu['content_id'].'"><ul id="'.$menu['content_slug'].'-'.$menu['content_id'].'" class="menu-main-container">';
		get_sub_menus($menu['content_id']);
		echo '</ul></nav>';

		$menu_request -> closeCursor();
	}

	function get_sub_menus($menu_parent_id){
		global $DDB, $CONFIG;

		$sub_menu_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_parent_id = :menu_parent_id and content_type = "menu-element"');
		$sub_menu_request -> execute(array(':menu_parent_id' => $menu_parent_id));
		
		while($sub_menu = $sub_menu_request -> fetch()){
			if($sub_menu['content_has_children'] == 1){
				echo '<li id="menu-item-'.$sub_menu['content_id'].'" class="menu-item has-children"><a href="'.$sub_menu['content_content'].'">'.$sub_menu['content_title'].'</a>';
					echo '<ul class="sub-menu">';
					get_sub_menus($sub_menu['content_id']);
					echo '</ul>';
				echo '</li>';
			}
			else{
				echo '<li id="menu-item-'.$sub_menu['content_id'].'" class="menu-item"><a href="'.$sub_menu['content_content'].'">'.$sub_menu['content_title'].'</a>';
				echo '</li>';
			}
		}

		$sub_menu_request -> closeCursor();
	}
	
	function to_slug(string $string){
		$string = str_replace(' ','-', strtolower($string));
		return $string;
	}