<?php

	require '../../../settings.php';
	require '../../../imports.php';

	// Ajouter un film.
	if( isset( $_POST[ 'movie' ] ) ) {
		$movie = new movie( -1 );

		if ( $_POST[ 'name' ] != '' ) {
			$movie->setName( $_POST[ 'name' ] );
		}
		else {
			$movie->setName( $_FILES[ 'movie' ][ 'name' ] );
		}

		$movie->register();

		move_uploaded_file( $_FILES[ 'movie' ] [ 'tmp_name' ], $movie->getPath() . 'movie.mp4' );
		//if( isset( $_POST[ 'preview' ] )) move_uploaded_file( $_FILES[ 'preview' ] [ 'tmp_name' ], $movie->getPath() . 'preview.png' );

		// Tags
		foreach( array_unique( $_POST[ 'tags' ] ) as $tag ) {
			$relation = new relation( -1 );
			$relation->setType( 8 );
			$relation->setA( $movie->getId() );
			$relation->setB( $tag );
			$relation->register();
		}

		// Persons
		foreach( array_unique( $_POST[ 'persons' ] ) as $person ) {
			$relation = new relation( -1 );
			$relation->setType( 7 );
			$relation->setA( $movie->getId() );
			$relation->setB( $person );
			$relation->register();
		}
	}