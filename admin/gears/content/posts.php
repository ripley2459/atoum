<div class="section large float left">
	<h1 class="left">Posts</h1>
	<a href="editor.php?mode=create&type=post" class="button tiny right">Add</a>
</div>

<div class="section large">
	<p>Get an overview of every posts on your site.</p>

<?php

	if(isset($_GET['order_direction'])){$order_direction = $_GET['order_direction'];}else{$order_direction = 'asc';}

	switch_order_direction($order_direction);

	get_content('post', 'content_name', $order_direction);

?>

</div>