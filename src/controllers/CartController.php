<?php
// src/controllers/CartController.php

// Inicia a sessão se não estiver iniciada
function cartInit(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
}

// Adiciona item ao carrinho
function cartAdd(int $productId, int $qty = 1): void {
    cartInit();
    require_once __DIR__ . '/../models/Product.php';
    $product = Product::find($productId);
    
    if (!$product) return;

    $current = $_SESSION['cart'][$productId] ?? 0;
    $newQty = $current + $qty;

    // Não deixa adicionar mais do que tem no estoque
    if ($newQty > $product['stock']) {
        $newQty = $product['stock'];
    }

    if ($newQty > 0) {
        $_SESSION['cart'][$productId] = $newQty;
    }
}