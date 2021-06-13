<?php
	
	// functions.php

	// GET_OPTION_VALUE
	// Return from the dabase a string that represent a option value.
	function get_option_value( $option_name ) {
		global $DDB;

		$sql = 'SELECT option_value FROM ' . PREFIX . 'options WHERE option_name = :option_name';
		$rqst_option = $DDB -> prepare( $sql );

		$rqst_option -> execute( [ ':option_name' => $option_name ] );
		$option = $rqst_option -> fetch();

		$option_value = $option['option_value'];

		$rqst_option -> closeCursor();

		return $option_value;
	}

	// WHITELIST
	// Return the value only if its inside an array of predetermined (hardcodded) values.
	function whitelist( &$value, array $allowed, string $message ) {
		if( $value === null ) return $allowed[0];

		$key = array_search( $value, $allowed, true );

		if( $key === false ) {
			throw new InvalidArgumentException( $message );
		}
		else {
			return $value;
		}
	}

	// NORMALIZE
	// Nomalize a string.
	function normalize( string $string ) {
		$string = strtolower( preg_replace( '/[^a-zA-Z0-9-_\.]/', '-', $string ) );
		return $string;
	}

	// GET_FILE_TYPE
	// Return the exploitable type of a file as a string.
	// For exemple a ".png" file will return "image".
	function get_file_type( string $filename ) {
		$extension = pathinfo( $filename, PATHINFO_EXTENSION );

		if( in_array( $extension, [ 'gif', 'jpg', 'jpeg', 'png' ] ) ) {
			return "image";
		}
		else if( in_array( $extension, [ 'mp4', 'vid' ] ) ) {
			return "video";
		}
		else {
			return "none";
		}
	}
	
	// INVERSE ORDER DIRECTION
	// Inverse the order direction
	function inverse_order_direction( string $ord ) {		
		switch( $ord ) {
			case 'asc':
				return 'desc';
				break;
			case 'desc':
				return 'asc';
				break;
		}
	}