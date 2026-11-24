<?php
// src/helpers/cart.php
require_once __DIR__ . '/../models/Product.php';

function cartInit(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
}

function cartAdd(int $productId, int $qty = 1): void {
    cartInit();
    $product = Product::find($productId);
    if (!$product) return;

    $current = $_SESSION['cart'][$productId] ?? 0;
    $newQty = $current + $qty;

    if ($newQty > $product['stock']) $newQty = $product['stock'];
    if ($newQty > 0) $_SESSION['cart'][$productId] = $newQty;
}

// NOVO: Função para buscar os itens prontos para exibir
function cartItems(): array {
    cartInit();
    $items = [];
    $total = 0;

    if (empty($_SESSION['cart'])) return ['items' => [], 'total' => 0];

    foreach ($_SESSION['cart'] as $id => $qty) {
        $p = Product::find($id);
        if ($p) {
            $p['qty'] = $qty;
            $p['subtotal'] = $p['price'] * $qty;
            $total += $p['subtotal'];
            $items[] = $p;
        }
    }
    return ['items' => $items, 'total' => $total];
}