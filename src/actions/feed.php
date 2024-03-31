<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Content-Type: application/json');


$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $jwt = $matches[1];
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized - Token not provided or invalid format']);
    exit;
}

$secretKey = 'kwjncf390-jfj0@J)M_()fmpiw';

try {
    $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
    http_response_code(200);
    echo json_encode(['message' => 'The token is valid']);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
?>


