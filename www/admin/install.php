
<?php

	// If Atoum is already installed, redirect the user.
	if( file_exists( '../settings.php' ) ) header( 'Location: ../index.php' );

	define( 'URL', sprintf( '%s://%s', isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] != 'off' ? 'https' : 'http', $_SERVER[ 'SERVER_NAME' ] ) );

	if ( isset( $_POST[ 'submit' ] ) ) {

		// Settings.php creation.
		$data = '<?php

		namespace Atoum;
	
		define( \'HOST\', \'' . $_POST[ 'db_host' ] . '\' );
		define( \'DBNAME\', \'' . $_POST[ 'db_name' ] . '\' );
		define( \'CHARSET\', \'utf8\' );
		define( \'USER\', \'' . $_POST[ 'db_username' ] . '\' );
		define( \'PASSWORD\', \'' . $_POST[ 'db_password' ] . '\' );
		define( \'PREFIX\', \'' . strtolower( preg_replace( '/[^a-zA-Z0-9-_\.]/', '_', $_POST[ 'db_prefix' ] ) ) . '\' );';

		file_put_contents( '../settings.php', $data );

		// If can't be imported there is an error.
		require '../settings.php';
		
		// First connection to the database.
		$dsn_options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => true
		];
	
		try {
			$DDB = new PDO( DSN, USER, PASSWORD, $dsn_options );
		}
		catch( \PDOException $e ) {
			throw new \PDOException( $e -> getMessage(), (int)$e -> getCode() );
		}

		// Content table.
		$sql = 'CREATE TABLE ' . PREFIX . 'content (
			content_id INT(11) AUTO_INCREMENT PRIMARY KEY,
			content_title VARCHAR(255),
			content_slug VARCHAR(255),
			content_type VARCHAR(25) NOT NULL,
			content_origin VARCHAR(25) NOT NULL,
			content_status VARCHAR(25) NOT NULL,
			content_author_id INT(11) NOT NULL,
			content_path VARCHAR(255),
			content_content LONGTEXT,
			content_date_created DEFAULT CURRENT_TIMESTAMP,
			content_date_modified DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)';

		if ( $DDB->query( $sql ) === true ) {
			echo 'Table ' . PREFIX . '_content successfully created.';
		}
		else {
			echo "Error creating table: " . $conn->error;
		}

		// Options table.
		$sql = 'CREATE TABLE ' . PREFIX . 'options (
			option_id INT(11) AUTO_INCREMENT PRIMARY KEY,
			option_name VARCHAR(25) NOT NULL,
			option_value LONGTEXT NOT NULL
		)';

		if ( $conn->query( $sql ) === TRUE ) {
			echo 'Table ' . PREFIX . '_content successfully created.';

			// Insert some basic options.
			$sql0 = 'INSERT INTO ' . PREFIX . 'options SET
				option_name = :option_name,
				option_value = :option_value';

			$rqst0 = $DDB->prepare( $sql0 );
			$rqst0->execute( [ 
				':option_name' => 'active_theme',
				':option_value' => 'option_name'
			] );

			$rqst0->closeCursor();
		}
		else {
			echo "Error creating table: " . $conn->error;
		}
	}

?>
<!doctype html>
<html lang="en">
<!-- START INSTALLER HTML -->

	<head class="admin">
	<!-- START INSTALLER HEAD -->
		<title>Atoum's Instalation Process</title>
		<meta charset="utf-8">
		<meta name="description" content="Installer">
		<meta name="author" content="Cyril Neveu">
		<link rel="stylesheet" href="<?php echo URL . '/includes/reset.css' ?>">
		<link rel="stylesheet" href="<?php echo URL . '/includes/template/includes/style.css' ?>">
	<!-- START INSTALLER HEAD -->
	</head>

	<body class="installer">
	<!-- START INSTALLER BODY -->

		<form action="installer.php" method="post" class="frame">
			<div>
				<h2>Account</h2>

				<label for="user_name">Username</label>
				<input type="text" name="user_name">
				<p>Username of the Atoum's main administrator.</p>

				<label for="user_password">Password</label>
				<input type="text" name="user_password">
				<label for="user_password_confirmation">Password confirmation</label>
				<input type="text" name="user_password_confirmation">
				<p>Password of the Atoum's main administrator.</p>

			</div>

			<div>
				<h2>Atoum settings</h2>

				<label for="db_name">Database name</label>
				<input type="text" name="db_name" required>
				<p>The name of the database you want to use with Atoum.</p>

				<label for="db_username">Username</label>
				<input type="text" name="db_username" required>
				<p>The username used to connect to your database.</p>

				<label for="db_password">Password</label>
				<input type="text" name="db_password" required>
				<p>The password used to connect to your database.</p>

				<label for="db_host">Host</label>
				<input type="text" name="db_host" required>
				<p>Your web host should give you this information.</p>

				<label for="db_prefix">Tables prefix</label>
				<input type="text" name="db_prefix">
				<p>Tables will be named using this, so you can run multiple Atoum instances with one database.</p>

				<input type="submit" name="submit" value="Save">
			</div>
		</form> 
		
		<script src="<?php echo URL . '/includes/scripts.js' ?>"></script>
	<!-- START INSTALLER BODY -->
	</body>

<!-- END INSTALLER HTML -->
</html>