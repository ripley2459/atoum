<?php

	if(isset($_GET['switch_to_theme'])){
		$switch_to_theme = $_GET['switch_to_theme'];
		update_option_value('active_theme', $switch_to_theme);
		header('location: themes.php');
	}

	echo
	get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('template' => 'admin'),
			'Themes'
		) . 
		get_block_div(
			$array = array('class' => 'themes-wrapper', 'template' => 'admin'),
			get_themes_wrapper()
		),
	);