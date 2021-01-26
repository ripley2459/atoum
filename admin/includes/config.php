<?php

		$CONFIG = array(
			'DB_NAME' => 'at_test',
			'PREFIX' => 'at_',
			'USERNAME' => 'root',
			'PASSWORD' => '',
			'HOST' => 'localhost');

		try{
			$bdd = new PDO('mysql:host=localhost;dbname=at_test;charset=utf8','root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e){
			die('Error: ' . $e -> getMessage());
		}

		$LINKS = array(
			'ROOT' => 'D:/Documents/Documents/Sites/atoum',
			'URL' => 'http://atoum',
			'PLUGINS' => 'D:/Documents/Documents/Sites/atoum/content/plugins/',
			'THEMES' => 'D:/Documents/Documents/Sites/atoum/content/themes/',
		);

		require $LINKS['ROOT'] . '/includes/functions.php';
		require $LINKS['ROOT'] . '/admin/includes/functions.php';

		$THEME = get_option_value('active_theme');

		require $LINKS['THEMES'] . $THEME . '/includes/functions.php';