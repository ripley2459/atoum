<?php
	
	// imports.php
	// 2021/04/27

	// option value
	// 2021/04/27
	// return from the dabase a string that represent a option value

	function get_option_value( $option_name ) {
		global $DDB;

		$sql = 'SELECT option_value FROM ' . PREFIX . 'options WHERE option_name = :option_name';
		$rqst_option = $DDB -> prepare( $sql );

		$rqst_option -> execute( array( ':option_name' => $option_name ) );
		$option = $rqst_option -> fetch();

		$option_value = $option['option_value'];

		$rqst_option -> closeCursor();

		return $option_value;
	}

	// whitelist
	// 2021/04/27
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