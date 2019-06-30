<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>

    <?php
    if ($parameters['logged']) {
        ?>
        <p>You are now logged in. <a href="/">Home</a></p>
        <?php
    }

    if ($parameters['loginError']) {
        ?>
        <p>Error: the email address is unknown or your password is invalid.</p>
        <?php
    }

    if (!$parameters['logged']) {
        ?>
        <p>Fill out the fields to login to your account.</p>

        <p>No account ? <a href="register">Register</a></p>

        <form id="register-form" action="/login" method="post">

            <label for="input-email">Your email address</label>
            <input type="email" id="input-email" name="email" required><br>

            <label for="input-password">Your password</label>
            <input type="password" id="input-password" name="password" required><br>

            <button type="submit">Login</button>
        </form>
        <?php
    }
    ?>

</body>
</html>