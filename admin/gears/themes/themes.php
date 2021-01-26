<div id="rp-content">

	<h1>Themes</h1>
	
	<?php

		if(isset($_GET['switch_to_theme'])){
			$switch_to_theme = $_GET['switch_to_theme'];
			update_option_value('active_theme', $switch_to_theme);
			header('location: themes.php');
		}
 
	?>

		<div class="container flex theme-browser">
		<?php

			get_themes();

		?>
		</div>