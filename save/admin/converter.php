<?php

	require_once('includes/simple_html_dom/simple_html_dom.php');

	function parser($value){
		$string = str_get_html($value);
		$string -> find('p', 0) -> innertext = 'J\'aime ceu';
		return $string;
	}

	if(isset($_POST['editor'])){
		$value = $_POST['editor'];
	}
	else{
		$value = '';
	}

?>

<!doctype html>
<html lang="fr">
	<head>
		<title>Converter</title>
		<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
	</head>
	<body>
		<h1>Converter</h1>
		<p>This tool can convert any html content to the Atoum's format.</p>
		<h2>Input</h2>
		<form action="converter.php" method="post">
			<textarea name="editor" id="editor" required>
				<?php echo $value ?>
			</textarea>
			<script>
				ClassicEditor
					.create( document.querySelector( '#editor' ) )
					.catch( error => {
					console.error( error );
				} );
			</script>
			<button type="submit">Format</button>
		</form>
		<h2>Result</h2>
		<?php echo parser($value); ?>
		<textarea></textarea>
	</body>
</html>