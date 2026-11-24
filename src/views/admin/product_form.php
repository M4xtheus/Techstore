<?php
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../layouts/header.php';

$id = $_GET['id'] ?? null;
$product = null;
$isEdit = false;

if ($id) {
    $stmt = db()->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch();
    $isEdit = true;
}

$cats = db()->query("SELECT * FROM categories")->fetchAll();
?>

<h2 class="page-title mb-4"><?= $isEdit ? 'Editar Produto' : 'Novo Produto' ?></h2>

<div class="card bg-dark border-secondary p-4">
    <!-- O enctype é OBRIGATÓRIO para upload de arquivos -->
    <form method="POST" action="/?route=admin_produto_salvar" enctype="multipart/form-data">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <input type="hidden" name="old_image" value="<?= $product['image'] ?? '' ?>">
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="text-light">Nome do Produto</label>
                <input type="text" name="name" class="form-control bg-dark text-light border-secondary" value="<?= $product['name'] ?? '' ?>" required>
            </div>
            <div class="col-md-3">
                <label class="text-light">Preço (R$)</label>
                <input type="number" step="0.01" name="price" class="form-control bg-dark text-light border-secondary" value="<?= $product['price'] ?? '' ?>" required>
            </div>
            <div class="col-md-3">
                <label class="text-light">Estoque</label>
                <input type="number" name="stock" class="form-control bg-dark text-light border-secondary" value="<?= $product['stock'] ?? '' ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="text-light">Categoria</label>
                <select name="category_id" class="form-select bg-dark text-light border-secondary" required>
                    <?php foreach ($cats as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= (isset($product['category_id']) && $product['category_id'] == $c['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-8">
                <label class="text-light">Descrição</label>
                <textarea name="description" class="form-control bg-dark text-light border-secondary" rows="2" required><?= $product['description'] ?? '' ?></textarea>
            </div>
        </div>

        <!-- AQUI ESTÁ O CAMPO DE IMAGEM -->
        <div class="mb-4">
            <label class="text-light">Imagem do Produto (Opcional)</label>
            <input type="file" name="image" class="form-control bg-dark text-light border-secondary" accept="image/*">
            <?php if ($isEdit && !empty($product['image'])): ?>
                <small class="text-success d-block mt-1">Imagem atual: <?= htmlspecialchars($product['image']) ?></small>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-success fw-bold w-100"><?= $isEdit ? 'Salvar Alterações' : 'Cadastrar Produto' ?></button>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>