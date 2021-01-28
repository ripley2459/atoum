<?php

	if(isset($_GET['order_direction'])){
		$order_direction = $_GET['order_direction'];
	}
	else{
		$order_direction = 'asc';
	}

	switch_order_direction($order_direction);

	echo get_block_section(
		get_block_title(
			1,
			'Posts',
			'',
			'',
			''
		) . 
		get_block_link(
			'editor.php?mode=create&type=post',
			'Add',
			'',
			'',
			'',
			''
		),
		'',
		'',
		''
	);

	echo get_block_section(
		get_content('post', 'content_name', $order_direction),
		'',
		'',
		''
	);