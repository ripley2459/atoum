<div>
<!-- START THEMES -->
	<div class="themes">
		<?php

			$themes = scandir( THEMES );
			$themes = array_diff( $themes, [ '.', '..' ] );

			foreach ( $themes as $theme ) { // Start foreach
				$infos = json_decode( file_get_contents( THEMES . $theme . '/includes/infos.json' ) );
			?>

			<div class="theme">
				<img src="<?php echo URL . '/content/themes/' . $theme . '/includes/preview.png'; ?>">
				<h1><?php echo $infos->name ?></h1>
				<h2><?php echo $infos->author ?></h2>
				<p><?php echo $infos->description ?></p>
			</div>

		<?php
			} // End foreach

			$infos = json_decode( file_get_contents( TEMPLATE . '/includes/infos.json' ) );
		?>

			<div class="theme">
				<img src="<?php echo URL . '/content/themes/' . $theme . '/includes/preview.png'; ?>">
				<h1><?php echo $infos->name ?></h1>
				<h2><?php echo $infos->author ?></h2>
				<p><?php echo $infos->description ?></p>
			</div>
	</div>
<!-- END THEMES -->
</div>