<?php
	
	// imports.php
	// 14:51 2021-05-06

	// option value
	// 14:51 2021-05-06
	// return from the dabase a string that represent a option value
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

	// whitelist
	// 14:51 2021-05-06
	// return the value only if its inside an array of predetermined values
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

	// to slug
	// 14:51 2021-05-06
	// nomalize a string
	function to_slug( string $string ) {
		$string = strtolower( preg_replace( '/[^a-zA-Z0-9-_\.]/', '-', $string ) );
		return $string;
	}