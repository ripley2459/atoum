<?php
	
	namespace Atoum;

	// Retrieve everything related to the theme.

	define( 'THEME', get_option_value( 'active_theme' ) . '/' );

	if( get_option_value( 'active_theme' ) == 'template' ) {
		// No theme saved in the database.
		define( 'STYLE', URL . '/includes/template/includes/style.css' );

		require INCLUDES . 'template/imports.php';
		require INCLUDES . 'template/load.php';
	}
	else {
		// A theme's name has been found. Use it.
		define( 'STYLE', URL . '/content/themes/' . THEME . '/includes/style.css' );

		require THEMES . THEME . '/imports.php';
		require THEMES . THEME . '/load.php';
	}