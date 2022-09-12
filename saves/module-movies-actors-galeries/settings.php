<?php

	define( 'HOST', 'localhost' );
	define( 'DBNAME', 'rp_lab' );
	define( 'CHARSET', 'utf8' );
	define( 'USER', 'root' );
	define( 'PASSWORD', '' );

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
		throw new \PDOException( $e -> getMessage(), (int)$e -> getCode() );
	}

	define( 'URL', sprintf( '%s://%s', isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] != 'off' ? 'https' : 'http', $_SERVER[ 'SERVER_NAME' ] ) );
	define( 'DIR', __DIR__ );
	define( 'INCLUDES', DIR . '/includes/' );
	define( 'CLASSES', INCLUDES . 'classes/' );
	define( 'FUNCTIONS', INCLUDES . 'functions/' );
	define( 'UPLOADS', DIR . '/content/uploads/' );
	define( 'UPLOADSDFROMURL', URL . '/content/uploads/' );