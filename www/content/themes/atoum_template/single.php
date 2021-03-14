<?php

	$request_post = $DDB->prepare('SELECT content_id FROM at_content WHERE content_slug = :content_slug');
	$request_post->execute(array(':content_slug' => $content_slug));

	while($post = $request_post->fetch()){
		$post = new post($post['content_id']);
		$post->display();
	}