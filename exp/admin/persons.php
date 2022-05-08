<?php

	require '../settings.php';
	require '../imports.php';

?>

<html>

	<?php require 'head.php'; ?>

	<body>

		<?php require 'header.php'; ?>

		<h1>Persons</h1>
		<div>
			<h2>Register a new person</h2>
			<form id="addNewPerson">
				<label for="name">Name</label>
				<input name="name" type="text" required />
			</form>
			<button onclick="registerNewPerson()">Save</button>
		</div>

		<div>
			<h2>Registered persons</h2>
			<table>
				<tbody id="persons">
					<!-- Persons -->
				</tbody>
			</table>
		</div>

		<script>
			document.addEventListener("DOMContentLoaded", function() {
				getAllPersons();
			});
		</script>
		<?php require 'footer.php'; ?>

	</body>

</html>