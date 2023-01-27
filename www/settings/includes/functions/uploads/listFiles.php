<?php

require_once dirname(__DIR__, 4) . '/load.php';

foreach (Content::getAll(1, 'name_DESC') as $content) {
    // TODO
}