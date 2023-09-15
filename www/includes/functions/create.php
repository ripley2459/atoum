<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('name', 'type');
echo Content::insert(0, R::whitelist(EDataType::from($_POST['type']), EDataType::cases()), $_POST['name'])->getId();