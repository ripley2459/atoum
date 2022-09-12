<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$movie = new movie( $_GET[ 'movie' ] );

	relation::purgeRelationsRelated( 9, $_GET[ 'movie' ] );
	relation::purgeRelationsRelated( 3, $_GET[ 'movie' ] );

	$movie->unregister();