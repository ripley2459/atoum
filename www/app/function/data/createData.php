<?php

$name = R::getParameter('name');
$type = R::getParameter('type');

echo Content::register([[0], [EDataType::from($type)->value], [0], [R::sanitize($name)], [$name], [R::EMPTY], [0]])[0];