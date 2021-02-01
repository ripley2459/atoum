<?php

	if(isset($_POST['name'])){

		$term_name = $_POST['name'];
		$term_type = 'class';

		if(empty($_POST['slug'])){
			$term_slug = $term_name;
		}
		else{
			$term_slug = $_POST['slug'];
		}
		if(isset($_POST['description'])){
			$term_description = $_POST['description'];
		}
		else{
			$term_description = ' ';
		}
		if(isset($_POST['parent'])){
			$term_parent_id = $_POST['parent'];
		}
		else{
			$term_parent_id = 0;
		}
		term_add($term_name, $term_slug, $term_type, $term_description, $term_parent_id);
		header('location: classes.php');
	}

	if(isset($_POST['delete'])){
		if(isset($_GET['term_to_delete'])){
			$term_to_delete = $_GET['term_to_delete'];
			echo $term_to_delete;
			term_delete($term_to_delete);
			header('location: classes.php');
		}
	}

	if(isset($_GET['order_direction'])){
		$order_direction = $_GET['order_direction'];
	}
	else{
		$order_direction = 'asc';
	}

	echo
	get_block_section(
		get_block_title(
			1,
			'Classes',
			'',
			'',
			'',
			''
		),
		'',
		'',
		'',
		''
	);

	if(!isset($_POST['update'])){
		switch_order_direction($order_direction);
		echo
		get_block_div(
			get_block_div(
				get_block_section(
					get_block_title(
						2,
						'Create a class',
						'',
						'',
						'',
						''
					) .
					get_block_form(
						get_block_label(
							'Name',
							'name',
							'',
							'',
							''
						) .
						get_block_input_text(
							'name',
							'name',
							'',
							$array = array('placeholder' => 'A tiny text', 'required' => 'required'),
							'',
							''
						) .
						get_block_paragraph(
							'Display name of the class.',
							'',
							'',
							'',
							''
						) .
						get_block_label(
							'Slug',
							'slug',
							'',
							'',
							''
						) .
						get_block_input_text(
							'slug',
							'slug',
							'',
							$array = array('placeholder' => 'A tiny text.'),
							'',
							''
						) .
						get_block_paragraph(
							'The slug is a normalized name made of lowercase letters, numbers and hyphens.',
							'',
							'',
							'',
							''
						) .
						get_block_label(
							'Parent class',
							'parent',
							'',
							'',
							''
						) .
						/* GETBLOCKSLECT .*/
						get_block_paragraph(
							'You can order your classes using parental class.',
							'',
							'',
							'',
							''
						) .
						get_block_label(
							'Description',
							'description',
							'',
							'',
							''
						) .
						get_block_input_text(
							'description',
							'description',
							'',
							$array = array('placeholder' => 'Description of your class.'),
							'',
							''
						) .
						get_block_paragraph(
							'The description allow you to known quickly what is inside a class.',
							'',
							'',
							'',
							''
						) .
						get_block_button(
							'Add',
							'submit',
							'',
							'btn_add_class',
							'',
							'',
							''
						),
						'',
						'',
						$array = array('action' => 'classes.php', 'method' => 'post'),
						'',
						''
					),
					'',
					'',
					'',
					''
				),
				'',
				'column',
				'',
				''
			) .
			get_block_div(
				get_block_section(
					get_block_title(
						2,
						'Your classes',
						'',
						'',
						'',
						''
					) .
					get_terms('class', 'term_name', $order_direction),
					'',
					'',
					'',
					''
				),
				'',
				'column',
				'',
				''
			),
			'',
			'row first-is-thin',
			'',
			''
		);
		//END DISPLAY CL
	}