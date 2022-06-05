<?php

	require 'settings.php';
	require 'imports.php';

?>

<html>

	<?php require 'head.php'; ?>

	<body>

		<?php require 'header.php'; ?>

			<?php echo movie::showAll(); ?>

		<?php require 'footer.php'; ?>

	</body>

</html>