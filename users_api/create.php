<?php

header("Content-Type: application/json; charset=utf-8");

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Use POST to create a user."
    ]);

    exit;
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");

if ($name === "" || $email === "") {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Name and email are required."
    ]);

    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Enter a valid email."
    ]);

    exit;
}

try {
    $db_obj = new DB_con();

    $result = $db_obj->create($name, $email);

    if ($result) {
        http_response_code(201);

        echo json_encode([
            "success" => true,
            "message" => "User added successfully."
        ]);
    } else {
        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Could not add the user."
        ]);
    }
} catch (PDOException $error) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Database operation failed."
    ]);
}