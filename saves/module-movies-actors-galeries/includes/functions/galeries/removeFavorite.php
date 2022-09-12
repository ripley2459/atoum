<?php

	require '../../../settings.php';
	require '../../../imports.php';

	galery::removeFavorite( $_GET[ 'image' ] );

	echo '<i class="fa fa-star-o"></i>';