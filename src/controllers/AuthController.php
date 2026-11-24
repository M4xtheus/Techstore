<?php
// src/controllers/AuthController.php
require_once __DIR__ . '/../config/database.php';

function authLogin(string $email, string $password): bool {
    $stmt = db()->prepare("SELECT * FROM users WHERE email = :e");
    $stmt->execute([':e' => $email]);
    $user = $stmt->fetch();

    // Verifica se o usuário existe e se a senha bate com o hash do banco
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true); // Segurança contra session fixation
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        return true;
    }
    return false;
}

function authRegister(string $name, string $email, string $password): array {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['ok' => false, 'msg' => 'E-mail inválido.'];
    }
    if (strlen($password) < 6) {
        return ['ok' => false, 'msg' => 'A senha precisa ter no mínimo 6 caracteres.'];
    }

    // Criptografa a senha
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = db()->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (:n, :e, :h, 'cliente')");
        $stmt->execute([':n' => $name, ':e' => $email, ':h' => $hash]);
        return ['ok' => true];
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            return ['ok' => false, 'msg' => 'Este e-mail já está cadastrado.'];
        }
        return ['ok' => false, 'msg' => 'Erro ao cadastrar.'];
    }
}