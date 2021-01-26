<div id="rp-content">

	<h1>Pages</h1>

	<p>Get an overview of every static pages on your site.</p>

<?php

	if(isset($_GET['order_direction'])){$order_direction = $_GET['order_direction'];}else{$order_direction = 'asc';}

	switch_order_direction($order_direction);

	get_content('page', 'content_name', $order_direction);

?>

</div>