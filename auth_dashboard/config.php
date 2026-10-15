<?php

session_start();

$pdo = new PDO(
    "mysql:host=localhost;dbname=registration_system;charset=utf8mb4",
    "root",
    "",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]
);


function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}


if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(32));
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST["token"] ?? "";

    if (!is_string($token) || !hash_equals($_SESSION["token"], $token)) {
        exit("Invalid request. Please refresh the page.");
    }
}