<?php

Auth::set('accountID', R::EMPTY);
Auth::close();

echo 'Logged out!';