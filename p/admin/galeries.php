<?php

	require '../settings.php';
	require '../imports.php';

?>

<html>

	<?php require 'head.php'; ?>

	<body>

		<?php require 'header.php'; ?>

		<h1>Galeries</h1>
		<div>
			<h2>Register a new galery</h2>
			<form id="addNewGalery">
				<label for="name">Name</label>
				<input name="name" type="text" required />
			</form>
			<button onclick="registerNewGalery()">Save</button>
		</div>

		<div>
			<h2>Registered galeries</h2>
			<table>
				<tbody id="galeries">
					<!-- Galeries -->
				</tbody>
			</table>
		</div>

		<script>
			document.addEventListener("DOMContentLoaded", function() {
				getAllGaleries();
			});
		</script>
		<?php require 'footer.php'; ?>

	</body>

</html>