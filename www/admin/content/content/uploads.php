<?php

	if(isset($_POST['delete'])){
		$content_id = $_POST['content_id'];
		content_delete($content_id);
		header('location: uploads.php');
	}

	if(isset($_POST['update'])){
		$content_id = $_POST['content_id'];
		$content_slug = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/', '-', $_POST['content_slug']));
		$content_title = $_POST['description'];
		content_update($content_id, $content_title, $content_slug);
		header('location: uploads.php');
	}

	if(isset($_POST['upload'])){
		//Create the uploads directory if no one exist.
		if(!is_dir($LINKS['UPLOADS'])){
			mkdir($LINKS['UPLOADS'], 0755, true);
		}

		$target_file = $LINKS['UPLOADS'] . basename($_FILES['file']['name']);
		$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		
		$check = getimagesize($_FILES['file']['tmp_name']);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$can_upload = 1;
		}
		else{
			echo "File is not an image.";
			$can_upload = 0;
		}

		if($_FILES['file']['size'] > 50000000 /* 50MB */){
			echo 'Your file is too large.';
			$can_upload = 0;
		}

		if(file_exists($target_file)) {
			echo 'Your file already exist.';
			$can_upload = 0;
		}
		
		if(
			$file_type != 'jpg' &&
			$file_type != 'png' &&
			$file_type != 'jpeg' &&
			$file_type != 'gif' &&

			$file_type != 'mov' &&
			$file_type != 'avi' &&
			$file_type != 'mp4' &&
			$file_type != 'flv' &&
			$file_type != 'wmv'
		){
			echo 'Your file\'s format isn\'t supported.';
			$can_upload = 0;
		}
		
		if ($can_upload == 0) {
			echo "Sorry, your file was not uploaded.";
		}
		else{
			if(move_uploaded_file($_FILES['file']['tmp_name'], $target_file)){
				echo "The file ". htmlspecialchars(basename($_FILES['file']['name'])). ' has been uploaded.';
				$file_path = $LINKS['URL'] . '/content/uploads/' . date('Y/m/d/') . $_FILES['file']['name'];
				add_file($_FILES['file']['name'], $file_type, $file_path);
			}
			else{
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}

	if(isset($_GET['order_direction'])){
		$order_direction = $_GET['order_direction'];
	}
	else{
		$order_direction = 'asc';
	}

	switch_order_direction($order_direction);

	if(isset($_GET['view'])){
		$view = $_GET['view'];
	}
	else{
		$view = 'grid';
	}

 	echo
	get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('template' => 'admin'),
			'Uploads'
		) .
		get_block_form(
			$array = array('action' => 'uploads.php', 'method' => 'post', 'enctype' => 'multipart/form-data', 'template' => 'admin'),
				get_block_input(
					$array = array('type' => 'file', 'name' => 'file', 'template' => 'admin')
				) .
				get_block_input(
					$array = array('type' => 'submit', 'name' => 'upload', 'value' => 'Upload', 'template' => 'admin')
				)
		) .
		get_block_div(
			$array = array('template' => 'admin'),
			get_block_title(
				2,
				$array = array('template' => 'admin'),
				'Your files'
			) .
			get_block_link(
				'uploads.php?view=list',
				$array = array('template' => 'admin'),
				'<i class="fas fa-bars"></i>'
			) .
			get_block_link(
				'uploads.php?view=grid',
				$array = array('template' => 'admin'),
				'<i class="fas fa-th-large"></i>'
			),
		)
	);

	if($view == 'list'){
		echo
		get_block_table(
			$array = array('template' => 'admin'),
			get_block_table_row(
				$array = array('template' => 'admin'),
				get_block_table_heading(
					$array = array('template' => 'admin'),
					'Actions'
				) .
				get_block_table_heading(
					$array = array('template' => 'admin'),
					get_block_link(
						'/admin/' . $folder . '/' . $page . '.php?view=list&order_by=content_name&order_direction=' . $order_direction,
						$array = array('template' => 'admin'),
						'Name<i class="' . $order_direction . '"></i>'
					)
				) .
				get_block_table_heading(
					$array = array('template' => 'admin'),
					get_block_link(
						'/admin/' . $folder . '/' . $page . '.php?view=list&order_by=content_author_id&order_direction=' . $order_direction,
						$array = array('template' => 'admin'),
						'Author<i class="' . $order_direction . '"></i>'
					)
				) .
				get_block_table_heading(
					$array = array('template' => 'admin'),
					get_block_link(
						'/admin/' . $folder . '/' . $page . '.php?view=list&order_by=content_date_created&order_direction=' . $order_direction,
						$array = array('template' => 'admin'),
						'Date<i class="' . $order_direction . '"></i>'
					)
				)
			) .
			get_files_uploaded($view),
		);
	}
	else{
		echo
		get_block_div(
			$array = array('template' => 'admin'),
			get_files_uploaded($view),
		);
	}

	function get_files_uploaded(string $view){
		global $DDB;
		$to_display = '';
		
		$get_file_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_status = :content_status ORDER BY :order_by :order_direction');
		$get_file_request -> execute(array(':content_status' => 'uploaded', ':order_by' => 'content_date_created', ':order_direction' => 'DESC'));

		$users_request = $DDB -> prepare('SELECT user_display_name FROM at_users WHERE user_id = :user_id');

		if($view == 'list'){
			while($content = $get_file_request -> fetch()){
				
				$users_request -> execute(array(':user_id' => $content['content_author_id']));
				$user = $users_request -> fetch();
				$user_display_name = $user['user_display_name'];
				
				$to_display .= display_file_as_table_row($content, $user_display_name);
			}
		}
		else{
			while($content = $get_file_request -> fetch()){
				
				$users_request -> execute(array(':user_id' => $content['content_author_id']));
				$user = $users_request -> fetch();
				$user_display_name = $user['user_display_name'];
				
				$to_display .= display_file_as_grid_member($content, $user_display_name);
			}
		}

		$users_request -> closeCursor();
		$get_file_request -> closeCursor();
		return $to_display;
	}
	
	function display_file_as_grid_member(array $content, string $user_display_name){
		$to_display = '';
		$to_display .=
			get_block_div(
				$array = array('template' => 'admin'),
				get_block_modal(
					$array = array('id' => $content['content_slug'], 'template' => 'admin'),
					get_block_image(
						$content['content_content'],
						$array = array('class' => 'upload_preview', 'alt' => $content['content_title'], 'template' => 'admin')
					),
					get_block_form(
						$array = array('action' => 'uploads.php', 'method' => 'post', 'template' => 'admin'),
						get_block_image(
							$content['content_content'],
							$array = array('class' => 'upload_preview', 'alt' => $content['content_title'], 'template' => 'admin')
						) .
						$content['content_date_created'] .
						get_block_input(
							$array = array('type' => 'hidden', 'name' => 'content_id', 'value' => $content['content_id'], 'required' => 'required', 'template' => 'admin')
						) .
						get_block_label(
							$array = array('for' => 'content_slug', 'template' => 'admin'),
							'Slug'
						) .
						get_block_input(
							$array = array('type' => 'text', 'name' => 'content_slug', 'value' => $content['content_slug'], 'required' => 'required', 'template' => 'admin')
						) .
						get_block_label(
							$array = array('for' => 'description', 'template' => 'admin'),
							'Description'
						) .
						get_block_input(
							$array = array('type' => 'text', 'name' => 'description', 'value' => $content['content_title'], 'required' => 'required', 'template' => 'admin')
						) .
						get_block_label(
							$array = array('for' => 'author', 'template' => 'admin'),
							'Author'
						) .
						get_block_input(
							$array = array('type' => 'hidden', 'name' => 'author_id', 'value' => $content['content_author_id'], 'required' => 'required', 'template' => 'admin')
						) .
						get_block_input(
							$array = array('type' => 'text', 'name' => 'author', 'value' => $user_display_name, 'readonly' => 'readonly', 'required' => 'required', 'template' => 'admin')
						) .
						get_block_input(
							$array = array('type' => 'submit', 'name' => 'delete', 'value' => 'Delete', 'template' => 'admin')
						) .
						get_block_input(
							$array = array('type' => 'submit', 'name' => 'update', 'value' => 'Save', 'template' => 'admin')
						)
					)
				)
			);
		return $to_display;
	}

	function display_file_as_table_row(array $content, string $user_display_name){
		$to_display = '';
		$to_display = $to_display .
			get_block_table_row(
				$array = array('template' => 'admin'),
				get_block_table_data(
					$array = array('template' => 'admin'),
					get_block_input(
						$array = array('type' => 'checkbox', 'name' => 'yolo', 'template' => 'admin')
					)
				) .
				get_block_table_data(
					$array = array('template' => 'admin'),
					get_block_image(
						$content['content_content'],
						$array = array('class' => 'upload_preview', 'template' => 'admin')
					) .
					$content['content_title']
				) .
				get_block_table_data(
					$array = array('template' => 'admin'),
					$user_display_name
				) .
				get_block_table_data(
					$array = array('template' => 'admin'),
					$content['content_date_created']
				)
			);
		return $to_display;
	}

	function add_file(string $file_name, string $file_type, string $file_path){
		global $DDB;

		$content_add_file_request = $DDB -> prepare('INSERT INTO at_content (content_title, content_slug, content_author_id, content_type, content_status, content_parent_id, content_has_children, content_content) VALUES (:content_title, :content_slug, :content_author_id, :content_type, :content_status, :content_parent_id, :content_has_children, :content_content)');

		$content_title = $file_name;
		$content_slug = preg_replace('/[^a-zA-Z0-9-_\.]/', '-', $file_name);
		$content_author_id = 1;
		$content_type = $file_type;
		$content_status = 'uploaded';
		$content_parent_id = 0;
		$content_has_children = 0;
		$content_content = $file_path;

		$content_add_file_request -> execute(array(':content_title' => $content_title, ':content_slug' => $content_slug, ':content_author_id' => $content_author_id, ':content_type' => $content_type, ':content_status' => $content_status, ':content_parent_id' => $content_parent_id, ':content_has_children' => $content_has_children, ':content_content' => $content_content));
		$content_add_file_request -> closeCursor();
	}

	function content_update(int $content_id, string $content_title, string $content_slug){
		global $DDB;
		$content_update_request = $DDB -> prepare('UPDATE at_content SET content_title = :content_title, content_slug = :content_slug WHERE content_id = :content_id');
		$content_update_request -> execute(array(':content_title' => $content_title, ':content_slug' => $content_slug, ':content_id' => $content_id));
		$content_update_request -> closeCursor();
	}

	function content_delete(int $content_id){
		global $DDB;
		$content_delete_request = $DDB -> prepare('DELETE FROM at_content WHERE content_id =  :content_id');
		$content_delete_request -> execute(array(':content_id' => $content_id));
		$content_delete_request -> closeCursor();
	}
