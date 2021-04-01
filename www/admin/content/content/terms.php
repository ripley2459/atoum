<?php

	order_manager();

	//Content edition
	//Remove
	//Version 1
	//If a parameter to_delete exist then try to delete this term
	if(isset($_GET['term_to_delete'])){
		$term = new at_term($_GET['term_to_delete']);
		$term->remove();
		header('location: terms.php');
	}

	//Update
	//Version 1
	if(isset($_GET['term_to_edit'])){
		//If a parameter to_delete exist then try to recover this term's parameters and put them into some varibales dispached inside the form below
		$term = new at_term($_GET['term_to_edit']);
		$term_name = $term->get_name();
		$term_slug = $term->get_slug();
		$term_parent_id = $term->get_parent_id();
		$term_description = $term->get_description();

		//Add inside the form's action url that we have a term to edit
		$url_complement = '?term_to_edit=' . $_GET['term_to_edit'];
		//Indicate inside the submite button that we are in a update configuration
		$action = 'Update';
	}
	else{
		//No term to edit so fill the form below with blank value
		$term_name = '';
		$term_slug = '';
		$term_parent_id = '';
		$term_description = '';

		$url_complement = '';
		$action = 'Save';
	}

	//Apply
	//Version 1
	if(isset($_POST['save'])){

		$term_name = $_POST['name'];

		if(!isset($_POST['slug'])){
			$term_slug = to_slug($_POST['name']);
		}
		else{
			$term_slug = to_slug($_POST['slug']);
		}

		if(!isset($_POST['parent_id'])){
			$term_parent_id = 0;
		}
		else{
			$term_parent_id = to_slug($_POST['parent_id']);
		}

		$term_description = $_POST['description'];
		
		//Add new term
		//Version 1
		if($_POST['save'] == 'Save'){
			$term = new at_term(-1);
			$term->insert($term_name, $term_slug, $term_description, $term_parent_id);
		}
		//Edit an existing term
		//Version 1
		else if($_POST['save'] == 'Update'){
			$term = new at_term($_GET['term_to_edit']);
			$term->edit($term_name, $term_slug, $term_description, $term_parent_id);
		}

		header('location: terms.php');
	}

	//Terms
	$table_content = '';
	$term_type = 'class';

	//Only parameters inside the white list can be used !!!!
	// /!\ Injection
	$order_by = whitelist($order_by, ['term_name', 'term_slug', 'usage'], 'Invalid field name!');
	$order_direction = whitelist($order_direction, ['asc', 'desc'], 'Invalid order direction!');

	$sql = 'SELECT term_id FROM at_terms WHERE term_type = :term_type ORDER BY ' . $order_by . ' ' . $order_direction;
	$request_get_terms = $DDB->prepare($sql);
	$request_get_terms->execute([':term_type'=>$term_type]);

	while($term = $request_get_terms->fetch()){
		//While we have terms to use, use their instance to create a row inside the table
		$term = new at_term($term['term_id']);
		$table_content .= $term->display_as_table_row();
	}

	$request_get_terms->closeCursor();

	//Create the table header
	$terms = 
		get_block_table(
			['template'=>'admin'],
			get_block_table_row(
				['template'=>'admin'],
				get_block_table_heading(
					['template'=>'admin'],
					get_block_link(
						'/admin/' . $folder . '/' . $page . '.php?order_by=term_name&order_direction=' . $order_direction,
						['template'=>'admin'],
						'Name<i class="' . $order_direction . '"></i>'
					)
				) .
				get_block_table_heading(
					['template'=>'admin'],
					get_block_link(
						'/admin/' . $folder . '/' . $page . '.php?order_by=term_slug&order_direction=' . $order_direction,
						['template'=>'admin'],
						'Slug<i class="' . $order_direction . '"></i>'
					)
				) .
				get_block_table_heading(
					['template'=>'admin'],
					'Description'
				) .
				get_block_table_heading(
					['template'=>'admin'],
					get_block_link(
						'/admin/' . $folder . '/' . $page . '.php?order_by=usage&order_direction=' . $order_direction,
						['template'=>'admin'],
						'Usage<i class="' . $order_direction . '"></i>'
					)
				)
			) .
			$table_content
		);

	//Content
	echo
	get_block_div(
		['template'=>'admin'],
		get_block_title(
			1,
			['template'=>'admin'],
			'Terms',
		),
	) .
	get_block_div(
		['class'=>'row', 'template'=>'admin'],
		get_block_div(
			['class'=>'column', 'template'=>'admin'],
			get_block_div(
				['template'=>'admin'],
				get_block_title(
					2,
					['template'=>'admin'],
					'Create a class'
				) .
				get_block_form(
					['action'=>'terms.php' . $url_complement, 'method'=>'post', 'template'=>'admin'],
					get_block_label(
						['for'=>'name', 'template'=>'admin'],
						'Name'
					) .
					get_block_input(
						['type'=>'text', 'name'=>'name', 'required'=>'required', 'value'=>$term_name, 'template'=>'admin'],
					) .
					get_block_paragraph(
						['template'=>'admin'],
						'Display name of the class.'
					) .
					get_block_label(
						['for'=>'slug', 'template'=>'admin'],
						'Slug'
					) .
					get_block_input(
						['type'=>'text', 'name'=>'slug', 'value'=>$term_slug, 'template'=>'admin'],
					) .
					get_block_paragraph(
						['template'=>'admin'],
						'The slug is a normalized name made of lowercase letters, numbers and hyphens.'
					) .
					get_block_label(
						['for'=>'parent_id', 'template'=>'admin'],
						'Parent class'
					) .
					/* GETBLOCKSLECT .*/
					get_block_paragraph(
						['template'=>'admin'],
						'You can order your classes using parental class.'
					) .
					get_block_label(
						['for'=>'description', 'template'=>'admin'],
						'Description'
					) .
					get_block_input(
						['type'=>'text', 'name'=>'description', 'value'=>$term_description, 'template'=>'admin'],
					) .
					get_block_paragraph(
						['template'=>'admin'],
						'The description allow you to known quickly what is inside a class.'
					) .
					get_block_input(
						['type'=>'submit', 'value'=>$action, 'name'=>'save', 'template'=>'admin']
					)
				)
			)
		) .
		get_block_div(
			['class'=>'column', 'template'=>'admin'],
			get_block_div(
				['template'=>'admin'],
				get_block_title(
					2,
					['template'=>'admin'],
					'Your classes'
				) .
				$terms
			)
		)
	);