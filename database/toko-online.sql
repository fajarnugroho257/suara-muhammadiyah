-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table toko-online.app_heading_menu
CREATE TABLE IF NOT EXISTS `app_heading_menu` (
  `app_heading_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_heading_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_heading_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`app_heading_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.app_heading_menu: ~9 rows (approximately)
INSERT INTO `app_heading_menu` (`app_heading_id`, `app_heading_name`, `app_heading_icon`, `created_at`, `updated_at`) VALUES
	('H0000', 'Dashboard', 'fas fa-tachometer-alt', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('H0001', 'Master Data Menu', 'fas fa-database', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('H0002', 'Master Data User', 'fas fa-users', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('H0003', 'Master Data', '', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('H0004', 'Data Penduduk', '', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('H0005', 'Data Produk', 'fas fa-database', '2024-11-10 20:40:45', '2024-11-10 20:42:14'),
	('H0006', 'Pesanan', 'fa fa-book', '2024-11-10 20:43:53', '2024-11-19 05:54:38'),
	('H0007', 'Laporan', 'fa fa-file-pdf', '2024-11-10 20:45:50', '2024-11-19 05:55:22'),
	('H0008', 'Akun', 'fa fa-users', '2024-11-10 20:46:22', '2024-11-19 05:55:47');

-- Dumping structure for table toko-online.app_menu
CREATE TABLE IF NOT EXISTS `app_menu` (
  `menu_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_heading_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_parent` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `app_menu_app_heading_id_foreign` (`app_heading_id`),
  CONSTRAINT `app_menu_app_heading_id_foreign` FOREIGN KEY (`app_heading_id`) REFERENCES `app_heading_menu` (`app_heading_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.app_menu: ~14 rows (approximately)
INSERT INTO `app_menu` (`menu_id`, `app_heading_id`, `menu_name`, `menu_url`, `menu_parent`, `created_at`, `updated_at`) VALUES
	('M0000', 'H0000', 'Dashboard', 'dashboard', '0', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('M0001', 'H0001', 'Heading Aplikasi', 'headingApp', '0', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('M0002', 'H0001', 'Menu Aplikasi', 'menuApp', '0', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('M0003', 'H0002', 'Role Pengguna', 'rolePengguna', '0', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('M0004', 'H0002', 'Role Menu', 'roleMenu', '0', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('M0005', 'H0002', 'Data User', 'dataUser', '0', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('M0006', 'H0003', 'Jabatan', 'jabatan', '0', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('M0007', 'H0004', 'Data Penduduk', 'dataPenduduk', '0', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('M0008', 'H0005', 'Data Produk', 'dataProduk', '0', '2024-11-10 20:43:05', '2024-11-10 20:43:05'),
	('M0009', 'H0006', 'Data Pesanan', 'dataPesanan', '0', '2024-11-10 20:44:53', '2024-11-10 20:45:31'),
	('M0010', 'H0007', 'Pesanan', 'laporanPesanan', '0', '2024-11-10 20:46:13', '2024-11-10 20:46:13'),
	('M0011', 'H0008', 'Akun Admin', 'akunAdmin', '0', '2024-11-10 20:46:53', '2024-11-10 20:47:33'),
	('M0012', 'H0008', 'Akun Pelanggan', 'akunPelanggan', '0', '2024-11-10 20:47:23', '2024-11-10 20:47:23'),
	('M0013', 'H0005', 'Data Kategori', 'dataKategori', '0', '2024-11-10 21:11:30', '2024-11-10 21:11:30');

-- Dumping structure for table toko-online.app_role
CREATE TABLE IF NOT EXISTS `app_role` (
  `role_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.app_role: ~5 rows (approximately)
INSERT INTO `app_role` (`role_id`, `role_name`, `created_at`, `updated_at`) VALUES
	('R0001', 'developer', '2024-11-10 06:51:33', '2024-11-10 06:51:33'),
	('R0002', 'admin', '2024-11-10 06:51:33', '2024-11-10 06:51:33'),
	('R0003', 'pengguna', '2024-11-10 06:51:33', '2024-11-10 06:51:33'),
	('R0004', 'admin toko', '2024-11-10 20:47:59', '2024-11-10 20:47:59'),
	('R0005', 'pelanggan', '2024-11-10 20:48:06', '2024-11-10 20:48:06');

-- Dumping structure for table toko-online.app_role_menu
CREATE TABLE IF NOT EXISTS `app_role_menu` (
  `role_menu_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_menu_id`),
  UNIQUE KEY `app_role_menu_menu_id_role_id_unique` (`menu_id`,`role_id`),
  KEY `app_role_menu_role_id_foreign` (`role_id`),
  CONSTRAINT `app_role_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `app_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `app_role_menu_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `app_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.app_role_menu: ~16 rows (approximately)
INSERT INTO `app_role_menu` (`role_menu_id`, `menu_id`, `role_id`, `created_at`, `updated_at`) VALUES
	('RM00001', 'M0001', 'R0001', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00002', 'M0002', 'R0001', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00003', 'M0003', 'R0001', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00004', 'M0004', 'R0001', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00005', 'M0005', 'R0001', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00006', 'M0000', 'R0001', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00007', 'M0000', 'R0002', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00008', 'M0000', 'R0003', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00009', 'M0006', 'R0002', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00010', 'M0007', 'R0002', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('RM00011', 'M0000', 'R0004', '2024-11-10 20:48:20', '2024-11-10 20:48:20'),
	('RM00012', 'M0008', 'R0004', '2024-11-10 20:48:24', '2024-11-10 20:48:24'),
	('RM00013', 'M0009', 'R0004', '2024-11-10 20:48:26', '2024-11-10 20:48:26'),
	('RM00014', 'M0010', 'R0004', '2024-11-10 20:48:28', '2024-11-10 20:48:28'),
	('RM00015', 'M0011', 'R0004', '2024-11-10 20:48:31', '2024-11-10 20:48:31'),
	('RM00016', 'M0012', 'R0004', '2024-11-10 20:48:35', '2024-11-10 20:48:35'),
	('RM00017', 'M0013', 'R0004', '2024-11-10 21:11:45', '2024-11-10 21:11:45'),
	('RM00018', 'M0000', 'R0005', '2024-11-11 03:29:59', '2024-11-11 03:29:59');

-- Dumping structure for table toko-online.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori_nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.kategori: ~6 rows (approximately)
INSERT INTO `kategori` (`id`, `slug`, `kategori_nama`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'buku', 'Buku', 'yes', '2024-11-10 21:32:51', '2024-11-19 23:06:18'),
	(2, 'kain-batik-muhammadiyah-na-dan-aisyah', 'Kain batik ( Muhammadiyah, NA dan Aisyah)', 'yes', '2024-11-10 21:34:30', '2024-11-11 04:55:33'),
	(3, 'baju-batik-muhammadiyah-na-dan-aisyah', 'Baju batik (Muhammadiyah, NA dan Aisyah)', 'yes', '2024-11-10 21:35:05', '2024-11-11 04:55:46'),
	(4, 'bendera', 'Bendera', 'yes', '2024-11-10 21:35:26', '2024-11-11 04:55:54'),
	(7, 'alat-ibadah-peci-sarung', 'Alat ibadah ( peci sarung)', 'yes', '2024-11-11 04:56:19', '2024-11-11 04:56:19'),
	(8, 'seragam-ortum-ipm-hw-ts', 'Seragam ortum ( ipm, hw, ts)', 'yes', '2024-11-11 04:56:33', '2024-11-11 04:56:33');

-- Dumping structure for table toko-online.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.migrations: ~22 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(2, '2024_08_28_081035_app_role', 1),
	(3, '2024_08_29_081211_app_menu', 1),
	(4, '2024_08_29_081213_users', 1),
	(5, '2024_08_29_081217_app_role_menu', 1),
	(6, '2024_08_29_092422_alter_column_role_name', 1),
	(7, '2024_08_30_020607_delete_column_role_name', 1),
	(8, '2024_08_30_024511_app_heading_menu', 1),
	(9, '2024_08_30_024724_add_column_heading_id', 1),
	(10, '2024_08_30_025128_add_foreign_key__heading_id', 1),
	(11, '2024_08_30_065332_alter_column', 1),
	(12, '2024_08_30_115218_add_column_nam', 1),
	(13, '2024_09_02_013705_primarykey_in_app_role_menu', 1),
	(14, '2024_09_02_025927_add_column_icon', 1),
	(15, '2024_11_10_135930_create_kategori', 2),
	(16, '2024_11_10_135933_create_produk', 3),
	(17, '2024_11_10_141139_create_pasanan', 4),
	(19, '2024_11_10_141827_create_pasanan_data', 5),
	(20, '2024_11_11_070202_create_produk_image', 6),
	(21, '2024_11_11_085103_create_users_data', 7),
	(22, '2024_11_11_115209_add_slug_column', 8),
	(23, '2024_11_11_133853_rename_pasanan_to_pesanan', 9),
	(24, '2024_11_11_134119_add_column_produk_id', 10),
	(25, '2024_11_19_112952_add_column_rating', 11),
	(26, '2024_11_20_143312_add_column_image', 12);

-- Dumping structure for table toko-online.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table toko-online.pesanan
CREATE TABLE IF NOT EXISTS `pesanan` (
  `pesanan_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesanan_tgl` datetime NOT NULL,
  `pesanan_st` enum('waiting','reject','approve') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pesanan_id`),
  KEY `pasanan_user_id_foreign` (`user_id`),
  CONSTRAINT `pasanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.pesanan: ~5 rows (approximately)

-- Dumping structure for table toko-online.pesanan_data
CREATE TABLE IF NOT EXISTS `pesanan_data` (
  `data_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesanan_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produk_id` bigint unsigned NOT NULL,
  `data_jlh` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`data_id`),
  KEY `pesanan_data_pesanan_id_foreign` (`pesanan_id`),
  KEY `pesanan_data_produk_id_foreign` (`produk_id`),
  CONSTRAINT `pesanan_data_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`pesanan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pesanan_data_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.pesanan_data: ~7 rows (approximately)

-- Dumping structure for table toko-online.produk
CREATE TABLE IF NOT EXISTS `produk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `produk_nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `produk_rating` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produk_deskripsi` text COLLATE utf8mb4_unicode_ci,
  `produk_harga` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `produk_stok` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `produk_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produk_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.produk: ~4 rows (approximately)
INSERT INTO `produk` (`id`, `kategori_id`, `slug`, `produk_nama`, `produk_rating`, `produk_deskripsi`, `produk_harga`, `produk_stok`, `produk_image`, `created_at`, `updated_at`) VALUES
	(5, 2, 'baju-koko-anak', 'baju koko anak', '4', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora atque excepturi distinctio quo recusandae libero veniam amet numquam, accusantium unde consectetur impedit officiis tenetur repellendus voluptate quia odio, consequatur est!', '50000', '119', 'id-11134207-7r98t-lmg5fukxxgng5b.jpg', '2024-11-11 01:14:49', '2024-11-20 06:23:46'),
	(6, 2, 'baju-koko-dewasa', 'Baju Koko Dewasa', '5', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora atque excepturi distinctio quo recusandae libero veniam amet numquam, accusantium unde consectetur impedit officiis tenetur repellendus voluptate quia odio, consequatur est!', '100000', '13', '1ecc2c2a-fb4f-4bcb-be7b-f1826905935e.jpg', '2024-11-11 01:24:08', '2024-11-20 06:13:47'),
	(7, 7, 'sarung', 'Sarung', '4', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora atque excepturi distinctio quo recusandae libero veniam amet numquam, accusantium unde consectetur impedit officiis tenetur repellendus voluptate quia odio, consequatur est!', '75000', '92', 'd48830f0b8d6ae3a02ee18d231066841.jpg', '2024-11-15 02:53:24', '2024-11-20 06:11:12'),
	(8, 8, 'seragam', 'Seragam', '3', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora atque excepturi distinctio quo recusandae libero veniam amet numquam, accusantium unde consectetur impedit officiis tenetur repellendus voluptate quia odio, consequatur est!', '25000', '72', 'id-11134207-7r98x-lp8ycmwmoakadd.jpg', '2024-11-15 02:58:32', '2024-11-20 06:19:05'),
	(9, 8, 'seragam-orang-tua-pria', 'Seragam Orang Tua Pria', '3', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora atque excepturi distinctio quo recusandae libero veniam amet numquam, accusantium unde consectetur impedit officiis tenetur repellendus voluptate quia odio, consequatur est!', '125000', '30', 'images.jpg', '2024-11-19 04:38:32', '2024-11-20 06:21:56');

-- Dumping structure for table toko-online.produk_image
CREATE TABLE IF NOT EXISTS `produk_image` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `produk_id` bigint unsigned NOT NULL,
  `data_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produk_image_produk_id_foreign` (`produk_id`),
  CONSTRAINT `produk_image_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.produk_image: ~16 rows (approximately)
INSERT INTO `produk_image` (`id`, `produk_id`, `data_image`, `created_at`, `updated_at`) VALUES
	(31, 7, '1088.5.jpg', '2024-11-20 06:11:12', '2024-11-20 06:11:12'),
	(32, 7, '22212912-9bd4-4b96-a9c9-7598cab48149.jpg', '2024-11-20 06:11:12', '2024-11-20 06:11:12'),
	(33, 7, 'd48830f0b8d6ae3a02ee18d231066841.jpg', '2024-11-20 06:11:12', '2024-11-20 06:11:12'),
	(34, 6, '1ecc2c2a-fb4f-4bcb-be7b-f1826905935e.jpg', '2024-11-20 06:13:47', '2024-11-20 06:13:47'),
	(35, 6, '6e572ea980b99c4763c37bd36790fc70.jpg_720x720q80.jpg', '2024-11-20 06:13:47', '2024-11-20 06:13:47'),
	(36, 6, '59b39371c0a7510ca0b142670c4850cd.jpg', '2024-11-20 06:13:47', '2024-11-20 06:13:47'),
	(37, 6, 'sg-11134201-23010-sm80htkr7ymvaa.jpg', '2024-11-20 06:13:47', '2024-11-20 06:13:47'),
	(38, 8, 'id-11134207-7r98q-lp95il3zo8sae2.jpg', '2024-11-20 06:17:58', '2024-11-20 06:17:58'),
	(39, 8, 'id-11134207-7r992-lp92c2fopj033b.jpg', '2024-11-20 06:17:58', '2024-11-20 06:17:58'),
	(40, 9, '056070e26bb1e1e74074477e3bc5c0bc.jpg', '2024-11-20 06:21:56', '2024-11-20 06:21:56'),
	(41, 9, 'id-11134207-7qul0-leowqu3fzi7a76.jpg', '2024-11-20 06:21:56', '2024-11-20 06:21:56'),
	(42, 9, 'images.jpg', '2024-11-20 06:21:56', '2024-11-20 06:21:56'),
	(43, 5, '813100242_d9a311c7-f430-42f0-9e0b-81233e1e1748_1024_1024.jpg', '2024-11-20 06:23:46', '2024-11-20 06:23:46'),
	(44, 5, 'f4a906f57d85012c7111c93c8c5bf3ea.jpg', '2024-11-20 06:23:46', '2024-11-20 06:23:46'),
	(45, 5, 'id-11134207-7r98t-lmg5fukxxgng5b.jpg', '2024-11-20 06:23:46', '2024-11-20 06:23:46'),
	(46, 5, 'images (1).jpg', '2024-11-20 06:23:46', '2024-11-20 06:23:46');

-- Dumping structure for table toko-online.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `app_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.users: ~5 rows (approximately)
INSERT INTO `users` (`user_id`, `name`, `role_id`, `username`, `password`, `created_at`, `updated_at`) VALUES
	('U0001', 'Developer', 'R0001', 'dev', '$2y$12$ESm9uImKCtylZwxU4LUVWu.86mGyzNmgcODP6Dvhkx3lo4tJMR94G', '2024-11-10 06:51:33', '2024-11-10 06:51:33'),
	('U0002', 'Admin', 'R0002', 'admin', '$2y$12$xCnMbm6RbbWjXYpTdWl0aOrBK9DJ3fJ.Jur6hZllYHeCimU4jE2pi', '2024-11-10 06:51:33', '2024-11-10 06:51:33'),
	('U0003', 'Pengguna', 'R0003', 'pengguna', '$2y$12$mItlVYMG/a3S31rjoJw9CueU6BN3P65Ygni.klsSTwLSDmqxVq9fC', '2024-11-10 06:51:34', '2024-11-10 06:51:34'),
	('U0004', 'Admin Toko', 'R0004', 'admintoko', '$2y$12$1Pc9S8Co1Aumv9BwgRrsouqtRzANutuOTRT7LueHViTFyW4zJFsNK', '2024-11-10 20:49:11', '2024-11-20 07:48:52'),
	('U0006', 'Muhammad Fajar Nugroho', 'R0005', 'pelanggan1', '$2y$12$tL1kPsX6Xx729uh4ydVAlePDUFf0NaOV2WX.M6u.BEz34IC8xA1Fq', '2024-11-11 03:25:57', '2024-11-20 07:57:59'),
	('U0007', 'Sinta', 'R0004', 'sinta', '$2y$12$epVgiB9tfd4jEBsqz5rJj.xqLga5WE.83qAmDviZ8rMfIsRjkEoPO', '2024-11-20 07:38:27', '2024-11-20 07:52:29'),
	('U0008', 'Rachma', 'R0005', 'rachma', '$2y$12$cvsI7vvQQrFDIW5QUFqk8.JNdlsRJK5cye7xpYGLPN.bK54Y.EETu', '2024-11-20 07:59:47', '2024-11-20 07:59:47');

-- Dumping structure for table toko-online.users_data
CREATE TABLE IF NOT EXISTS `users_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_alamat` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_nama_lengkap` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_telp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_tgl_lahir` date DEFAULT NULL,
  `user_jk` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_data_user_id_foreign` (`user_id`),
  CONSTRAINT `users_data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko-online.users_data: ~1 rows (approximately)
INSERT INTO `users_data` (`id`, `user_id`, `user_alamat`, `user_nama_lengkap`, `user_telp`, `user_tgl_lahir`, `user_jk`, `image`, `created_at`, `updated_at`) VALUES
	(1, 'U0004', 'Magelang', 'Admin Toko', '085647151215', '2024-11-01', 'L', 'avatar5.png', NULL, '2024-11-20 07:48:52'),
	(4, 'U0006', 'Magelang', 'Muhammad Fajar Nugroho', '085647151215', '2024-11-01', 'L', 'avatar.png', '2024-11-11 03:25:57', '2024-11-20 07:57:59'),
	(5, 'U0007', 'Magelang', 'Sinta', '085647151215', '2024-11-01', 'L', 'avatar2.png', '2024-11-20 07:38:27', '2024-11-20 07:49:08'),
	(6, 'U0008', 'Metoyudan', 'Rachma', '085647151215', '2024-11-20', 'P', 'avatar3.png', '2024-11-20 07:59:47', '2024-11-20 07:59:47');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
