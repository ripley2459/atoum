<?php
	
	//Check if settings and configs are valid
	if(!file_exists('config.php') || !file_exists('settings.php')){
		header('Location: admin/installer.php');
	}

	//Load Atoum's settings
	require 'settings.php';
	require 'config.php';

	//Prepare the content, homepage by default
	$content_type = 'page';
	$content_slug = 'homepage';

	//Get the content to display if exist unless use the prepared content
	if(isset($_GET['type'])){
		$content_type = $_GET['type'];
	}

	if(isset($_GET['content'])){
		$content_slug = $_GET['content'];
	}

?>

<!doctype html>
<html>

	<head>
		<link rel="stylesheet" href="<?php echo URL . '/includes/reset.css'; ?>">
		<link rel="stylesheet" href="<?php echo THEMERESSOURCESPATH . 'style.css'; ?>">

		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Rajdhani&family=Roboto" rel="stylesheet">

		<script src="https://kit.fontawesome.com/447390b449.js" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<title>Index.php</title>
	</head>

	<body id="<?php echo $content_slug; ?>" class="<?php echo $content_type; ?>">

	<?php

		require THEMEPATH . '/header.php';

		echo '<div id="content">';

		switch($content_type){
			case 'page':
				require THEMEPATH . '/page.php';
				break;
			case 'post':
				require THEMEPATH . '/single.php';
				break;
			case 'posts':
				require THEMEPATH . '/posts.php';
				break;
			case 'class':
				require THEMEPATH . '/posts.php';
				break;
			default:
				require THEMEPATH . '/page.php';
				break;
		}

		echo '</div>';

		require THEMEPATH . '/footer.php';

	?>

	</body>
</html>
<script src="<?php echo URL . '/includes/scripts.js'; ?>"></script>
<script src="<?php echo THEMERESSOURCESPATH . 'scripts.js'; ?>"></script>