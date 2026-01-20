<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/tomtroc/public/css/style.css">
</head>
<body>
    <?php require __DIR__ . '/header.php'; ?>

    <main class="page-content">
        <?php require __DIR__ . '/../' . $view . '.php'; ?>
    </main>

    <?php require __DIR__ . '/footer.php'; ?>
</body>
</html>