
<?php
session_start();

$email = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $host = 'localhost';
    $dbname = 'registration_system';
    $username = 'root';
    $dbpassword = '';

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $username,
            $dbpassword,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

        $stmt = $pdo->prepare(
            "SELECT id, name, email, password
             FROM users
             WHERE email = :email"
        );

        $stmt->execute([
            'email' => $email
        ]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            header('Location: users.php');
            exit;

        } else {
            $error = 'Invalid email or password.';
        }

    } catch (PDOException $e) {
        $error = 'Something went wrong. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | AuthSystem</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <main class="auth-page">

        <section class="auth-card">

            <a href="register.php" class="brand">
                <span class="brand-icon">A</span>
                <span>AuthSystem</span>
            </a>

            <div class="auth-heading">
                <div class="heading-icon">✦</div>
                <h1>Welcome back</h1>
                <p>Enter your details to access your account.</p>
            </div>

            <?php if ($error !== ''): ?>
                <div class="displayError">
                    <p class="form-error">
                        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="auth-form">

                <div class="form-group">
                    <label for="email">Email address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        autocomplete="email"
                        value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <div class="label-row">
                        <label for="password">Password</label>
                    </div>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <label class="checkbox-row remember-row">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                <button type="submit" class="auth-button">
                    Sign in
                    <span aria-hidden="true">→</span>
                </button>

            </form>

            <div class="auth-footer">
                Don't have an account?
                <a href="register.php">Create account</a>
            </div>

            <p class="security-note">
                <span aria-hidden="true">🔒</span>
                Your information is kept secure.
            </p>

        </section>

        <aside class="auth-decoration">

            <div class="decoration-content">
                <span class="eyebrow">WELCOME BACK</span>

                <h2>Good to see<br>you again.</h2>

                <p>
                    Sign in to continue where you left off.
                    Your account is waiting for you.
                </p>

                <div class="feature-item">
                    <span class="feature-check">✓</span>
                    Simple and secure access
                </div>

                <div class="feature-item">
                    <span class="feature-check">✓</span>
                    Access your personal account
                </div>

                <div class="feature-item">
                    <span class="feature-check">✓</span>
                    Get started in seconds
                </div>
            </div>

            <div class="decoration-orb orb-one"></div>
            <div class="decoration-orb orb-two"></div>

        </aside>

    </main>

</body>
</html>
