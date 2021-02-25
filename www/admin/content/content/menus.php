<?php

	$order_direction = 'asc';

	echo
	get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('template' => 'admin'),
			'Menus'
		) .
		get_block_div(
			$array = array('class' => 'row', 'template' => 'admin'),
			get_block_div(
				$array = array('class' => 'column', 'template' => 'admin'),
				get_block_title(
					2,
					$array = array('template' => 'admin'),
					'Create a menu'
				) .
				get_block_form(
					$array = array('action' => 'menus.php', 'method' => 'post', 'template' => 'admin'),
					get_block_label(
						$array = array('for' => 'menu_name', 'template' => 'admin'),
						'Name'
					) .
					get_block_input(
						$array = array('type' => 'text', 'name' => 'menu_name', 'required' => 'required', 'template' => 'admin')
					) .
					get_block_input(
						$array = array('type' => 'submit', 'name' => 'submit', 'value' => 'Create', 'template' => 'admin')
					)
				) .
				get_block_title(
					3,
					$array = array('template' => 'admin'),
					'Add elements'
				) .
				get_block_div(
					$array = array('class' => 'accordion_group', 'template' => 'admin'),
					get_block_accordion(
						$array = array('template' => 'admin'),
						'Pages',
						get_content_for_menus('page')
					) .
					get_block_accordion(
						$array = array('template' => 'admin'),
						'Posts',
						get_content_for_menus('post')
					) .
					get_block_accordion(
						$array = array('template' => 'admin'),
						'Links',
						/* get_content_for_menus('link') */'LINKS'
					) .
					get_block_accordion(
						$array = array('template' => 'admin'),
						'Classes',
						get_terms_for_menus('class')
					)
				)
			) .
			get_block_div(
				$array = array('class' => 'column', 'template' => 'admin'),
				get_block_title(
					2,
					$array = array('template' => 'admin'),
					'Organise your menu'
				) .
				get_block_div(
					$array = array('template' => 'admin'),
					get_block_title(
						2,
						$array = array('template' => 'admin'),
						'Your classes'
					)
				) .
				get_block_div(
					$array = array('template' => 'admin'),
					get_menus_as_tabs()
				)
			)
		)
	);
	
	function get_menus_as_tabs(){
		global $DDB;

		$tab_headers = array();
		$tab_content = array();

		$menu_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_type = "menu"');
		$menu_request -> execute();
		
		while($menu = $menu_request -> fetch()){
			array_push($tab_headers, $menu['content_id'] . '-' . $menu['content_slug']);
			array_push($tab_content, get_sub_menus_as_tabs($menu['content_id']));
		}

		$menu_request -> closeCursor();

		return
		get_block_tabs(
			$array = array('template' => 'admin'),
			$tab_headers,
			$tab_content
		);
	}

	function get_sub_menus_as_tabs($menu_parent_id){
		global $DDB;
		$to_display = '';

		$sub_menu_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_parent_id = :menu_parent_id and content_type = "menu-element"');
		$sub_menu_request -> execute(array(':menu_parent_id' => $menu_parent_id));
		
		while($sub_menu = $sub_menu_request -> fetch()){
			if($sub_menu['content_has_children'] == 1){
				$to_display .= $sub_menu['content_id'] . $sub_menu['content_content'] . $sub_menu['content_title'] . get_sub_menus_as_tabs($sub_menu['content_id']);
			}
			else{
				$to_display .= $sub_menu['content_id'] . $sub_menu['content_content'] . $sub_menu['content_title'];
			}
		}

		$sub_menu_request -> closeCursor();
		return $to_display;
	}