<?php

	if($content_type = 'posts'){
		$sql = 'SELECT content_id FROM at_content WHERE content_type = :content_type';
		$request_posts = $DDB->prepare($sql);
		$request_posts->execute(array(':content_type' => 'post'));

		while($post = $request_posts->fetch()){
			$post = new post($post['content_id']);
			$post->display_preview();
		}
	}
	
	if($content_type = 'class'){
		
	}