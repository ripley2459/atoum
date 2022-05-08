<?php

	require '../../../settings.php';
	require '../../../imports.php';

	if( $_POST[ 'name' ] != '' ) {
		$person = new person( -1 );

		$person->setName( $_POST[ 'name' ] );
		$person->register();
	}