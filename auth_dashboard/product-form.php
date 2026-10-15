<?php

require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = 0;
$name = "";
$description = "";
$price = "";
$quantity = "";
$error = "";
$title = "Add product";

if (isset($_GET["id"])) {
    $id = filter_var(
        $_GET["id"],
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    if (!$id) {
        exit("Invalid product ID.");
    }

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        exit("Product not found.");
    }

    $name = $product["name"];
    $description = $product["description"];
    $price = $product["price"];
    $quantity = $product["quantity"];

    $title = "Edit product";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = trim($_POST["price"] ?? "");
    $quantity = trim($_POST["quantity"] ?? "");

    $validQuantity = filter_var(
        $quantity,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 0, "max_range" => 2147483647]]
    );

    if (
        $name === "" ||
        $description === "" ||
        $price === "" ||
        $quantity === ""
    ) {
        $error = "All fields are required.";
    } elseif (strlen($name) > 150) {
        $error = "Product name is too long.";
    } elseif (strlen($description) > 10000) {
        $error = "Description is too long.";
    } elseif (
        !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $price) ||
        $price > 99999999.99
    ) {
        $error = "Enter a valid price with up to two decimal places.";
    } elseif ($validQuantity === false) {
        $error = "Quantity must be a whole number of zero or more.";
    } else {
        if ($id === 0) {
            $stmt = $pdo->prepare(
                "INSERT INTO products (name, description, price, quantity)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->execute([
                $name,
                $description,
                $price,
                $validQuantity
            ]);
        } else {
            $stmt = $pdo->prepare(
                "UPDATE products
                 SET name = ?, description = ?, price = ?, quantity = ?
                 WHERE id = ?"
            );

            $stmt->execute([
                $name,
                $description,
                $price,
                $validQuantity,
                $id
            ]);
        }

        header("Location: users.php");
        exit;
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

        <label for="name">Product name</label>
        <input
            type="text"
            id="name"
            name="name"
            maxlength="150"
            value="<?= h($name) ?>"
            required
        >

        <label for="description">Description</label>
        <textarea
            id="description"
            name="description"
            rows="5"
            maxlength="10000"
            required
        ><?= h($description) ?></textarea>

        <label for="price">Price</label>
        <input
            type="number"
            id="price"
            name="price"
            min="0"
            max="99999999.99"
            step="0.01"
            value="<?= h($price) ?>"
            required
        >

        <label for="quantity">Quantity</label>
        <input
            type="number"
            id="quantity"
            name="quantity"
            min="0"
            max="2147483647"
            step="1"
            value="<?= h($quantity) ?>"
            required
        >

        <button type="submit">Save product</button>
        <a href="users.php" class="back-link">Cancel</a>
    </form>
</div>

</body>
</html>