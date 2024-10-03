<?php

use Dotenv\Dotenv;

require __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mysqli = new mysqli(hostname: $_ENV['DB_HOSTNAME'], username: $_ENV['DB_USERNAME'], password: $_ENV['DB_PASSWORD'], database: $_ENV['DB_DATABASE']);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;