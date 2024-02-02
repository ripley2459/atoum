<?php

R::require('username', 'name', 'password', 'confirmPassword');

$username = R::getParameter('username', 'The username can\'t be empty!', true);
$name = R::getParameter('name', 'The name can\'t be empty!', true);
$password = R::getParameter('password', 'The password can\'t be empty!', true);
$confirmPassword = R::getParameter('confirmPassword', 'The password confirmation can\'t be empty!', true);
R::checkArgument($password === $confirmPassword, 'Passwords aren\'t the same!', true);

$request = RDB::select(User::getTableName(), 'count(*)')
    ->where('username', '=', $username)
    ->execute();
$data = $request->fetchColumn();
R::checkArgument($data === 0, 'An account with this username already exist!', true);

$password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 13]);
R::checkArgument($password && !R::blank($password), 'Failed to secure the provided password!', true);

$data = [[$username], [$name], [$password], [0]];
R::checkArgument(count(User::register($data)) > 0, 'Failed to create the account!', true);

echo 'New account created!';