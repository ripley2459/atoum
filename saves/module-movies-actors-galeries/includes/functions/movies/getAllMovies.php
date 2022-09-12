<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$movies = movie::getAll();

	foreach( $movies as $movie ) {
		echo '<tr id="' . $movie->getId() . '_row">';
		echo '<td>' . $movie->getName() . '</td>';
		echo '<td>';
		echo '<button onclick="openMovieSettings(' . $movie->getId() . ')">Settings</button>';
		echo '<div id="' . $movie->getId() . '">';
		echo '<!-- Movie ' . $movie->getId() . ' settings -->';
		echo '</div>';
		echo '</td>';
		echo '</tr>';
	}