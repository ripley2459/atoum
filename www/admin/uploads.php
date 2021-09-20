<?php

	namespace Atoum;
	// uploads.php

	// Update relations
	if ( isset( $_POST['tags'] ) ){
		$relations = get_relations_related( $_POST[ 'relation_type' ], $_POST[ 'content_id' ] );

		foreach( $relations as $relation ) {
			$relation->unregister();
		}
	
		foreach( $_POST[ 'tags' ] as $tag ) {
			$relation = new at_class_relation( -1 );
	
			$relation->set_type( $_POST[ 'relation_type' ] );
			$relation->set_a_id( $_POST[ 'content_id' ] );
			$relation->set_b_id( $tag );
	
			$relation->register();
		}

		header( 'Location: admin.php?p=uploads.php' );
	}

	// Remove a content
	if( isset( $_GET[ 'remove' ] ) ) {
		$content = new at_class_upload( $_GET[ 'remove' ] );
		$content->remove();
		header( 'Location: admin.php?p=uploads.php' );
	}

	// Upload a new content
	if( isset( $_POST[ 'upload' ] ) ) {

		foreach ( $_FILES[ 'files' ] [ 'tmp_name' ] as $key => $value ) {

			// File informations
			$file_tmpname = $_FILES[ 'files' ] [ 'tmp_name' ] [ $key ];
			$file_name = $_FILES[ 'files' ] [ 'name' ] [ $key ];
			$file_slug = normalize( $_FILES[ 'files' ] [ 'name' ] [ $key ] );
			$file_ext = get_file_type( $file_name );

			if ( !file_exists( UPLOADS ) ) mkdir( UPLOADS, 0777, true);
			$file_path = UPLOADS . $file_slug;

			if ( move_uploaded_file( $file_tmpname, $file_path ) ) {
				$new_file = new at_class_upload( -1 );

				$new_file->set_title( $file_name );
				$new_file->set_slug( $file_slug );
				$new_file->set_type( $file_ext );
				$new_file->set_origin( 'uploaded' );
				$new_file->set_status( 'published' );
				$new_file->set_author_id( 0 );
				$new_file->set_path( $file_path );
				$new_file->set_content( 'Your file description...' );

				$new_file->add();

				header( 'Location: admin.php?p=uploads.php' );
			}
			else {
				// TODO
			}
		}
	}

	// Bulk Upload
	if ( isset( $_POST[ 'bulk_upload' ] ) ) {

		$files = array_diff( scandir( ROOT . 'content/uploads/bulk/' ), [ '.', '..' ] );

		foreach( $files as $file ) {
			rename( ROOT . 'content/uploads/bulk/' . $file, UPLOADS . normalize( $file ) );

			// Register the file inside the database.
			$new_file = new at_class_upload( -1 );

			$new_file->set_title( $file );
			$new_file->set_slug( normalize( $file ) );
			$new_file->set_type( get_file_type( $file ) );
			$new_file->set_origin( 'bulk uploaded' );
			$new_file->set_status( 'published' );
			$new_file->set_author_id( 0 );
			$new_file->set_path( UPLOADS . normalize( $file ) );
			$new_file->set_content( 'Your file description...' );

			$new_file->add();

			$file_id = $DDB->lastInsertId();

			// Relations
			$relations = get_relations_related( $_POST[ 'relation_type' ], $file_id );

			foreach( $relations as $relation ) {
				$relation->unregister();
			}
		
			foreach( $_POST[ 'bulk_tags' ] as $tag ) {
				$relation = new at_class_relation( -1 );
		
				$relation->set_type( $_POST[ 'relation_type' ] );
				$relation->set_a_id( $file_id );
				$relation->set_b_id( $tag );
		
				$relation->register();
			}
		}

		header( 'Location: admin.php?p=uploads.php' );
	}
?>
	<div>
	<!-- START UPLOADS -->
		<h1>Uploads</h1>

		<!-- Add new content -->
		<form method="post" action="admin.php?p=uploads.php" enctype="multipart/form-data">
			<h2>Add new content</h2>
			<input type="file" name="files[]" multiple>
			<input type="submit" name="upload" value="Upload">
		</form>

		<!-- Bulk Upload -->
		<form method="post" action="admin.php?p=uploads.php" enctype="multipart/form-data">
			<h2>Bulk upload</h2>
			<ol>
				<li>Place your files in the folder named <em>bulk</em> under the <em>content/uploads</em> directory.</li>
				<li>Press the button to start the operation.</li>
				<li>Tags will be applied and files will be moved into proper folder.</li>
			</ol>

			<label for="relation_type">Type</label>
			<input type="number" name="relation_type" value="<?php echo 0; ?>" readonly></br>

			<?php
				$relation = new at_class_relation( -1 );
					$relation->set_type( 0 );

						$tags = get_all_tags();

						foreach ( $tags as $tag ) {
							$relation->set_b_id( $tag->get_id() );
			?>

							<input type="checkbox" value="<?php echo $tag->get_id() ?>" name="bulk_tags[]">
							<label for="bulk_tags[]"><?php echo $tag->get_name() ?></label></br>

			<?php
						}
			?>

			<input type="submit" name="bulk_upload" value="Bulk Upload">
		</form>

		<!-- Display content -->
		<h2>Your content</h2>
			<table>
				<tr>
					<th>Title</th>
					<th>Date</th>
					<th>Description</th>
					<th>Actions</th>
				</tr>

				<?php

					$uploads = get_all_uploads();

					$relation = new at_class_relation( -1 );
					$relation->set_type( 0 );

					foreach ($uploads as $file) {
						$relation->set_a_id( $file->get_id() );
				?>

				<tr>
					<td><?php echo $file->get_title() ?></td>
					<td><?php echo $file->get_date_created() ?></td>
					<td><?php echo $file->get_content() ?></td>
					<td><button onclick="openModal(<?php echo $file->get_id() ?>)">Tags</button><a href="admin.php?p=uploads.php&remove=<?php echo $file->get_id() ?>">Delete</a></td>
				</tr>

				<div id="<?php echo $file->get_id() ?>" class="modal">
					<div class="modal_content">
						<button onclick="closeModal(<?php echo $file->get_id() ?>)" class="close">Close</button>

						<form method="post" action="admin.php?p=uploads.php">

							<label for="content_id">ID</label>
							<input type="number" name="content_id" value="<?php echo $file->get_id() ?>" readonly>

							<label for="relation_type">Type</label>
							<input type="number" name="relation_type" value="<?php echo 0; ?>" readonly></br>

						<?php
							$tags = get_all_tags();
							foreach ( $tags as $tag ) {
								$relation->set_b_id( $tag->get_id() );
						?>

								<input type="checkbox" value="<?php echo $tag->get_id() ?>" name="tags[]" <?php if( $relation->are_linked() ) echo 'checked'; ?>>
								<label for="tags[]"><?php echo $tag->get_name() ?></label></br>

						<?php
							}
						?>

							<input type="submit" name="save" value="Save">
						</form>

					</div>
				</div>

				<?php
					}
				?>
			</table>
	<!-- END UPLOADS -->
	</div>