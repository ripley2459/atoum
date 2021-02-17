<?php

	if(isset($_POST['submit'])){
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
				$file_path = $LINKS['UPLOADS'] . $_FILES['file']['name'];
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
					$array = array('type' => 'submit', 'name' => 'submit', 'value' => 'Upload', 'template' => 'admin')
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
		global $bdd;
		$to_display = '';
		
		$get_file_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_status = :content_status ORDER BY :order_by :order_direction');
		$get_file_request -> execute(array(':content_status' => 'uploaded', ':order_by' => 'content_date_created', ':order_direction' => 'DESC'));

		$users_request = $bdd -> prepare('SELECT user_display_name FROM at_users WHERE user_id = :user_id');

		if($view == 'list'){
			while($content = $get_file_request -> fetch()){
				
				$users_request -> execute(array(':user_id' => $content['content_author_id']));
				$user = $users_request -> fetch();
				$user_display_name = $user['user_display_name'];
				
				$to_display = $to_display .
					display_file_as_table_row($content, $user_display_name);
			}
		}
		else{
			while($content = $get_file_request -> fetch()){
				
				$users_request -> execute(array(':user_id' => $content['content_author_id']));
				$user = $users_request -> fetch();
				$user_display_name = $user['user_display_name'];
				
				$to_display = $to_display .
					display_file_as_grid_member($content, $user_display_name);
			}
		}

		$users_request -> closeCursor();
		$get_file_request -> closeCursor();
		return $to_display;
	}
	
	function display_file_as_grid_member(array $content, string $user_display_name){
		$to_display = '';
		$to_display = $to_display .
			get_block_div(
				$array = array('template' => 'admin'),
				$content['content_title']
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
		global $bdd;

		$content_add_file_request = $bdd -> prepare('INSERT INTO at_content (content_title, content_slug, content_author_id, content_type, content_status, content_parent_id, content_has_children, content_content) VALUES (:content_title, :content_slug, :content_author_id, :content_type, :content_status, :content_parent_id, :content_has_children, :content_content)');

		$content_title = $file_name;
		$content_slug = str_replace(' ','-', strtolower($file_name));
		$content_author_id = 1;
		$content_type = $file_type;
		$content_status = 'uploaded';
		$content_parent_id = 0;
		$content_has_children = 0;
		$content_content = $file_path;

		$content_add_file_request -> execute(array(':content_title' => $content_title, ':content_slug' => $content_slug, ':content_author_id' => $content_author_id, ':content_type' => $content_type, ':content_status' => $content_status, ':content_parent_id' => $content_parent_id, ':content_has_children' => $content_has_children, ':content_content' => $content_content));
		$content_add_file_request -> closeCursor();
	}