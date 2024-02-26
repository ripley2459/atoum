<?php

$username = R::getParameter('username', null, 'The username can\'t be empty!', false);
$password = R::getParameter('password', null, 'The password can\'t be empty!', false);

$request = RDB::select(User::getTableName(), 'id', 'password')
    ->where('username', '=', $username)
    ->limit(1)
    ->execute();
$data = $request->fetch(PDO::FETCH_ASSOC);
R::checkArgument($data != false, 'No account exist with the provided username!', false);

$id = $data['id'];
$hash = $data['password'];

$match = password_verify($password, $hash);
R::checkArgument($match, 'Wrong password!', false);

Auth::set('accountID', $id);

echo 'Logged in!';