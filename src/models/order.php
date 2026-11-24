<?php
// src/models/Order.php
require_once __DIR__ . '/../config/database.php';

class Order {
    public static function create(int $userId, string $paymentMethod, array $cartItems, float $total): int {
        $pdo = db();
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO orders (user_id, payment_method, total, status) VALUES (:uid, :pm, :t, 'pago')");
            $stmt->execute([':uid' => $userId, ':pm' => $paymentMethod, ':t' => $total]);
            $orderId = (int)$pdo->lastInsertId();

            $insItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (:oid, :pid, :qty, :price)");
            $decStock = $pdo->prepare("UPDATE products SET stock = stock - :qty WHERE id = :pid AND stock >= :qty2");

            foreach ($cartItems as $item) {
                $insItem->execute([
                    ':oid' => $orderId,
                    ':pid' => $item['id'],
                    ':qty' => $item['qty'],
                    ':price' => $item['price']
                ]);

                $decStock->execute([
                    ':qty' => $item['qty'],
                    ':pid' => $item['id'],
                    ':qty2' => $item['qty']
                ]);

                if ($decStock->rowCount() === 0) {
                    throw new Exception("Estoque insuficiente para o produto: " . $item['name']);
                }
            }

            $pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}