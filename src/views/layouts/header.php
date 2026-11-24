<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Os melhores eletrônicos</title>
    
    <?php 
    // Descobre automaticamente a URL base (funciona no localhost:8000 e no localhost/techstore/public)
    $baseUrl = (strpos($_SERVER['REQUEST_URI'], '/techstore') !== false) ? '/techstore/public' : ''; 
    ?>
    
    <!-- FAVICON PERSONALIZADO -->
    <link rel="icon" type="image/png" href="<?= $baseUrl ?>/assets/img/favicontechstore.png">
    
    <!-- Bootstrap 5 (CSS) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Nosso CSS -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-5 sticky-top">
    <div class="container">
        <!-- Logo no menu -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $baseUrl ?>/">
            <img src="<?= $baseUrl ?>/assets/img/favicontechstore.png" alt="Logo TechStore" width="30" height="30" class="d-inline-block align-text-top">
            TechStore
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Links da Esquerda -->
            <ul class="navbar-nav me-auto">
                <!-- Link do Catálogo removido. A logo à esquerda já faz esse papel. -->
                
                <!-- Painel Admin (só aparece para admin) -->
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link text-warning fw-bold" href="<?= $baseUrl ?>/?route=admin">⚙️ Painel Admin</a></li>
                    <li class="nav-item"><a class="nav-link text-warning fw-bold" href="<?= $baseUrl ?>/?route=admin_pedidos">📦 Pedidos</a></li>
                <?php endif; ?>
            </ul>

            <!-- Links da Direita -->
            <ul class="navbar-nav align-items-center">
                <!-- Carrinho -->
                <li class="nav-item me-2">
                    <a class="btn btn-outline-light px-3" href="<?= $baseUrl ?>/?route=carrinho">🛒 Carrinho</a>
                </li>

                <!-- Login / Perfil -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light mt-1" href="#" role="button" data-bs-toggle="dropdown">
                            Olá, <?= explode(' ', $_SESSION['user_name'])[0] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="<?= $baseUrl ?>/?route=logout">Sair</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary px-4 fw-bold" href="<?= $baseUrl ?>/?route=login">Entrar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container min-vh-100 pb-5">