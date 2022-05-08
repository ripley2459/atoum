<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$movie = new movie( $_GET[ 'movie' ] );

	$movie->unregister();