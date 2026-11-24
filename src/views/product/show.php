<?php
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../helpers/cart.php';
require_once __DIR__ . '/../layouts/header.php';

$id = $_GET['id'] ?? 0;
$product = Product::find($id);

if (!$product) {
    echo "<div class='alert alert-danger'>Produto não encontrado.</div>";
    require_once __DIR__ . '/../layouts/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $qty = (int)($_POST['quantity'] ?? 1);
    cartAdd($product['id'], $qty);
    echo "<div class='alert alert-success fw-bold'>✅ Produto adicionado! <a href='/?route=carrinho' class='alert-link'>Ir para o carrinho</a></div>";
}

$parcela = $product['price'] / 12;
?>

<div class="row mt-4">
    <div class="col-md-5">
        <div class="card bg-dark border-secondary p-3 text-center">
            <!-- AQUI ESTÁ A CORREÇÃO DA IMAGEM -->
            <?php if (!empty($product['image'])): ?>
                <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['name']) ?>">
            <?php else: ?>
                <img src="https://placehold.co/600x400/242831/a1a1aa?text=<?= urlencode($product['name']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['name']) ?>">
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-7">
        <span class="badge badge-categoria mb-2"><?= htmlspecialchars($product['category_name']) ?></span>
        <h1 class="text-white fw-bold mb-2"><?= htmlspecialchars($product['name']) ?></h1>
        <p class="text-secondary mb-4"><?= htmlspecialchars($product['description']) ?></p>

        <div class="bg-dark border border-secondary p-4 rounded mb-4">
            <h2 class="text-success fw-bold mb-1">R$ <?= number_format($product['price'], 2, ',', '.') ?></h2>
            <p class="text-light mb-0">
                ou <strong>12x de R$ <?= number_format($parcela, 2, ',', '.') ?></strong> sem juros
            </p>
        </div>

        <form method="POST" class="mb-4">
            <div class="row align-items-end">
                <div class="col-4">
                    <label class="text-light mb-1">Quantidade</label>
                    <input type="number" name="quantity" class="form-control bg-dark text-light border-secondary" value="1" min="1" max="<?= $product['stock'] ?>" <?= $product['stock'] == 0 ? 'disabled' : '' ?>>
                </div>
                <div class="col-8">
                    <?php if ($product['stock'] > 0): ?>
                        <button type="submit" name="add_to_cart" class="btn btn-primary btn-lg w-100 fw-bold">🛒 Adicionar ao Carrinho</button>
                    <?php else: ?>
                        <button type="button" class="btn btn-danger btn-lg w-100 fw-bold" disabled>Produto Esgotado</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <div class="mt-4 border-top border-secondary pt-3">
            <p class="text-secondary mb-2">Formas de pagamento aceitas:</p>
            <div class="d-flex gap-3">
                <span class="badge bg-light text-dark p-2">💳 Cartão de Crédito</span>
                <span class="badge bg-light text-dark p-2">⚡ PIX</span>
                <span class="badge bg-light text-dark p-2">📄 Boleto</span>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>