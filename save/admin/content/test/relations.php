<?php

	if(isset($_POST['name']))
	{
		$sql = 'INSERT INTO at_test SET test_name = :test_name';
		$request = $DDB->prepare($sql);
		$request->execute(array(':test_name' => $_POST['name']));
		$request->closeCursor();
		(0); //ou exit; tout seul
	}

	echo
	get_block_div(
		$array = array('template' => 'admin'),
		get_block_title(
			2,
			$array = array('template' => 'admin'),
			'The XMLHttpRequest Object'
		) .
		get_block_label(
			$array = array('for' => 'name', 'template' => 'admin'),
			'Name'
		) .
		get_block_input(
			$array = array('type' => 'text', 'name' => 'name', 'onkeydown' => 'addTest(this.value)', 'template' => 'admin')
		) .
		get_block_div(
			$array = array('id' => 'txtHint', 'template' => 'admin'),
			''
		)
	);