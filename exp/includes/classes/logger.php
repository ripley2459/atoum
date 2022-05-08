<?php

	class logger {
		static function logError( string $t ) {
			logger::log( '[' . date("Y-m-d H:i:s") . ']' . '[ERROR] ' . $t );
		}

		static function logInfo( string $t ) {
			logger::log( '[' . date("Y/m/d-H:i:s") . ']' . '[INFO] ' . $t );
		}

		static function log( string $t ) {
			$f = fopen( DIR . "/log.txt", "a" );
			fwrite( $f, $t . "\n" );
			fclose( $f );
		}
	}