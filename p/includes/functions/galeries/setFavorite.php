<?php

	require '../../../settings.php';
	require '../../../imports.php';

	galery::setFavorite( $_GET[ 'image' ] );

	echo '<i class="fa fa-star"></i>';