<?php

	define('HOST', 'localhost');
	define('DBNAME', 'at_test');
	define('CHARSET', 'utf8');
	define('USER', 'root');
	define('PASSWORD', '');
	define('PREFIX', 'at_');

	define('ROOT', __DIR__);
	define('URL', sprintf('%s://%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']));
	define('PLUGINS', __DIR__ . '/content/plugins/');
	define('THEMES', __DIR__ . '/content/themes/');
	define('UPLOADS', __DIR__ . '/content/uploads/' . date('Y/m/d/'));

	define('BLOCKS', ROOT . '/includes/blocks/');
	define('CLASSES', ROOT . '/includes/classes/');

	include ROOT . '/blocks.php';
	require ROOT . '/classes.php';

	require ROOT . '/includes/functions.php';
	require ROOT . '/admin/includes/functions.php';

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

	$THEME = get_option_value('active_theme');

	require THEMES . $THEME . '/includes/functions.php';
	require THEMES . $THEME . '/includes/blocks.php';