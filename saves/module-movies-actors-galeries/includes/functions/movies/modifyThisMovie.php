<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$movie = new movie( $_GET[ 'movie' ] );

	if( $_POST[ 'name' ] != '' ) {
		$movie->changeName( $_POST[ 'name' ] );
	}

	relation::purgeRelationsRelated( 9, $_GET[ 'movie' ] );
	relation::purgeRelationsRelated( 3, $_GET[ 'movie' ] );

	// Tags
	foreach( array_unique( $_POST[ 'tags' ] ) as $tag ) {
		$relation = new relation( -1 );
		$relation->setType( 9 );
		$relation->setA( $_GET[ 'movie' ] );
		$relation->setB( $tag );
		$relation->register();
	}

	// Persons
	foreach( array_unique( $_POST[ 'persons' ] ) as $person ) {
		$relation = new relation( -1 );
		$relation->setType( 3 );
		$relation->setA( $movie->getId() );
		$relation->setB( $person );
		$relation->register();
	}