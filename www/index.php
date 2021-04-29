<?php
	
	// index.php
	// 2021/04/27

	if( ! file_exists( 'settings.php' ) ) header( 'Location: admin/installer.php' );

	require 'settings.php';
	require 'config.php';
	require 'imports.php';
	require 'load.php';

	//Page construction
	require 'head.php';
	require 'body.php';