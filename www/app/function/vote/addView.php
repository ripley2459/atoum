<?php

$data = new Content(intval(R::getParameter('data')));

$data->increaseViews();