
<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$host = 'localhost';
$dbname = 'registration_system';
$username = 'root';
$dbpassword = '';

$users = [];
$error = '';

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

    // Get all users
    $stmt = $pdo->prepare(
        "SELECT id, name, email, phone
         FROM users
         ORDER BY id DESC"
    );

    $stmt->execute();

    $users = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = 'Unable to load users. Please try again later.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Users | AuthSystem</title>

    <link rel="stylesheet" href="users.css">
</head>

<body>

    <main class="page-container">

        <!-- Header -->
        <header class="topbar">

            <a href="users.php" class="brand">
                <span class="brand-icon">A</span>
                <span>AuthSystem</span>
            </a>

            <div class="user-info">
                <div class="user-avatar">
                    <?= htmlspecialchars(
                        strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </div>

                <div class="user-details">
                    <span class="user-label">Signed in as</span>

                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION['user_name'] ?? 'User',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </strong>
                </div>

                <a href="logout.php" class="logout-btn">Logout</a>
            </div>

        </header>

        <!-- Page Heading -->
        <section class="page-heading">

            <div>
                <span class="eyebrow">DATABASE MANAGEMENT</span>

                <h1>Users Directory</h1>

                <p>
                    View all registered users and their account information.
                </p>
            </div>

            <div class="total-card">
                <span class="total-label">Total Users</span>

                <strong><?= count($users) ?></strong>

                <span class="total-description">
                    Registered accounts
                </span>
            </div>

        </section>

        <!-- Users Table -->
        <section class="users-card">

            <div class="table-heading">
                <div>
                    <h2>All Users</h2>
                    <p>Information retrieved from your database.</p>
                </div>

                <span class="users-badge">
                    <?= count($users) ?> users
                </span>
            </div>

            <?php if ($error !== ''): ?>

                <div class="error-message" role="alert">
                    <?= htmlspecialchars(
                        $error,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </div>

            <?php else: ?>

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (count($users) > 0): ?>

                                <?php foreach ($users as $user): ?>

                                    <tr>
                                        <td>
                                            <span class="id-badge">
                                                #<?= (int) $user['id'] ?>
                                            </span>
                                        </td>

                                        <td>
                                            <div class="name-cell">

                                                <div class="table-avatar">
                                                    <?= htmlspecialchars(
                                                        strtoupper(
                                                            substr(
                                                                $user['name'],
                                                                0,
                                                                1
                                                            )
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>
                                                </div>

                                                <span class="user-name">
                                                    <?= htmlspecialchars(
                                                        $user['name'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>
                                                </span>

                                            </div>
                                        </td>

                                        <td>
                                            <span class="email-text">
                                                <?= htmlspecialchars(
                                                    $user['email'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="phone-text">
                                                <?= htmlspecialchars(
                                                    $user['phone'] ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </span>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="4" class="empty-state">
                                        No users have been registered yet.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

            <div class="table-footer">
                Showing <?= count($users) ?> registered users
            </div>

        </section>

        <footer class="page-footer">
            &copy; <?= date('Y') ?> AuthSystem. All rights reserved.
        </footer>

    </main>

</body>
</html>
