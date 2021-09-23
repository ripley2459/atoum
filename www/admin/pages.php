<?php

	namespace Atoum;

?>
	<div>
	<!-- START PAGES -->

		<h1>Pages</h1>
		<a href="admin.php?p=editor.php&e=page">Add</a>
		<?php

			$page = new at_class_page( 1 );
			echo $page->get_iframe();

		?>

	<!-- END PAGES -->
	</div>