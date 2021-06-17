<?php

	$to_display = '';

	$file = file_get_contents(ROOT . '/admin/content/test/ModLister.json', 'r');

	$mods = json_decode($file);
	$modsAmount = count($mods);

 	for($i = 0; $i < $modsAmount; $i++){
		$mods[$i]->a;
		
		$to_display .=
		'<div class="mod">
			<a href="' . $mods[$i]->u . '" target="_blank">' . $mods[$i]->n . '</a><span>   ' . $mods[$i]->v . '</span>
			<p>by: ' . $mods[$i]->a . '.</p>
			<p>File: ' . $mods[$i]->f . '</p>
			</br>
		</div>';
		
	}

	echo
	get_block_accordion(
		$array = array('template' => 'admin'),
		'Mods list',
		get_block_div(
			$array = array('class' => 'accordion_group', 'template' => 'admin'),
			$to_display
		)
	);

?>