<?php

	//editor
	//Version 1

	//Variables
	//Version 1
	$action = whitelist($_GET['action'], ['create', 'update'], 'Invalid action!');
	$type = whitelist($_GET['type'], ['page', 'post'], 'Invalid content type!');
	//Complete the URL
	$editor_url = 'action=' . $action . '&type=' . $type;

	//Looking for what action to do
	//Version 1
	if(isset($_GET['content_to_edit']) && $action == 'update'){
		//Case update a existing post/page
		$content = new at_content($_GET['content_to_edit']);
		$editor_url .= '&content_to_edit=' . $content->get_id();
		
		//Update an existing page/post
		//version 1
		if(isset($_POST['action'])){
			$content->set_title($_POST['content_title']);

			if(!isset($_POST['content_slug'])){
				$content->set_slug(to_slug($_POST['content_title']));
			}
			else{
				$content->set_slug(to_slug($_POST['content_slug']));
			}

			$content->set_status($_POST['content_status']);
			$content->set_content($_POST['content_content']);

			$content->edit();

			header('location: ' . $type . '.php');
		}
	}
	else{
		//Basic action: create a new page/post
		$content = new at_content(-1);

		//Create a new page/post
		//Version 1
		if(isset($_POST['action'])){
			//Set Title
 			$content->set_title($_POST['content_title']);
			echo $content->get_title();
			//Set slug
			if(!isset($_POST['content_slug'])){
				$content->set_slug(to_slug($_POST['content_title']));
			}
			else{
				$content->set_slug(to_slug($_POST['content_slug']));
			}
			echo $content->get_slug();
			//Set author id
			$content->set_author_id(0);
			echo $content->get_author_id();
			//Set type
			$content->set_type($type);
			echo $content->get_type();
			//Set status
			$content->set_status($_POST['content_status']);
			echo $content->get_status();
			//Set parent id
			$content->set_parent_id(0);
			echo $content->get_parent_id();
			//Set has children
			$content->set_has_children(0);
			echo $content->get_has_children();
			//Set content
			$content->set_content($_POST['content_content']);
			echo $content->get_content();

			//$content->insert();

			header('location: ' . $type . '.php');
		}
	}

?>

<!--
	Editor
	Version 1
-->
<form action="editor.php?<?php echo $editor_url; ?>" method="post">
	<div>
		<h1>Editor</h1>
		<label for="content_title">Title:</label>
		<input type="text" name="content_title" value="<?php echo $content->get_title(); ?>">
		<textarea id="editor" name="content_content">
			<?php echo $content->get_content(); ?>
		</textarea>
	<nav class="right">
		<div class="side-menu-content">

			<label for="content_slug">Slug:</label>
			<input type="text" name="content_slug" value="<?php echo $content->get_slug(); ?>">

			<label for="content_status">Status:</label>
			<select name="content_status">
				<?php
					//Create one option for each status
					//Select the used for an update mode
					$status = new at_status();
					foreach($status->get_status() as $value){
						if($value == $content->get_status()){
							echo '<option selected value="' . $value . '">' . ucfirst($value) . '</option>';
						}
						else{
							echo '<option value="' . $value . '">' . ucfirst($value) . '</option>';
						}
					}
				?>
			</select>

		</div>
	</nav>
	<input type="submit" value=<?php echo ucfirst($action); ?> name="action">
</form>
<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
<script>ClassicEditor.create(document.querySelector('#editor')).catch(error=>{console.error(error);});</script>