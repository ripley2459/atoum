<?php

	require '../../../settings.php';
	require '../../../imports.php';

	if( $_POST[ 'name' ] != '' ) {
		$galery = new galery( -1 );

		$galery->setName( $_POST[ 'name' ] );
		$galery->register();
	}