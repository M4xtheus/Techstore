<?php
// src/helpers/auth.php

function requireAdmin(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: /');
        exit;
    }
}