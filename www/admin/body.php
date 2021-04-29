<?php
	
	// body.php
	// 2021/04/28

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

	</body>
	<!-- END BODY -->
</html>
<!-- END HTML -->