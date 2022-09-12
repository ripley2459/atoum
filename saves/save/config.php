<?php

	//Links
	//Version 1
	//since Atoum 1
	define('ROOT', __DIR__);
	define('URL', sprintf('%s://%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']));
	define('PLUGINSPATH', __DIR__ . '/content/plugins/');
	define('UPLOADSPATH', __DIR__ . '/content/uploads/' . date('Y/m/d/'));
	define('THEMESPATH', __DIR__ . '/content/themes/');
	define('BLOCKSPATH', __DIR__ . '/includes/blocks/');
	define('CLASSESPATH', __DIR__ . '/includes/classes/');

	//Load basics requierements
	//Version 1
	//since Atoum 1
	require __DIR__ . '/includes/blocks.php';
	require __DIR__ . '/includes/classes.php';
	require __DIR__ . '/includes/functions.php';
	require __DIR__ . '/admin/includes/functions.php';

	//Connection to the database
	//Version 1
	//since Atoum 1
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

	//THEME
	//Version 1
	//since Atoum 1
	//Get the active theme from the database
	define('THEME', get_option_value('active_theme'));
	
	if(THEME == 'none'){
		//No theme loaded, load the atoum template and the basic style.css
		define('THEMEPATH', __DIR__ . '/includes/template/');
		define ('THEMERESSOURCESPATH', URL . '/includes/template/includes/');
	}
	else{
		//Define pathes to the loaded theme, the scripts.js and the style.css of that theme
		define('THEMEPATH', THEMESPATH . THEME . '/');
		define ('THEMERESSOURCESPATH', URL . '/content/themes/' . THEME . '/includes/');
	}

	require THEMEPATH . '/includes/functions.php';
	require THEMEPATH . '/includes/blocks.php';
	require THEMEPATH . '/includes/classes.php';

