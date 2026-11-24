<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../controllers/AuthController.php';

$erro = '';
$sucesso = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = authRegister($_POST['name'], $_POST['email'], $_POST['password']);
    if ($result['ok']) {
        $sucesso = 'Conta criada com sucesso! Faça login para continuar.';
    } else {
        $erro = $result['msg'];
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card bg-dark border-secondary p-4">
            <h3 class="text-center text-white mb-4">Criar Conta</h3>
            
            <?php if ($erro): ?><div class="alert alert-danger"><?= $erro ?></div><?php endif; ?>
            <?php if ($sucesso): ?><div class="alert alert-success"><?= $sucesso ?></div><?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="text-light">Nome Completo</label>
                    <input type="text" name="name" class="form-control bg-dark text-light border-secondary" required>
                </div>
                <div class="mb-3">
                    <label class="text-light">E-mail</label>
                    <input type="email" name="email" class="form-control bg-dark text-light border-secondary" required>
                </div>
                <div class="mb-4">
                    <label class="text-light">Senha</label>
                    <input type="password" name="password" class="form-control bg-dark text-light border-secondary" required>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold">Cadastrar</button>
            </form>
            
            <p class="text-center mt-3 text-secondary">
                Já tem conta? <a href="/?route=login" class="text-primary">Faça Login</a>
            </p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>