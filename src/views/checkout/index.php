<?php
require_once __DIR__ . '/../../helpers/cart.php';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../models/Product.php';

cartInit();

if (empty($_SESSION['cart'])) {
    echo "<div class='alert alert-warning text-center mt-5 text-dark'>Seu carrinho está vazio. <a href='/' class='alert-link'>Voltar à loja</a></div>";
    require_once __DIR__ . '/../layouts/footer.php';
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-danger text-center mt-5 text-dark'>Você precisa estar logado para finalizar a compra. <a href='/?route=login' class='alert-link'>Entrar agora</a></div>";
    require_once __DIR__ . '/../layouts/footer.php';
    exit;
}

$items = [];
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $p = Product::find($id);
    if ($p) {
        $p['qty'] = $qty;
        $p['subtotal'] = $p['price'] * $qty;
        $total += $p['subtotal'];
        $items[] = $p;
    }
}

$erro = '';

// Se o formulário de checkout for enviado, redireciona para a tela de pagamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentMethod = $_POST['payment_method'] ?? '';
    if (in_array($paymentMethod, ['pix', 'boleto', 'cartao'])) {
        header("Location: /?route=pagamento&method=" . $paymentMethod . "&total=" . $total);
        exit;
    } else {
        $erro = "Selecione uma forma de pagamento válida.";
    }
}
?>

<h2 class="page-title">Finalizar Compra</h2>

<?php if ($erro): ?>
    <div class="alert alert-danger text-dark"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="row mt-4">
    <div class="col-md-7">
        <div class="card bg-dark border-secondary p-4 mb-4">
            <h4 class="text-white mb-3">Resumo do Pedido</h4>
            <?php foreach ($items as $item): ?>
                <div class="d-flex justify-content-between text-light mb-2 border-bottom border-secondary pb-2">
                    <span><?= $item['qty'] ?>x <?= htmlspecialchars($item['name']) ?></span>
                    <span>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></span>
                </div>
            <?php endforeach; ?>
            <div class="d-flex justify-content-between text-white fs-5 fw-bold mt-3">
                <span>Total:</span>
                <span class="text-success">R$ <?= number_format($total, 2, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card bg-dark border-secondary p-4">
            <h4 class="text-white mb-3">Forma de Pagamento</h4>
            <form method="POST">
                <div class="form-check mb-3 p-3 border border-secondary rounded">
                    <input class="form-check-input" type="radio" name="payment_method" value="pix" id="pix" checked>
                    <label class="form-check-label text-light w-100" for="pix">
                        <strong>⚡ PIX</strong><br><small class="text-secondary">Aprovação imediata</small>
                    </label>
                </div>
                <div class="form-check mb-3 p-3 border border-secondary rounded">
                    <input class="form-check-input" type="radio" name="payment_method" value="cartao" id="cartao">
                    <label class="form-check-label text-light w-100" for="cartao">
                        <strong>💳 Cartão de Crédito</strong><br><small class="text-secondary">Até 12x sem juros</small>
                    </label>
                </div>
                <div class="form-check mb-4 p-3 border border-secondary rounded">
                    <input class="form-check-input" type="radio" name="payment_method" value="boleto" id="boleto">
                    <label class="form-check-label text-light w-100" for="boleto">
                        <strong>📄 Boleto</strong><br><small class="text-secondary">Vence em 3 dias</small>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Ir para Pagamento</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>