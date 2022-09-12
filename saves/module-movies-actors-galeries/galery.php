<?php

	require 'settings.php';
	require 'imports.php';

	$galery = new galery( $_GET[ 'galery' ] );

?>

<html>

	<?php require 'head.php'; ?>

	<body>

		<?php require 'header.php'; ?>

		<?php echo $galery->display( true ); ?>

		<?php require 'footer.php'; ?>

	</body>

</html>