<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$person = new person( $_GET[ 'person' ] );

	if( $_POST[ 'name' ] != '' ) {
		$person->changeName( $_POST[ 'name' ] );
	}

	relation::purgeRelationsRelated( 10, $_GET[ 'person' ] );

	// Tags
	foreach( array_unique( $_POST[ 'tags' ] ) as $tag ) {
		$relation = new relation( -1 );
		$relation->setType( 10 );
		$relation->setA( $_GET[ 'person' ] );
		$relation->setB( $tag );
		$relation->register();
	}