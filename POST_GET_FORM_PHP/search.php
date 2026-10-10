
<?php
$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
</head>
<body>

    <h1>Search</h1>

    <form action="search.php" method="GET">
        <input type="text" name="search" placeholder="Enter your search..." value="<?= htmlspecialchars($search) ?>">

        <button type="submit">Search</button>
    </form>

    <?php if ($search !== ""): ?>
        <h2>
            Search result for:
            <?= htmlspecialchars($search) ?>
        </h2>
    <?php endif; ?>

</body>
</html>
