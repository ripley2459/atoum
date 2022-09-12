<?php

	if($content_type = 'posts'){
		$posts = '';
		$sql = 'SELECT content_id FROM at_content WHERE content_type = :content_type';
		$request_posts = $DDB->prepare($sql);
		$request_posts->execute([':content_type'=>'post']);

		while($post = $request_posts->fetch()){
			$post = new post($post['content_id']);
			$posts .= $post->display_preview();
		}
		
		echo
		get_block_div(
			['class'=>'posts_main_container', 'template'=>'theme'],
			$posts
		);
	}
	
	if($content_type = 'class'){
		
	}