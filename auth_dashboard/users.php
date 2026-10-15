<?php

require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT id, name FROM users WHERE id = ?");
$stmt->execute([$_SESSION["user_id"]]);
$currentUser = $stmt->fetch();

if (!$currentUser) {
    $_SESSION = [];
    session_destroy();

    header("Location: login.php");
    exit;
}

$_SESSION["user_name"] = $currentUser["name"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_var(
        $_POST["id"] ?? "",
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    $type = $_POST["type"] ?? "";

    if (!$id || ($type !== "user" && $type !== "product")) {
        exit("Invalid delete request.");
    }

    if ($type === "user") {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        
        if ($id == $_SESSION["user_id"]) {
            $_SESSION = [];
            session_destroy();

            header("Location: login.php");
            exit;
        }
    } else {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }

    header("Location: users.php");
    exit;
}


$stmt = $pdo->query(
    "SELECT id, name, email, phone FROM users ORDER BY id DESC"
);

$users = $stmt->fetchAll();


$stmt = $pdo->query(
    "SELECT id, name, description, price, quantity, created_at
     FROM products
     ORDER BY id DESC"
);

$products = $stmt->fetchAll();

$totalUsers = count($users);
$totalProducts = count($products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <header>
        <div>
            <h1>Dashboard</h1>
            <p>Welcome, <?= h($_SESSION["user_name"]) ?></p>
        </div>

        <form action="logout.php" method="post">
            <input
                type="hidden"
                name="token"
                value="<?= h($_SESSION["token"]) ?>"
            >
            <button type="submit" class="delete">Logout</button>
        </form>
    </header>

    <nav>
        <a href="#users">Users</a>
        <a href="#products">Products</a>
    </nav>

    <div class="stats">
        <div class="stat">
            <h2>Total users</h2>
            <p><?= $totalUsers ?></p>
        </div>

        <div class="stat">
            <h2>Total products</h2>
            <p><?= $totalProducts ?></p>
        </div>
    </div>

    <section class="card" id="users">
        <div class="section-heading">
            <h2>Users</h2>
            <a href="user-form.php" class="button">Add user</a>
        </div>

        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user["id"] ?></td>
                            <td><?= h($user["name"]) ?></td>
                            <td><?= h($user["email"]) ?></td>
                            <td><?= h($user["phone"]) ?></td>
                            <td>
                                <div class="actions">
                                    <a
                                        href="user-form.php?id=<?= $user["id"] ?>"
                                        class="button"
                                    >
                                        Edit
                                    </a>

                                    <form method="post">
                                        <input
                                            type="hidden"
                                            name="token"
                                            value="<?= h($_SESSION["token"]) ?>"
                                        >
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= $user["id"] ?>"
                                        >
                                        <input
                                            type="hidden"
                                            name="type"
                                            value="user"
                                        >
                                        <button type="submit" class="delete">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if ($totalUsers === 0): ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="card" id="products">
        <div class="section-heading">
            <h2>Products</h2>
            <a href="product-form.php" class="button">Add product</a>
        </div>

        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Created date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product["id"] ?></td>
                            <td><?= h($product["name"]) ?></td>
                            <td><?= h($product["description"]) ?></td>
                            <td><?= h($product["price"]) ?></td>
                            <td><?= $product["quantity"] ?></td>
                            <td><?= h($product["created_at"]) ?></td>
                            <td>
                                <div class="actions">
                                    <a
                                        href="product-form.php?id=<?= $product["id"] ?>"
                                        class="button"
                                    >
                                        Edit
                                    </a>

                                    <form method="post">
                                        <input
                                            type="hidden"
                                            name="token"
                                            value="<?= h($_SESSION["token"]) ?>"
                                        >
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= $product["id"] ?>"
                                        >
                                        <input
                                            type="hidden"
                                            name="type"
                                            value="product"
                                        >
                                        <button type="submit" class="delete">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if ($totalProducts === 0): ?>
                        <tr>
                            <td colspan="7">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</div>

</body>
</html>