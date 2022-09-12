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

		<h1>Relations</h1>
		<div>
			<table>
				<tbody>
					<tr>
						<td>Relations types</td>
						<td>Movie</td>
						<td>Person</td>
						<td>Galery</td>
						<td>Tag</td>
					</tr>
					<tr>
						<td>Movie</td>
						<td>n/a</td>
						<td>3</td>
						<td>6</td>
						<td>9</td>
					</tr>
					<tr>
						<td>Person</td>
						<td>0</td>
						<td>n/a</td>
						<td>7</td>
						<td>10</td>
					</tr>
					<tr>
						<td>Galery</td>
						<td>1</td>
						<td>4</td>
						<td>n/a</td>
						<td>11</td>
					</tr>
					<tr>
						<td>Tag</td>
						<td>2</td>
						<td>5</td>
						<td>8</td>
						<td>n/a</td>
					</tr>
				</tbody>
			</table>
			<p>This table give the number associated with every relation type.</p>
		</div>

		<?php require 'footer.php'; ?>

	</body>

</html>