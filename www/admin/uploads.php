<?php

	namespace Atoum;
	// uploads.php

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
		$content = new at_class_content( $_GET[ 'remove' ] );
		$content->unregister();
		header( 'Location: admin.php?p=uploads.php' );
	}

	// Upload a new content
	if( isset( $_POST[ 'upload' ] ) ) {

		$countfiles = count( $_FILES[ 'files' ] [ 'name' ] );

		for( $i = 0; $i < $countfiles; $i++ ) {
			// for
			$filename = normalize( $_FILES[ 'files' ] [ 'name' ] [ $i ] );

			move_uploaded_file( $_FILES[ 'files' ] [ 'tmp_name' ] [ $i ], UPLOADS . $filename );

			$content_infos = pathinfo( UPLOADS . $filename );

			$content = new at_class_content( -1 );

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
					<td><button onclick="openModal(<?php echo $file->get_id() ?>)">Tags</button></td>
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
	</div>
	<!-- END UPLOADS -->