<?php
	
	namespace Atoum;
	// load.php

	// retrieve the theme
	// if its can't be loaded, load the template

	define( 'THEME', get_option_value( 'active_theme' ) . '/' );

	if( get_option_value( 'active_theme' ) == 'none' ) {
		// no theme saved in the database
		define( 'STYLE', URL . '/includes/template/includes/style.css' );

		require INCLUDES . 'template/imports.php';
		require INCLUDES . 'template/load.php';
	}
	else {
		// a theme's name has been found. Use it.
		define( 'STYLE', URL . '/content/themes/' . THEME . '/includes/style.css' );

		require THEMES . THEME . '/imports.php';
		require THEMES . THEME . '/load.php';
	}