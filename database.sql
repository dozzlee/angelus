-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2016 at 04:08 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `casper`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `order_id`, `country`, `state`, `zip_code`, `phone_number`, `address_line_1`, `address_line_2`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 'us', 'MA', '01129', '13553', '198 Cabinet Street', 'Springfield, Massachusetts - 01129', '2016-05-10 07:10:20', '2016-05-10 07:10:20'),
(2, 2, 9, 'us', 'MA', '01610', '13553', 'Clark University, 950 Main Street', '', '2016-05-10 07:11:34', '2016-05-10 07:11:34'),
(3, 22, 10, 'us', 'MA', '01610', '13553', 'Clark University, 950 Main Street', 'Worcester, MA', '2016-05-10 14:08:42', '2016-05-10 14:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(6, 22, '2016-05-10 14:57:37', '2016-05-10 14:57:37');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(7, 6, 12, 1, '2016-05-10 14:58:02', '2016-05-10 14:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `original_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `filename`, `mime`, `original_filename`, `created_at`, `updated_at`) VALUES
(12, 'phpdMVICa.png', 'image/png', 'product.png', '2016-05-10 14:00:03', '2016-05-10 14:00:03'),
(13, 'php31FA8O.png', 'image/png', 'product.png', '2016-05-10 14:00:31', '2016-05-10 14:00:31'),
(14, 'phpPeOLVG.png', 'image/png', 'product.png', '2016-05-10 14:01:00', '2016-05-10 14:01:00'),
(15, 'phpOq5PT8.png', 'image/png', 'product.png', '2016-05-10 14:01:31', '2016-05-10 14:01:31'),
(16, 'phpKxgWOP.png', 'image/png', 'product.png', '2016-05-10 14:01:53', '2016-05-10 14:01:53'),
(17, 'phpYcOHiy.png', 'image/png', 'product.png', '2016-05-10 14:02:26', '2016-05-10 14:02:26'),
(18, 'phprJhb4f.png', 'image/png', 'product.png', '2016-05-10 14:02:53', '2016-05-10 14:02:53'),
(19, 'phpqaS8Vk.png', 'image/png', 'product.png', '2016-05-10 14:03:52', '2016-05-10 14:03:52'),
(20, 'phpaaTjTT.png', 'image/png', 'product.png', '2016-05-10 14:03:52', '2016-05-10 14:03:52'),
(21, 'phpkCZo5r.png', 'image/png', 'product.png', '2016-05-10 14:05:05', '2016-05-10 14:05:05'),
(22, 'phpwgjN5o.png', 'image/png', 'product.png', '2016-05-10 14:05:05', '2016-05-10 14:05:05');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_03_01_004913_create_table_products', 1),
('2016_03_01_005004_create_table_files', 1),
('2016_03_01_023233_create_table_carts', 1),
('2016_03_01_023240_create_table_carts_item', 1),
('2016_03_01_054519_create_table_orders', 1),
('2016_03_01_054526_create_table_order_items', 1),
('2016_03_05_022316_create_cache_table', 1),
('2016_03_06_040207_create_sessions_table', 1),
('2016_05_10_024753_create_address_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_progress` int(11) NOT NULL,
  `delivered_by` date NOT NULL,
  `total_paid` double(8,2) NOT NULL,
  `stripe_transaction_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_progress`, `delivered_by`, `total_paid`, `stripe_transaction_id`, `created_at`, `updated_at`) VALUES
