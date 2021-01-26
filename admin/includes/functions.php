<?php

	//Fonctions communes aux modules de l'administration


	//Donne des valeurs aux variables "folder" et "page" en fonction de l'url

	function get_dir(){
		global $folder, $page;

		if(isset($_GET['folder'])){
			$folder = $_GET['folder'];
		}
		else{
			$folder = 'admin';
		}

		if(isset($_GET['page'])){
			$page = $_GET['page'];
		}
		else{
			$page = 'admin';
		}
	}


	//Donne la valeur d'un option en fonction de son nom
	function get_option_value($option_name){
		global $bdd, $option_value;
		
		$option_request = $bdd -> prepare('SELECT option_value FROM at_options WHERE option_name = :option_name');
		$option_request -> execute(array(':option_name' => $option_name));
		$option = $option_request -> fetch();

		return $option['option_value'];

		$option_request -> closeCursor();
	}

	function update_option_value($option_name, $new_value){
		global $bdd;

		$update_option_request = $bdd -> prepare('UPDATE at_options SET option_value = :option_value WHERE option_name = :option_name');
		$update_option_request -> execute(array(':option_value' => $new_value, ':option_name' => $option_name));
		$update_option_request -> closeCursor();
	}