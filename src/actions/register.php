<?php

require_once __DIR__ . '/../helpers.php';

$email = $_POST['email'];
$password = trim($_POST['password']);

$checkUser = findUser($email);
if($checkUser){
    addValidationError('email', 'Пользователь с такой почтой уже зарегистрирован');
    setOldValue('email', $email);
    redirect('/register.php');
    return;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    setOldValue('email', $email);
    addValidationError('email', 'Указана неправильная почта');
    redirect('/register.php');
    return;
}

if ($password===''){
    addValidationError('password', 'Пароль пустой');
    redirect('/register.php');
    return;
}

$passwordCheckStatus = checkPasswordStrength($password);
if ($passwordCheckStatus == 'weak') {
    addValidationError('password', "Пароль легкий. В пароле должны быть буквы разного регистра и цифры");
    redirect('/register.php');
    return;
}

if (!empty($_SESSION['validation'])) {
    setOldValue('email', $email);
    redirect('/register.php');
    return;
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