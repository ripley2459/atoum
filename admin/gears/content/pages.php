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
			'Pages'
		) . 
		get_block_link(
			'editor.php?mode=create&type=post',
			'Add',
			'',
			'',
			'',
			'',
			'',
			''
		)
	);

	echo get_block_div(
		$array = array('template' => 'admin'),
		get_content('page', 'content_name', $order_direction)
	);