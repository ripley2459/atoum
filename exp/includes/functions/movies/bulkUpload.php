<?php

	require '../../../settings.php';
	require '../../../imports.php';

	logger::logInfo( 'Bulk uploading operation started' );

	$files = normalized_scan( DIR . '/content/bulk/' );

	logger::logInfo( 'Found ' . count( $files ) . ' files' );

	foreach( $files as $file ) {
		$movie = new movie( -1 );
		$movie->setName( $file );
		$movie->register();

		logger::logInfo( $file . ' registered' );

		copy( DIR . '/content/bulk/' . $file, $movie->getPath() . 'movie.mp4' );

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

		logger::logInfo( 'Tags applied on ' . $file );
	}