<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$movie = new movie( $_GET[ 'movie' ] );

	echo '<h3>' . $movie->getName() . '</h3>';
	//echo '<p>Registration date: ' . $movie->getRegistrationDate() . '</p>';
	//echo '<p>File name: ' . normalize( $movie->getFileName() ) . '</p>';
	echo '<form id="updateMovie' . $movie->getId() . '">';
	echo '<label for="name">Name</label>';
	echo '<input name="name" type="text"/>';
	echo tag::displayOnlyOfType( $movie->getId(), 8 /* type de relation */, 1 /* type de tag */ );
	echo '</form>';
	echo '<button onclick="modifyThisMovie(' . $movie->getId() . ')">Save</button>';
	echo '<button onclick="unregisterThisMovie(' . $movie->getId() . ')">Unregister</button>';