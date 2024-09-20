/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50739 (5.7.39)
 Source Host           : localhost:3306
 Source Schema         : pdam

 Target Server Type    : MySQL
 Target Server Version : 50739 (5.7.39)
 File Encoding         : 65001

 Date: 21/05/2024 09:32:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for departemen
-- ----------------------------
DROP TABLE IF EXISTS `departemen`;
CREATE TABLE `departemen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `pimpinan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of departemen
-- ----------------------------
BEGIN;
INSERT INTO `departemen` (`id`, `nama`, `pimpinan`, `created_at`, `updated_at`) VALUES (1, 'Divisi Anggaran', 'udin', '2024-04-20 03:31:40', '2024-04-20 07:45:50');
INSERT INTO `departemen` (`id`, `nama`, `pimpinan`, `created_at`, `updated_at`) VALUES (2, 'Divisi Perencanaan', 'Budi', '2024-04-20 03:31:48', '2024-04-20 07:45:57');
INSERT INTO `departemen` (`id`, `nama`, `pimpinan`, `created_at`, `updated_at`) VALUES (4, 'Divisi Informasi', 'Toto', '2024-04-20 07:46:14', '2024-04-20 07:46:14');
INSERT INTO `departemen` (`id`, `nama`, `pimpinan`, `created_at`, `updated_at`) VALUES (5, 'Divisi Teknologi', 'Dian Wowo', '2024-04-20 07:46:33', '2024-04-20 07:46:33');
COMMIT;

-- ----------------------------
-- Table structure for hasil
-- ----------------------------
DROP TABLE IF EXISTS `hasil`;
CREATE TABLE `hasil` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `jadwal_id` int(11) unsigned DEFAULT NULL,
  `hasil_pemeliharaan` text,
  `hasil_penggantian` text,
  `keterangan` text,
  `biaya` varchar(255) DEFAULT NULL,
  `teknisi_id` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_id` (`jadwal_id`),
  KEY `teknisi_id` (`teknisi_id`),
  CONSTRAINT `jadwal_id` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `teknisi_id` FOREIGN KEY (`teknisi_id`) REFERENCES `teknisi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hasil
-- ----------------------------
BEGIN;
INSERT INTO `hasil` (`id`, `jadwal_id`, `hasil_pemeliharaan`, `hasil_penggantian`, `keterangan`, `biaya`, `teknisi_id`, `created_at`, `updated_at`) VALUES (3, 2, 'perlu nambah disk.', 'bekerja dengan baik', 'sip', '1000000', 2, '2024-04-20 06:41:56', '2024-04-20 06:47:03');
INSERT INTO `hasil` (`id`, `jadwal_id`, `hasil_pemeliharaan`, `hasil_penggantian`, `keterangan`, `biaya`, `teknisi_id`, `created_at`, `updated_at`) VALUES (5, 3, 'Tidak ada kendala', '-', '-', '0', 3, '2024-04-20 07:51:44', '2024-04-20 07:51:44');
INSERT INTO `hasil` (`id`, `jadwal_id`, `hasil_pemeliharaan`, `hasil_penggantian`, `keterangan`, `biaya`, `teknisi_id`, `created_at`, `updated_at`) VALUES (6, 4, 'tinta habis', 'Ganti Tinta', '-', '120000', 5, '2024-04-20 07:52:11', '2024-04-20 07:52:11');
COMMIT;

