-- Tabel PPID untuk database ptpemaco_hr_production
-- Jalankan manual (phpMyAdmin / mysql client). Aman dijalankan ulang (IF NOT EXISTS).
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `ppid_permohonan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_registrasi` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(30) DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kategori_pemohon` varchar(30) NOT NULL DEFAULT 'perorangan',
  `rincian_informasi` text NOT NULL,
  `tujuan_penggunaan` text DEFAULT NULL,
  `cara_memperoleh` varchar(50) DEFAULT NULL,
  `cara_mendapatkan` varchar(50) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'diproses',
  `catatan` text DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ppid_permohonan_no_registrasi_unique` (`no_registrasi`),
  KEY `ppid_permohonan_status_index` (`status`),
  KEY `ppid_permohonan_created_at_index` (`created_at`),
  KEY `ppid_permohonan_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ppid_pengaduan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_tiket` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(30) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `subjek` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'baru',
  `tanggapan` text DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ppid_pengaduan_no_tiket_unique` (`no_tiket`),
  KEY `ppid_pengaduan_status_index` (`status`),
  KEY `ppid_pengaduan_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ppid_keberatan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_registrasi` varchar(50) NOT NULL,
  `permohonan_id` bigint(20) unsigned DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(30) DEFAULT NULL,
  `alasan` varchar(5) NOT NULL,
  `uraian` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'diproses',
  `tanggapan` text DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ppid_keberatan_no_registrasi_unique` (`no_registrasi`),
  KEY `ppid_keberatan_permohonan_id_foreign` (`permohonan_id`),
  KEY `ppid_keberatan_status_index` (`status`),
  KEY `ppid_keberatan_created_at_index` (`created_at`),
  CONSTRAINT `ppid_keberatan_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `ppid_permohonan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

