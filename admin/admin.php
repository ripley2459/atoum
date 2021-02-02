<?php

	require 'includes/config.php';

	get_dir();

	if($folder != 'admin' or $page != 'admin'){
		require 'gears/' . $folder . '/functions.php';
	}

?>
<!doctype html>
<html lang="fr">
	<head>
		<link rel="stylesheet" href="<?php echo $LINKS['URL'] . '/content/themes/' . $THEME . '/includes/style.css'; ?>">
		<script src="https://kit.fontawesome.com/447390b449.js" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<title><?php echo ucfirst($page) . ' - Atoum administration'; ?></title>
	</head>
	<body>
		<header>
			<?php

				require $LINKS['THEMES'] . $THEME . '/admin-menu.php';

			?>
		</header>
		<div class="admin_content has-left-side-menu">
			<?php

				if($folder == 'admin' or $page == 'admin'){
					
				}
				else{
					require 'gears/' . $folder . '/' . $page . '.php';
				}

			?>
		</div>
		<footer>

		</footer>
	</body>
</html>
<script src="<?php echo $LINKS['URL'] . '/includes/scripts.js'; ?>"></script>
<script src="<?php echo $LINKS['URL'] . '/content/themes/' . $THEME . '/includes/scripts.js'; ?>"></script>
<script src="<?php echo $LINKS['URL'] . '/admin/gears/' . $folder . '/' . $page . '.js'; ?>"></script>