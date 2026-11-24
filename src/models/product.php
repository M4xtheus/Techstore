<?php
// src/models/Product.php
require_once __DIR__ . '/../config/database.php';

class Product {
    // Busca todos os produtos (com filtro de categoria e busca por texto)
    public static function all(?int $categoryId = null, ?string $search = null): array {
        $sql = "SELECT p.*, c.name AS category_name 
                FROM products p 
                JOIN categories c ON c.id = p.category_id 
                WHERE p.active = 1";
        
        $params = [];
        
        if ($categoryId) {
            $sql .= " AND p.category_id = :cat";
            $params[':cat'] = $categoryId;
        }
        
        if ($search) {
            // CORREÇÃO: Usar dois parâmetros diferentes para o mesmo valor
            $sql .= " AND (p.name LIKE :search1 OR p.description LIKE :search2)";
            $params[':search1'] = "%{$search}%";
            $params[':search2'] = "%{$search}%";
        }
        
        $sql .= " ORDER BY p.id DESC";
        
        $stmt = db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Busca um único produto pelo ID
    public static function find(int $id): ?array {
        $stmt = db()->prepare("SELECT p.*, c.name AS category_name 
                               FROM products p 
                               JOIN categories c ON c.id = p.category_id 
                               WHERE p.id = :id AND p.active = 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }
}