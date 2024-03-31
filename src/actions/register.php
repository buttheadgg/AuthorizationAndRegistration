<?php

require_once __DIR__ . '/../helpers.php';

$email = $_POST['email'];
$password = trim($_POST['password']);

$checkUser = findUser($email);

header('Content-Type: application/json');

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
    addValidationError('password', "weak_password");
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
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $userId = $pdo->lastInsertId();

    echo json_encode([
        'user_id' => (int)$userId,
        'password_check_status' => $passwordCheckStatus
    ]);

}catch (\Exception $e){
    echo json_encode(['error' => $e->getMessage()]);
    return;
}

