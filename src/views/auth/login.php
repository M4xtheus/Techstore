<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../controllers/AuthController.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (authLogin($_POST['email'], $_POST['password'])) {
        header('Location: /'); // Se logar, vai para a home
        exit;
    } else {
        $erro = 'E-mail ou senha incorretos.';
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card bg-dark border-secondary p-4">
            <h3 class="text-center text-white mb-4">Entrar na Conta</h3>
            
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?= $erro ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="text-light">E-mail</label>
                    <input type="email" name="email" class="form-control bg-dark text-light border-secondary" required>
                </div>
                <div class="mb-4">
                    <label class="text-light">Senha</label>
                    <input type="password" name="password" class="form-control bg-dark text-light border-secondary" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Entrar</button>
            </form>
            
            <p class="text-center mt-3 text-secondary">
                Não tem conta? <a href="/?route=cadastro" class="text-primary">Cadastre-se</a>
            </p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>