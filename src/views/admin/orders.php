<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../layouts/header.php';

// Busca todos os pedidos com o nome e email do cliente
$stmt = db()->query("
    SELECT o.*, u.name AS client_name, u.email AS client_email 
    FROM orders o 
    JOIN users u ON u.id = o.user_id 
    ORDER BY o.id DESC
");
$orders = $stmt->fetchAll();
?>

<h2 class="page-title mb-4">Histórico de Pedidos</h2>

<div class="card bg-dark border-secondary p-4">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>Pedido</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Pagamento</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $o): ?>
                <tr>
                    <td><strong>#<?= $o['id'] ?></strong></td>
                    <td>
                        <?= htmlspecialchars($o['client_name']) ?><br>
                        <small class="text-secondary"><?= htmlspecialchars($o['client_email']) ?></small>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
                    <td class="text-uppercase"><?= $o['payment_method'] ?></td>
                    <td class="text-success fw-bold">R$ <?= number_format($o['total'], 2, ',', '.') ?></td>
                    <td><span class="badge bg-success"><?= $o['status'] ?></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>