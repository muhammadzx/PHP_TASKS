<?php

require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: users.php");
    exit;
}

$_SESSION = [];

session_destroy();

header("Location: login.php");
exit;