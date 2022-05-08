<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$person = new person( $_GET[ 'person' ] );

	$person->unregister();