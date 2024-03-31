<?php

session_start();


require_once __DIR__ . '/config.php';
function redirect($path)
{
    header("Location: $path");
    die();

}

function addValidationError(string $fieldName, string $message)
{
    $_SESSION['validation'][$fieldName] = $message;
}

function hasValidationError(string $fieldName): bool
{
    return isset($_SESSION['validation'][$fieldName]);
}

function validationErrorAttr(string $fieldName)
{
    echo isset($_SESSION['validation'][$fieldName]) ? 'aria-invalid="true"' : '';
}

function validationErrorMessage(string $fieldName)
{
    $message = $_SESSION['validation'][$fieldName] ?? '';
    unset($_SESSION['validation'][$fieldName]);
    echo $message;

}

function clearValidation()
{
    $_SESSION['validation'] = [];
}

function setOldValue(string $key, mixed $value)
{
    $_SESSION['old'][$key] = $value;
}

function old(string $key)
{
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

function clearOldValues(string $key): void
{
    $_SESSION['old'] = [];
}

function checkPasswordStrength($password)
{
    $passwordCheckStatus = 'weak';
    $length = strlen($password);
    $hasLetters = preg_match('@[a-zA-Z]@', $password);
    $hasDigits = preg_match('@[0-9]@', $password);
    $hasSpecialChars = preg_match('@[^\w]@', $password);

    if ($length >= 8 && $hasLetters && $hasDigits) {
        $passwordCheckStatus = 'good';
    }

    if ($length >= 12 && $hasLetters && $hasDigits && $hasSpecialChars) {
        $passwordCheckStatus = 'perfect';
    }

    return $passwordCheckStatus;
}

function setMessage(string $key, string $message): void
{
    $_SESSION['message'][$key] = $message;
}

function hasMessage(string $key): bool
{
    return isset($_SESSION['message'][$key]);
}

function getMessage(string $key)
{
    $message = $_SESSION['message'][$key] ?? '';
    unset($_SESSION['message'][$key]);
    return $message;
}

function getPDO(): PDO
{
    try {
        return new \PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    } catch (\PDOException $e) {
        die("Connection error: {$e->getMessage()}");
    }
}

function findUser(string $email): array|bool
{
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email =:email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

function logout(): void
{
    unset($_SESSION['user']['id']);
    redirect('/index.php');
}

function checkAuth(): void
{
    if (!isset($_SESSION['user']['id'])) {
        redirect('/');
    }
}

function checkGuest(): void
{
    if (!isset($_SESSION['user']['id'])) {
        redirect('/home.php');
    }
}