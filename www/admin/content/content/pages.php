<?php

	order_manager();

	$content_type = 'page';
	$table_content = '';

	//Only parameters inside the white list can be used !!!!
	// /!\ Injection
	$order_by = whitelist($_GET['order_by'], ['content_title', 'content_author_id', 'content_date_created', 'content_date_modified'], 'Invalid field name!');
	$order_direction = whitelist($order_direction, ['asc', 'desc'], 'Invalid order direction!');

	$sql = 'SELECT content_id FROM at_content WHERE content_type = :content_type ORDER BY ' . $order_by . ' ' . $order_direction;
	$request_get_content = $DDB->prepare($sql);
	$request_get_content->execute([':content_type'=>$content_type]);

	while($content = $request_get_content->fetch()){
		//While we have pages to use, use their instance to create a row inside the table
		$content = new at_content($content['content_id']);
		$table_content .= $content->display_as_table_row();
	}

	$request_get_content->closeCursor();

	//Table header
	$to_display =
	get_block_table(
		['class'=>'table-' . $content_type, 'template'=>'admin'],
		get_block_table_row(
			['template'=>'admin'],
			get_block_table_heading(
				['template'=>'admin'],
				get_block_link(
					'/admin/' . $folder . '/' . $page . '.php?order_by=content_title&order_direction=' . $order_direction,
					['template'=>'admin'],
					'Title<i class="' . $order_direction . '"></i>'
				),
				'',
				'',
				'',
				''
			) .
			get_block_table_heading(
				['template'=>'admin'],
				get_block_link(
					'/admin/' . $folder . '/' . $page . '.php?order_by=content_author_id&order_direction=' . $order_direction,
					['template'=>'admin'],
					'Author<i class="' . $order_direction . '"></i>'
				)
			) .
			get_block_table_heading(
				['template'=>'admin'],
				'Classes'
			) .
			get_block_table_heading(
				['template'=>'admin'],
				get_block_link(
					'/admin/' . $folder . '/' . $page . '.php?order_by=content_date_created&order_direction=' . $order_direction,
					['template'=>'admin'],
					'Creation date<i class="' . $order_direction . '"></i>'
				)
			) .
			get_block_table_heading(
				['template'=>'admin'],
				get_block_link(
					'/admin/' . $folder . '/' . $page . '.php?order_by=content_date_modified&order_direction=' . $order_direction,
					['template'=>'admin'],
					'Last modification date<i class="' . $order_direction . '"></i>'
				)
			)
		) .
		$table_content
	);

	//Content
	echo get_block_div(
		['template'=>'admin'],
		get_block_title(
			1,
			['template'=>'admin'],
			'Pages'
		) . 
		get_block_link(
			'editor.php?action=create&type=page',
			['template'=>'admin'],
			'Add'
		)
	);

	echo get_block_div(
		['template'=>'admin'],
		$to_display
	);