<?php

require "config.php";

$name = "";
$email = "";
$phone = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = strtolower(trim($_POST["email"] ?? ""));
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if (
        $name === "" ||
        $email === "" ||
        $phone === "" ||
        $password === ""
    ) {
        $error = "All fields are required.";
    } elseif (strlen($name) > 100) {
        $error = "Name is too long.";
    } elseif (
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($email) > 190
    ) {
        $error = "Enter a valid email.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "Phone must contain exactly 10 digits.";
    } elseif (strlen($password) < 8 || strlen($password) > 72) {
        $error = "Password must be between 8 and 72 bytes.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = "This email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO users (name, email, phone, password)
                     VALUES (?, ?, ?, ?)"
                );

                $stmt->execute([$name, $email, $phone, $hashedPassword]);

                header("Location: login.php");
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
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">
    <h1>Create account</h1>

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
            required
        >

        <label for="confirm_password">Confirm password</label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            minlength="8"
            maxlength="72"
            required
        >

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>