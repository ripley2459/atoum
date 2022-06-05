<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$galery = new galery( $_GET[ 'galery' ] );

	echo '<h3>' . $galery->getName() . '</h3>';
	//echo '<p>Registration date: ' . $galery->getRegistrationDate() . '</p>';
	//echo '<p>File name: ' . normalize( $galery->getFileName() ) . '</p>';
	echo '<form id="updateGalery' . $galery->getId() . '">';
	echo '<label for="name">Name</label>';
	echo '<input name="name" type="text"/>';
	echo tag::displayOnlyOfType( $galery->getId(), 11 /* type de relation */, 0 /* type de tag */ );
	echo person::displayAllAsCheckBox( $galery->getId(), 4 );
	echo '</form>';
	echo '<button onclick="modifyThisGalery(' . $galery->getId() . ')">Save</button>';
	echo '<button onclick="unregisterThisGalery(' . $galery->getId() . ')">Unregister</button>';