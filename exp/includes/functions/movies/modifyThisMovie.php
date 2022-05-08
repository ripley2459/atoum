<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$movie = new movie( $_GET[ 'movie' ] );

	if( $_POST[ 'name' ] != '' ) {
		$movie->changeName( $_POST[ 'name' ] );
	}

	relation::purgeRelationsRelated( 8, $_GET[ 'movie' ] );

	foreach( array_unique( $_POST[ 'tags' ] ) as $tag ) {
		$relation = new relation( -1 );
		$relation->setType( 8 );
		$relation->setA( $_GET[ 'movie' ] );
		$relation->setB( $tag );
		$relation->register();
	}