-- ----------------------------
-- Table structure for infrastruktur
-- ----------------------------
DROP TABLE IF EXISTS `infrastruktur`;
CREATE TABLE `infrastruktur` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nomor_seri` varchar(255) DEFAULT NULL,
  `nomor_alat` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `departemen_id` int(11) unsigned DEFAULT NULL,
  `pengguna_id` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dep` (`departemen_id`),
  KEY `peng` (`pengguna_id`),
  CONSTRAINT `dep` FOREIGN KEY (`departemen_id`) REFERENCES `departemen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `peng` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of infrastruktur
-- ----------------------------
BEGIN;
INSERT INTO `infrastruktur` (`id`, `nomor_seri`, `nomor_alat`, `nama`, `jenis`, `merk`, `satuan`, `jumlah`, `keterangan`, `departemen_id`, `pengguna_id`, `created_at`, `updated_at`, `lokasi`, `status`, `tahun`) VALUES (1, '5678975', 'ALT123', 'Server Dell', 'server', 'Dell', 'buah', '1', '-', 2, 1, '2024-04-20 04:35:17', '2024-05-04 23:11:37', 'RAK 1', 'f', 'asd');
INSERT INTO `infrastruktur` (`id`, `nomor_seri`, `nomor_alat`, `nama`, `jenis`, `merk`, `satuan`, `jumlah`, `keterangan`, `departemen_id`, `pengguna_id`, `created_at`, `updated_at`, `lokasi`, `status`, `tahun`) VALUES (2, '4543213435', NULL, 'Komputer AIO Lenovo', 'komputer', 'Lenovo', 'buah', '1', '-', 2, 3, '2024-04-20 07:50:08', '2024-04-20 07:50:08', NULL, NULL, NULL);
INSERT INTO `infrastruktur` (`id`, `nomor_seri`, `nomor_alat`, `nama`, `jenis`, `merk`, `satuan`, `jumlah`, `keterangan`, `departemen_id`, `pengguna_id`, `created_at`, `updated_at`, `lokasi`, `status`, `tahun`) VALUES (3, '45678998778', NULL, 'Printer EPSON L3510', 'printer', 'EPSOn', 'buah', '1', 'baru', 4, 2, '2024-04-20 07:50:49', '2024-04-20 07:50:49', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for jadwal
-- ----------------------------
DROP TABLE IF EXISTS `jadwal`;
CREATE TABLE `jadwal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `infrastruktur_id` int(10) unsigned DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bulan` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asdasdfasds` (`infrastruktur_id`),
  CONSTRAINT `asdasdfasds` FOREIGN KEY (`infrastruktur_id`) REFERENCES `infrastruktur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jadwal
-- ----------------------------
BEGIN;
INSERT INTO `jadwal` (`id`, `infrastruktur_id`, `tanggal`, `status`, `created_at`, `updated_at`, `bulan`, `tahun`) VALUES (2, 1, '2024-04-20', 'terjadwal', '2024-04-20 06:41:29', '2024-05-05 08:58:41', '2', '2024');
INSERT INTO `jadwal` (`id`, `infrastruktur_id`, `tanggal`, `status`, `created_at`, `updated_at`, `bulan`, `tahun`) VALUES (3, 2, '2024-04-26', 'terjadwal', '2024-04-20 07:51:10', '2024-04-20 07:51:10', NULL, NULL);
INSERT INTO `jadwal` (`id`, `infrastruktur_id`, `tanggal`, `status`, `created_at`, `updated_at`, `bulan`, `tahun`) VALUES (4, 3, '2024-04-30', 'terjadwal', '2024-04-20 07:51:20', '2024-04-20 07:51:20', NULL, NULL);
INSERT INTO `jadwal` (`id`, `infrastruktur_id`, `tanggal`, `status`, `created_at`, `updated_at`, `bulan`, `tahun`) VALUES (5, 1, '2024-05-06', 'terjadwal', '2024-05-05 08:38:55', '2024-05-05 08:38:55', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for pemusnahan
-- ----------------------------
DROP TABLE IF EXISTS `pemusnahan`;
CREATE TABLE `pemusnahan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `infrastruktur_id` int(11) unsigned DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `petugas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inf` (`infrastruktur_id`),
  CONSTRAINT `inf` FOREIGN KEY (`infrastruktur_id`) REFERENCES `infrastruktur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pemusnahan
-- ----------------------------
BEGIN;
INSERT INTO `pemusnahan` (`id`, `infrastruktur_id`, `nomor`, `tanggal`, `created_at`, `updated_at`, `petugas`) VALUES (2, 1, 'P001', '2024-04-20', '2024-04-20 07:13:59', '2024-04-20 07:13:59', 'andi');
COMMIT;

-- ----------------------------
-- Table structure for pengguna
-- ----------------------------
DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE `pengguna` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `departemen_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pengguna
-- ----------------------------
BEGIN;
INSERT INTO `pengguna` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `departemen_id`) VALUES (1, 'Sinta', 'jl Gatot Subroto', '098765678', '2024-04-20 03:41:44', '2024-04-20 07:48:14', 1);
INSERT INTO `pengguna` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `departemen_id`) VALUES (2, 'Didi hidayat', 'jl Gatot Subroto V', '08324536271', '2024-04-20 07:48:31', '2024-04-20 07:48:31', 2);
INSERT INTO `pengguna` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `departemen_id`) VALUES (3, 'Lana Goto', 'Jl A Yani Km 9', '084526713122', '2024-04-20 07:48:58', '2024-04-20 07:48:58', 5);
COMMIT;

