	<body class="admin">
	<!-- START ADMIN BODY -->
		<?php

			$page = ( isset( $_GET['p'] ))  ? $_GET['p'] : 'overview.php' ;

			require 'header.php';

		?>

		<div>

			<?php require $page; ?>

		</div>
		<script src="<?php echo URL . '/includes/scripts.js' ?>"></script>
	<!-- END ADMIN BODY -->
	</body>

<!-- END ADMIN HTML -->
</html>