(10, 22, 1, '2016-05-17', 66.95, 'ch_189XnCD1x6mDPYuG31e3giqA', '2016-05-10 14:08:42', '2016-05-10 14:09:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `file_id`, `created_at`, `updated_at`) VALUES
(1, 10, 11, 2, 12, '2016-05-10 14:08:42', '2016-05-10 14:08:42'),
(2, 10, 17, 3, 18, '2016-05-10 14:08:42', '2016-05-10 14:08:42'),
(3, 10, 15, 1, 16, '2016-05-10 14:08:42', '2016-05-10 14:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `user_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `imageurl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_stock` int(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `imageurl`, `file_id`, `product_stock`, `created_at`, `updated_at`) VALUES
(11, 'Product 1', 'The product description of product 1 goes here. Product 1 is a very affordable product and can be shipped with 5-8 working business days', 5.99, '/products/download/11/phpdMVICa.png', '12', 8, '2016-05-10 14:00:03', '2016-05-10 14:08:42'),
(12, 'Product 2', 'The product description of product 2 goes here. Product 2 is a very affordable product and can be shipped with 5-8 working business days', 10.00, '/products/download/12/php31FA8O.png', '13', 90, '2016-05-10 14:00:31', '2016-05-10 14:00:31'),
(13, 'Product 3', '                                            The product description of product 3 goes here. Product 3 is a very affordable product and can be shipped with 5-8 working business days\r\n                                         ', 120.99, '/products/download/13/phpPeOLVG.png', '14', 7, '2016-05-10 14:01:00', '2016-05-10 14:01:07'),
(14, 'Product 4', 'The product description of product 4 goes here. Product 4 is a very affordable product and can be shipped with 5-8 working business days', 14.00, '/products/download/14/phpOq5PT8.png', '15', 33, '2016-05-10 14:01:31', '2016-05-10 14:01:31'),
(15, 'Product 5', 'The product description of product 5 goes here. Product 5 is a very affordable product and can be shipped with 5-8 working business days', 25.00, '/products/download/15/phpKxgWOP.png', '16', 24, '2016-05-10 14:01:53', '2016-05-10 14:08:42'),
(16, 'Product 6', 'The product description of product 6 goes here. Product 6 is a very affordable product and can be shipped with 5-8 working business days', 73.86, '/products/download/16/phpYcOHiy.png', '17', 15, '2016-05-10 14:02:27', '2016-05-10 14:02:27'),
(17, 'Product 7', 'The product description of product 7 goes here. Product 7 is a very affordable product and can be shipped with 5-8 working business days', 9.99, '/products/download/17/phprJhb4f.png', '18', 97, '2016-05-10 14:02:53', '2016-05-10 14:08:42'),
(18, 'Product 8', 'The product description of product 8 goes here. Product 8 is a very affordable product and can be shipped with 5-8 working business days', 42.50, '/products/download/18/phpqaS8Vk.png', '19', 80, '2016-05-10 14:03:52', '2016-05-10 14:03:52'),
(19, 'Product 9', 'The product description of product 9 goes here. Product 9 is a very affordable product and can be shipped with 5-8 working business days\r\n                                         ', 7.00, '/products/download/19/phpaaTjTT.png', '20', 14, '2016-05-10 14:03:52', '2016-05-10 14:04:25'),
(20, 'Product 10', '                                            The product description of product 10 goes here. Product 10 is a very affordable product and can be shipped with 5-8 working business days\r\n                                         ', 10.00, '/products/download/20/phpkCZo5r.png', '21', 18, '2016-05-10 14:05:05', '2016-05-10 14:05:43'),
(21, 'Product 11', '                                            The product description of product 11 goes here. Product 11 is a very affordable product and can be shipped with 5-8 working business days\r\n                                         ', 20.00, '/products/download/21/phpwgjN5o.png', '22', 75, '2016-05-10 14:05:05', '2016-05-10 14:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('b520e5e50c84adbdafc0ef8c469f3d622e73c9c0', 22, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.94 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUWhMOUJtNVBGVkhkTTZOOFJjMFpESlhldFRGdUFSVm9TOG0wSWpmZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly9sb2NhbGhvc3Q6OTAwMC9wcm9kdWN0cy9kb3dubG9hZC8xMi9waHAzMUZBOE8ucG5nIjt9czo1OiJmbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjI7czo5OiJfc2YyX21ldGEiO2E6Mzp7czoxOiJ1IjtpOjE0NjI4Nzk3Mjc7czoxOiJjIjtpOjE0NjI4MzQxNDk7czoxOiJsIjtzOjE6IjAiO319', 1462879728);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0000000000',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_customer_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirm_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `password`, `stripe_customer_id`, `is_admin`, `remember_token`, `confirm_link`, `is_verified`, `created_at`, `updated_at`) VALUES
(21, 'Daniel', 'Quaidoo', 'dquaidoo@clarku.edu', '4132313553', '$2y$10$75VfF/i2kutMwLQMJ8uZROqSoX2trPf6rOPls3rDbtX1clt1aZIZW', '', 1, 'SuVvmcteZbWd6JhdFYBIHJKw02Wu3cpjvJRbYMNISdJ1QHz2R0pLJTe58aur', 'wipApOFfHHf2V4VP2bZQPNHDvnTJXs', 1, '2016-05-10 11:48:54', '2016-05-10 14:49:06'),
(22, 'Daniel', 'Quaidoo', 'daniel.quaidoo@gmail.com', '0000000000', '$2y$10$PG9Da5okDdSLEQQIAN3Rgub.uaarD.tFTC4J98EO.i69GxV5E6L4S', 'cus_8QOabtdy4ucgyq', 0, 'uVMItddbxTWInROUDuWWzChg0R1Xg1txxN6QgdDQN9W712M1ehmu8JxlIfB4', 'OEEnqRUPOeD0ozX7agLL0xRDDjy3ZS', 0, '2016-05-10 11:56:50', '2016-05-10 14:58:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `cache_key_unique` (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`token`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
