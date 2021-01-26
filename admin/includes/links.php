<?php

	//CONNECT TO THE DATABASE
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=rp_test;charset=utf8','root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e){
		die("Error: " . $e -> getMessage());
	}


	//LINKS
	$links = array(
		'root' => $_SERVER['DOCUMENT_ROOT'],
		'url' => 'http://atoum',
		'plugins' => $_SERVER['DOCUMENT_ROOT'].'/content/plugins/',
		'themes' => $_SERVER['DOCUMENT_ROOT'].'/content/themes/',
	);


	require $links['root'].'/includes/functions.php';
	require $links['root'].'/admin/includes/functions.php';

	//Prendre le thème actif
	get_option_value('active_theme');
	$THEME = $option_value;
	//Load ses fonctions
	require $links['themes'].$THEME.'/includes/functions.php';
	
	//Charger les plugins