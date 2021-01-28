<?php

	echo get_block_section(
		get_block_title(1, 'Uploads', '', '', '') .	
		get_block_div(
			get_block_link('medias.php?mode=list', '<i class="fas fa-bars"></i>', '', '','', '') . 
			get_block_link('medias.php?mode=grid', '<i class="fas fa-th-large"></i>', '', '', '', '')
		, 'uploads-form', '', '')
	, '', '', '');