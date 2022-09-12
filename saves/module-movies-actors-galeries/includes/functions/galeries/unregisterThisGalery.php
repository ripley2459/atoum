<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$galery = new galery( $_GET[ 'galery' ] );

	relation::purgeRelationsRelated( 11, $galery->getId() );
	relation::purgeRelationsRelated( 4, $galery->getId() );

	$galery->unregister();