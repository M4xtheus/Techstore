<?php
// public/index.php
session_start();

$route = $_GET['route'] ?? 'home';

// ==========================================
// ROTAS DA LOJA (FRONTEND)
// ==========================================
if ($route === 'home' || $route === 'produtos') {
    require_once __DIR__ . '/../src/views/product/list.php';
} 
else if ($route === 'produto') {
    require_once __DIR__ . '/../src/views/product/show.php';
} 
else if ($route === 'carrinho') {
    require_once __DIR__ . '/../src/views/cart/index.php';
} 
else if ($route === 'atualizar_carrinho') {
    require_once __DIR__ . '/../src/helpers/cart.php';
    require_once __DIR__ . '/../src/models/Product.php';
    cartInit();
    
    $id = (int)($_POST['id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);
    
    if ($id > 0) {
        $product = Product::find($id);
        if ($product && $qty > $product['stock']) {
            $qty = $product['stock'];
        }
        if ($qty < 1) $qty = 1;
        $_SESSION['cart'][$id] = $qty;
    }
    
    $cartData = cartItems();
    $novoSubtotal = 0;
    foreach ($cartData['items'] as $item) {
        if ($item['id'] == $id) {
            $novoSubtotal = $item['subtotal'];
            break;
        }
    }

    header('Content-Type: application/json');
    echo json_encode([
        'total_formatado' => number_format($cartData['total'], 2, ',', '.'),
        'subtotal_formatado' => number_format($novoSubtotal, 2, ',', '.'),
        'qty_ajustada' => $qty
    ]);
    exit;
} 
else if ($route === 'checkout') {
    require_once __DIR__ . '/../src/views/checkout/index.php';
} 
else if ($route === 'pagamento') {
    require_once __DIR__ . '/../src/views/checkout/payment.php';
} 
else if ($route === 'finalizar_pagamento') {
    require_once __DIR__ . '/../src/helpers/cart.php';
    require_once __DIR__ . '/../src/models/Order.php';
    require_once __DIR__ . '/../src/models/Product.php';
    
    cartInit();
    
    if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
        header('Location: /');
        exit;
    }
    
    $method = $_GET['method'] ?? 'pix';
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

    try {
        $orderId = Order::create($_SESSION['user_id'], $method, $items, $total);
        $_SESSION['cart'] = [];
        header("Location: /?route=sucesso&id=" . $orderId);
        exit;
    } catch (Exception $e) {
        echo "<div class='alert alert-danger mt-5 text-center'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
        echo "<div class='text-center mt-3'><a href='/?route=carrinho' class='btn btn-outline-light'>Voltar ao carrinho</a></div>";
    }
} 
else if ($route === 'sucesso') {
    require_once __DIR__ . '/../src/views/checkout/success.php';
} 
else if ($route === 'login') {
    require_once __DIR__ . '/../src/views/auth/login.php';
} 
else if ($route === 'cadastro') {
    require_once __DIR__ . '/../src/views/auth/register.php';
} 
else if ($route === 'logout') {
    session_destroy();
    header('Location: /');
    exit;
}

// ==========================================
// ROTAS DO PAINEL ADMINISTRATIVO
// ==========================================
else if ($route === 'admin') {
    require_once __DIR__ . '/../src/helpers/auth.php';
    requireAdmin();
    require_once __DIR__ . '/../src/views/admin/dashboard.php';
} 
else if ($route === 'admin_pedidos') {
    require_once __DIR__ . '/../src/helpers/auth.php';
    requireAdmin();
    require_once __DIR__ . '/../src/views/admin/orders.php';
}
else if ($route === 'admin_produto_novo') {
    require_once __DIR__ . '/../src/helpers/auth.php';
    requireAdmin();
    require_once __DIR__ . '/../src/views/admin/product_form.php';
} 
else if ($route === 'admin_produto_editar') {
    require_once __DIR__ . '/../src/helpers/auth.php';
    requireAdmin();
    require_once __DIR__ . '/../src/views/admin/product_form.php';
} 
else if ($route === 'admin_produto_salvar') {
    require_once __DIR__ . '/../src/helpers/auth.php';
    requireAdmin();
    require_once __DIR__ . '/../src/config/database.php';
    
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $cat = $_POST['category_id'];
    $desc = $_POST['description'];
    
    $imageName = $_POST['old_image'] ?? null;
    
    // Lógica de Upload de Imagem
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (in_array($fileExt, $allowed)) {
            $newName = uniqid() . '.' . $fileExt;
            $uploadPath = __DIR__ . '/../public/uploads/' . $newName;
            
            if (move_uploaded_file($fileTmp, $uploadPath)) {
                $imageName = $newName;
            } else {
                die("Erro ao mover o arquivo para a pasta uploads. Verifique se a pasta 'public/uploads' existe e tem permissão.");
            }
        } else {
            die("Formato de arquivo não permitido. Use JPG, JPEG, PNG ou WEBP.");
        }
    }

    if ($id) {
        $stmt = db()->prepare("UPDATE products SET name=:n, price=:p, stock=:s, category_id=:c, description=:d, image=:i WHERE id=:id");
        $stmt->execute([':n'=>$name, ':p'=>$price, ':s'=>$stock, ':c'=>$cat, ':d'=>$desc, ':i'=>$imageName, ':id'=>$id]);
    } else {
        $stmt = db()->prepare("INSERT INTO products (name, price, stock, category_id, description, image) VALUES (:n, :p, :s, :c, :d, :i)");
        $stmt->execute([':n'=>$name, ':p'=>$price, ':s'=>$stock, ':c'=>$cat, ':d'=>$desc, ':i'=>$imageName]);
    }
    header('Location: /?route=admin');
    exit;
} 
else if ($route === 'admin_produto_deletar') {
    require_once __DIR__ . '/../src/helpers/auth.php';
    requireAdmin();
    require_once __DIR__ . '/../src/config/database.php';
    
    $id = $_GET['id'] ?? 0;
    $stmt = db()->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header('Location: /?route=admin');
    exit;
} 
else {
    http_response_code(404);
    echo "<h1 class='text-center mt-5 text-white'>Página não encontrada (Erro 404)</h1>";
}