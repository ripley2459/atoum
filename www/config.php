<?php

	define( 'URL', sprintf( '%s://%s', isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] != 'off' ? 'https' : 'http', $_SERVER[ 'SERVER_NAME' ] ) );
	define( 'ROOT', __DIR__ . '/');
	define( 'PLUGINS', __DIR__ . '/content/plugins/' );
	define( 'THEMES', __DIR__ . '/content/themes/' );
	define( 'TEMPLATE', __DIR__ . '/includes/template/' );
	define( 'INCLUDES', __DIR__ . '/includes/' );
	define( 'WIDGETS', __DIR__ . 'includes/widgets/' );
	define( 'UPLOADS', __DIR__ . '/content/uploads/' . date( 'Y/m/d/' ) );

	// Connection to the database.

	define( 'DSN', 'mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=' . CHARSET );

	$dsn_options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => true
	];

	try {
		$DDB = new PDO( DSN, USER, PASSWORD, $dsn_options );
	}
	catch( \PDOException $e ) {
		throw new \PDOException( $e -> getMessage(), ( int )$e -> getCode() );
	}