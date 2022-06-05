<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$person = new person( $_GET[ 'person' ] );

	relation::purgeRelationsRelated( 10, $_GET[ 'person' ] );

	$person->unregister();