<?php
require './includes/db.php';
require './includes/functions.php';

$users = fetchAll($pdo, 'SELECT * FROM users');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CRUD Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Lista de Usuários</h1>
    <a href="user_form.php" class="btn btn-primary mb-3">Adicionar Usuário</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <a href="user_form.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Tem certeza?')">Excluir</a>
                    <a href="user_colors.php?id=<?= $user['id'] ?>" class="btn btn-secondary btn-sm">Gerenciar Cores</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
