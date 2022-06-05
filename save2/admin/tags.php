<?php
	
	namespace Atoum;
	// tags.php

	// Order by and order_direction setup
	if( isset( $_GET[ 'ob' ] ) ) $order_by = 'tag_' . $_GET[ 'ob' ];
	if( isset( $_GET[ 'od' ] ) ) $order_direction = $_GET[ 'od' ];

	$order_by = whitelist( $order_by, [ 'tag_name', 'tag_slug' ], 'Invalid field name!' );
	$order_direction = whitelist( $order_direction, [ 'asc', 'desc' ], 'Invalid order direction!' );

	// Remove tag
	// Remove the selected tag from the database.
	// Also remove every relations of that tag.
	if( isset( $_GET[ 'tag_to_delete' ] ) ) {
		$tag = new at_class_tag( $_GET[ 'tag_to_delete' ] );
		$tag->remove();
		header( 'location: admin.php?p=tags.php' );
	}

	// Edit
	// Edit an existing tag.
	if( isset( $_GET[ 'tag_to_edit' ] ) ) {
		// Need to edit a tag so fill the form with it's values.
		$tag = new at_class_tag( $_GET[ 'tag_to_edit' ] );
		$action = 'Update';
	}
	else {
		// No tag to edit so fill the form with bank values.
		$tag = new at_class_tag( -1 );
		$action = 'Save';
	}

	// Apply
	// Insert the tag inside the databse using parameters given by the form.
	if( isset( $_POST[ 'save' ] ) ) {

		$tag_name = $_POST[ 'name' ];

		if( $_POST[ 'slug' ] == '' ) {
			$tag_slug = normalize( $_POST[ 'name' ] );
		}
		else{
			$tag_slug = normalize( $_POST[ 'slug' ] );
		}

		$tag_type = 'tag';

		if( ! isset( $_POST[ 'parent_id' ] ) ) {
			$tag_parent_id = 0;
		}
		else{
			$tag_parent_id = $_POST[ 'parent_id' ];
		}

		$tag_description = $_POST[ 'description' ];

		switch ( $_POST[ 'save' ] ) {
			case 'Save':
				$tag = new at_class_tag( -1 );

				$tag->set_name( $tag_name );
				$tag->set_slug( $tag_slug );
				$tag->set_type( $tag_type );
				$tag->set_parent_id( $tag_parent_id );
				$tag->set_description( $tag_description );

				$tag->insert();
				break;

			case 'Update':
				$tag = new at_class_tag( $_GET[ 'tag_to_edit' ] );

				$tag->set_name( $tag_name );
				$tag->set_slug( $tag_slug );
				$tag->set_type( $tag_type );
				$tag->set_parent_id( $tag_parent_id );
				$tag->set_description( $tag_description );

				$tag->edit();
				break;
		}

		//header('location: admin.php?p=tags.php');
	}

	// Get tags
	// Return the complete list of tags registerred inside the database.
	function display_tags() {
		global $DDB, $order_by, $order_direction;
		
		$sql0 = 'SELECT tag_id from ' . PREFIX . 'tags ORDER BY ' . $order_by . ' ' . $order_direction;

		$rqst_get_tags = $DDB->prepare( $sql0 );
		$rqst_get_tags->execute();

		while( $tag = $rqst_get_tags->fetch() ) {
			// While we have tags to use, use their instance to create a row inside the table/
			$tag = new at_class_tag( $tag[ 'tag_id' ] );
			echo $tag->display_as_table_row();
		}

		$rqst_get_tags->closeCursor();
	}
?>
	<div class="frame">
	<!-- START TAGS -->
		<h1>Tags</h1>
		<p>Tags are a good way to organise your content.</p>
		<div class="row">

			<div class="column">
				<form class="column" action="admin.php?p=tags.php<?php if( isset( $_GET[ 'tag_to_edit' ] ) ) echo '&tag_to_edit=' . $_GET[ 'tag_to_edit' ]; ?>" method="post">
						<?php 
							if( isset( $_GET[ 'tag_to_edit' ] ) ) {
								echo '<h3>Update an existing tag</h3>'; 
							}
							else {
								echo '<h3>Create a new tag</h3>';
							}
						?>

					<!-- Name -->
					<label for="name">Name</label>
					<input type="text" name="name" value="<?php echo $tag->get_name(); ?>" required>
					<p>The display name of the tag.</p>

					<!-- Slug -->
					<label for="slug">Slug</label>
					<input type="text" name="slug" value="<?php echo $tag->get_slug(); ?>">
					<p>The slug is a normalized name. It's must be unique and only composed with lowercase letters, numbers and hyphens.</p>
					<p>Let this input blank to use the name as the slug.</p>

					<!-- Parent tag -->
					<label for="parent_id">Parent tag</label>
					<select name="parent_id">
					<?php
						$sql0 = 'SELECT * from ' . PREFIX . 'tags';
						$rqst_get_tags = $DDB->prepare( $sql0 );
						$rqst_get_tags->execute();
						while( $tags = $rqst_get_tags->fetch() ) {
							// While we have tags to use, use their instance to create a row inside the table.
							$tag_temp = new at_class_tag( $tags[ 'tag_id' ] );
					?>
							<option value="<?php echo $tag_temp->get_id(); ?>"<?php if( isset( $_GET[ 'tag_to_edit' ] ) && $tag_temp->get_id() == $tag->get_parent_id() ) echo "selected" ?>>
								<?php echo $tag_temp->get_name(); ?>
							</option>
					<?php
						}
					?>
					</select>
					<p>The parent tag can be used to create a well organized hierarchy for your content.</p>
					<p>In fact it's a sub category.</p>

					<!-- Description -->
					<label for="description">Description</label>
					<input type="text" name="description" value="<?php echo $tag->get_description(); ?>">
					<p>A short description to quickly understand what's under this tag.</p>

					<input type="submit" name="save" value="<?php echo $action; ?>">
				</form>
			</div>

			<div class="column">
				<h2>Your tags</h2>
				<input type="text" id="tags_search" onkeyup="searchForTag()" placeholder="Search...">
				<table id="tags_list">
					<tr>
						<th><a href="admin.php?p=tags.php&ob=name&od=<?php echo inverse_order_direction( $order_direction ); ?>">Name<i class="<?php echo $order_direction ?>"></i></a></th>
						<th><a href="admin.php?p=tags.php&ob=slug&od=<?php echo inverse_order_direction( $order_direction ); ?>">Slug<i class="<?php echo $order_direction ?>"></i></a></th>
						<th>Description</th>
						<th>Usage</th>
					</tr>
				<?php display_tags(); ?>
				<table>
			</div>

		</div>
	<!-- END TERMS -->
	</div>