	<div class="frame">
	<!-- START OVERVIEW -->

		<h1>PHP Instalation</h1>

		<style type="text/css">
			#phpinfo {}
			#phpinfo pre {}
			#phpinfo a:link {}
			#phpinfo a:hover {}
			#phpinfo table {}
			#phpinfo .center {}
			#phpinfo .center table {}
			#phpinfo .center th {}
			#phpinfo td, th {}
			#phpinfo h1 {}
			#phpinfo h2 {}
			#phpinfo .p {}
			#phpinfo .e {}
			#phpinfo .h {}
			#phpinfo .v {}
			#phpinfo .vr {}
			#phpinfo img {}
			#phpinfo hr {}
		</style>

		<div id="phpinfo">
			<?php

				ob_start () ;
				phpinfo () ;
				$pinfo = ob_get_contents () ;
				ob_end_clean () ;

				// the name attribute "module_Zend Optimizer" of an anker-tag is not xhtml valide, so replace it with "module_Zend_Optimizer"
				echo ( str_replace ( "module_Zend Optimizer", "module_Zend_Optimizer", preg_replace ( '%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo ) ) ) ;

			?>
		</div>

		<?php
			$upload_max_filesize = ini_get( 'upload_max_filesize' );
			$post_max_size = ini_get( 'post_max_size' );
			$memory_limit = ini_get( 'memory_limit' );
			$upload_mb = min($upload_max_filesize, $post_max_size, $memory_limit);
		?>
		<form>
			<h2>Uploads</h2>

			<label>The maximum size of an uploaded file (in bytes):</label>
			<input type="text" name="name" id="name" value="<?php echo $upload_max_filesize; ?>" required readonly>

			<label>The maximum size of the data received by the POST method:</label>
			<input type="text" name="name" id="name" value="<?php echo $post_max_size; ?>" required readonly>

			<label>The memory limit (in bytes) a script is allowed to allocate:</label>
			<input type="text" name="name" id="name" value="<?php echo $memory_limit; ?>" required readonly>

			<label>Effective upload size (in bytes):</label>
			<input type="text" name="name" id="name" value="<?php echo $upload_mb; ?>" required readonly>

		</form>

		<div id="databaseinfos">
			<?php

				$rqst0 = $DDB->prepare( "SHOW TABLE STATUS" );
				$rqst0->execute();

				$size = 0;  
				while( $row = $rqst0->fetch() ) {  
					$size += $row[ "Data_length" ] + $row[ "Index_length" ];  
				}

				$decimals = 2;  
				$mbytes = number_format( $size / ( 1024 * 1024 ), $decimals );

				echo $mbytes;

			?>
		</div>

	<!-- END OVERVIEW -->
	</div>



	<?php

	/**
	* Detects max size of file can be uploaded to server
	*
	* Based on php.ini parameters “upload_max_filesize”, “post_max_size” &
	* “memory_limit”.
	*
	* Valid for single file upload form. May be used
	* as MAX_FILE_SIZE hidden input or to inform user about max allowed file size.
	*
	* RULE memory_limit > post_max_size > upload_max_filesize
	* http://php.net/manual/en/ini.core.php : 128M > 8M > 2M
	* Sets max size of post data allowed. This setting also affects file upload.
	* To upload large files, this value must be larger than upload_max_filesize.
	* If memory limit is enabled by your configure script, memory_limit also
	* affects file uploading. Generally speaking, memory_limit should be larger
	* than post_max_size. When an integer is used, the value is measured in bytes.
	* Shorthand notation, as described in this FAQ, may also be used. If the size
	* of post data is greater than post_max_size, the $_POST and $_FILES
	* superglobals are empty. This can be tracked in various ways, e.g. by passing
	* the $_GET variable to the script processing the data, i.e.
	* , and then checking
	* if $_GET["processed"] is set.
	* memory_limit > post_max_size > upload_max_filesize
	* @author Paul Melekhov edited by lostinscope
	* @return int Max file size in bytes

	function detectMaxUploadFileSize(){

		* Converts shorthands like “2M” or “512K” to bytes
		*
		* @param $size
		* @return mixed
	
		$normalizesize = function($size) {
			if (preg_match("/^([\d\.]+)([KMG])$/i", $size, $match)) {
				$pos = array_search($match[2], array("K", "M", "G"));
				if ($pos !== false) {
					$size = $match[1] * pow(1024, $pos + 1);
				}
			}
			return $size;
		};

		$max_upload = $normalizesize( ini_get( "upload_max_filesize" ) );
		$max_post = ( ini_get( "post_max_size" ) == 0 ) ? function() { throw new Exception( "Check Your php.ini settings" ); } : $normalizesize( ini_get( "post_max_size" ) );
		$memory_limit = ( ini_get( "memory_limit" ) == -1 ) ? $max_post : $normalizesize( ini_get( "memory_limit" ) );

		if( $memory_limit < $max_post || $memory_limit < $max_upload ) return $memory_limit;

		if( $max_post < $max_upload ) return $max_post;

		$maxFileSize = min( $max_upload, $max_post, $memory_limit );
		
		return $maxFileSize;
	}

	echo detectMaxUploadFileSize();

	*/