-- ----------------------------
-- Table structure for rekanan
-- ----------------------------
DROP TABLE IF EXISTS `rekanan`;
CREATE TABLE `rekanan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pimpinan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rekanan
-- ----------------------------
BEGIN;
INSERT INTO `rekanan` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `pimpinan`) VALUES (1, 'PT IT Solution', 'jl A Yani Km 6', '0987656789', '2024-04-20 03:58:25', '2024-04-20 07:15:30', 'Gusti');
INSERT INTO `rekanan` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `pimpinan`) VALUES (2, 'PT Digital Network', 'Jl Kayu Tangi', '0878234782778', '2024-04-20 07:14:40', '2024-04-20 07:14:40', 'Gilang');
INSERT INTO `rekanan` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `pimpinan`) VALUES (3, 'PT Media Banua', 'Jl Gatot Subroto VII No 6', '083624327346', '2024-04-20 07:49:29', '2024-04-20 07:49:29', 'Vikri Winata');
COMMIT;

-- ----------------------------
-- Table structure for role_users
-- ----------------------------
DROP TABLE IF EXISTS `role_users`;
CREATE TABLE `role_users` (
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `role_users_user_id_role_id_unique` (`user_id`,`role_id`) USING BTREE,
  KEY `role_users_role_id_foreign` (`role_id`) USING BTREE,
  CONSTRAINT `role_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of role_users
-- ----------------------------
BEGIN;
INSERT INTO `role_users` (`user_id`, `role_id`) VALUES (1, 1);
INSERT INTO `role_users` (`user_id`, `role_id`) VALUES (5, 1);
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES (1, 'superadmin', '2020-12-23 23:17:35', '2020-12-23 23:17:35');
COMMIT;

-- ----------------------------
-- Table structure for serah_terima
-- ----------------------------
DROP TABLE IF EXISTS `serah_terima`;
CREATE TABLE `serah_terima` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `infrastruktur_id` int(11) unsigned DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `penerima` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sfgdf` (`infrastruktur_id`),
  CONSTRAINT `sfgdf` FOREIGN KEY (`infrastruktur_id`) REFERENCES `infrastruktur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of serah_terima
-- ----------------------------
BEGIN;
INSERT INTO `serah_terima` (`id`, `infrastruktur_id`, `nomor`, `tanggal`, `created_at`, `updated_at`, `penerima`) VALUES (1, 1, 'ST001', '2024-04-20', '2024-04-20 07:00:38', '2024-04-20 07:01:27', 'andi law');
COMMIT;

-- ----------------------------
-- Table structure for teknisi
-- ----------------------------
DROP TABLE IF EXISTS `teknisi`;
CREATE TABLE `teknisi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rekanan_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of teknisi
-- ----------------------------
BEGIN;
INSERT INTO `teknisi` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `rekanan_id`) VALUES (2, 'adi', 'jl S Lulut Komple Graha', '09876543', '2024-04-20 06:46:48', '2024-05-01 07:32:13', 3);
INSERT INTO `teknisi` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `rekanan_id`) VALUES (3, 'Rendra Hidayat', 'Jl A Yani km 7', '087757789239', '2024-04-20 07:47:02', '2024-04-20 07:47:02', 1);
INSERT INTO `teknisi` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `rekanan_id`) VALUES (4, 'Rifky Santono', 'Jl Pramuka Km 6 GG nanas', '0899213773774', '2024-04-20 07:47:37', '2024-04-20 07:47:37', 2);
INSERT INTO `teknisi` (`id`, `nama`, `alamat`, `telp`, `created_at`, `updated_at`, `rekanan_id`) VALUES (5, 'Tomy Harda', 'Jl Kayu tangi IIq', '0827347235671', '2024-04-20 07:48:04', '2024-04-20 07:48:04', 5);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` varchar(255) NOT NULL,
  `password_superadmin` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `api_token` varchar(255) DEFAULT NULL,
  `last_session` varchar(255) DEFAULT NULL,
  `change_password` int(1) unsigned DEFAULT '0' COMMENT '0: belum, 1: sudah',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_username_unique` (`username`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `password_superadmin`, `remember_token`, `created_at`, `updated_at`, `api_token`, `last_session`, `change_password`) VALUES (1, 'superadmin', NULL, 'superadmin', '2024-05-05 17:14:28', '$2y$10$3k7FLC2TkBzYnumOyiv7BOmTOsTzzJHb3/p4aKcBUoGonp4Jij0Wu', NULL, 'zHTuKjqOn3YRUWkm22JR2TXgRQxwL17vxzioycMae1oxtteWDVkCxIt5LyWq', '2024-05-05 17:14:28', '2024-05-05 17:14:28', NULL, NULL, 0);
INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `password_superadmin`, `remember_token`, `created_at`, `updated_at`, `api_token`, `last_session`, `change_password`) VALUES (5, 'adi', NULL, 'adi', '2024-04-20 11:07:17', '$2y$10$sxXBzHYpymU8.AMoywsDh.EzC5P9fHnIr2POgiTkFWp11kQQBJQaG', NULL, NULL, '2024-04-20 03:07:17', '2024-04-20 03:07:17', NULL, NULL, 0);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
