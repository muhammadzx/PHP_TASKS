<?php

header("Content-Type: application/json; charset=utf-8");

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Use POST to delete a user."
    ]);

    exit;
}

$id = (int) ($_POST["id"] ?? 0);

if ($id <= 0) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "A valid user ID is required."
    ]);

    exit;
}

try {
    $db_obj = new DB_con();

    $result = $db_obj->delete($id);

    if ($result) {
        echo json_encode([
            "success" => true,
            "message" => "Delete request completed."
        ]);
    } else {
        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Could not delete the user."
        ]);
    }
} catch (PDOException $error) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Database operation failed."
    ]);
}