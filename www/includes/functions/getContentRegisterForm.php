<?php

require_once dirname(__DIR__, 2) . '/load.php';

if (!isset($_GET['type'])) {
    return;
}

$type = EContentType::fromInt($_GET['type']);

?>

<h2>Register a new <?= strtolower($type->name) ?></h2>
<input type="text" id="contentName" required/>
<button onclick="registerContent()">Register!</button>