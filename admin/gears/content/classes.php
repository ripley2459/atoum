<?php

	$term_type = 'class';

	if(isset($_POST['action'])){
		$action = $_POST['action'];
	}

	if(isset($_GET['term_to_delete'])){
		$action = 'delete';
		$term_to_delete = $_GET['term_to_delete'];
		term_delete($term_to_delete);
		header('location: classes.php');
	}
	else if(isset($_POST['name'], $_GET['term_to_edit']) && $action == 'edit'){
		$action = 'edit';
		$term_to_edit = $_GET['term_to_edit'];
		$term_name = $_POST['name'];
		if(isset($_POST['slug'])){
			$term_slug = to_slug($_POST['slug']);
		}
		else{
			$term_slug = to_slug($term_name);
		}
		if(isset($_POST['description'])){
			$term_description = $_POST['description'];
		}
		else{
			$term_description = ' ';
		}
		if(isset($_POST['parent_id'])){
			$term_parent_id = $_POST['parent_id'];
		}
		else{
			$term_parent_id = 0;
		}
		term_edit($term_to_edit, $term_name, $term_slug, $term_description, $term_parent_id);
		header('location: classes.php');
	}
	else if(isset($_GET['term_to_edit'])){
		$action = 'edit';
		$term_to_edit = $_GET['term_to_edit'];
		$url_complement = '?term_to_edit=' . $term_to_edit;
		$term = get_term_to_edit($term_to_edit, $term_type);
	}
	else if(isset($_POST['name'])){
		$action = 'add';
		$term_name = $_POST['name'];
		if(isset($_POST['slug'])){
			$term_slug = str_replace(' ','-', strtolower($_POST['slug']));
		}
		else{
			$term_slug = str_replace(' ','-', strtolower($term_name));
		}
		if(isset($_POST['description'])){
			$term_description = $_POST['description'];
		}
		else{
			$term_description = ' ';
		}
		if(isset($_POST['parent_id'])){
			$term_parent_id = $_POST['parent_id'];
		}
		else{
			$term_parent_id = 0;
		}
		term_add($term_name, $term_slug, $term_type, $term_description, $term_parent_id);
		header('location: classes.php');
	}
	else {
		$action = 'add';
		$term = array('term_name' => '', 'term_slug' => '', 'term_parent_id' => '', 'term_description' => '');
		$url_complement = '';
	}

	if(isset($_GET['order_direction'])){
		$order_direction = $_GET['order_direction'];
	}
	else{
		$order_direction = 'asc';
	}

	switch_order_direction($order_direction);

	echo
	get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('template' => 'admin'),
			'Classes',
		),
	);

	echo
	get_block_div(
		$array = array('class' => 'row', 'template' => 'admin'),
		get_block_div(
			$array = array('class' => 'column', 'template' => 'admin'),
			get_block_div(
				$array = array('template' => 'admin'),
				get_block_title(
					2,
					$array = array('template' => 'admin'),
					'Create a class'
				) .
				get_block_form(
					$array = array('action' => 'classes.php' . $url_complement, 'method' => 'post', 'template' => 'admin'),
					get_block_label(
						$array = array('for' => 'name', 'template' => 'admin'),
						'Name'
					) .
					get_block_input(
						$array = array('type' => 'hidden', 'name' => 'action', 'required' => 'required', 'value' => $action, 'template' => 'admin'),
					) .
					get_block_input(
						$array = array('type' => 'text', 'name' => 'name', 'required' => 'required', 'value' => $term['term_name'], 'template' => 'admin'),
					) .
					get_block_paragraph(
						$array = array('template' => 'admin'),
						'Display name of the class.'
					) .
					get_block_label(
						$array = array('for' => 'slug', 'template' => 'admin'),
						'Slug'
					) .
					get_block_input(
						$array = array('type' => 'text', 'name' => 'slug', 'value' => $term['term_slug'], 'template' => 'admin'),
					) .
					get_block_paragraph(
						$array = array('template' => 'admin'),
						'The slug is a normalized name made of lowercase letters, numbers and hyphens.'
					) .
					get_block_label(
						$array = array('for' => 'parent_id', 'template' => 'admin'),
						'Parent class'
					) .
					/* GETBLOCKSLECT .*/
					get_block_paragraph(
						$array = array('template' => 'admin'),
						'You can order your classes using parental class.'
					) .
					get_block_label(
						$array = array('for' => 'description', 'template' => 'admin'),
						'Description'
					) .
					get_block_input(
						$array = array('type' => 'text', 'name' => 'description', 'value' => $term['term_description'], 'template' => 'admin'),
					) .
					get_block_paragraph(
						$array = array('template' => 'admin'),
						'The description allow you to known quickly what is inside a class.'
					) .
					get_block_input(
						$array = array('type' => 'submit', 'value' => 'Save', 'template' => 'admin')
					),
				),
			),
		) .
		get_block_div(
			$array = array('class' => 'column', 'template' => 'admin'),
			get_block_div(
				$array = array('template' => 'admin'),
				get_block_title(
					2,
					$array = array('template' => 'admin'),
					'Your classes'
				) .
				get_terms('class', 'term_name', $order_direction),
			),
		),
	);