<?php

R::require('username', 'name', 'password', 'confirmPassword');

$username = R::getParameter('username', message: 'The username can\'t be empty!', throwException: false);
$name = R::getParameter('name', message: 'The name can\'t be empty!', throwException: false);
$password = R::getParameter('password', message: 'The password can\'t be empty!', throwException: false);
$confirmPassword = R::getParameter('confirmPassword', message: 'The password confirmation can\'t be empty!', throwException: false);
R::checkArgument($password === $confirmPassword, message: 'Passwords aren\'t the same!', throwException: false);

$request = RDB::select(User::getTableName(), 'count(*)')
    ->where('username', '=', $username)
    ->execute();
$data = $request->fetchColumn();
R::checkArgument($data === 0, 'An account with this username already exist!', false);

$password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 13]);
R::checkArgument($password && !R::blank($password), 'Failed to secure the provided password!', false);

$data = [[$username], [$name], [$password], [0]];
R::checkArgument(count(User::register($data)) > 0, 'Failed to create the account!', false);

echo 'New account created!';