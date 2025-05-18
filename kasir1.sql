-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 18 Bulan Mei 2025 pada 09.19
-- Versi server: 9.2.0
-- Versi PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_02_032020_create_products_table', 1),
(6, '2024_02_06_032021_create_orders_table', 1),
(7, '2024_02_06_032022_create_order_products_table', 1),
(8, '2024_02_10_083227_add_done_at_to_orders_table', 1),
(9, '2024_02_13_215502_add_paid_amount_to_orders_table', 1),
(10, '2025_05_14_154935_add_grand_total_to_orders_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `done_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `paid_amount` int DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `invoice_number`, `created_at`, `updated_at`, `done_at`, `deleted_at`, `paid_amount`, `grand_total`) VALUES
('1bac517c-38b2-42ba-a410-a9fef15d5386', 'ddf2c9', '2025-05-18 05:29:01', '2025-05-18 05:29:22', '2025-05-18 05:29:22', NULL, 35000, NULL),
('87de6594-5eed-4a5a-b4cc-344033493291', 'd8649d', '2025-05-18 05:31:41', '2025-05-18 05:31:59', '2025-05-18 05:31:59', NULL, 15000, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_products`
--

CREATE TABLE `order_products` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0c4aa3a3-ae3b-4ac1-b6ac-68b26f43807a', '1bac517c-38b2-42ba-a410-a9fef15d5386', 'e624f096-4399-4d9b-b76f-1c44a5b2d1f8', 1, 12000, '2025-05-18 05:29:05', '2025-05-18 05:29:05', NULL),
('13382b55-8f50-476e-9e72-72345b1ac47e', '87de6594-5eed-4a5a-b4cc-344033493291', 'e59a725a-eca6-4388-8907-51896b53da2a', 1, 10000, '2025-05-18 05:31:51', '2025-05-18 05:31:51', NULL),
('785c586c-89a1-4784-8b05-604d6d1fb253', '87de6594-5eed-4a5a-b4cc-344033493291', '04468556-da82-4ed6-aea6-cea5dcf04dca', 1, 4000, '2025-05-18 05:31:46', '2025-05-18 05:31:46', NULL),
('c6ac60eb-1304-47b6-807c-f7a0f46de2e5', '1bac517c-38b2-42ba-a410-a9fef15d5386', '9e88cbef-4691-412c-a319-5141fa5db765', 1, 10000, '2025-05-18 05:29:03', '2025-05-18 05:29:03', NULL),
('ea066d95-9a59-4998-849f-3c6add1a4b7b', '1bac517c-38b2-42ba-a410-a9fef15d5386', 'e59a725a-eca6-4388-8907-51896b53da2a', 1, 10000, '2025-05-18 05:29:06', '2025-05-18 05:29:06', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cost_price` int NOT NULL,
  `selling_price` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `cost_price`, `selling_price`, `image`, `stock`, `created_at`, `updated_at`, `deleted_at`) VALUES
('04468556-da82-4ed6-aea6-cea5dcf04dca', 'TEH PANAS', 'teh angst', 3000, 4000, 'aEVt1X4TwxkdQE5S46hbM08W3ceAMzndR1LPLhOI.jpg', 50, '2025-03-02 04:39:57', '2025-05-14 08:34:22', NULL),
('3ee1dc59-5133-4eee-af1c-65ef5b2e52ff', 'CHOCOLATE', 'COKLAT', 8000, 10000, 'wwmo72KlaU3aUF7KdJZeNoxpMIsYuxVnO7cfKQNo.png', 50, '2025-05-14 10:13:37', '2025-05-14 10:13:37', NULL),
('9e88cbef-4691-412c-a319-5141fa5db765', 'JERUK PERAS', 'ES JERUK', 6000, 10000, 'OeH22PR3IkeOOIqWjccV57knhODMbzVCy3xmjJGu.png', 80, '2025-05-14 10:12:25', '2025-05-14 10:12:25', NULL),
('caa436ca-1e1b-42d5-87f0-3f25cce014b9', 'JOSHUA', 'Minuman', 4000, 5000, 'RZFOreVuvFLLaV43yhapIBJDqqx0wTG8ZPQQWuwJ.jpg', 50, '2025-03-02 04:38:35', '2025-05-14 08:34:35', NULL),
('e59a725a-eca6-4388-8907-51896b53da2a', 'TAHU KRESS', 'TAHUUUUUU', 5000, 10000, 'nARlF7k8ZpkXcjHNwiHg2t5S9OJddU7Bpozg0hSC.png', 70, '2025-05-14 08:27:10', '2025-05-14 08:27:10', NULL),
('e624f096-4399-4d9b-b76f-1c44a5b2d1f8', 'TAHU WALEK', 'tahu walek', 8000, 12000, 'unSzSLKZSSs0mkbpuLckmnt9hh74nSwK7SkcxpjG.jpg', 50, '2025-03-02 04:41:00', '2025-05-14 08:34:43', NULL),
('ed663f06-7179-4ec3-bd98-4f7df9e239d3', 'FRENCH FRIEST', 'KENTANG', 11000, 15000, '44fICgA77yurCgY1EgUGTUsANFKfCkWxbOLbsjiO.png', 50, '2025-05-14 10:14:47', '2025-05-14 10:14:47', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_invoice_number_unique` (`invoice_number`);

--
-- Indeks untuk tabel `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_products_order_id_foreign` (`order_id`),
  ADD KEY `order_products_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
