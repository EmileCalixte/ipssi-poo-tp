<?php

if (!file_exists(__DIR__.'/vendor/autoload.php')) {
    throw new Exception('Exec composer install');
}
require __DIR__.'/vendor/autoload.php';

session_start();

new \Application\Controllers\MainController($_SERVER['REQUEST_URI']);