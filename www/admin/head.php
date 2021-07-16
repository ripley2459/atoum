<!-- START ADMIN HTML -->
<!doctype html>
<html lang="en">
	<!-- START ADMIN HEAD -->
	<head class="admin">

		<?php

			// Define the page title.
			$page = 'overview.php';

			if( isset( $_GET['p'] ) ) $page = $_GET['p'];

		?>

		<title><?php echo ucfirst( str_replace( '.php', '', $page ) ) . ' - Atoum\'s administration'; ?></title>
		<meta charset="utf-8">
		<meta name="description" content="Homepage">
		<meta name="author" content="Cyril Neveu">
		<link rel="stylesheet" href="<?php echo URL . '/includes/reset.css' ?>">
		<link rel="stylesheet" href="<?php echo STYLE; ?>">
	</head>
	<!-- END ADMIN HEAD -->