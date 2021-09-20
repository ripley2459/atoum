<?php

	namespace Atoum;
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

	/**
	 * NORMALIZE
	 * Replaces all special characters and spaces with dashes.
	 * @return string normalized.
	 * @since 2021/09/20
	 */
	function normalize( string $string ) {
		return strtolower( preg_replace( '/[^a-zA-Z0-9-_\.]/', '-', $string ) );
	}

	// GET_FILE_TYPE
	// Return the exploitable type of a file as a string.
	// For exemple a ".png" file will return "image".
	function get_file_type( string $file_name ) {
		$extension = pathinfo( $file_name, PATHINFO_EXTENSION );

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
	
	/**
	 * INVERSE ORDER DIRECTION
	 * Reverses the sort direction.
	 * @example asc became desc
	 * @return string
	 * @since 2021/06/15
	 */
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

	/**
	 * GET UPLOADS
	 * Return an array with all uploads stored in the database.
	 * @return array of objects.
	 * @since 20201/06/15
	 */
	function get_all_uploads() {
		global $DDB;

		$uploads = [];

		$sql0 = 'SELECT content_id FROM ' . PREFIX . 'content WHERE content_origin = \'uploaded\' OR content_origin = \'bulk uploaded\'';

		$rqst_get_uploads = $DDB->prepare( $sql0 );
		$rqst_get_uploads->execute();

		while( $file = $rqst_get_uploads->fetch() ) {
			$file = new at_class_upload( $file[ 'content_id' ] );
			array_push($uploads, $file);
		}

		$rqst_get_uploads->closeCursor();
		
		return $uploads;
	}

	/**
	 * GET TAGS
	 * Return an array with all tags stored in the database.
	 * @return array of objets.
	 * @since 2021/06/15
	 */
	function get_all_tags() {
		global $DDB;

		$tags = [];

		$sql0 = 'SELECT tag_id FROM ' . PREFIX . 'tags';

		$rqst_get_tags = $DDB->prepare( $sql0 );
		$rqst_get_tags->execute();

		while( $tag = $rqst_get_tags->fetch() ) {
			$tag = new at_class_tag( $tag[ 'tag_id' ] );
			array_push($tags, $tag);
		}

		$rqst_get_tags->closeCursor();
		
		return $tags;
	}

	/**
	 * GET RELATIONS RELATED
	 */
	function get_relations_related( $relation_type, $content_id ) {
		global $DDB;

		$relations = [];

		$sql0 = 'SELECT relation_id FROM ' . PREFIX . 'relations WHERE relation_type = :relation_type AND relation_a_id = :relation_a_id';

		$rqst_get_relations_related = $DDB->prepare( $sql0 );
		$rqst_get_relations_related->execute( [ ':relation_type'=>$relation_type, ':relation_a_id'=>$content_id ] );

		while( $relation = $rqst_get_relations_related->fetch() ) {
			$relation = new at_class_relation( $relation[ 'relation_id' ] );
			array_push($relations, $relation);
		}

		$rqst_get_relations_related->closeCursor();
		
		return $relations;
	}