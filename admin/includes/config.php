<?php

		$CONFIG = array(
			'DB_NAME' => 'at_test',
			'PREFIX' => 'at_',
			'USERNAME' => 'root',
			'PASSWORD' => '',
			'HOST' => 'localhost'
		);

		try{
			$bdd = new PDO('mysql:host=localhost;dbname=at_test;charset=utf8','root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e){
			die('Error: ' . $e -> getMessage());
		}

		$LINKS = array(
			'ROOT' => $_SERVER['DOCUMENT_ROOT'],
			'URL' => sprintf('%s://%s',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']),
			'PLUGINS' => $_SERVER['DOCUMENT_ROOT'] . '/content/plugins/',
			'THEMES' => $_SERVER['DOCUMENT_ROOT'] . '/content/themes/',
			'UPLOADS' => $_SERVER['DOCUMENT_ROOT'] . '/content/uploads/' . date('Y/m/d/'),
		);

		//Create the uploads directory if no one exist.
		if(!is_dir($LINKS['UPLOADS'])){
			mkdir($LINKS['UPLOADS'], 0755, true);
		}

		require $LINKS['ROOT'] . '/includes/functions.php';
		require $LINKS['ROOT'] . '/admin/includes/functions.php';

		$THEME = get_option_value('active_theme');

		require $LINKS['THEMES'] . $THEME . '/includes/functions.php';
		require $LINKS['THEMES'] . $THEME . '/includes/blocks.php';