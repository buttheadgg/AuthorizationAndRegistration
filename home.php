<?php
require_once __DIR__ . '/src/helpers.php';

checkAuth();

?>


<!DOCTYPE html>
<html lang="ru" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>авторизация и регистрация</title>
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.sand.min.css"
    />
    <link rel="stylesheet" href="assets/app.css">
</head>
<body><img src="picture.png" alt="Я старался..." class="centered-image">

<form action="src/actions/logout.php" method="post">
    <div class="exit-button">
        <button role="button"> Выйти</button>
    </div>
</form>
</body>

