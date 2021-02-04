<?php

	echo
	get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('class' => 'themes-name', 'template' => 'admin'),
			'Uploads'
		) .	
		get_block_div(
			$array = array('template' => 'admin'),
			get_block_link(
				'uploads.php?mode=list',
				'<i class="fas fa-bars"></i>',
				'',
				'',
				'',
				'',
				'',
				''
			) .
			get_block_link(
				'uploads.php?mode=grid',
				'<i class="fas fa-th-large"></i>',
				'',
				'',
				'',
				'',
				'',
				''
			),
		)
	);