<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <h1>Welcome<?php
        if (\Application\Controllers\MainController::$currentUser instanceof \Application\Model\User) {
            ?>, <?= htmlspecialchars(\Application\Controllers\MainController::$currentUser->getName()) ?>
        <?php
        }
    ?></h1>
    <ul>
        <?php
        if(\Application\Controllers\MainController::$currentUser instanceof \Application\Model\User) {
            ?>
            <li><a href="logout">Logout</a></li>
            <?php
        } else {
            ?>
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
            <?php
        }
        ?>
        <li><a href="/view-meetings">View meetings</a></li>
        <li><a href="/create-meeting">Create a meeting</a></li>
    </ul>
</body>
</html>