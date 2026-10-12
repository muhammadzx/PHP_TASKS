<?php
declare(strict_types=1);

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$password = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";
$terms=$_POST["terms"] ?? "";


function validateForm($name,$email,$phone,$password,$confirm_password,$terms){
   
    if ($name === '' || $email === '' || $phone === '' || $password === '' || $confirm_password === '') {
        return "All fields are required.";
    }

   
    if (strlen($name) < 3) {
        return "Name must be at least 3 characters.";
    }

    if (!preg_match("/^[\p{L}\s'-]+$/u", $name)) {
        return "Name can only contain letters, spaces, hyphens, and apostrophes.";
    }

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email address.";
    }

   
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        return "Phone number must contain exactly 10 digits.";
    }

   
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters.";
    }

   
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain at least one uppercase letter.";
    }

    
    if (!preg_match('/[a-z]/', $password)) {
        return "Password must contain at least one lowercase letter.";
    }

    
    if (!preg_match('/[0-9]/', $password)) {
        return "Password must contain at least one number.";
    }

    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        return "Password must contain at least one special character.";
    }

    if ($password !== $confirm_password) {
        return "Passwords do not match.";
    }

    if (!$terms) {
        return "You must accept the Terms of Service and Privacy Policy.";
    }

    return true;
}

$host = 'localhost';
$dbname = 'registration_system';
$username = 'root';
$dbpassword = '';

$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $username,
    $dbpassword,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | AuthSystem</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="auth-page">

        <section class="auth-card">

            <a href="login.html" class="brand">
                <span class="brand-icon">A</span>
                <span>AuthSystem</span>
            </a>

            <div class="auth-heading">
                <div class="heading-icon">✦</div>
                <h1>Create an account</h1>
                <p>Join us today. It only takes a minute.</p>
            </div>
            <div class = "displayError">
                
<?php                    

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validation = validateForm($name, $email, $phone, $password, $confirm_password,$terms);

    if ($validation !== true) {
        echo '<p class = "form-error">' .  htmlspecialchars($validation) . '</p>';
    } else {

        $stmt = $pdo->prepare(
            "SELECT id FROM users WHERE email = :email"
        );

        $stmt->execute([
            'email' => $email
        ]);

        if ($stmt->fetch()) {
            echo ' <p class = "form-error"> This email is already registered. </p>';
        } else {
            echo '<p class = "form-error"> Email is valid and available. </p>';
            $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (name ,email ,phone ,password)
            VALUES (:name, :email, :phone, :password)");

            $stmt->execute([
             'name' => $name,
             'email' => $email,
             'phone' => $phone,
             'password' => $hashedPassword]);

             header('Location: login.php');
             exit;
        }
    }
}?>
                </div>
            <form action="register.php" method="POST" class="auth-form">

                <div class="form-group">
                    <label for="name">Full name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your full name"
                        autocomplete="name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        autocomplete="email"
                        required
                    >
                </div>

                 <div class="form-group">
                    <label for="phone">phone</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        placeholder="your phone number"
                        maxlength="10"
                        required
                    >
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a strong password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                    <small class="input-hint">
                        Use at least 8 characters.
                    </small>
                </div>

               

                <div class="form-group">
                    <label for="confirm-password">
                        Confirm password
                    </label>
                    <input
                        type="password"
                        id="confirm-password"
                        name="confirm_password"
                        placeholder="Enter your password again"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                </div>

                <label class="checkbox-row">
                    <input type="checkbox" name="terms" required>
                    <span>
                        I agree to the
                        <span class="highlight-text">Terms of Service</span>
                        and
                        <span class="highlight-text">Privacy Policy</span>.
                    </span>
                </label>

                <button type="submit" class="auth-button">
                    Create account
                    <span aria-hidden="true">→</span>
                </button>

            </form>

            <div class="auth-footer">
                Already have an account?
                <a href="login.php">Sign in</a>
            </div>

            <p class="security-note">
                <span aria-hidden="true">🔒</span>
                Your information is kept secure.
            </p>

        </section>

        <aside class="auth-decoration">
            <div class="decoration-content">
                <span class="eyebrow">SIMPLE. SECURE. SMART.</span>
                <h2>Your journey<br>starts here.</h2>
                <p>
                    Create your account and enjoy a simple,
                    secure way to manage your access.
                </p>

                <div class="feature-item">
                    <span class="feature-check">✓</span>
                    Easy account setup
                </div>

                <div class="feature-item">
                    <span class="feature-check">✓</span>
                    Secure authentication
                </div>

                <div class="feature-item">
                    <span class="feature-check">✓</span>
                    Your account, your control
                </div>
            </div>

            <div class="decoration-orb orb-one"></div>
            <div class="decoration-orb orb-two"></div>
        </aside>

    </main>
</body>
</html>


