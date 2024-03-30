<?php

require_once __DIR__ . '/../helpers.php';



$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
    addValidationError('email', 'Неправильный формат ввода');
    setMessage('error', 'Что-то не то');
    redirect('/');
}

$user = findUser($email);

if (!$user) {
    setMessage('error',"Пользователь $email не найден");
    redirect('/');
}

if (!password_verify($password, $user['password'])){
    setMessage('error',"Неверный пароль");
    redirect('/');
}

$_SESSION['user']['id'] = $user['id'];

redirect('/home.php');