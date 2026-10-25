<?php

header("Content-Type: application/json; charset=utf-8");

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Use POST to update a user."
    ]);

    exit;
}

$id = (int) ($_POST["id"] ?? 0);
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");

if ($id <= 0 || $name === "" || $email === "") {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "User ID, name, and email are required."
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

    $result = $db_obj->update($id, $name, $email);

    if ($result) {
        echo json_encode([
            "success" => true,
            "message" => "Update request completed."
        ]);
    } else {
        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Could not update the user."
        ]);
    }
} catch (PDOException $error) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Database operation failed."
    ]);
}