<?php

$content = new Content(R::getParameter('data'));

R::checkArgument(Relation::remove($content), 'Failed to delete relations!', true);

R::checkArgument($content->unregister(), 'Failed to delete this data!', true);