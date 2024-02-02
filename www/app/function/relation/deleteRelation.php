<?php

$child = R::getParameter('child');
$parent = R::getParameter('parent');

$request = RDB::delete(Relation::getTableName())
    ->where('type', '=', Relation::getTypeFrom($child, $parent))
    ->where('child', '=', $child)
    ->where('parent', '=', $parent)
    ->execute();