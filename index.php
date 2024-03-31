<?php

require_once __DIR__ . '/src/helpers.php';


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
<body>

<form class="card" action="src/actions/authorize.php" method="post">
    <h2 class="form-title">Авторизация</h2>


    <label for="email">
        E-mail
        <input
            type="text"
            id="email"
            name="email"
            placeholder="example@vk.com"
            value="<?php echo old('email') ?>"
            <?php echo validationErrorAttr('email'); ?>
        >
        <?php if(hasValidationError('email')): ?>
            <small> <?php echo validationErrorMessage('email'); ?> </small>
        <?php endif; ?>
    </label>

    <label for="password">
        Password
        <input
            type="password"
            id="password"
            name="password"
            placeholder="******"
            <?php echo validationErrorAttr('password'); ?>
        >
        <?php if(hasValidationError('password')): ?>
            <small> <?php echo validationErrorMessage('password'); ?> </small>
        <?php endif; ?>
    </label>

    <button
        type="submit"
        id="submit"
    >Продолжить</button>

</form>


<p><a href="/register.php">Перейти в регистрацию</a></p>

<script src="assets/app.js"></script>
</body>
</html>