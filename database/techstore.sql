-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/11/2026 às 20:11
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `techstore`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `slug` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Celulares', 'celulares'),
(2, 'Videogames', 'videogames'),
(3, 'Notebooks', 'notebooks'),
(4, 'Acessórios', 'acessorios'),
(5, 'Áudio', 'audio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `payment_method` enum('pix','boleto','cartao') NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pendente','pago','cancelado') NOT NULL DEFAULT 'pago',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `payment_method`, `total`, `status`, `created_at`) VALUES
(8, 2, 'pix', 1598.00, 'pago', '2026-11-24 17:49:45'),
(9, 2, 'boleto', 3198.00, 'pago', '2026-11-24 18:01:46'),
(10, 2, 'pix', 2647.90, 'pago', '2026-11-24 18:10:52'),
(11, 2, 'pix', 8417.90, 'pago', '2026-11-24 18:14:14'),
(12, 2, 'boleto', 699.00, 'pago', '2026-11-24 19:01:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(9, 8, 26, 1, 899.00),
(10, 8, 25, 1, 699.00),
(11, 9, 24, 1, 1899.00),
(12, 9, 20, 1, 1299.00),
(13, 10, 21, 1, 1499.00),
(14, 10, 26, 1, 899.00),
(15, 10, 19, 1, 249.90),
(16, 11, 15, 1, 429.00),
(17, 11, 17, 1, 7899.00),
(18, 11, 22, 1, 89.90),
(19, 12, 25, 1, 699.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `image`, `active`, `created_at`) VALUES
(1, 1, 'Smartphone Galaxy X20', 'Tela AMOLED 6.5\", 256GB, 12GB RAM', 3499.90, 15, '6b05c8f859944.webp', 1, '2026-11-23 02:13:26'),
(2, 1, 'iPhone 15 Pro', 'Titanium, 256GB, câmera 48MP', 7299.00, 8, '6b05c8e59c27c.jpg', 1, '2026-11-23 02:13:26'),
(3, 2, 'PlayStation 5 Slim', 'Console 1TB + 1 controle DualSense', 3899.90, 10, '6b05c8c1db831.jpg', 1, '2026-11-23 02:13:26'),
(4, 2, 'Xbox Series X', 'Console 1TB, 4K, 120fps', 4299.00, 6, '6b05c8a9d05fb.png', 1, '2026-11-23 02:13:26'),
(5, 3, 'Notebook Gamer Nitro', 'RTX 4060, Ryzen 7, 16GB RAM', 6499.00, 4, '6b05c899f2525.png', 1, '2026-11-23 02:13:26'),
(6, 4, 'Mouse Gamer RGB', 'Sensor 16000 DPI, 7 botões', 189.90, 30, '6b05c889edd06.jpg', 1, '2026-11-23 02:13:26'),
(7, 5, 'Headset Bluetooth Pro', 'Cancelamento de ruído ativo, 40h bateria', 449.90, 20, '6b05c875b0344.jpg', 1, '2026-11-23 02:13:26'),
(8, 1, 'Samsung Galaxy S24 Ultra', 'Titanium, 512GB, 12GB RAM, S-Pen', 8999.00, 12, '6b05c86138f71.jpg', 1, '2026-11-23 02:43:28'),
(9, 1, 'Xiaomi 14 Pro', 'Snapdragon 8 Gen 3, Câmera Leica', 6499.00, 25, '6b05c84f926fa.webp', 1, '2026-11-23 02:43:28'),
(10, 1, 'Motorola Edge 50 Ultra', 'Tela pOLED, 125W TurboPower', 4599.00, 18, '6b05c83b82888.webp', 1, '2026-11-23 02:43:28'),
(11, 1, 'iPhone 13 (Seminovo)', '128GB, Bateria 90%', 2899.00, 5, '6b05c82b1ee4d.jpg', 1, '2026-11-23 02:43:28'),
(12, 2, 'Nintendo Switch OLED', 'Tela 7\", 64GB, Joy-Con Branco', 2299.00, 15, '6b05c7d87d77e.jpg', 1, '2026-11-23 02:43:28'),
(13, 2, 'Steam Deck OLED', '1TB, Tela HDR, Portátil', 4999.00, 7, '6b05c7c245ca1.jpg', 1, '2026-11-23 02:43:28'),
(14, 2, 'Controle DualSense PS5', 'Sem fio, Branco', 449.90, 40, '6b05c7a6489bc.jpg', 1, '2026-11-23 02:43:28'),
(15, 2, 'Controle Xbox Series', 'Sem fio, Preto', 429.00, 34, '6b05c7930b623.jpg', 1, '2026-11-23 02:43:28'),
(16, 3, 'MacBook Air M3', '13\", 8GB RAM, 256GB SSD', 8499.00, 10, '6b05c77e9db1f.jpg', 1, '2026-11-23 02:43:28'),
(17, 3, 'Dell XPS 13', 'Intel Core i7, 16GB RAM, 512GB SSD', 7899.00, 5, '6b05c76979310.jpg', 1, '2026-11-23 02:43:28'),
(18, 3, 'Acer Predator Helios', 'RTX 4070, Intel i9, 32GB RAM', 12500.00, 3, '6b05c752e303e.webp', 1, '2026-11-23 02:43:28'),
(19, 4, 'Teclado Mecânico Redragon', 'Switch Outemu Red, RGB', 249.90, 49, '6b05c71456468.webp', 1, '2026-11-23 02:43:28'),
(20, 4, 'Monitor Gamer 27', 'IPS, 1ms, FreeSync', 1299.00, 14, '6b05c6f98f355.jpg', 1, '2026-11-23 02:43:28'),
(21, 4, 'Cadeira Gamer ThunderX3', 'Reclinável, Apoio de braço 4D', 1499.00, 7, '6b05c6c89c6d5.jpg', 1, '2026-11-23 02:43:28'),
(22, 4, 'Mousepad Speed XXL', 'Borda costurada, 90x40cm', 89.90, 59, '6b05c6af26694.jpg', 1, '2026-11-23 02:43:28'),
(23, 5, 'Fone JBL Quantum 400', 'Som surround, USB', 399.00, 20, '6b05c697d6c73.webp', 1, '2026-11-23 02:43:28'),
(24, 5, 'AirPods Pro 2', 'Cancelamento de ruído ativo, USB-C', 1899.00, 12, '6b05c68074b7a.jpg', 1, '2026-11-23 02:43:28'),
(25, 5, 'Caixa de Som JBL Flip 6', 'À prova d\'água, 12h de bateria', 699.00, 17, '6b05c64d2d02a.webp', 1, '2026-11-23 02:43:28'),
(26, 5, 'Microfone HyperX QuadCast', 'Condensador, USB', 899.00, 4, '6b05c4dbdda72.webp', 1, '2026-11-23 02:43:28');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('cliente','admin') NOT NULL DEFAULT 'cliente',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Administrador', 'admin@techstore.com', '$2y$10$fec7N1KYuLIc.eL0Q3g6m.xi.f25XHrVat3xAN3BaWL30C2rCEbNW', 'admin', '2026-11-23 02:13:26'),
(2, 'Cliente Teste', 'cliente@teste.com', '$2y$10$fec7N1KYuLIc.eL0Q3g6m.xi.f25XHrVat3xAN3BaWL30C2rCEbNW', 'cliente', '2026-11-23 02:13:26');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Índices de tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_user` (`user_id`);

--
-- Índices de tabela `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_order` (`order_id`),
  ADD KEY `fk_items_product` (`product_id`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_category` (`category_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
