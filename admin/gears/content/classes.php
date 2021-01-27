<div class="section large">
	<h1>Classes</h1>

		<?php

			if(isset($_POST['name'])){
				$term_name = $_POST['name'];

				if(empty($_POST['slug'])){
					$term_slug = $term_name;
				}
				else{
					$term_slug = $_POST['slug'];
				}

				$term_type = 'class';

				if(isset($_POST['description'])){
					$term_description = $_POST['description'];
				}
				else{
					$term_description = ' ';
				}

				if(isset($_POST['parent'])){
					$term_parent_id = $_POST['parent'];
				}
				else{
					$term_parent_id = '0';
				}

				term_add($term_name, $term_slug, $term_type, $term_description, $term_parent_id);
				header('location: classes.php');
			}

			if(isset($_GET['term_to_delete'])){
				$term_to_delete = $_GET['term_to_delete'];
				echo $term_to_delete;
				term_delete($term_to_delete);
				header('location: classes.php');
			}

		?>

	<div class="row two-column first-is-thin">
		<div class="column">
			<h2>Create a class</h2>

				<form action="classes.php" method="post">
					<label for="name"><b>Name</b></label>
					<input type="text" id="name" name="name" placeholder="Class name" required class="full">
					<p>Display name of the class.</p>

					<label for="slug"><b>Slug</b></label>
					<input type="text" id="slug" name="slug" placeholder="A tiny text." class="full">
					<p>The slug is a normalized name made of lowercase letters, numbers and hyphens.</p>

					<label for="parent"><b>Parent class</b></label>
					<?php 
						get_terms_list('class');
					?>
					<p>You can order your classes using parental class.</p>

					<label for="description"><b>Description</b></label>
					<input type="text" id="description" name="description" placeholder="Description of your class." class="full">
					<p>The description allow you to known quickly what is inside a class.</p>

					<button type="submit" value="Submit" class="tiny float-right">Add</button>
				</form>

		</div>


		<div class="column">
			<h2>Your classes</h2>

		<?php

			if(isset($_GET['order_direction'])){$order_direction = $_GET['order_direction'];}else{$order_direction = 'asc';}

			switch_order_direction($order_direction);

			get_terms('class', 'term_name', $order_direction);

		?>

		</div>
	</div>
</div>