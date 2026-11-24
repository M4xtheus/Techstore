<?php
require_once __DIR__ . '/../layouts/header.php';

$method = $_GET['method'] ?? '';
$total = $_GET['total'] ?? '0.00';

if (!in_array($method, ['pix', 'cartao', 'boleto'])) {
    echo "<div class='alert alert-danger mt-5'>Método de pagamento inválido.</div>";
    require_once __DIR__ . '/../layouts/footer.php';
    exit;
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card bg-dark border-secondary p-4 text-center">
            
            <?php if ($method === 'pix'): ?>
                <h3 class="text-success fw-bold mb-3">Pagamento via PIX</h3>
                <p class="text-light">Escaneie o QR Code abaixo:</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=chavepix123" class="mx-auto mb-3 rounded" alt="QR Code PIX">
                <p class="text-secondary small">Chave: 123.456.789-00 (TechStore)</p>
                
            <?php elseif ($method === 'cartao'): ?>
                <h3 class="text-primary fw-bold mb-4">Cartão de Crédito</h3>
                
                <!-- Formulário com Labels -->
                <form class="text-start">
                    <div class="mb-3">
                        <label class="form-label text-light">Número do Cartão</label>
                        <input type="text" class="form-control bg-dark text-light border-secondary" placeholder="0000 0000 0000 0000" maxlength="19" oninput="mascaraCartao(this)">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-light">Nome Impresso no Cartão</label>
                        <input type="text" class="form-control bg-dark text-light border-secondary" placeholder="Como está escrito no cartão">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-light">Validade (MM/AA)</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" placeholder="MM/AA" maxlength="5" oninput="mascaraValidade(this)">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-light">Código de Segurança (CVV)</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" placeholder="Ex: 123" maxlength="3">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-light">Parcelamento</label>
                        <select class="form-select bg-dark text-light border-secondary">
                            <option>1x de R$ <?= number_format((float)$total, 2, ',', '.') ?> (Sem juros)</option>
                            <option>2x de R$ <?= number_format((float)$total / 2, 2, ',', '.') ?> (Sem juros)</option>
                            <option>3x de R$ <?= number_format((float)$total / 3, 2, ',', '.') ?> (Sem juros)</option>
                            <option>6x de R$ <?= number_format((float)$total / 6, 2, ',', '.') ?> (Sem juros)</option>
                            <option>12x de R$ <?= number_format((float)$total / 12, 2, ',', '.') ?> (Sem juros)</option>
                        </select>
                    </div>
                </form>

            <?php elseif ($method === 'boleto'): ?>
                <h3 class="text-warning fw-bold mb-3">Boleto Bancário</h3>
                <p class="text-light">O boleto será gerado no valor de <strong>R$ <?= number_format((float)$total, 2, ',', '.') ?></strong>.</p>
                <div class="bg-light text-dark p-2 rounded mb-3 text-start" style="font-family: monospace;">
                    12345.67890 12345.678901 12345.678901 1 12345678901234
                </div>
                <p class="text-secondary small">Vencimento em 3 dias úteis.</p>
            <?php endif; ?>

            <!-- BOTÃO DE CONFIRMAR -->
            <a href="/?route=finalizar_pagamento&method=<?= $method ?>" class="btn btn-success btn-lg w-100 fw-bold mt-4">Confirmar Pagamento</a>
            <a href="/?route=carrinho" class="btn btn-outline-light w-100 mt-2">Voltar ao Carrinho</a>
        </div>
    </div>
</div>

<!-- SCRIPT PARA AS MÁSCARAS -->
<script>
    function mascaraCartao(input) {
        let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número
        value = value.replace(/(\d{4})(?=\d)/g, '$1 '); // Adiciona espaço a cada 4 dígitos
        input.value = value;
    }

    function mascaraValidade(input) {
        let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número
        if (value.length > 2) {
            value = value.slice(0, 2) + '/' + value.slice(2); // Adiciona a barra após o mês
        }
        input.value = value;
    }
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>