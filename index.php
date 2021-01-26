<?php

	require 'admin/includes/links.php';

	if(isset($_GET['type'], $_GET['content'])){
		$content_type = $_GET['type'];
		$content_slug = $_GET['content'];
	}
	else{

	}

?>

<!doctype html>
<html lang="fr">
	<head>
		<link rel="stylesheet" href="<?php echo $links['url'].'/content/themes/'.$THEME.'/includes/style.css'; ?>">
		<script src="https://kit.fontawesome.com/447390b449.js" crossorigin="anonymous"></script>
		<title>Index.php</title>
	</head>

	<body>

	<?php

		require $links['themes'].$THEME.'/header.php';

		switch($_GET['type']){
			case 'page':
				require $links['themes'].$THEME.'/page.php';
				break;
			case 'post':
				require $links['themes'].$THEME.'/single.php';
				break;
			case 'posts':
				require $links['themes'].$THEME.'/posts.php';
		}

		require $links['themes'].$THEME.'/footer.php';

	?>

	</body>
	<foot>
		<script src="<?php echo $links['url'].'/includes/scripts.js'; ?>"></script>
		<script src="<?php echo $links['url'].'/content/themes/'.$THEME.'/includes/scripts.js'; ?>"></script>
	</foot>
</html>