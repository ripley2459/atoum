<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$person = new person( $_GET[ 'person' ] );

	if( $_POST[ 'name' ] != '' ) {
		$person->changeName( $_POST[ 'name' ] );
	}

	relation::purgeRelationsRelated( 7, $_GET[ 'person' ] );

	foreach( array_unique( $_POST[ 'tags' ] ) as $tag ) {
		$relation = new relation( -1 );
		$relation->setType( 7 );
		$relation->setA( $_GET[ 'person' ] );
		$relation->setB( $tag );
		$relation->register();
	}