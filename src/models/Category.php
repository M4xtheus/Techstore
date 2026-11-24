<?php
// src/models/Category.php
require_once __DIR__ . '/../config/database.php';

class Category {
    public static function all(): array {
        $stmt = db()->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}