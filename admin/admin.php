<?php

	require 'includes/links.php';
	get_dir();
	if($folder != 'admin' or $page != 'admin'){
		require 'gears/'.$folder.'/functions.php';
	}

?>

<!doctype html>
<html lang="fr">
	<head>
		<link rel="stylesheet" href="<?php echo $links['url'].'/content/themes/'.$THEME.'/includes/style.css'; ?>">
		<script src="https://kit.fontawesome.com/447390b449.js" crossorigin="anonymous"></script>
		<title>Admin</title>
	</head>

	<body>
		<header>
			<?php

				require $links['themes'].$THEME.'/admin-menu.php';

			?>
		</header>

		<div id="main">
			<div class="section large">
			<?php

				if($folder == 'admin' or $page == 'admin'){
					
				}
				else{
					require 'gears/'.$folder.'/'.$page.'.php';
				}

			?>
			</div>
		</div>

		<footer>
			<script src="<?php echo $links['url'].'/includes/scripts.js'; ?>"></script>
			<script src="<?php echo $links['url'].'/content/themes/'.$THEME.'/includes/scripts.js'; ?>"></script>
		</footer>
	</body>
</html>