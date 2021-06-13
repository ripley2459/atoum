<?php
	
	// uploads.php
	// Remove a content
	if( isset( $_GET[ 'remove' ] ) ) {
		$content = new at_class_content( $_GET[ 'remove' ] );
		$content->unregister();
		header( 'Location: content.php' );
	}

	// Upload a new content
	if( isset( $_POST[ 'upload' ] ) ) {

		$countfiles = count( $_FILES[ 'files' ] [ 'name' ] );

		for( $i = 0; $i < $countfiles; $i++ ) {
			// for
			$filename = normalize( $_FILES[ 'files' ] [ 'name' ] [ $i ] );

			move_uploaded_file( $_FILES[ 'files' ] [ 'tmp_name' ] [ $i ], UPLOADS . $filename );

			$content_infos = pathinfo( UPLOADS . $filename );

			$content = new content( -1 );

			$content->set_title( $filename );
			$content->set_type( get_file_type( $filename ) );
			$content->set_path( $filename );

			$content->register();
			//end for
		}
	}
?>
	<!-- START UPLOADS -->
	<div>
		<h1>Uploads</h1>

		<!-- Add new content -->
		<h2>Add new content</h2>
		<form method="post" action="admin.php?p=uploads.php" enctype="multipart/form-data">
			<input type="file" name="files[]" id="files" multiple>
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