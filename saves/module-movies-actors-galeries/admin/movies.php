<?php

	require '../settings.php';
	require '../imports.php';

?>

<html>

	<?php require 'head.php'; ?>

	<body>

		<?php require 'header.php'; ?>

		<h1>Movies</h1>
		<div>
			<h2>Register a new movie</h2>
			<form id="registerNewMovie">
				<div>
					<p><em>Let empty to use the file's name.</em></p>
					<label for="name">Name</label>
					<input name="name" type="text">
				</div>

				<div>
					<p><em>Let empty to use the default preview.</em></p>
					<label for="preview">Preview</label>
					<input type="file" name="preview">
				</div>

				<div>
					<label for="movie">Movie</label>
					<input type="file" name="movie">
				</div>

				<div>
					<label for="tags">Tags</label>
					<p><em>Selected tags will be automaticaly linked to the uploaded movie.</em></p>
					<?php echo tag::displayOnlyOfType( -1, 9 /* type de relation */, 1 /* type de tag */ ); ?>

					<label for="persons">Persons</label>
					<p><em>Selected persons will be automaticaly linked to the uploaded movie.</em></p>
					<?php echo person::displayAllAsCheckBox( -1, 3 ); ?>
				</div>
			</form>

			<button onclick="registerNewMovie()">Save</button>
			<button onclick="bulkUpload()">Bulk Upload</button>
		</div>

		<div>
			<h2>Registered movies</h2>
			<table>
				<tbody id="movies">
					<!-- Movies -->
				</tbody>
			</table>
		</div>

		<script>
			document.addEventListener("DOMContentLoaded", function() {
				getAllMovies();
			});
		</script>
		<?php require 'footer.php'; ?>

	</body>

</html>