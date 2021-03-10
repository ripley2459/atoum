<?php

	$request_posts = $DDB->prepare('SELECT content_id FROM at_content WHERE content_type = :content_type');
	$request_posts->execute(array(':content_type' => 'post'));

	while($post = $request_posts->fetch()){
		$post = new post($post['content_id']);
		$post->_display_preview();
	}