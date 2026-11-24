<?php
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../layouts/header.php';

// Pega os parâmetros da URL
$catId = isset($_GET['cat']) ? (int)$_GET['cat'] : null;
$busca = $_GET['busca'] ?? null;

$products = Product::all($catId, $busca);
$categories = Category::all();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title m-0">Nossos Produtos</h2>
</div>

<!-- CAMPO DE BUSCA -->
<form method="GET" action="/" class="mb-4 d-flex gap-2">
    <input type="hidden" name="route" value="produtos">
    <?php if ($catId): ?><input type="hidden" name="cat" value="<?= $catId ?>"><?php endif; ?>
    <input type="text" name="busca" class="form-control bg-dark text-light border-secondary" placeholder="Buscar por nome ou descrição..." value="<?= htmlspecialchars($busca ?? '') ?>">
    <button type="submit" class="btn btn-primary px-4 fw-bold">Buscar</button>
</form>

<!-- BOTÕES DE FILTRO POR CATEGORIA -->
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="/?route=produtos" class="btn <?= $catId === null ? 'btn-primary' : 'btn-outline-secondary' ?>">
        Todos
    </a>
    <?php foreach ($categories as $cat): ?>
        <a href="/?route=produtos&cat=<?= $cat['id'] ?>" 
           class="btn <?= $catId === $cat['id'] ? 'btn-primary' : 'btn-outline-secondary' ?>">
            <?= htmlspecialchars($cat['name']) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- GRADE DE PRODUTOS -->
<div class="row g-4">
    <?php if (empty($products)): ?>
        <div class="col-12 text-center text-secondary mt-5">
            <h4>Nenhum produto encontrado.</h4>
            <a href="/?route=produtos" class="btn btn-outline-light mt-3">Limpar filtros</a>
        </div>
    <?php endif; ?>

    <?php foreach ($products as $p): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card card-produto h-100">
                <div class="img-container">
                    <!-- Se tiver imagem no banco, mostra. Senão, mostra o placeholder -->
                    <?php if (!empty($p['image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>">
                    <?php else: ?>
                        <img src="https://placehold.co/400x300/242831/a1a1aa?text=<?= urlencode($p['name']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>">
                    <?php endif; ?>
                </div>
                <div class="card-body d-flex flex-column p-4">
                    <span class="badge badge-categoria mb-2 align-self-start"><?= htmlspecialchars($p['category_name']) ?></span>
                    <h5 class="card-title mb-3"><?= htmlspecialchars($p['name']) ?></h5>
                    
                    <div class="mt-auto">
                        <h4 class="preco mb-3">R$ <?= number_format($p['price'], 2, ',', '.') ?></h4>
                        
                        <?php if ($p['stock'] > 0): ?>
                            <a href="/?route=produto&id=<?= $p['id'] ?>" class="btn btn-comprar w-100">Ver Detalhes</a>
                        <?php else: ?>
                            <button class="btn btn-secondary w-100" disabled>Esgotado</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>