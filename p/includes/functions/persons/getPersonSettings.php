<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$person = new person( $_GET[ 'person' ] );

	echo '<h3>' . $person->getName() . '</h3>';
	//echo '<p>Registration date: ' . $person->getRegistrationDate() . '</p>';
	//echo '<p>File name: ' . normalize( $person->getFileName() ) . '</p>';
	echo '<form id="updatePerson' . $person->getId() . '">';
	echo '<label for="name">Name</label>';
	echo '<input name="name" type="text"/>';
	echo tag::displayOnlyOfType( $person->getId(), 10 /* type de relation */, 2 /* type de tag */ );
	echo '</form>';
	echo '<button onclick="modifyThisPerson(' . $person->getId() . ')">Save</button>';
	echo '<button onclick="unregisterThisPerson(' . $person->getId() . ')">Unregister</button>';