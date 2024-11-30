<?php
require './includes/db.php';
require './includes/functions.php';

$id = $_GET['id'] ?? null;
$name = $email = '';

if ($id) {
    $user = fetchAll($pdo, 'SELECT * FROM users WHERE id = ?', [$id]);
    if ($user) {
        $name = $user[0]['name'];
        $email = $user[0]['email'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if ($id) {
        executeQuery($pdo, 'UPDATE users SET name = ?, email = ? WHERE id = ?', [$name, $email, $id]);
    } else {
        executeQuery($pdo, 'INSERT INTO users (name, email) VALUES (?, ?)', [$name, $email]);
    }
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title><?= $id ? 'Editar' : 'Adicionar' ?> Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4"><?= $id ? 'Editar' : 'Adicionar' ?> Usuário</h1>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
