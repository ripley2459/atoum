<?php

	//Fonctions propres au module "posts"


	//Renvoie un tableau contenant tout les posts d'un certains type

	function get_content($content_type, $order_by, $order_direction){
		global $bdd, $content;
		$content_request = $bdd -> prepare('SELECT * FROM at_content WHERE content_type = :content_type ORDER BY :order_by :order_direction');
		$content_request -> execute(array(':content_type' => $content_type,':order_by' => $order_by,':order_direction' => $order_direction));
		$content = $content_request -> fetch();
		return $content;
	}


	//renvoie le nom d'affichage d'un utilisateur

	function get_user_display_name($user_id){
		global $bdd;
		$user_request = $bdd -> prepare('SELECT user_display_name FROM at_users WHERE ID = :user_id');
		$user_request -> execute(array(':user_id' => $user_id));
		$user_display_name = $user_request -> fetch();
	}