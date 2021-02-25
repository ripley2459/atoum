<?php

	$term_type = 'class';
	$action = '';

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
		$term = term_recover($term_to_edit, $term_type);
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
						$array = array('type' => 'submit', 'value' => 'Save', 'name' => 'save', 'template' => 'admin')
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
	
	function get_terms(string $term_type, string $order_by, string $order_direction){
		//Display terms as a table
		global $DDB, $folder, $page;
		$to_display = '';
		$table_content = '';

		$request_get_terms = $DDB->prepare('SELECT * FROM at_terms WHERE term_type = :term_type ORDER BY :order_by :order_direction');
		$request_get_terms->execute(array(':term_type' => $term_type, ':order_by' => $order_by,':order_direction' => $order_direction));

		while($term = $request_get_terms->fetch()){

			$table_content .=
			get_block_table_row(
				$array = array('template' => 'admin'),
				get_block_table_data(
					$array = array('class' => 'spoiler_container', 'template' => 'admin'),
					$term['term_name'] . '</br>' .
					get_block_div(
						$array = array('class' => 'spoiler', 'template' => 'admin'),
						get_block_link(
							'#',
							$array = array('template' => 'admin'),
							'Display'
						) . ' | ' .
						get_block_link(
							'classes.php?term_to_edit=' . $term['term_id'],
							$array = array('template' => 'admin'),
							'Edit'
						) . ' | ' .
						get_block_link(
							'classes.php?term_to_delete=' . $term['term_id'],
							$array = array('template' => 'admin'),
							'Delete'
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
				) .
				get_block_table_data(
					$array = array('template' => 'admin'),
					'X'
				)
			);
		}

		$to_display .= 
			get_block_table(
				$array = array('template' => 'admin'),
				get_block_table_row(
					$array = array('template' => 'admin'),
					get_block_table_heading(
						$array = array('template' => 'admin'),
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=term_name&order_direction=' . $order_direction,
							$array = array('template' => 'admin'),
							'Name<i class="' . $order_direction . '"></i>'
						)
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						get_block_link(
							'/admin/' . $folder . '/' . $page . '.php?order_by=term_slug&order_direction=' . $order_direction,
							$array = array('template' => 'admin'),
							'Slug<i class="' . $order_direction . '"></i>'
						)
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						'Description'
					) .
					get_block_table_heading(
						$array = array('template' => 'admin'),
						'Usage'
					)
				) .
				$table_content
			);

		$request_get_terms->closeCursor();

		return $to_display;
	}

	function term_recover(int $term_id, string $term_type){
		//Get the class to term
		global $DDB;
		$request_term_recover = $DDB->prepare('SELECT * FROM at_terms WHERE term_type = :term_type and term_id = :term_id');
		$request_term_recover->execute(array(':term_type' => $term_type, ':term_id' => $term_id));
		$term = $request_term_recover->fetch();

		$term = array(
			'term_name' => $term['term_name'],
			'term_slug' => $term['term_slug'],
			'term_parent_id' => $term['term_parent_id'],
			'term_description' => $term['term_description']
		);

		$request_term_recover->closeCursor();
		return $term;
	}

	function term_edit(int $term_id, string $term_name, string $term_slug, string $term_description, string $term_parent_id){
		//Edit the term
		global $DDB;
		$request_term_edit = $DDB->prepare('UPDATE at_terms SET term_name = :term_name, term_slug = :term_slug, term_description = :term_description, term_parent_id = :term_parent_id WHERE term_id = :term_id');
		$request_term_edit->execute(array(':term_name' => $term_name, ':term_slug' => $term_slug, ':term_description'=> $term_description, ':term_parent_id' => $term_parent_id, ':term_id' => $term_id));
		$request_term_edit->closeCursor();
	}

	function term_delete(int $term_id){
		//delete the term
		global $DDB;
		$request_term_delete = $DDB->prepare('DELETE FROM at_terms WHERE term_id =  :term_id');
		$request_term_delete->execute(array(':term_id' => $term_id));
		$request_term_delete->closeCursor();
	}