<?php



?>
	<div>
	<!-- START THEMES -->

		<?php

			$themes = scandir( THEMES );
			$themes = array_diff( $themes, [ '.', '..' ] );

			foreach ( $themes as $theme ) {
				$infos = json_decode( file_get_contents( THEMES . $theme . '/includes/infos.json' ) );
			?>

				<div class="theme">
					<img src="<?php echo URL . '/content/themes/' . $infos->name . '/includes/preview.png'; ?>">
					<h1><?php echo $infos->name ?></h1>
					<h2><?php echo $infos->author ?></h2>
				</div>

		<?php
			}
		?>

	<!-- END THEMES -->
	</div>