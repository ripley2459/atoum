<?php

	/**
	 * Retirer les charactères chelou d'une chaîne de caractères.
	 * @return string
	 * @since 2022/12/25
	 */
	function normalize( $string ) {
		return strtolower( preg_replace( '/[^a-zA-Z0-9-_\.]/', '_', $string ) );
	}

	/**
	 * Analyse un chemin et renvoie les fichiers en ométtant "." et "..";
	 * @return array
	 * @since 2021/12/25
	 */
	function normalizedScan( $path ) {
		return array_diff( scandir( $path ), [ '.', '..' ] );
	}

	/**
	 * Donne toutes les fichiers présents dans un dossiers et les sous-dossiers.
	 * @return array
	 * @since 2021/12/25
	 */
	function getContent( $path ) {
		$files = [];

		foreach ( normalizedScan( $path ) as $file ) {
			if ( is_dir( $path . '/' . $file ) ) {
				foreach ( normalizedScan( $path . '/' . $file ) as $sub_file ) {
					array_push( $files, $path . '/' . $file . '/' . $sub_file );
				}
			}
			else {
				array_push( $files, $path . '/' . $file );
			}
		}

		return $files;
	}

	/**
	 * Ne permet d'utiliser que des valeurs hardcodées.
	 * @since 2021/09/20
	 */
	function whitelist( &$value, array $allowed, string $message ) {
		if( $value === null ) return $allowed[ 0 ];

		$key = array_search( $value, $allowed, true );

		if( $key === false ) {
			throw new InvalidArgumentException( $message );
		}
		else {
			return $value;
		}
	}