<?php
	
	// uploads.php
	// 20:18 2021-05-03

?>
	<!-- START UPLOADS -->
	<div>
		<h1>Uploads</h1>

		<!-- Add new content -->
		<h2>Add new content</h2>
		<form method="post" action="content.php" enctype="multipart/form-data">
			<input type="file" name="file[]" id="file" multiple>
			<input type="submit" name="upload" value="Upload">
		</form>

		<!-- Display content -->
		<h2>Your content</h2>
			<table>
				<tr>
					<th>Type</th>
					<th>Title</th>
					<th>Actions</th>
				</tr>
	</div>
	<!-- END UPLOADS -->