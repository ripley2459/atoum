<?php

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

	function get_option_value($option_name){
		global $DDB;

		$request_option = $DDB -> prepare('SELECT option_value FROM at_options WHERE option_name = :option_name');
		$request_option -> execute(array(':option_name' => $option_name));

		$option = $request_option -> fetch();

		$option_value = $option['option_value'];

		$request_option -> closeCursor();

		return $option_value;
	}

	function update_option_value($option_name, $new_value){
		global $bdd;
		$update_option_request = $bdd -> prepare('UPDATE at_options SET option_value = :option_value WHERE option_name = :option_name');
		$update_option_request -> execute(array(':option_value' => $new_value, ':option_name' => $option_name));
		$update_option_request -> closeCursor();
	}
	
	//Analyse strang and extract values.
	function scan_line($string){
		$string = '';
		switch($string){
			case strpos($line, 'Name:'):
				$line =  str_replace('Name: ','', $line);
				break;
			case strpos($line, 'Author(s):'):
				$line =  str_replace('Author(s): ','', $line);
				break;
			case strpos($line, 'URL:'):
				$line =  str_replace('URL: ','', $line);
				break;
			case strpos($line, 'Version:'):
				$line =  str_replace('Version: ','', $line);
				break;
			case strpos($line, 'Version date:'):
				$line =  str_replace('Version date: ','', $line);
				break;
			case strpos($line, 'Description:'):
				$line =  str_replace('Description: ','', $line);
				break;
		}
		return $line;
	}