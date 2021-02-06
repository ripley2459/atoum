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

	echo get_block_form(
		$array = array('action' => 'uploads.php', 'method' => 'post', 'enctype' => 'multipart/form-data', 'template' => 'admin'),
			get_block_input(
				$array = array('type' => 'file', 'name' => 'file', 'template' => 'admin')
			) .
			get_block_input(
				$array = array('type' => 'submit', 'name' => 'submit', 'value' => 'Upload', 'template' => 'admin')
			)
	);

/* 	echo
	get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			1,
			$array = array('class' => 'themes-name', 'template' => 'admin'),
			'Uploads'
		) .	
		get_block_div(
			$array = array('template' => 'admin'),
			get_block_link(
				'uploads.php?mode=list',
				'<i class="fas fa-bars"></i>',
				'',
				'',
				'',
				'',
				'',
				''
			) .
			get_block_link(
				'uploads.php?mode=grid',
				'<i class="fas fa-th-large"></i>',
				'',
				'',
				'',
				'',
				'',
				''
			),
		)
	); */