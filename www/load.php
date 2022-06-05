<?php
	
	namespace Atoum;

	// THEME
	// Check if a theme is installaed, if not use the template theme.
	if( get_option_value( 'active_theme' ) == 'template' ) {
		// No theme saved in the database.
		define( 'STYLE', URL . '/includes/template/includes/style.css' );
		define( 'THEME', INCLUDES . 'template' . '/' );

		require THEME . 'imports.php';
		require THEME . 'load.php';
	}
	else {
		// A theme's name has been found. Use it.
		define( 'THEME', THEMES . get_option_value( 'active_theme' ) . '/' );
		define( 'STYLE', URL . '/content/themes/' . THEME . '/includes/style.css' );

		require THEME . 'imports.php';
		require THEME . 'load.php';
	}

	// PAGE
	if( isset( $_GET[ 'page' ] ) ) {
		define( 'PAGE', $_GET[ 'page' ] );
	}
	else {
		define( 'PAGE', false );
	}