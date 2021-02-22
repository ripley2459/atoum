<?php

echo
get_block_title(
	1,
	$array = array('template' => 'admin'),
	'Test'
) .
get_block_modal(
	$array = array('id' => 'modal1', 'template' => 'admin'),
	'Modal 1',
	'Modal 1',
) .
get_block_modal(
	$array = array('id' => 'modal2', 'template' => 'admin'),
	'Modal 2',
	'Modal 2',
) .
get_block_modal(
	$array = array('id' => 'modal3', 'template' => 'admin'),
	'Modal 3',
	'Modal 3',
);