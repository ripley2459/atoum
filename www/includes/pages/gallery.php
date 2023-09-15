<?php

R::require('id');

$data = new BlockGallery('gallery-' . $_GET['id']);
$data->getImages($_GET['id'], true);
echo $data->display();