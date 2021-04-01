<?php

	//Database configuration
	//Version 1
	define('HOST', 'localhost');
	define('DBNAME', 'at_test');
	define('CHARSET', 'utf8');
	define('USER', 'root');
	define('PASSWORD', '');
	define('PREFIX', 'at_');

	//Links
	//Version 1
	define('ROOT', __DIR__);
	define('URL', sprintf('%s://%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']));
	define('PLUGINS', __DIR__ . '/content/plugins/');
	define('THEMES', __DIR__ . '/content/themes/');
	define('UPLOADS', __DIR__ . '/content/uploads/' . date('Y/m/d/'));

	define('BLOCKS', __DIR__ . '/includes/blocks/');
	define('CLASSES', __DIR__ . '/includes/classes/');

	//Load basics settings
	//Version 1
	include __DIR__ . '/includes/blocks.php';
	require __DIR__ . '/includes/classes.php';

	require __DIR__ . '/includes/functions.php';
	require __DIR__ . '/admin/includes/functions.php';

	//Conection to the database
	//Version 1
	define('DSN', 'mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=' . CHARSET);

	$dsn_options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => true
	];

	try{
		$DDB = new PDO(DSN, USER, PASSWORD, $dsn_options);
	}
	catch(\PDOException $e){
		throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}

	//Get the theme name from the database and load its settings
	//Version 1
	$THEME = get_option_value('active_theme');

	require THEMES . $THEME . '/includes/functions.php';
	require THEMES . $THEME . '/includes/blocks.php';
	require THEMES . $THEME . '/includes/classes.php';