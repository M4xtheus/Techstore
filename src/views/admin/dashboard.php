<?php
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../layouts/header.php';

// Busca todos os produtos (incluindo os inativos)
$stmt = db()->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title m-0">Painel Administrativo</h2>
    <a href="/?route=admin_produto_novo" class="btn btn-success fw-bold">+ Novo Produto</a>
</div>

<div class="card bg-dark border-secondary p-4">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td>R$ <?= number_format($p['price'], 2, ',', '.') ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td>
                        <a href="/?route=admin_produto_editar&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="/?route=admin_produto_deletar&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>