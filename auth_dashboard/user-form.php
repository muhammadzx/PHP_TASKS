<?php

require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = 0;
$name = "";
$email = "";
$phone = "";
$error = "";
$title = "Add user";

if (isset($_GET["id"])) {
    $id = filter_var(
        $_GET["id"],
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    if (!$id) {
        exit("Invalid user ID.");
    }

    $stmt = $pdo->prepare(
        "SELECT id, name, email, phone FROM users WHERE id = ?"
    );

    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user) {
        exit("User not found.");
    }

    $name = $user["name"];
    $email = $user["email"];
    $phone = $user["phone"];

    $title = "Edit user";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = strtolower(trim($_POST["email"] ?? ""));
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || $email === "" || $phone === "") {
        $error = "Name, email and phone are required.";
    } elseif (strlen($name) > 100) {
        $error = "Name is too long.";
    } elseif (
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($email) > 190
    ) {
        $error = "Enter a valid email.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "Phone must contain exactly 10 digits.";
    } elseif ($id === 0 && $password === "") {
        $error = "Password is required.";
    } elseif (
        $password !== "" &&
        (strlen($password) < 8 || strlen($password) > 72)
    ) {
        $error = "Password must be between 8 and 72 bytes.";
    } else {
        $stmt = $pdo->prepare(
            "SELECT id FROM users WHERE email = ? AND id != ?"
        );

        $stmt->execute([$email, $id]);

        if ($stmt->fetch()) {
            $error = "This email is already registered.";
        } else {
            try {
                if ($id === 0) {
                   
                    $hashedPassword = password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );

                    $stmt = $pdo->prepare(
                        "INSERT INTO users (name, email, phone, password)
                         VALUES (?, ?, ?, ?)"
                    );

                    $stmt->execute([
                        $name,
                        $email,
                        $phone,
                        $hashedPassword
                    ]);
                } elseif ($password === "") {
                    
                    $stmt = $pdo->prepare(
                        "UPDATE users
                         SET name = ?, email = ?, phone = ?
                         WHERE id = ?"
                    );

                    $stmt->execute([$name, $email, $phone, $id]);
                } else {
                    
                    $hashedPassword = password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );

                    $stmt = $pdo->prepare(
                        "UPDATE users
                         SET name = ?, email = ?, phone = ?, password = ?
                         WHERE id = ?"
                    );

                    $stmt->execute([
                        $name,
                        $email,
                        $phone,
                        $hashedPassword,
                        $id
                    ]);
                }

                header("Location: users.php");
                exit;
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $error = "This email is already registered.";
                } else {
                    throw $e;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($title) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">
    <h1><?= h($title) ?></h1>

    <?php if ($error !== ""): ?>
        <p class="error"><?= h($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input
            type="hidden"
            name="token"
            value="<?= h($_SESSION["token"]) ?>"
        >

        <label for="name">Full name</label>
        <input
            type="text"
            id="name"
            name="name"
            maxlength="100"
            value="<?= h($name) ?>"
            required
        >

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            maxlength="190"
            value="<?= h($email) ?>"
            required
        >

        <label for="phone">Phone</label>
        <input
            type="text"
            id="phone"
            name="phone"
            maxlength="10"
            pattern="[0-9]{10}"
            value="<?= h($phone) ?>"
            required
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            minlength="8"
            maxlength="72"
            <?= $id === 0 ? "required" : "" ?>
        >

        <?php if ($id !== 0): ?>
            <p class="hint">
                Leave password empty to keep the current password.
            </p>
        <?php endif; ?>

        <button type="submit">Save user</button>
        <a href="users.php" class="back-link">Cancel</a>
    </form>
</div>

</body>
</html>