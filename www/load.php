<?php
	
	namespace Atoum;

	// Retrieve everything related to the theme.

	// Check if a theme is installaed, if not use the template theme.
	if( get_option_value( 'active_theme' ) == 'template' ) {
		// No theme saved in the database.
		define( 'STYLE', URL . '/includes/template/includes/style.css' );
		define( 'THEME', INCLUDES . 'template' . '/' );
	}
	else {
		// A theme's name has been found. Use it.
		define( 'STYLE', URL . '/content/themes/' . THEME . '/includes/style.css' );
		define( 'THEME', get_option_value( 'active_theme' ) . '/' );
	}

	require THEME . '/imports.php';
	require THEME . '/load.php';