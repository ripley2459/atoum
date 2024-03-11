<?php

require_once '../load.php';

Auth::start();
// Auth::verifyToken(App::getArgument('token'));

const ALLOWED_FUNCTIONS = [
    'auth/login',
    'auth/logout',
    'auth/register',

    'data/getData',
    'data/createData',
    'data/deleteData',
    'data/editData',
    'data/uploadData',
    'data/setPreview',
    'data/typeaheadSearch',

    'gallery/getImagesLinked',
    'gallery/getImagesNonLinked',

    'playlist/getVideosLinked',
    'playlist/getVideosNonLinked',

    'relation/createRelation',
    'relation/deleteRelation',

    'vote/applyVote',
    'vote/addView',

    'db/saveDB'
];

$function = R::whitelist(R::getParameter('function'), ALLOWED_FUNCTIONS);

require_once 'function/' . $function . '.php';