<?php
require_once __DIR__ . '/../layouts/header.php';
$orderId = $_GET['id'] ?? '0';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 text-center">
        <div class="card bg-dark border-success p-5" style="box-shadow: 0 0 20px rgba(25, 135, 84, 0.3);">
            <h1 class="text-success display-1 mb-3">🎉</h1>
            <h2 class="text-white fw-bold mb-3">Pagamento Confirmado!</h2>
            <p class="text-light fs-5 mb-4">
                O seu pedido <strong>#<?= htmlspecialchars($orderId) ?></strong> foi aprovado e já está sendo preparado.
            </p>
            <p class="text-secondary mb-5">
                Enviamos os detalhes para o seu e-mail. Obrigado por comprar na TechStore!
            </p>
            
            <a href="/" class="btn btn-primary btn-lg w-100 fw-bold mb-2">Voltar ao Catálogo</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>