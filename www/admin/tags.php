<?php
	
	// tags.php
	// 15:33 2021-05-06

	// remove tag
	// 15:33 2021-05-06
	// remove the selected tag from the database
	// also remove every relations of that tag
	if( isset( $_GET[ 'tag_to_delete' ] ) ) {
		$tag = new at_class_tag( $_GET[ 'tag_to_delete' ] );
		$tag->remove();
		header( 'location: admin.php?p=tags.php' );
	}

	// edit
	// 15:10 2021-05-06
	// edit an existing tag
	if( isset( $_GET[ 'tag_to_edit' ] ) ) {
		// need to edit a tag so fill the form with it's values
		$tag = new at_class_tag( $_GET[ 'tag_to_edit' ] );
		$action = 'Update';
	}
	else {
		// no tag to edit so fill the form with bank values
		$tag = new at_class_tag( -1 );
		$action = 'Save';
	}

	// apply
	// 15:10 2021-05-06
	// insert the tag inside the databse using parameters given by the form
	if( isset( $_POST[ 'save' ] ) ) {

		$tag_name = $_POST[ 'name' ];

		if( ! isset( $_POST[ 'slug' ] ) ) {
			$tag_slug = to_slug( $_POST[ 'name' ] );
		}
		else{
			$tag_slug = to_slug( $_POST[ 'slug' ] );
		}

		if( ! isset( $_POST[ 'parent_id' ] ) ) {
			$tag_parent_id = 0;
		}
		else{
			$tag_parent_id = $_POST[ 'parent_id' ];
		}

		$tag_description = $_POST[ 'description' ];

		switch ( $_POST[ 'save' ] ) {
			case 'Save':
				$term = new at_class_tag( -1 );

				$term->set_name( $tag_name );
				$term->set_slug( $tag_slug );
				$term->set_parent_id( $tag_parent_id );
				$term->set_description( $tag_description );

				$term->insert();
				break;

			case 'Update':
				$term = new at_class_tag( $_GET[ 'tag_to_edit' ] );

				$term->set_name( $tag_name );
				$term->set_slug( $tag_slug );
				$term->set_parent_id( $tag_parent_id );
				$term->set_description( $tag_description );

				$term->edit();
				break;
		}

		header('location: admin.php?p=tags.php');
	}

	// get tags
	// 00:40 2021-05-06
	// return the complete list of tags registerred inside the database 
	function at_get_tags() {
		global $DDB;
		
		$order_by = whitelist( $order_by, [ 'tag_name', 'tag_slug' ], 'Invalid field name!' );
		$order_direction = whitelist( $order_direction, [ 'ASC', 'DESC' ], 'Invalid order direction!' );
		
		$sql0 = 'SELECT tag_id from ' . PREFIX . 'tags ORDER BY ' . $order_by . ' ' . $order_direction;

		$rqst_get_tags = $DDB->prepare( $sql0 );
		$rqst_get_tags->execute();

		while( $tag = $rqst_get_tags->fetch() ) {
			//While we have tags to use, use their instance to create a row inside the table
			$tag = new at_class_tag( $tag[ 'tag_id' ] );
			echo $tag->display_as_table_row();
		}

		$rqst_get_tags->closeCursor();
	}
?>
	<!-- START TAGS -->
	<div>
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
					<input type="text" name="parent_id" value="<?php echo $tag->get_parent_id(); ?>">
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
				<table>
					<tr>
						<th>Name</th>
						<th>Slug</th>
						<th>Age</th>
						<th>Usage</th>
					</tr>
				<?php at_get_tags(); ?>
				<table>
			</div>

		</div>
	</div>
	<!-- END TERMS -->