<?php

	require '../settings.php';
	require '../imports.php';

	// Ajouter un tag.
	if( isset( $_POST[ 'add' ] ) ) {
		$tag = new tag( -1 );
		$tag->setType( $_POST[ 'type' ] );
		$tag->setValue( $_POST[ 'value' ] );
		$tag->register();
		header( 'tags.php' );
	}

	// Supprimer un tag.
	if( isset( $_GET[ 'remove' ] ) ) {
		$tag = new tag( $_GET[ 'remove' ] );
		$tag->unregister();
		header( 'tags.php' );
	}

?>

<html>

	<?php require 'head.php'; ?>

	<body>

		<?php require 'header.php'; ?>

		<h1>Tags</h1>
		<div>
			<h2>Register a new tag</h2>
			<form action="tags.php" method="POST">

				<label for="type">Type</label>
				<select name="type">
					<?php
						foreach( tag::getTypes() as $type => $value ) {
					?>
						<option value="<?php echo $type; ?>"><?php echo $value; ?></option>
					<?php
						}
					?>
				</select>

				<label for="value">Value</label>
				<input name="value" type="text" required />

				<button type="submit" name="add" value="Submit">Submit</button>

			</form>
		</div>

		<div>
			<h2>Registered tags</h2>
			<table>
				<tbody>

		<?php

			foreach( tag::getAll() as $tag ) {

		?>
								
				<tr>
					<td>
						<?php echo $tag->getType(); ?>
					</td>
					<td>
						<?php echo $tag->getValue(); ?>
					</td>
				</tr>

		<?php
			}
		?>
				</tbody>
			</table>
		</div>

		<?php require 'footer.php'; ?>

	</body>

</html>