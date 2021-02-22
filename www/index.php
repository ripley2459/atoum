<?php

	if(!file_exists('admin/includes/config.php')){
		header('Location: admin/installer.php');
	}

	require 'admin/includes/config.php';

	$content_type = 'page';
	$content_slug = 'home_page';

	if(isset($_GET['type'])){
		$content_type = $_GET['type'];
	}

	if(isset($_GET['content'])){
		$content_slug = $_GET['content'];
	}

?>

<!doctype html>
<html lang="fr">
	<head>
		<link rel="stylesheet" href="<?php echo $LINKS['URL'] . '/includes/reset.css'; ?>">
		<link rel="stylesheet" href="<?php echo $LINKS['URL'] . '/content/themes/' . $THEME . '/includes/style.css'; ?>">
		<script src="https://kit.fontawesome.com/447390b449.js" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<title>Index.php</title>
	</head>
	<body id="<?php echo $content_slug; ?>" class="<?php echo $content_type; ?>">

	<?php

		require $LINKS['THEMES'] . $THEME . '/header.php';

		switch($content_type){
			case 'page':
				require $LINKS['THEMES'] . $THEME . '/page.php';
				break;
			case 'post':
				require $LINKS['THEMES'] . $THEME . '/single.php';
				break;
			case 'posts':
				require $LINKS['THEMES'] . $THEME . '/posts.php';
				break;
			default:
				require $LINKS['THEMES'] . $THEME . '/page.php';
				break;
		}

		require $LINKS['THEMES'] . $THEME . '/footer.php';

	?>

	</body>
</html>
<script src="<?php echo $LINKS['URL'] . '/includes/scripts.js'; ?>"></script>
<script src="<?php echo $LINKS['URL'] . '/content/themes/' . $THEME . '/includes/scripts.js'; ?>"></script>