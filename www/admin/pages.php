<?php

	namespace Atoum;

	// Order by and order_direction setup
	if( isset( $_GET[ 'ob' ] ) ) $order_by = 'content_' . $_GET[ 'ob' ];
	if( isset( $_GET[ 'od' ] ) ) $order_direction = $_GET[ 'od' ];

	$order_by = whitelist( $order_by, [ 'content_title', 'content_slug', 'content_date_modified' ], 'Invalid field name!' );
	$order_direction = whitelist( $order_direction, [ 'asc', 'desc' ], 'Invalid order direction!' );

?>
	<div class="frame">
	<!-- START PAGES -->

		<h1>Pages</h1>
		<a href="admin.php?p=editor.php&e=page">Add</a>
		<?php

			echo at_class_page::show_all_as_table();

		?>

	<!-- END PAGES -->
	</div>