<?php

	if(isset($_GET['order_direction'])){
		$order_direction = $_GET['order_direction'];
	}
	else{
		$order_direction = 'asc';
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