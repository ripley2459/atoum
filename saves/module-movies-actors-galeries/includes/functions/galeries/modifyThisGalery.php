<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$galery = new galery( $_GET[ 'galery' ] );

	if( $_POST[ 'name' ] != '' ) {
		$galery->changeName( $_POST[ 'name' ] );
	}

	relation::purgeRelationsRelated( 10, $_GET[ 'galery' ] );

	// Tags
	foreach( array_unique( $_POST[ 'tags' ] ) as $tag ) {
		$relation = new relation( -1 );
		$relation->setType( 11 );
		$relation->setA( $_GET[ 'galery' ] );
		$relation->setB( $tag );
		$relation->register();
	}

	// Persons
	foreach( array_unique( $_POST[ 'persons' ] ) as $person ) {
		$relation = new relation( -1 );
		$relation->setType( 4 );
		$relation->setA( $_GET[ 'galery' ] );
		$relation->setB( $person );
		$relation->register();
	}