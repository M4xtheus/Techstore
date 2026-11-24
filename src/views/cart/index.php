<?php
require_once __DIR__ . '/../../helpers/cart.php';
require_once __DIR__ . '/../layouts/header.php';

$cartData = cartItems();
$items = $cartData['items'];
$total = $cartData['total'];
?>

<h2 class="page-title">Seu Carrinho</h2>

<?php if (empty($items)): ?>
    <div class="alert alert-info text-dark mt-4">
        Seu carrinho está vazio. <a href="/" class="alert-link">Voltar às compras</a>
    </div>
<?php else: ?>
    <div class="row mt-4">
        <div class="col-md-8">
            <?php foreach ($items as $item): ?>
                <div class="card bg-dark border-secondary mb-3">
                    <div class="card-body d-flex align-items-center">
                        <img src="https://placehold.co/100x100/242831/a1a1aa?text=IMG" class="rounded me-3" width="80">
                        <div class="flex-grow-1">
                            <h5 class="text-white mb-1"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="text-success mb-0" id="price-<?= $item['id'] ?>">R$ <?= number_format($item['price'], 2, ',', '.') ?></p>
                        </div>
                        
                        <div class="d-flex align-items-center me-3">
                            <input type="number" id="qty-<?= $item['id'] ?>" value="<?= $item['qty'] ?>" min="1" max="<?= $item['stock'] ?>" class="form-control bg-dark text-light border-secondary me-2" style="width: 80px;" onchange="atualizarItem(<?= $item['id'] ?>, this.value)">
                        </div>
                        
                        <div class="text-end me-3" style="width: 120px;">
                            <strong class="text-white fs-5" id="subtotal-<?= $item['id'] ?>">R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></strong>
                        </div>
                        
                        <a href="/?route=carrinho&remove=<?= $item['id'] ?>" class="btn btn-outline-danger btn-sm">🗑️</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-4">
                <h4 class="text-white mb-3">Resumo</h4>
                <div class="d-flex justify-content-between text-white fs-5 fw-bold mb-4">
                    <span>Total:</span>
                    <span class="text-success" id="total-geral">R$ <?= number_format($total, 2, ',', '.') ?></span>
                </div>
                <a href="/?route=checkout" class="btn btn-primary w-100 fw-bold py-2">Finalizar Compra</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
function atualizarItem(productId, novaQty) {
    document.getElementById('total-geral').innerText = 'Calculando...';
    
    fetch('/?route=atualizar_carrinho', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${productId}&qty=${novaQty}`
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('total-geral').innerText = 'R$ ' + data.total_formatado;
        document.getElementById(`subtotal-${productId}`).innerText = 'R$ ' + data.subtotal_formatado;
        
        if (data.qty_ajustada && document.getElementById(`qty-${productId}`).value != data.qty_ajustada) {
            document.getElementById(`qty-${productId}`).value = data.qty_ajustada;
            alert('Quantidade ajustada ao limite do estoque disponível!');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        document.getElementById('total-geral').innerText = 'Erro ao calcular';
    });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>