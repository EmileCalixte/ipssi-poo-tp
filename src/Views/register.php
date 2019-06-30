<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    <?php

    if ($parameters['registered']) {
        ?>
        <p>You have successfully registered. You can now <a href="/login">login</a>.</p>
        <?php
    }

    if ($parameters['errors']) {
        ?>
        <p>The following error(s) occurred:</p>
        <ul>
            <?php foreach($parameters['errors'] as $error) {
                ?>
                <li><?= $error ?></li>
                <?php
            } ?>
        </ul>
        <?php
    }

    if (!$parameters['registered']) {
        ?>
        <p>Fill out the fields to create your account.</p>

        <p>You have an account ? <a href="login">Login</a></p>

        <form id="register-form" action="/register" method="post">
            <label for="input-name">Your name</label>
            <input type="text" id="input-name" name="name" required><br>

            <label for="input-email">Your email address</label>
            <input type="email" id="input-email" name="email" required><br>

            <label for="input-password">Your password</label>
            <input type="password" id="input-password" name="password" required><br>

            <label for="input-password">Confirm your password</label>
            <input type="password" id="input-password-confirm" name="password-confirm" required><br>

            <button type="submit">Create my account</button>
        </form>
        <?php
    }

    ?>

</body>
</html>