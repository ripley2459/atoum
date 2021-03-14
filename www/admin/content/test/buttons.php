<?php

	if(isset($_POST['Dummy'])){
		echo $_POST['Dummy'];
	}

	if(isset($_POST['no'])){
		echo 'no';
	}

?>

<h1>Test</h1>

<form action="buttons.php" method="post">
	<input type="submit" value="Yes" name="Dummy">
	<input type="submit" value="No" name="Chipo">
</form>