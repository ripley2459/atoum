<div id="rp-content">

	<h1>Posts</h1>

	<p>Get an overview of every posts on your site.</p>

<?php

	if(isset($_GET['order_direction'])){$order_direction = $_GET['order_direction'];}else{$order_direction = 'asc';}

	switch_order_direction($order_direction);

	get_content('post', 'content_name', $order_direction);

?>

</div>