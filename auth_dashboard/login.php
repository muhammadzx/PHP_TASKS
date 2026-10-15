<?php

require "config.php";

if (isset($_SESSION["user_id"])) {
    header("Location: users.php");
    exit;
}

$email = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare(
        "SELECT id, name, email, password
         FROM users
         WHERE email = ?"
    );

    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["user_email"] = $user["email"];

        header("Location: users.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">
    <h1>Login</h1>

    <?php if ($error !== ""): ?>
        <p class="error"><?= h($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input
            type="hidden"
            name="token"
            value="<?= h($_SESSION["token"]) ?>"
        >

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= h($email) ?>"
            required
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>

</body>
</html>