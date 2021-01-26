<?php

	if(isset($_POST['database-name'], $_POST['tables-prefix'], $_POST['username'], $_POST['password'], $_POST['host'])){
		$database_name = $_POST['database-name'];
		$table_prefix = $_POST['tables-prefix'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$host = $_POST['host'];	

		install($database_name, $table_prefix, $username, $password, $host);
		
		require 'includes/config.php';
		echo $CONFIG['PREFIX'] . 'options';
	}

/****************************************************************************************************/

	function install($database_name, $table_prefix, $username, $password, $host){
		global $bdd, $links, $CONFIG;

		$database_name = 'at_' . str_replace(' ','_', strtolower($database_name));
		$table_prefix = str_replace(' ','_', strtolower($table_prefix));

		$CONFIG = array(
			'DB_NAME' => $database_name,
			'TABLE_PREFIX' => $table_prefix,
			'USERNAME' => $username,
			'PASSWORD' => $password,
			'HOST' => $host
		);

		$config_content = "<?php

		\$CONFIG = array(
			'DB_NAME' => '" . $database_name . "',
			'PREFIX' => '" . $table_prefix . "',
			'USERNAME' => '" . $username . "',
			'PASSWORD' => '" . $password . "',
			'HOST' => '" . $host . "');

		try{
			\$bdd = new PDO('mysql:host=". $CONFIG['HOST'] . ";dbname=". $CONFIG['DB_NAME'] . ";charset=utf8','". $CONFIG['USERNAME'] . "', '". $CONFIG['PASSWORD'] . "', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception \$e){
			die('Error: ' . \$e -> getMessage());
		}

		\$LINKS = array(
			'ROOT' => '" . $_SERVER['DOCUMENT_ROOT'] . "',
			'URL' => 'http://atoum',
			'PLUGINS' => '" . $_SERVER['DOCUMENT_ROOT'] . "/content/plugins/',
			'THEMES' => '" . $_SERVER['DOCUMENT_ROOT'] . "/content/themes/',
		);

		require \$LINKS['ROOT'] . '/includes/functions.php';
		require \$LINKS['ROOT'] . '/admin/includes/functions.php';

		\$THEME = get_option_value('active_theme');

		require \$LINKS['themes'] . \$THEME . '/includes/functions.php';";

		$config_file = fopen('includes/config.php', 'w');
		fwrite($config_file, $config_content);
		fclose($config_file);

		$bdd = new mysqli($host, $username, $password);
		if($bdd -> connect_error){
			die('Connection failed: ' . $bdd -> connect_error);
		}

		$create_dabase_request = "CREATE DATABASE $database_name";
		if($bdd -> query($create_dabase_request) === TRUE){
			echo '<p class="query-success">Database created successfully.</p>';
		}
		else{
			echo '<p class="query-error">Error creating database: ' . $bdd -> error . '</p>';
		}
		
		//Se mettre dans la base de donnée fraichement créée
		$bdd -> select_db($database_name);

		$bucket = $table_prefix . 'content';
		$create_table_content_request = "CREATE TABLE $bucket (
			content_id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			content_title TEXT NOT NULL,
			content_slug TEXT NOT NULL,
			content_author BIGINT(20) UNSIGNED,
			content_date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
			content_date_modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			content_type VARCHAR(20),
			content_status VARCHAR(20),
			content_parent_id BIGINT(20),
			content_has_children TINYINT(1),
			content_content LONGTEXT
		)";

		if($bdd -> query($create_table_content_request) === TRUE){
			echo '<p class="query-success">Table content created successfully.</p>';
		}
		else{
			echo '<p class="query-error">Error creating content table: ' . $bdd -> error . '</p>';
		}

		$bucket = $table_prefix . 'options';
		$create_table_options_request = "CREATE TABLE $bucket (
			option_id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			option_name TEXT NOT NULL,
			option_value LONGTEXT
		)";

		if($bdd -> query($create_table_options_request) === TRUE){
			echo '<p class="query-success">Table options created successfully.</p>';
		}
		else{
			echo '<p class="query-error">Error creating options table: ' . $bdd -> error . '</p>';
		}

		$bucket = $table_prefix . 'terms';
		$create_table_terms_request = "CREATE TABLE $bucket (
			term_id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			term_name VARCHAR(20) NOT NULL,
			term_slug VARCHAR(20) NOT NULL,
			term_type VARCHAR(20) NOT NULL,
			term_description TEXT,
			term_parent_id BIGINT(20)
		)";

		if($bdd -> query($create_table_terms_request) === TRUE){
			echo '<p class="query-success">Table content terms successfully.</p>';
		}
		else{
			echo '<p class="query-error">Error creating terms table: ' . $bdd -> error . '</p>';
		}

		$bucket = $table_prefix . 'users';
		$create_table_users_request = "CREATE TABLE $bucket (
			user_id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			user_name VARCHAR(20) NOT NULL,
			user_display_name VARCHAR(20) NOT NULL
		)";
		
		if($bdd -> query($create_table_users_request) === TRUE){
			echo '<p class="query-success">Table content users successfully.</p>';
		}
		else{
			echo '<p class="query-error">Error creating users table: ' . $bdd -> error . '</p>';
		}
		
		//header('location: admin.php');
	}

/****************************************************************************************************/

?>

<!doctype html>
<html lang="fr">
	<head>
		<link rel="stylesheet" href="<?php echo $LINKS['URL'].'/content/themes/'.$THEME.'/includes/style.css'; ?>">
		<script src="https://kit.fontawesome.com/447390b449.js" crossorigin="anonymous"></script>
		<title>Install</title>
	</head>

	<body>
		<header>
			
		</header>

		<div id="installation" class="section">
			<h1>Atoum installation process</h1>
			<form action="install.php" method="post">

				<label for="name"><b>Database name</b></label>
					<input type="text" id="database-name" name="database-name" placeholder="Database name" class="full" value="atoum_db" required>
				<p>The name will be standardized using lowercase letters, numbers and underscores.</p>
				<label for="name"><b>Tables prefix</b></label>
					<input type="text" id="tables-prefix" name="tables-prefix" placeholder="Table prefix" class="full" value="at_" required>
				<p>This allow you to have multiple Atoum installation within one database.</p>

				<label for="name"><b>Username</b></label>
					<input type="text" id="username" name="username" placeholder="Username" class="full" value="root" required>
				<p>Your MySQL username.</p>
				<label for="name"><b>Password</b></label>
					<input type="text" id="password" name="password" placeholder="Password" class="full" value="">
				<p>Your MySQL Password.</p>
				<label for="name"><b>Host</b></label>
					<input type="text" id="host" name="host" placeholder="Host" class="full" value="localhost" required>
				<p>Try "localhost" or get this information from your webhost.</p>

				<p>By using Atoum, you accept all lines of any indigestible contract.</p>
				<p>You also agree that your personal data, your physical and mental security will be compromised.</p>
				<button type="submit" value="Submit" class="full float-right">Install Atoum</button>
			</form>
		</div>

		<footer>
			<script src="<?php echo $LINKS['URL'].'/includes/scripts.js'; ?>"></script>
			<script src="<?php echo $LINKS['URL'].'/content/themes/'.$THEME.'/includes/scripts.js'; ?>"></script>
		</footer>
	</body>
</html>