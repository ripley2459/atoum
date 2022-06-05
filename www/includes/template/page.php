<?php

	$page = get_post($content_type, $content_slug);

?>

	<div id="rp-content">
		<div id="<?php echo 'single-'.$page['slug']; ?>" class="single post-main-container has-children">
			<div class="post-header section">
				<h1><?php echo $page['title']; ?></h1>
				<p class="author-display-name"><?php echo $page['author_display_name']; ?></p>
			</div>
			<div class="post-body section">
				<p><?php echo $page['content']; ?></p>
			</div>
			<div class="post-footer section">
			</div>
		</div>
	</div>

PAGE