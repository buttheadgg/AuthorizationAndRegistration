<?php

require_once __DIR__ . '/../helpers.php';

$email = $_POST['email'];
$password = $_POST['password'];




if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    setOldValue('email', $email);
    addValidationError('email', 'Указана неправильная почта');
}

if (empty($password)){
    addValidationError('password', 'Пароль пустой');
}

if (!empty($_SESSION['validation'])) {
    redirect('/register.php');
}

$pdo = getPDO();


$query = "INSERT INTO users (email, password) VALUES (:email, :password)";
$params = [
    'email' => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT)
];

$stmt = $pdo -> prepare($query);

try{
    $stmt -> execute($params);
}catch (\Exception $e){
    die($e->getMessage());
}

redirect('/index.php');