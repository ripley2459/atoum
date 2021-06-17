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
		global $DDB;
		$request_option_update = $DDB->prepare('UPDATE at_options SET option_value = :option_value WHERE option_name = :option_name');
		$request_option_update->execute(array(':option_value' => $new_value, ':option_name' => $option_name));
		$request_option_update->closeCursor();
	}
	
	//Analyse strang and extract values.
	function scan_line(string $string){
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

	//allow only value inside the array to be returned
	function whitelist(&$value, array $allowed, string $message) {
		if ($value === null) {
			return $allowed[0];
		}
		$key = array_search($value, $allowed, true);
		if ($key === false) { 
			throw new InvalidArgumentException($message); 
		} else {
			return $value;
		}
	}

	//manage the order direction
	function order_manager(){
		global $order_direction;
		if(isset($_GET['order_direction'])){
			$order_direction = $_GET['order_direction'];
		}
		else{
			$order_direction = 'desc';
		}
		switch_order_direction($order_direction);	
	}

	//invert the order direction
	function switch_order_direction($order_direction){		
		global $order_direction;
		switch($order_direction){
			case 'asc':
				$order_direction = 'desc';
				break;
			case 'desc':
				$order_direction =  'asc';
				break;
			default:
				$order_direction = 'asc';
		}
	}