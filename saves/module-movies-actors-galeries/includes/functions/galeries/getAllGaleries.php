<?php

	require '../../../settings.php';
	require '../../../imports.php';

	$galerys = galery::getAll();

	foreach( $galerys as $galery ) {
		echo '<tr id="' . $galery->getId() . '_row">';
		echo '<td>' . $galery->getName() . '</td>';
		echo '<td>';
		echo '<button onclick="openGalerySettings(' . $galery->getId() . ')">Settings</button>';
		echo '<div id="' . $galery->getId() . '">';
		echo '<!-- Galery ' . $galery->getId() . ' settings -->';
		echo '</div>';
		echo '</td>';
		echo '</tr>';
	}