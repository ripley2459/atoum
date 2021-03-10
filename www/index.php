<?php

	if(!file_exists('config.php')){
		header('Location: installer.php');
	}

	require 'config.php';

	$content_type = 'page';
	$content_slug = 'homepage';

	if(isset($_GET['type'])){
		$content_type = $_GET['type'];
	}

	if(isset($_GET['content'])){
		$content_slug = $_GET['content'];
	}
	
	echo 'type=' . $content_type . ' & content=' . $content_slug;

?>

<!doctype html>
<html lang="fr">
	<head>
		<link rel="stylesheet" href="<?php echo URL . '/includes/reset.css'; ?>">
		<link rel="stylesheet" href="<?php echo URL . '/content/themes/' . $THEME . '/includes/style.css'; ?>">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Rajdhani&family=Roboto" rel="stylesheet">
		<script src="https://kit.fontawesome.com/447390b449.js" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<title>Index.php</title>
	</head>
	<body id="<?php echo $content_slug; ?>" class="<?php echo $content_type; ?>">

	<?php

		require THEMES . $THEME . '/header.php';

		echo '<div id="content">';

		switch($content_type){
			case 'page':
				require THEMES . $THEME . '/page.php';
				break;
			case 'post':
				require THEMES . $THEME . '/single.php';
				break;
			case 'posts':
				require THEMES . $THEME . '/posts.php';
				break;
			default:
				require THEMES . $THEME . '/page.php';
				break;
		}

		echo '</div>';

		require THEMES . $THEME . '/footer.php';

	?>

	</body>
</html>
<script src="<?php echo URL . '/includes/scripts.js'; ?>"></script>
<script src="<?php echo URL . '/content/themes/' . $THEME . '/includes/scripts.js'; ?>"></script>