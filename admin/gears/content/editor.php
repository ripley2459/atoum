<?php
	
	if(isset($_GET['content_type'])){
		$type = $_GET['content_type'];
	}
	else {
		$type= 'post';
	}

	if(isset($_POST['action'])){
		$action = $_POST['action'];
	}
	else {
		$action= 'add';
	}
	
	if(isset($_GET['content_to_edit'])){
		$action = 'edit';
		$content_to_edit = $_GET['content_to_edit'];
		$content = get_content_to_edit($content_to_edit, $type);
	}
	else{
		$content = array(
			'content_title' => '',
			'content_slug' => '',
			'content_author_id' => '0',
			'content_date_created' => '',
			'content_date_modified' => '',
			'content_type' => $type,
			'content_status' => '',
			'content_parent_id' => '0',
			'content_has_children' => '0',
			'content_content' => ''
		);
	}

?>

<form action="editor.php" method="post">
	<div>
		<h1>Editor</h1>
		<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
		<div id="editor">
			<?php echo $content['content_content']; ?>
		</div>
	</div>
	<nav class="side-menu right">
		<div class="side-menu-content">

			<label for="content_slug">Slug:</label>
			<input type="text" name="content_slug" value="<?php echo $content['content_slug']; ?>">

			<label for="content_status">Status:</label>
			<select name="content_status">
			  <option value="published">Published</option>
			  <option value="draft">Draft</option>
			  <option value="private">Private</option>
			</select>

			<input type="hidden" name="content_has_children" value="<?php echo $content['content_has_children']; ?>">
			<input type="hidden" name="content_parent_id" value="<?php echo $content['content_parent_id']; ?>">
			<input type="hidden" name="content_author_id" value="<?php echo $content['content_author_id']; ?>">
			<input type="hidden" name="action" value="<?php echo $action; ?>">

		</div>
	</nav>

	<button type="submit" value="Submit" class="full float-right">Add</button>
	
</form>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>