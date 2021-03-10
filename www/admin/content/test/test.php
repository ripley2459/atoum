<?php

	//require CLASSES . 'relation.php';
	//require CLASSES . 'file.php';

	$fruits = array("brownie" => "brownie", "orange" => "orange", "banane" => "banane", "pomme" => "pomme", "poire" => "poire", "abricot" => "abricot", "groseille" => "groseille");

	if(isset($_POST['submit'])){
		foreach($fruits as $x => $fruit){
			if(isset($_POST[$fruit])){
				echo '<p>' . $fruit . '</p>';
			}
		}
	}

	//$test_relation = new relation(4);

?>

<h1>Test</h1>

<form action="test.php" method="post">
	<div>
		<?php
			foreach($fruits as $x => $fruit){
				echo '<input type="checkbox" name="' . $fruit .'" value="' . $fruit .'">';
				echo '<label for="' . $fruit .'"> ' . $fruit .'</label></input>';
			}

/* 			$test_display = $test_relation->get_relations();
			var_dump($test_display);
			
			$test_file = new file();
 */
		?>

	</div>
	<input type="submit" value="Valider" name="submit">
</form>