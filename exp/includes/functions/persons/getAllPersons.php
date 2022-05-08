<?php

	require '../../../settings.php';
	require '../../..//imports.php';

	$persons = person::getAll();

	foreach( $persons as $person ) {
		echo '<tr id="' . $person->getId() . '_row">';
		echo '<td>' . $person->getName() . '</td>';
		echo '<td>';
		echo '<button onclick="openPersonSettings(' . $person->getId() . ')">Settings</button>';
		echo '<div id="' . $person->getId() . '">';
		echo '<!-- Person ' . $person->getId() . ' settings -->';
		echo '</div>';
		echo '</td>';
		echo '</tr>';
	}