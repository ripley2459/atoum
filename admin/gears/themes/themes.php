<?php

	if(isset($_GET['switch_to_theme'])){
		$switch_to_theme = $_GET['switch_to_theme'];
		update_option_value('active_theme', $switch_to_theme);
		header('location: themes.php');
	}

	echo get_block_section(
	get_block_title(
		1, 'Themes'
			, '', '', 'template') . 
			get_block_div(get_themes_wrapper(), '', 'themes-wrapper', 'template')
		, '', '', 'template');