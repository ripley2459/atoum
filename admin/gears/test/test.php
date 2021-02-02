<?php

	echo 'yolo';
	echo get_block_form(
		get_block_label(
			'Test',
			$array = array('for' => 'input', 'template' => 'admin')
		) .
		get_block_input(
			$array = array('type' => 'radio', 'name' => 'input', 'required' => 'required', 'template' => 'admin'),
		) .
		get_block_input(
			$array = array('type' => 'hidden', 'name' => 'chipolata', 'value' => '420', 'template' => 'admin'),
		) .
		get_block_input(
			$array = array('type' => 'submit', 'name' => 'input', 'required' => 'required', 'template' => 'admin'),
		),
		$array = array('id' => 'test_yolo', 'class' => 'chipolata lavabo', 'action' => 'test.php', 'target' => '_blank', 'method' => 'post', 'template' => 'admin')
	);