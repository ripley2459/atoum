<?php

	require 'admin/includes/config.php';

	if(isset($_GET['type'], $_GET['content'])){
		$content_type = $_GET['type'];
		$content_slug = $_GET['content'];
	}
	else{
		$content_type = 'page';
		$content_slug = 'home_page';
	}

?>

<!doctype html>
<html lang="fr">
	<head>
		<link rel="stylesheet" href="<?php echo $LINKS['URL'] . '/content/themes/' . $THEME . '/includes/style.css'; ?>">
		<script src="https://kit.fontawesome.com/447390b449.js" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<title>Index.php</title>
	</head>

	<body>

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