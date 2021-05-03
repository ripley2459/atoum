<?php
	
	// body.php
	// 20:18 2021-05-03

?>
	<!-- START BODY -->
	<body class="admin">
		<?php

			$page = 'overview.php';

			if( isset( $_GET['p'] ) ) $page = $_GET['p'];

			require 'header.php';

		?>

		<div>

			<?php require $page; ?>

		</div>
		<script src="<?php echo URL . '/includes/scripts.js' ?>"></script>
	</body>
	<!-- END BODY -->
</html>
<!-- END HTML -->