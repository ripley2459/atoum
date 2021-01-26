<?php

	function get_post($content_type, $content_slug){
		global $bdd, $post, $CONFIG;

		$post_request = $bdd -> prepare('SELECT * FROM :table_content WHERE content_type = :content_type and content_slug = :content_slug');
		$post_request -> execute(array(':content_type' => $content_type, ':content_slug' => $content_slug));
		$post = $post_request -> fetch();
		
		$user_display_name_request = $bdd -> prepare('SELECT user_display_name FROM $CONFIG[PREFIX].users WHERE user_id = :user_id');
		$user_display_name_request -> execute(array(':table_content' => $CONFIG['PREFIX'] . 'content', ':user_id' => $post['content_author']));
		$user = $user_display_name_request -> fetch();
		
		$post = array(
			'id' => $post['content_id'],
			'title' => $post['content_title'],
			'slug' => $post['content_slug'],
			'author_id' => $post['content_author'],
			'author_display_name' => $user['user_display_name'],
			'date_created' => $post['content_date_created'],
			'date_modified' => $post['content_date_modified'],
			'type' => $post['content_type'],
			'status' => $post['content_status'],
			'parent_id' => $post['content_parent_id'],
			'has_children' => $post['has_children'],
			'content' => $post['content_content']
		);

		$post_request -> closeCursor();
		$user_display_name_request -> closeCursor();
	}

	function get_posts($content_type){
		global $bdd, $posts;
	}

	function get_menu($menu){
		global $bdd, $CONFIG;

		$menu_request = $bdd -> prepare('SELECT * FROM :table_content WHERE content_slug = :content_slug and content_type = "menu"');
		$menu_request -> execute(array(':table_content' => $CONFIG['PREFIX'] . 'content', ':content_slug' => $menu));
		$menu = $menu_request -> fetch();
		
		echo '<div id="'.$menu['content_slug'].'-main-container"><ul id="'.$menu['content_slug'].'" class="menu-main-container menu-'.$menu['content_id'].'">';
		get_sub_menus($menu['content_id']);
		echo '</ul></div>';
		$menu_request -> closeCursor();
	}

	function get_sub_menus($menu_parent_id){
		global $bdd, $CONFIG;

		$sub_menu_request = $bdd -> prepare('SELECT * FROM :table_content WHERE content_parent_id = :menu_parent_id and content_type = "menu-element"');
		$sub_menu_request -> execute(array(':table_content' => $CONFIG['PREFIX'] . 'content', ':menu_parent_id' => $menu_parent_id));
		
		while($sub_menu = $sub_menu_request -> fetch()){
			echo '<li id="menu-item-'.$sub_menu['content_id'].'"><a href="#">'.$sub_menu['content_title'].'</a>';
			if($sub_menu['has_children'] == 1){
				echo '<ul class="sub-menu">';
				get_sub_menus($sub_menu['content_id']);
				echo '</ul>';
			}
			echo '</li>';
		}

		$sub_menu_request -> closeCursor();
	}