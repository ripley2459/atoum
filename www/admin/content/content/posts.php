<?php

	if(isset($_GET['order_direction'])){
		$order_direction = $_GET['order_direction'];
	}
	else{
		$order_direction = 'asc';
	}

	if(isset($_POST['update'])){
		$term_type = 'class';

		$request_terms = $DDB -> prepare('SELECT * FROM at_terms WHERE term_type = :term_type');
		$request_terms->execute(array(':term_type' => $term_type));
//Réccupère si le term est chécké dans la form
		while($terms = $request_terms->fetch()){
			if(isset($_POST[$terms['term_slug']])){
				echo $terms['term_slug'];
			}
		}
		
		$request_terms -> closeCursor();
	}

	switch_order_direction($order_direction);

	echo get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('template' => 'admin'),
			'Posts'
		) . 
		get_block_link(
			'editor.php?mode=create&type=post',
			$array = array('template' => 'admin'),
			'Add'
		)
	);

	echo get_block_div(
		$array = array('template' => 'admin'),
		get_content('post', 'content_name', $order_direction)
	);