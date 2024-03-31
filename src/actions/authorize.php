<?php

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use \Firebase\JWT\JWT;

session_start();

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

$user = findUser($email);

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    addValidationError('email', 'Неправильный формат ввода');
    header('Location: /');
    exit;
}


if (!$user) {
    addValidationError('email',"Пользователь $email не найден");
    header('Location: /');
    exit;
}

if (!password_verify($password, $user['password'])) {
    addValidationError('password',"Неверный пароль");
    header('Location: /');
    exit;
}

$issuedAt = time();
$expirationTime = $issuedAt + 3600;
$payload = [
    'user_id' => $user['id'],
    'iat' => $issuedAt,
    'exp' => $expirationTime,
];

$secretKey = 'kwjncf390-jfj0@J)M_()fmpiw';
$algorithm = 'HS256';

$jwt = JWT::encode($payload, $secretKey, $algorithm);

echo json_encode(['access_token' => $jwt]);

exit;