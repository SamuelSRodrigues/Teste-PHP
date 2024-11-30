<?php
require './includes/db.php';
require './includes/functions.php';

$userId = $_GET['id'] ?? null;

if (!$userId) {
    die('ID do usuário não fornecido.');
}

$user = fetchAll($pdo, 'SELECT * FROM users WHERE id = ?', [$userId]);
if (!$user) {
    die('Usuário não encontrado.');
}

$allColors = fetchAll($pdo, 'SELECT * FROM colors');

$userColors = fetchAll($pdo, 'SELECT color_id FROM user_colors WHERE user_id = ?', [$userId]);
$userColorIds = array_column($userColors, 'color_id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedColors = $_POST['colors'] ?? [];

    executeQuery($pdo, 'DELETE FROM user_colors WHERE user_id = ?', [$userId]);

    foreach ($selectedColors as $colorId) {
        executeQuery($pdo, 'INSERT INTO user_colors (user_id, color_id) VALUES (?, ?)', [$userId, $colorId]);
    }

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Gerenciar Cores - <?= htmlspecialchars($user[0]['name']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Gerenciar Cores - <?= htmlspecialchars($user[0]['name']) ?></h1>
    <form method="post">
        <div class="mb-3">
            <label for="colors" class="form-label">Cores Disponíveis</label>
            <div>
                <?php foreach ($allColors as $color): ?>
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="colors[]" 
                            value="<?= $color['id'] ?>" 
                            id="color-<?= $color['id'] ?>" 
                            <?= in_array($color['id'], $userColorIds) ? 'checked' : '' ?>
                        >
                        <label class="form-check-label" for="color-<?= $color['id'] ?>">
                            <?= htmlspecialchars($color['name']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
