<?php

	require 'settings.php';
	require 'imports.php';

	$movie = new movie( $_GET[ 'movie' ] );

?>

<html>

	<?php require 'head.php'; ?>

	<body>

		<?php require 'header.php'; ?>

		<div id="<?php echo $movie->getId(); ?>" class="movie">
			<?php echo $movie->display(); ?>
			<h2><?php echo $movie->getName(); ?></h2>
            <div>
                <?php echo $movie->getRelatedPersonChips(); ?>
                <form id="addRelatedPerson">
                    <input name="name" list="persons" type="text" />
                    <?php echo person::displayAllAsDataList( 'persons' ); ?>
                </form>
                <button onclick="applyPersonOnContent()">Save</button>
            </div>
			<?php echo $movie->getRelatedTagChips(); ?>
		</div>
		<?php require 'footer.php'; ?>

	</body>

</html>