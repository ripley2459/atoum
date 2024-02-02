<?php

$child = R::getParameter('child');
$parent = R::getParameter('parent');

$data = [
    [Relation::getTypeFrom($child, $parent)], [$child], [$parent]
];

if (!Relation::exists($child, $parent))
    Relation::register($data);