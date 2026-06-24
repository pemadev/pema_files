-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 07, 2026 at 01:18 PM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u601794364_pema`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `action`, `module`, `description`, `subject_type`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'deleted', 'banner', 'Menghapus banner: Poster Agroindustri', NULL, NULL, '2026-06-07 00:34:57', '2026-06-07 00:34:57'),
(2, 1, 'deleted', 'banner', 'Menghapus banner: Poster Jasa & Perdagangan', NULL, NULL, '2026-06-07 00:35:00', '2026-06-07 00:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `title`, `description`, `date`, `location`, `latitude`, `longitude`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rapat Umum Pemegang Saham (RUPS) Tahunan 2026', 'RUPS Tahunan PT Pembangunan Aceh untuk membahas laporan tahunan, pengesahan laporan keuangan, dan penetapan penggunaan laba tahun buku 2025.', '2026-06-30', 'Banda Aceh', NULL, NULL, 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(2, 'Expo Investasi Aceh 2026', 'PEMA berpartisipasi dalam Expo Investasi Aceh untuk mempromosikan peluang investasi di sektor migas, agroindustri, dan kawasan industri.', '2026-08-15', 'Aceh Convention Center', NULL, NULL, 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(3, 'test', 'test', '2026-06-07', 'test', NULL, NULL, 1, '2026-06-06 14:29:29', '2026-06-06 14:31:53', '2026-06-06 14:31:53'),
(4, 'test', NULL, '2026-06-07', 'Jalan Mohammad Jam, Kampung Baru, Baiturrahman, Banda Aceh, Aceh, Sumatra, 23241, Indonesia', 5.5530155, 95.3186864, 1, '2026-06-06 21:21:14', '2026-06-07 00:38:16', '2026-06-07 00:38:16');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `title`, `link`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'downloaded-image.jpeg', 'Poster PEMA', NULL, 1, 1, '2026-06-06 07:13:00', '2026-06-06 07:13:00', NULL),
(2, 'banners/banner-agro.jpg', 'Poster Agroindustri', NULL, 2, 1, '2026-06-06 07:14:13', '2026-06-07 00:34:57', '2026-06-07 00:34:57'),
(3, 'banners/banner-jasa.jpg', 'Poster Jasa & Perdagangan', NULL, 3, 1, '2026-06-06 07:14:13', '2026-06-07 00:35:00', '2026-06-07 00:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `category`, `title`, `subtitle`, `description`, `icon`, `image`, `images`, `tags`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'migas', 'Alih Kelola Wilayah Kerja Blok B', 'Alih Kelola Wilayah Kerja B  Wilayah Kerja (WK)’B’ merupakan  wilayah  kerja  produksi  migas  paling produktif  di  provinsi  Aceh  sejak  1977  yang  di- operasikan pertama kali oleh Mobil Oil Indonesia.', '<div>Lebih dari 16 Trilion Cubic Feed (TCF) gas dan 700 juta barel kondensat telah diproduksi dari WK ‘B’, dari sejumlah lapangan besar, diantaranya South Arun Lhoksukon A dan D. <br><br></div><div>Gas bumi yang diproduksikan dari WK B menjadi bahan baku utama pembuatan LNG (Liquefied Natural Gas) yang diproduksikan oleh PT Arun NGL untuk di ekspor ke negara pengguna yakni Jepang, Korea dan Taiwan. <br><br></div><div>PEMA  selaku  Badan  Usaha  Milik  Aceh  (BUMA)  melalui  anak  usaha  yakni  PT  Pema  Global  Energi (PGE)  sebagai  Kontraktor  WK  ‘B’  yang  berlaku efektif  sejak  17  Mei  2021  hingga  17  Mei  2041 dengan luasan area kerja mencapai 1.309 km2. <br><br></div><div>Dengan lapangan yang sudah mature menjadi tan- tangan bagi PT PGE untuk tetap beroperasi dan ber- produksi dengan menjaga tingkat keekonomian melalui serangkaian efisiensi dan optimasi, tanpa mengurangi aspek keselamatan operasi.<br><br></div>', NULL, NULL, 'businesses/BUvh17b4rEuXPzu7iWyDhgoLMGoJHtqzOb9hwcUP.webp,businesses/Xc1AifnkfhU07Z2oqvUokkwp9thTMXH9tX0D5ULb.webp', '[\"Alih Kelola\",\"Blok B\",\"Migas Aceh\",\"Hulu Migas\"]', 0, '2026-06-05 15:52:09', '2026-06-07 20:15:56', NULL),
(2, 'migas', 'Komersialisasi Komoditi Sulfur', 'Untuk  bidang  pengelolaan  sumber  daya  alam mineral,  PEMA  telah  merealisasikan pengembangan  mineral  sulfur.', '<div>Terkait  proyek sulfur  ini,  PEMA  telah  melakukan pengapalan lifting  sulfur  perdana  pada  Jumat,  14  Januari 2022 sebanyak 1.300 ton dengan tujuan industri kertas. <br><br></div><div>Sulfur itu merupakan hasil produksi wilayah kerja Medco Blok A, dengan pengapalan perdana melalui Pelabuhan KEK Arun, Blanglancang, Lhokseumawe.<br><br></div><div>Komodi sulfur  digunakan  dalam  skala  besar untuk  kebutuhan  industri  pupuk  dan  industri kertas.  Dengan  begitu,  PEMA  mampu mendongkrak  pemasukan  terhadap  Pendapatan Asli  Daerah  Aceh.  Proses  pengapalan  dan pengiriman  material  sulfur  diharapkan  terus meningkat.<br><br></div>', NULL, NULL, 'businesses/hEt3uEGoqdyMOGhSkji79UckZ6qomqKICJ18D7Jt.webp', '[\"Sulfur\",\"Komoditi\",\"Perdagangan\"]', 1, '2026-06-05 15:52:09', '2026-06-07 20:15:56', NULL),
(3, 'agroindustri', 'Komersialisasi Komoditi Kopi', 'Kopi Gayo telah menerima beberapa  Sertifikasi Internasional karena  kualitasnya yang sangat baik. Terutama  kopi  organiknya yang memiliki sertifikat fair trade dengan Indikasi Geografis (GI).', '<div>Kopi berkualitas tinggi yang tumbuh di  ketinggian  antara  1.200 hingga 1.500 meter di atas permukaan laut. Memiliki cita rasa yang  khas,  dengan  sentuhan bunga,  cokelat,  dan  rempah- rempah.  Adapun  produk  yang ditawarkan  berupa  jenis  kopi grade  1  dengan  metode  semi-washed yang  baik  serta  kopi asalan.<br><br></div><div>Secara  khusus,  kopi  Arabika  Gayo mendapat nilai tertinggi dalam Lelang Kopi  Spesial  Indonesia  2010  di  Bali, yang menjamin kualitas Arabika Gayo sebagai  salah  satu  kopi  terbaik  di dunia. Oleh Karena itu PEMA sebagai BUMA memiliki kewajiban untuk ikut serta  dalam  pengembangan  industri Kopi di Aceh yang mana menjadi salah satu  pemasukan  hasil  perkebunan terbesar Aceh.<br><br></div><div>Bisnis Trading Kopi Arabika Gayo, dimana PEMA bekerjasama dengan mitra lokal berupa  kerjasama  operasional  (KSO). Kerjasama ini memiliki potensi dengan 950 orang yang memiliki luas lahan 975 Ha, dengan potensi sebesar ini diharapkan untuk mampu memproduksi kopi sebanyak 40 Kontainer per tahun.<br><br></div><div><br></div>', NULL, NULL, 'businesses/LHM2N086KXWPNbXvrJc23nVPPdFSoKkFs2GcbPht.webp', '[\"Kopi Gayo\",\"Arabika\",\"Perkebunan\",\"Ekspor\"]', 0, '2026-06-05 15:52:09', '2026-06-07 20:15:56', NULL),
(4, 'agroindustri', 'Industri Perikanan Aceh', NULL, 'PEMA berinvestasi dalam industri perikanan berbasis potensi kelautan Aceh yang melimpah. Pengembangan dilakukan dari hulu ke hilir untuk menciptakan rantai nilai yang kuat dan berkelanjutan.', NULL, NULL, NULL, '[\"Perikanan\",\"Kelautan\",\"Industri\"]', 1, '2026-06-05 15:52:09', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(5, 'agroindustri', 'Ekspor Cangkang Sawit', NULL, 'PEMA melakukan ekspor cangkang sawit (palm kernel shell) yang digunakan sebagai bahan bakar biomassa ramah lingkungan. Produk ini memiliki permintaan tinggi di pasar Jepang, Korea, dan Eropa.', NULL, NULL, NULL, '[\"Cangkang Sawit\",\"Biomassa\",\"Ekspor\"]', 2, '2026-06-05 15:52:09', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(6, 'jasa', 'Kawasan Industri Aceh (KIA) Ladong', NULL, 'PEMA mengelola Kawasan Industri Aceh (KIA) Ladong yang berlokasi strategis di Aceh Besar. Kawasan ini dikembangkan sebagai pusat industri terpadu yang ramah lingkungan dan berdaya saing global.', NULL, NULL, NULL, '[\"KIA Ladong\",\"Kawasan Industri\",\"Investasi\"]', 0, '2026-06-05 15:52:09', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(7, 'jasa', 'KEK Arun — Kawasan Ekonomi Khusus', NULL, 'PEMA berperan dalam pengembangan Kawasan Ekonomi Khusus (KEK) Arun sebagai pusat pertumbuhan ekonomi baru di Aceh Utara. KEK Arun difokuskan pada sektor industri, energi, dan logistik.', NULL, NULL, NULL, '[\"KEK Arun\",\"Kawasan Ekonomi\",\"Industri\"]', 1, '2026-06-05 15:52:09', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(8, 'jasa', 'Jaringan Telekomunikasi', NULL, 'PEMA menyediakan layanan infrastruktur telekomunikasi untuk mendukung konektivitas digital di berbagai wilayah Aceh, termasuk daerah terpencil yang belum terjangkau oleh operator utama.', NULL, NULL, NULL, '[\"Telekomunikasi\",\"Infrastruktur\",\"Digital\"]', 2, '2026-06-05 15:52:09', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(9, 'migas', 'Alih Kelola Kerja Blok B', NULL, '<p>Deskripsi detail untuk Alih Kelola Kerja Blok B. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 2, '2026-06-05 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(10, 'migas', 'Komoditi Sulfur', NULL, '<p>Deskripsi detail untuk Komoditi Sulfur. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 3, '2026-03-08 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(11, 'migas', 'Explorasi Minyak Blok A', NULL, '<p>Deskripsi detail untuk Explorasi Minyak Blok A. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 4, '2026-04-21 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(12, 'migas', 'Pengolahan Gas Alam', NULL, '<p>Deskripsi detail untuk Pengolahan Gas Alam. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 5, '2026-05-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(13, 'migas', 'Distribusi BBM Regional', NULL, '<p>Deskripsi detail untuk Distribusi BBM Regional. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 6, '2026-04-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(14, 'migas', 'Pertambangan Batubara', NULL, '<p>Deskripsi detail untuk Pertambangan Batubara. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 7, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(15, 'migas', 'Energi Surya Aceh', NULL, '<p>Deskripsi detail untuk Energi Surya Aceh. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 8, '2026-04-27 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(16, 'migas', 'Pembangkit Listrik Gas', NULL, '<p>Deskripsi detail untuk Pembangkit Listrik Gas. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 9, '2026-05-02 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(17, 'migas', 'Pengolahan Minyak Mentah', NULL, '<p>Deskripsi detail untuk Pengolahan Minyak Mentah. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 10, '2026-03-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(18, 'migas', 'Storage & Tank Farm', NULL, '<p>Deskripsi detail untuk Storage & Tank Farm. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 11, '2026-04-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(19, 'migas', 'Pipeline Transportasi Gas', NULL, '<p>Deskripsi detail untuk Pipeline Transportasi Gas. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 12, '2026-03-31 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(20, 'migas', 'LNG Processing Plant', NULL, '<p>Deskripsi detail untuk LNG Processing Plant. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 13, '2026-04-05 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(21, 'migas', 'Drilling Services Aceh', NULL, '<p>Deskripsi detail untuk Drilling Services Aceh. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 14, '2026-05-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(22, 'migas', 'Well Maintenance Program', NULL, '<p>Deskripsi detail untuk Well Maintenance Program. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 15, '2026-04-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(23, 'migas', 'Seismic Survey Aceh', NULL, '<p>Deskripsi detail untuk Seismic Survey Aceh. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 16, '2026-04-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(24, 'migas', 'Geothermal Exploration', NULL, '<p>Deskripsi detail untuk Geothermal Exploration. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 17, '2026-04-07 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(25, 'migas', 'Biomass Energy Plant', NULL, '<p>Deskripsi detail untuk Biomass Energy Plant. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 18, '2026-05-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(26, 'migas', 'Hydro Power Aceh', NULL, '<p>Deskripsi detail untuk Hydro Power Aceh. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 19, '2026-03-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(27, 'migas', 'Wind Farm Lhokseumawe', NULL, '<p>Deskripsi detail untuk Wind Farm Lhokseumawe. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 20, '2026-03-21 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(28, 'migas', 'Solar Panel Installation', NULL, '<p>Deskripsi detail untuk Solar Panel Installation. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 21, '2026-04-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(29, 'migas', 'Gas Processing Unit', NULL, '<p>Deskripsi detail untuk Gas Processing Unit. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 22, '2026-05-16 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(30, 'migas', 'Oil Refinery Modernization', NULL, '<p>Deskripsi detail untuk Oil Refinery Modernization. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 23, '2026-03-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(31, 'migas', 'Petrochemical Plant', NULL, '<p>Deskripsi detail untuk Petrochemical Plant. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 24, '2026-04-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(32, 'migas', 'Lubricant Manufacturing', NULL, '<p>Deskripsi detail untuk Lubricant Manufacturing. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 25, '2026-05-31 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(33, 'migas', 'Asphalt Production', NULL, '<p>Deskripsi detail untuk Asphalt Production. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 26, '2026-04-20 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(34, 'migas', 'Bitumen Processing', NULL, '<p>Deskripsi detail untuk Bitumen Processing. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 27, '2026-04-29 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(35, 'migas', 'Naphtha Production', NULL, '<p>Deskripsi detail untuk Naphtha Production. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 28, '2026-03-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(36, 'migas', 'Kerosene Distribution', NULL, '<p>Deskripsi detail untuk Kerosene Distribution. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 29, '2026-04-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(37, 'migas', 'Diesel Fuel Supply', NULL, '<p>Deskripsi detail untuk Diesel Fuel Supply. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 30, '2026-04-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(38, 'migas', 'Aviation Fuel Services', NULL, '<p>Deskripsi detail untuk Aviation Fuel Services. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 31, '2026-04-16 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(39, 'migas', 'Marine Fuel Supply', NULL, '<p>Deskripsi detail untuk Marine Fuel Supply. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 32, '2026-05-29 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(40, 'migas', 'LPG Distribution Network', NULL, '<p>Deskripsi detail untuk LPG Distribution Network. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 33, '2026-05-29 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(41, 'migas', 'Natural Gas Pipeline', NULL, '<p>Deskripsi detail untuk Natural Gas Pipeline. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 34, '2026-03-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(42, 'migas', 'CNG Station Network', NULL, '<p>Deskripsi detail untuk CNG Station Network. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 35, '2026-04-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(43, 'migas', 'Hydrogen Production', NULL, '<p>Deskripsi detail untuk Hydrogen Production. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 36, '2026-05-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(44, 'migas', 'Carbon Capture Project', NULL, '<p>Deskripsi detail untuk Carbon Capture Project. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 37, '2026-06-05 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(45, 'migas', 'Methane Recovery System', NULL, '<p>Deskripsi detail untuk Methane Recovery System. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 38, '2026-04-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(46, 'migas', 'Flare Gas Recovery', NULL, '<p>Deskripsi detail untuk Flare Gas Recovery. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 39, '2026-05-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(47, 'migas', 'Enhanced Oil Recovery', NULL, '<p>Deskripsi detail untuk Enhanced Oil Recovery. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 40, '2026-05-08 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(48, 'migas', 'Enhanced Gas Recovery', NULL, '<p>Deskripsi detail untuk Enhanced Gas Recovery. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 41, '2026-05-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(49, 'migas', 'Oil Spill Response', NULL, '<p>Deskripsi detail untuk Oil Spill Response. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 42, '2026-03-10 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(50, 'migas', 'Environmental Monitoring', NULL, '<p>Deskripsi detail untuk Environmental Monitoring. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 43, '2026-05-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(51, 'migas', 'Waste Heat Recovery', NULL, '<p>Deskripsi detail untuk Waste Heat Recovery. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 44, '2026-03-31 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(52, 'migas', 'Cogeneration Plant', NULL, '<p>Deskripsi detail untuk Cogeneration Plant. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 45, '2026-04-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(53, 'migas', 'Trigeneration System', NULL, '<p>Deskripsi detail untuk Trigeneration System. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 46, '2026-04-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(54, 'migas', 'Power Purchase Agreement', NULL, '<p>Deskripsi detail untuk Power Purchase Agreement. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 47, '2026-03-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(55, 'migas', 'Energy Audit Services', NULL, '<p>Deskripsi detail untuk Energy Audit Services. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 48, '2026-04-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(56, 'migas', 'Energy Efficiency Program', NULL, '<p>Deskripsi detail untuk Energy Efficiency Program. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 49, '2026-04-06 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(57, 'migas', 'Smart Grid Implementation', NULL, '<p>Deskripsi detail untuk Smart Grid Implementation. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 50, '2026-03-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(58, 'migas', 'Micro Grid Development', NULL, '<p>Deskripsi detail untuk Micro Grid Development. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 51, '2026-06-05 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(59, 'migas', 'Battery Storage System', NULL, '<p>Deskripsi detail untuk Battery Storage System. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 52, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(60, 'migas', 'EV Charging Network', NULL, '<p>Deskripsi detail untuk EV Charging Network. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 53, '2026-05-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(61, 'migas', 'Fuel Cell Technology', NULL, '<p>Deskripsi detail untuk Fuel Cell Technology. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 54, '2026-04-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(62, 'migas', 'Biofuel Production', NULL, '<p>Deskripsi detail untuk Biofuel Production. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 55, '2026-04-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(63, 'migas', 'Ethanol Manufacturing', NULL, '<p>Deskripsi detail untuk Ethanol Manufacturing. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 56, '2026-04-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(64, 'migas', 'Biodiesel Processing', NULL, '<p>Deskripsi detail untuk Biodiesel Processing. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 57, '2026-04-16 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(65, 'migas', 'Renewable Energy Certificate', NULL, '<p>Deskripsi detail untuk Renewable Energy Certificate. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 58, '2026-03-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(66, 'migas', 'Carbon Trading Platform', NULL, '<p>Deskripsi detail untuk Carbon Trading Platform. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 59, '2026-06-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(67, 'migas', 'Emissions Monitoring', NULL, '<p>Deskripsi detail untuk Emissions Monitoring. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 60, '2026-05-25 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(68, 'migas', 'Air Quality Monitoring', NULL, '<p>Deskripsi detail untuk Air Quality Monitoring. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 61, '2026-03-27 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(69, 'migas', 'Water Treatment Plant', NULL, '<p>Deskripsi detail untuk Water Treatment Plant. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 62, '2026-03-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(70, 'migas', 'Desalination Project', NULL, '<p>Deskripsi detail untuk Desalination Project. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 63, '2026-05-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(71, 'migas', 'Wastewater Treatment', NULL, '<p>Deskripsi detail untuk Wastewater Treatment. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 64, '2026-04-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(72, 'migas', 'Solid Waste Management', NULL, '<p>Deskripsi detail untuk Solid Waste Management. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 65, '2026-04-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(73, 'migas', 'Hazardous Waste Disposal', NULL, '<p>Deskripsi detail untuk Hazardous Waste Disposal. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 66, '2026-06-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(74, 'migas', 'Environmental Impact Assessment', NULL, '<p>Deskripsi detail untuk Environmental Impact Assessment. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 67, '2026-05-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(75, 'migas', 'Sustainability Reporting', NULL, '<p>Deskripsi detail untuk Sustainability Reporting. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 68, '2026-03-18 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(76, 'migas', 'Green Building Certification', NULL, '<p>Deskripsi detail untuk Green Building Certification. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 69, '2026-04-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(77, 'migas', 'Energy Star Program', NULL, '<p>Deskripsi detail untuk Energy Star Program. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 70, '2026-05-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(78, 'migas', 'ISO 14001 Certification', NULL, '<p>Deskripsi detail untuk ISO 14001 Certification. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 71, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(79, 'migas', 'Clean Development Mechanism', NULL, '<p>Deskripsi detail untuk Clean Development Mechanism. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 72, '2026-04-18 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(80, 'migas', 'Joint Implementation Project', NULL, '<p>Deskripsi detail untuk Joint Implementation Project. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 73, '2026-04-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(81, 'migas', 'Carbon Offset Program', NULL, '<p>Deskripsi detail untuk Carbon Offset Program. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 74, '2026-04-20 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(82, 'migas', 'Renewable Portfolio Standard', NULL, '<p>Deskripsi detail untuk Renewable Portfolio Standard. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 75, '2026-05-18 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(83, 'migas', 'Feed-in Tariff Program', NULL, '<p>Deskripsi detail untuk Feed-in Tariff Program. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 76, '2026-05-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(84, 'migas', 'Net Metering Program', NULL, '<p>Deskripsi detail untuk Net Metering Program. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 77, '2026-03-23 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(85, 'migas', 'Virtual Power Plant', NULL, '<p>Deskripsi detail untuk Virtual Power Plant. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 78, '2026-05-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(86, 'migas', 'Demand Response Program', NULL, '<p>Deskripsi detail untuk Demand Response Program. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 79, '2026-03-10 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(87, 'migas', 'Peak Shaving Service', NULL, '<p>Deskripsi detail untuk Peak Shaving Service. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 80, '2026-04-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(88, 'migas', 'Load Balancing System', NULL, '<p>Deskripsi detail untuk Load Balancing System. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 81, '2026-06-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(89, 'migas', 'Frequency Regulation', NULL, '<p>Deskripsi detail untuk Frequency Regulation. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 82, '2026-04-29 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(90, 'migas', 'Voltage Control Service', NULL, '<p>Deskripsi detail untuk Voltage Control Service. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 83, '2026-04-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(91, 'migas', 'Reactive Power Compensation', NULL, '<p>Deskripsi detail untuk Reactive Power Compensation. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 84, '2026-05-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(92, 'migas', 'Power Quality Monitoring', NULL, '<p>Deskripsi detail untuk Power Quality Monitoring. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 85, '2026-03-10 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(93, 'migas', 'Grid Stability Analysis', NULL, '<p>Deskripsi detail untuk Grid Stability Analysis. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 86, '2026-05-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(94, 'migas', 'Reliability Assessment', NULL, '<p>Deskripsi detail untuk Reliability Assessment. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 87, '2026-04-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(95, 'migas', 'Maintenance Scheduling', NULL, '<p>Deskripsi detail untuk Maintenance Scheduling. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 88, '2026-03-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(96, 'migas', 'Predictive Maintenance AI', NULL, '<p>Deskripsi detail untuk Predictive Maintenance AI. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 89, '2026-04-10 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(97, 'migas', 'Digital Twin Technology', NULL, '<p>Deskripsi detail untuk Digital Twin Technology. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 90, '2026-04-25 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(98, 'migas', 'IoT Sensor Network', NULL, '<p>Deskripsi detail untuk IoT Sensor Network. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 91, '2026-04-02 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(99, 'migas', 'Remote Monitoring System', NULL, '<p>Deskripsi detail untuk Remote Monitoring System. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 92, '2026-04-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(100, 'migas', 'SCADA Integration', NULL, '<p>Deskripsi detail untuk SCADA Integration. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 93, '2026-04-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(101, 'migas', 'Cybersecurity for Energy', NULL, '<p>Deskripsi detail untuk Cybersecurity for Energy. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 94, '2026-03-31 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(102, 'migas', 'Data Analytics Platform', NULL, '<p>Deskripsi detail untuk Data Analytics Platform. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 95, '2026-06-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(103, 'migas', 'Machine Learning Optimization', NULL, '<p>Deskripsi detail untuk Machine Learning Optimization. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 96, '2026-03-18 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(104, 'migas', 'Cloud Computing Infrastructure', NULL, '<p>Deskripsi detail untuk Cloud Computing Infrastructure. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 97, '2026-03-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(105, 'migas', 'Edge Computing Deployment', NULL, '<p>Deskripsi detail untuk Edge Computing Deployment. Ini adalah unit bisnis yang bergerak di sektor minyak dan gas bumi yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"minyak\",\"gas\",\"energi\",\"aceh\"]', 98, '2026-05-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(106, 'agroindustri', 'Perkebunan Kopi Aceh', NULL, '<p>Deskripsi detail untuk Perkebunan Kopi Aceh. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 3, '2026-04-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(107, 'agroindustri', 'Industri Perikanan', NULL, '<p>Deskripsi detail untuk Industri Perikanan. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 4, '2026-05-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(108, 'agroindustri', 'Eksport Cangkang Sawit', NULL, '<p>Deskripsi detail untuk Eksport Cangkang Sawit. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 5, '2026-04-29 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(109, 'agroindustri', 'Pengolahan Kelapa Sawit', NULL, '<p>Deskripsi detail untuk Pengolahan Kelapa Sawit. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 6, '2026-05-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09');
INSERT INTO `businesses` (`id`, `category`, `title`, `subtitle`, `description`, `icon`, `image`, `images`, `tags`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(110, 'agroindustri', 'Pertanian Organik', NULL, '<p>Deskripsi detail untuk Pertanian Organik. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 7, '2026-04-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(111, 'agroindustri', 'Hortikultura Modern', NULL, '<p>Deskripsi detail untuk Hortikultura Modern. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 8, '2026-05-29 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(112, 'agroindustri', 'Peternakan Ayam', NULL, '<p>Deskripsi detail untuk Peternakan Ayam. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 9, '2026-05-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(113, 'agroindustri', 'Budidaya Ikan Lele', NULL, '<p>Deskripsi detail untuk Budidaya Ikan Lele. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 10, '2026-03-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(114, 'agroindustri', 'Perkebunan Karet', NULL, '<p>Deskripsi detail untuk Perkebunan Karet. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 11, '2026-06-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(115, 'agroindustri', 'Industri Kopi Arabika', NULL, '<p>Deskripsi detail untuk Industri Kopi Arabika. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 12, '2026-04-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(116, 'agroindustri', 'Pengolahan Kakao', NULL, '<p>Deskripsi detail untuk Pengolahan Kakao. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 13, '2026-05-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(117, 'agroindustri', 'Pertanian Padi Sawah', NULL, '<p>Deskripsi detail untuk Pertanian Padi Sawah. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 14, '2026-05-21 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(118, 'agroindustri', 'Perkebunan Nilam', NULL, '<p>Deskripsi detail untuk Perkebunan Nilam. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 15, '2026-05-08 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(119, 'agroindustri', 'Industri Lada Hitam', NULL, '<p>Deskripsi detail untuk Industri Lada Hitam. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 16, '2026-04-25 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(120, 'agroindustri', 'Pengolahan Cengkeh', NULL, '<p>Deskripsi detail untuk Pengolahan Cengkeh. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 17, '2026-06-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(121, 'agroindustri', 'Pertanian Jagung', NULL, '<p>Deskripsi detail untuk Pertanian Jagung. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 18, '2026-04-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(122, 'agroindustri', 'Perkebunan Pisang', NULL, '<p>Deskripsi detail untuk Perkebunan Pisang. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 19, '2026-04-18 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(123, 'agroindustri', 'Industri Ubikayu', NULL, '<p>Deskripsi detail untuk Industri Ubikayu. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 20, '2026-03-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(124, 'agroindustri', 'Budidaya Udang', NULL, '<p>Deskripsi detail untuk Budidaya Udang. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 21, '2026-04-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(125, 'agroindustri', 'Perikanan Tangkap', NULL, '<p>Deskripsi detail untuk Perikanan Tangkap. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 22, '2026-05-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(126, 'agroindustri', 'Pengolahan Hasil Laut', NULL, '<p>Deskripsi detail untuk Pengolahan Hasil Laut. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 23, '2026-05-05 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(127, 'agroindustri', 'Industri Susu Sapi', NULL, '<p>Deskripsi detail untuk Industri Susu Sapi. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 24, '2026-05-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(128, 'agroindustri', 'Peternakan Kambing', NULL, '<p>Deskripsi detail untuk Peternakan Kambing. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 25, '2026-03-21 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(129, 'agroindustri', 'Perkebunan Teh', NULL, '<p>Deskripsi detail untuk Perkebunan Teh. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 26, '2026-05-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(130, 'agroindustri', 'Pertanian Sayuran', NULL, '<p>Deskripsi detail untuk Pertanian Sayuran. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 27, '2026-04-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(131, 'agroindustri', 'Industri Buah-buahan', NULL, '<p>Deskripsi detail untuk Industri Buah-buahan. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 28, '2026-05-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(132, 'agroindustri', 'Pengolahan Rempah', NULL, '<p>Deskripsi detail untuk Pengolahan Rempah. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 29, '2026-04-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(133, 'agroindustri', 'Pertanian Organik Premium', NULL, '<p>Deskripsi detail untuk Pertanian Organik Premium. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 30, '2026-03-16 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(134, 'agroindustri', 'Budidaya Lele Sangkuriang', NULL, '<p>Deskripsi detail untuk Budidaya Lele Sangkuriang. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 31, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(135, 'agroindustri', 'Perikanan Bandeng', NULL, '<p>Deskripsi detail untuk Perikanan Bandeng. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 32, '2026-04-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(136, 'agroindustri', 'Industri Tepung Ikan', NULL, '<p>Deskripsi detail untuk Industri Tepung Ikan. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 33, '2026-03-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(137, 'agroindustri', 'Pengolahan Rumput Laut', NULL, '<p>Deskripsi detail untuk Pengolahan Rumput Laut. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 34, '2026-04-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(138, 'agroindustri', 'Pertanian Madu Lebah', NULL, '<p>Deskripsi detail untuk Pertanian Madu Lebah. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 35, '2026-03-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(139, 'agroindustri', 'Perkebunan Jati', NULL, '<p>Deskripsi detail untuk Perkebunan Jati. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 36, '2026-04-02 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(140, 'agroindustri', 'Industri Rotan', NULL, '<p>Deskripsi detail untuk Industri Rotan. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 37, '2026-05-20 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(141, 'agroindustri', 'Pertanian Tembakau', NULL, '<p>Deskripsi detail untuk Pertanian Tembakau. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 38, '2026-04-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(142, 'agroindustri', 'Pengolahan Kopi Liberika', NULL, '<p>Deskripsi detail untuk Pengolahan Kopi Liberika. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 39, '2026-04-25 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(143, 'agroindustri', 'Budidaya Ikan Gurame', NULL, '<p>Deskripsi detail untuk Budidaya Ikan Gurame. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 40, '2026-04-10 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(144, 'agroindustri', 'Perikanan Tuna', NULL, '<p>Deskripsi detail untuk Perikanan Tuna. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 41, '2026-05-27 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(145, 'agroindustri', 'Industri Keripik Pisang', NULL, '<p>Deskripsi detail untuk Industri Keripik Pisang. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 42, '2026-05-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(146, 'agroindustri', 'Pertanian Kentang', NULL, '<p>Deskripsi detail untuk Pertanian Kentang. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 43, '2026-05-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(147, 'agroindustri', 'Perkebunan Cabe', NULL, '<p>Deskripsi detail untuk Perkebunan Cabe. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 44, '2026-03-23 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(148, 'agroindustri', 'Industri Kacang Tanah', NULL, '<p>Deskripsi detail untuk Industri Kacang Tanah. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 45, '2026-04-18 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(149, 'agroindustri', 'Pengolahan Bawang', NULL, '<p>Deskripsi detail untuk Pengolahan Bawang. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 46, '2026-04-08 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(150, 'agroindustri', 'Pertanian Melon', NULL, '<p>Deskripsi detail untuk Pertanian Melon. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 47, '2026-05-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(151, 'agroindustri', 'Budidaya Ikan Nila', NULL, '<p>Deskripsi detail untuk Budidaya Ikan Nila. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 48, '2026-04-06 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(152, 'agroindustri', 'Perikanan Cakalang', NULL, '<p>Deskripsi detail untuk Perikanan Cakalang. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 49, '2026-05-08 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(153, 'agroindustri', 'Industri Kedelai', NULL, '<p>Deskripsi detail untuk Industri Kedelai. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 50, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(154, 'agroindustri', 'Pertanian Ubi Jalar', NULL, '<p>Deskripsi detail untuk Pertanian Ubi Jalar. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 51, '2026-03-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(155, 'agroindustri', 'Perkebunan Jahe', NULL, '<p>Deskripsi detail untuk Perkebunan Jahe. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 52, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(156, 'agroindustri', 'Industri Kunyit', NULL, '<p>Deskripsi detail untuk Industri Kunyit. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 53, '2026-03-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(157, 'agroindustri', 'Pengolahan Lengkuas', NULL, '<p>Deskripsi detail untuk Pengolahan Lengkuas. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 54, '2026-03-20 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(158, 'agroindustri', 'Pertanian Serai', NULL, '<p>Deskripsi detail untuk Pertanian Serai. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 55, '2026-03-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(159, 'agroindustri', 'Perkebunan Kemiri', NULL, '<p>Deskripsi detail untuk Perkebunan Kemiri. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 56, '2026-04-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(160, 'agroindustri', 'Industri Pala', NULL, '<p>Deskripsi detail untuk Industri Pala. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 57, '2026-05-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(161, 'agroindustri', 'Pengolahan Vanili', NULL, '<p>Deskripsi detail untuk Pengolahan Vanili. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 58, '2026-04-08 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(162, 'agroindustri', 'Pertanian Coklat Rakyat', NULL, '<p>Deskripsi detail untuk Pertanian Coklat Rakyat. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 59, '2026-04-06 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(163, 'agroindustri', 'Budidaya Ikan Patin', NULL, '<p>Deskripsi detail untuk Budidaya Ikan Patin. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 60, '2026-04-05 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(164, 'agroindustri', 'Perikanan Tongkol', NULL, '<p>Deskripsi detail untuk Perikanan Tongkol. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 61, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(165, 'agroindustri', 'Industri Abon Ikan', NULL, '<p>Deskripsi detail untuk Industri Abon Ikan. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 62, '2026-04-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(166, 'agroindustri', 'Pertanian Padi Organik', NULL, '<p>Deskripsi detail untuk Pertanian Padi Organik. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 63, '2026-04-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(167, 'agroindustri', 'Perkebunan Sawit Rakyat', NULL, '<p>Deskripsi detail untuk Perkebunan Sawit Rakyat. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 64, '2026-04-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(168, 'agroindustri', 'Industri Minyak Sawit', NULL, '<p>Deskripsi detail untuk Industri Minyak Sawit. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 65, '2026-05-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(169, 'agroindustri', 'Pengolahan Palm Kernel', NULL, '<p>Deskripsi detail untuk Pengolahan Palm Kernel. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 66, '2026-04-22 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(170, 'agroindustri', 'Pertanian Jagung Manis', NULL, '<p>Deskripsi detail untuk Pertanian Jagung Manis. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 67, '2026-03-21 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(171, 'agroindustri', 'Budidaya Ikan Mas', NULL, '<p>Deskripsi detail untuk Budidaya Ikan Mas. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 68, '2026-04-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(172, 'agroindustri', 'Perikanan Herring', NULL, '<p>Deskripsi detail untuk Perikanan Herring. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 69, '2026-05-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(173, 'agroindustri', 'Industri Tahu Tempe', NULL, '<p>Deskripsi detail untuk Industri Tahu Tempe. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 70, '2026-05-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(174, 'agroindustri', 'Pertanian Kacang Hijau', NULL, '<p>Deskripsi detail untuk Pertanian Kacang Hijau. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 71, '2026-04-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(175, 'agroindustri', 'Perkebunan Kacang Mete', NULL, '<p>Deskripsi detail untuk Perkebunan Kacang Mete. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 72, '2026-05-31 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(176, 'agroindustri', 'Industri Minyak Atsiri', NULL, '<p>Deskripsi detail untuk Industri Minyak Atsiri. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 73, '2026-05-08 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(177, 'agroindustri', 'Pengolahan Nilam Aceh', NULL, '<p>Deskripsi detail untuk Pengolahan Nilam Aceh. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 74, '2026-04-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(178, 'agroindustri', 'Pertanian Jahe Merah', NULL, '<p>Deskripsi detail untuk Pertanian Jahe Merah. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 75, '2026-05-20 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(179, 'agroindustri', 'Budidaya Ikan Sidat', NULL, '<p>Deskripsi detail untuk Budidaya Ikan Sidat. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 76, '2026-05-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(180, 'agroindustri', 'Perikanan Teri', NULL, '<p>Deskripsi detail untuk Perikanan Teri. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 77, '2026-03-29 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(181, 'agroindustri', 'Industri Terasi', NULL, '<p>Deskripsi detail untuk Industri Terasi. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 78, '2026-06-05 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(182, 'agroindustri', 'Pertanian Padi Inpari', NULL, '<p>Deskripsi detail untuk Pertanian Padi Inpari. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 79, '2026-05-22 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(183, 'agroindustri', 'Perkebunan Kelapa', NULL, '<p>Deskripsi detail untuk Perkebunan Kelapa. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 80, '2026-04-25 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(184, 'agroindustri', 'Industri Copra', NULL, '<p>Deskripsi detail untuk Industri Copra. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 81, '2026-04-21 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(185, 'agroindustri', 'Pengolahan Virgin Coconut', NULL, '<p>Deskripsi detail untuk Pengolahan Virgin Coconut. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 82, '2026-05-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(186, 'agroindustri', 'Pertanian Ubi Kayu', NULL, '<p>Deskripsi detail untuk Pertanian Ubi Kayu. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 83, '2026-04-02 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(187, 'agroindustri', 'Budidaya Ikan Baung', NULL, '<p>Deskripsi detail untuk Budidaya Ikan Baung. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 84, '2026-04-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(188, 'agroindustri', 'Perikanan Belut', NULL, '<p>Deskripsi detail untuk Perikanan Belut. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 85, '2026-04-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(189, 'agroindustri', 'Industri Kerupuk', NULL, '<p>Deskripsi detail untuk Industri Kerupuk. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 86, '2026-05-07 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(190, 'agroindustri', 'Pertanian Semangka', NULL, '<p>Deskripsi detail untuk Pertanian Semangka. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 87, '2026-03-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(191, 'agroindustri', 'Perkebunan Semangka', NULL, '<p>Deskripsi detail untuk Perkebunan Semangka. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 88, '2026-04-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(192, 'agroindustri', 'Industri Jus Buah', NULL, '<p>Deskripsi detail untuk Industri Jus Buah. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 89, '2026-06-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(193, 'agroindustri', 'Pengolahan Frozen Food', NULL, '<p>Deskripsi detail untuk Pengolahan Frozen Food. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 90, '2026-04-23 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(194, 'agroindustri', 'Pertanian Wortel', NULL, '<p>Deskripsi detail untuk Pertanian Wortel. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 91, '2026-04-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(195, 'agroindustri', 'Budidaya Ikan Lele Dumbo', NULL, '<p>Deskripsi detail untuk Budidaya Ikan Lele Dumbo. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 92, '2026-04-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(196, 'agroindustri', 'Perikanan Gurita', NULL, '<p>Deskripsi detail untuk Perikanan Gurita. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 93, '2026-05-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(197, 'agroindustri', 'Industri Sarden Kaleng', NULL, '<p>Deskripsi detail untuk Industri Sarden Kaleng. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 94, '2026-05-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(198, 'agroindustri', 'Pertanian Bayam', NULL, '<p>Deskripsi detail untuk Pertanian Bayam. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 95, '2026-04-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(199, 'agroindustri', 'Perkebunan Kubis', NULL, '<p>Deskripsi detail untuk Perkebunan Kubis. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 96, '2026-05-05 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(200, 'agroindustri', 'Industri Selada', NULL, '<p>Deskripsi detail untuk Industri Selada. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 97, '2026-04-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(201, 'agroindustri', 'Pengolahan Sayuran Beku', NULL, '<p>Deskripsi detail untuk Pengolahan Sayuran Beku. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 98, '2026-04-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(202, 'agroindustri', 'Pertanian Tomat', NULL, '<p>Deskripsi detail untuk Pertanian Tomat. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 99, '2026-05-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(203, 'agroindustri', 'Budidaya Ikan Hias', NULL, '<p>Deskripsi detail untuk Budidaya Ikan Hias. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 100, '2026-05-22 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(204, 'agroindustri', 'Perikanan Salmon Lokal', NULL, '<p>Deskripsi detail untuk Perikanan Salmon Lokal. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 101, '2026-05-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(205, 'agroindustri', 'Industri Makanan Ringan', NULL, '<p>Deskripsi detail untuk Industri Makanan Ringan. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 102, '2026-05-16 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(206, 'agroindustri', 'Pertanian Cabe Rawit', NULL, '<p>Deskripsi detail untuk Pertanian Cabe Rawit. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 103, '2026-05-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(207, 'agroindustri', 'Perkebunan Jahe Gajah', NULL, '<p>Deskripsi detail untuk Perkebunan Jahe Gajah. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 104, '2026-05-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(208, 'agroindustri', 'Industri Teh Herbal', NULL, '<p>Deskripsi detail untuk Industri Teh Herbal. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 105, '2026-04-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(209, 'agroindustri', 'Pengolahan Rempah Bubuk', NULL, '<p>Deskripsi detail untuk Pengolahan Rempah Bubuk. Ini adalah unit bisnis yang bergerak di sektor agroindustri yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"agro\",\"pertanian\",\"perikanan\",\"aceh\"]', 106, '2026-04-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(210, 'jasa', 'KIA Ladong', NULL, '<p>Deskripsi detail untuk KIA Ladong. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 3, '2026-04-23 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(211, 'jasa', 'KEK Arun', NULL, '<p>Deskripsi detail untuk KEK Arun. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 4, '2026-05-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(212, 'jasa', 'Jaringan Telekomunikasi', NULL, '<p>Deskripsi detail untuk Jaringan Telekomunikasi. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 5, '2026-04-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(213, 'jasa', 'Pengelolaan Pelabuhan', NULL, '<p>Deskripsi detail untuk Pengelolaan Pelabuhan. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 6, '2026-04-23 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(214, 'jasa', 'Logistik & Shipping', NULL, '<p>Deskripsi detail untuk Logistik & Shipping. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 7, '2026-04-27 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(215, 'jasa', 'Konstruksi Gedung', NULL, '<p>Deskripsi detail untuk Konstruksi Gedung. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 8, '2026-03-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(216, 'jasa', 'Pembangunan Jalan', NULL, '<p>Deskripsi detail untuk Pembangunan Jalan. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 9, '2026-05-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(217, 'jasa', 'Jasa Konsultansi', NULL, '<p>Deskripsi detail untuk Jasa Konsultansi. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 10, '2026-04-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(218, 'jasa', 'Pendidikan & Pelatihan', NULL, '<p>Deskripsi detail untuk Pendidikan & Pelatihan. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 11, '2026-04-20 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(219, 'jasa', 'Kesehatan Masyarakat', NULL, '<p>Deskripsi detail untuk Kesehatan Masyarakat. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 12, '2026-03-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(220, 'jasa', 'Pariwisata Aceh', NULL, '<p>Deskripsi detail untuk Pariwisata Aceh. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 13, '2026-04-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(221, 'jasa', 'Perhotelan Banda Aceh', NULL, '<p>Deskripsi detail untuk Perhotelan Banda Aceh. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 14, '2026-03-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(222, 'jasa', 'Restoran & Kuliner', NULL, '<p>Deskripsi detail untuk Restoran & Kuliner. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 15, '2026-04-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(223, 'jasa', 'Jasa Keuangan', NULL, '<p>Deskripsi detail untuk Jasa Keuangan. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 16, '2026-04-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(224, 'jasa', 'Asuransi Syariah', NULL, '<p>Deskripsi detail untuk Asuransi Syariah. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 17, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09');
INSERT INTO `businesses` (`id`, `category`, `title`, `subtitle`, `description`, `icon`, `image`, `images`, `tags`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(225, 'jasa', 'Perbankan Mikro', NULL, '<p>Deskripsi detail untuk Perbankan Mikro. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 18, '2026-05-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(226, 'jasa', 'Jasa Hukum', NULL, '<p>Deskripsi detail untuk Jasa Hukum. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 19, '2026-04-16 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(227, 'jasa', 'Akuntansi & Audit', NULL, '<p>Deskripsi detail untuk Akuntansi & Audit. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 20, '2026-06-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(228, 'jasa', 'Manajemen Properti', NULL, '<p>Deskripsi detail untuk Manajemen Properti. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 21, '2026-05-06 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(229, 'jasa', 'Real Estate Development', NULL, '<p>Deskripsi detail untuk Real Estate Development. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 22, '2026-05-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(230, 'jasa', 'Jasa Kebersihan', NULL, '<p>Deskripsi detail untuk Jasa Kebersihan. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 23, '2026-05-29 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(231, 'jasa', 'Pengamanan Property', NULL, '<p>Deskripsi detail untuk Pengamanan Property. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 24, '2026-04-27 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(232, 'jasa', 'Jasa Catering', NULL, '<p>Deskripsi detail untuk Jasa Catering. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 25, '2026-03-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(233, 'jasa', 'Event Organizer', NULL, '<p>Deskripsi detail untuk Event Organizer. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 26, '2026-04-23 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(234, 'jasa', 'Percetakan & Publishing', NULL, '<p>Deskripsi detail untuk Percetakan & Publishing. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 27, '2026-04-10 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(235, 'jasa', 'Digital Marketing', NULL, '<p>Deskripsi detail untuk Digital Marketing. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 28, '2026-06-02 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(236, 'jasa', 'IT Consulting', NULL, '<p>Deskripsi detail untuk IT Consulting. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 29, '2026-05-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(237, 'jasa', 'Software Development', NULL, '<p>Deskripsi detail untuk Software Development. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 30, '2026-04-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(238, 'jasa', 'Cloud Services', NULL, '<p>Deskripsi detail untuk Cloud Services. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 31, '2026-05-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(239, 'jasa', 'Data Center', NULL, '<p>Deskripsi detail untuk Data Center. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 32, '2026-04-20 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(240, 'jasa', 'Jasa Desain Interior', NULL, '<p>Deskripsi detail untuk Jasa Desain Interior. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 33, '2026-04-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(241, 'jasa', 'Arsitektur & Engineering', NULL, '<p>Deskripsi detail untuk Arsitektur & Engineering. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 34, '2026-03-22 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(242, 'jasa', 'Jasa Survey Tanah', NULL, '<p>Deskripsi detail untuk Jasa Survey Tanah. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 35, '2026-05-31 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(243, 'jasa', 'Pemetaan & GIS', NULL, '<p>Deskripsi detail untuk Pemetaan & GIS. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 36, '2026-05-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(244, 'jasa', 'Jasa Laboratorium', NULL, '<p>Deskripsi detail untuk Jasa Laboratorium. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 37, '2026-06-04 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(245, 'jasa', 'Pengujian Material', NULL, '<p>Deskripsi detail untuk Pengujian Material. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 38, '2026-05-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(246, 'jasa', 'Quality Control Services', NULL, '<p>Deskripsi detail untuk Quality Control Services. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 39, '2026-05-10 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(247, 'jasa', 'Jasa Transportasi', NULL, '<p>Deskripsi detail untuk Jasa Transportasi. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 40, '2026-03-08 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(248, 'jasa', 'Rental Kendaraan', NULL, '<p>Deskripsi detail untuk Rental Kendaraan. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 41, '2026-04-18 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(249, 'jasa', 'Jasa Kurir & Ekspedisi', NULL, '<p>Deskripsi detail untuk Jasa Kurir & Ekspedisi. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 42, '2026-05-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(250, 'jasa', 'Freight Forwarding', NULL, '<p>Deskripsi detail untuk Freight Forwarding. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 43, '2026-04-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(251, 'jasa', 'Customs Brokerage', NULL, '<p>Deskripsi detail untuk Customs Brokerage. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 44, '2026-05-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(252, 'jasa', 'Jasa Pendidikan Online', NULL, '<p>Deskripsi detail untuk Jasa Pendidikan Online. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 45, '2026-03-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(253, 'jasa', 'Kursus & Training', NULL, '<p>Deskripsi detail untuk Kursus & Training. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 46, '2026-04-21 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(254, 'jasa', 'Jasa Konsultansi HR', NULL, '<p>Deskripsi detail untuk Jasa Konsultansi HR. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 47, '2026-04-05 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(255, 'jasa', 'Outsourcing Tenaga Kerja', NULL, '<p>Deskripsi detail untuk Outsourcing Tenaga Kerja. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 48, '2026-03-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(256, 'jasa', 'Jasa Pemasaran', NULL, '<p>Deskripsi detail untuk Jasa Pemasaran. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 49, '2026-04-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(257, 'jasa', 'Sales & Distribution', NULL, '<p>Deskripsi detail untuk Sales & Distribution. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 50, '2026-06-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(258, 'jasa', 'Jasa Penagihan', NULL, '<p>Deskripsi detail untuk Jasa Penagihan. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 51, '2026-05-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(259, 'jasa', 'Jasa Pengumpulan Data', NULL, '<p>Deskripsi detail untuk Jasa Pengumpulan Data. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 52, '2026-06-01 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(260, 'jasa', 'Jasa Penulisan Konten', NULL, '<p>Deskripsi detail untuk Jasa Penulisan Konten. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 53, '2026-04-07 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(261, 'jasa', 'Jasa Terjemahan', NULL, '<p>Deskripsi detail untuk Jasa Terjemahan. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 54, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(262, 'jasa', 'Jasa Fotografi', NULL, '<p>Deskripsi detail untuk Jasa Fotografi. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 55, '2026-06-02 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(263, 'jasa', 'Jasa Videografi', NULL, '<p>Deskripsi detail untuk Jasa Videografi. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 56, '2026-05-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(264, 'jasa', 'Jasa Event Management', NULL, '<p>Deskripsi detail untuk Jasa Event Management. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 57, '2026-04-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(265, 'jasa', 'Wedding Organizer', NULL, '<p>Deskripsi detail untuk Wedding Organizer. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 58, '2026-05-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(266, 'jasa', 'Jasa Dekorasi', NULL, '<p>Deskripsi detail untuk Jasa Dekorasi. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 59, '2026-04-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(267, 'jasa', 'Jasa Rias & Makeup', NULL, '<p>Deskripsi detail untuk Jasa Rias & Makeup. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 60, '2026-04-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(268, 'jasa', 'Jasa Laundry', NULL, '<p>Deskripsi detail untuk Jasa Laundry. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 61, '2026-05-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(269, 'jasa', 'Jasa Potong Rambut', NULL, '<p>Deskripsi detail untuk Jasa Potong Rambut. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 62, '2026-05-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(270, 'jasa', 'Jasa Spa & Wellness', NULL, '<p>Deskripsi detail untuk Jasa Spa & Wellness. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 63, '2026-04-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(271, 'jasa', 'Jasa Gym & Fitness', NULL, '<p>Deskripsi detail untuk Jasa Gym & Fitness. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 64, '2026-05-31 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(272, 'jasa', 'Jasa Kesehatan Alternatif', NULL, '<p>Deskripsi detail untuk Jasa Kesehatan Alternatif. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 65, '2026-04-10 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(273, 'jasa', 'Jasa Akupuntur', NULL, '<p>Deskripsi detail untuk Jasa Akupuntur. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 66, '2026-03-23 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(274, 'jasa', 'Jasa Fisioterapi', NULL, '<p>Deskripsi detail untuk Jasa Fisioterapi. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 67, '2026-04-16 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(275, 'jasa', 'Jasa Home Care', NULL, '<p>Deskripsi detail untuk Jasa Home Care. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 68, '2026-03-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(276, 'jasa', 'Jasa Baby Sitter', NULL, '<p>Deskripsi detail untuk Jasa Baby Sitter. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 69, '2026-06-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(277, 'jasa', 'Jasa Tukang Kebun', NULL, '<p>Deskripsi detail untuk Jasa Tukang Kebun. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 70, '2026-04-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(278, 'jasa', 'Jasa Service AC', NULL, '<p>Deskripsi detail untuk Jasa Service AC. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 71, '2026-04-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(279, 'jasa', 'Jasa Service Listrik', NULL, '<p>Deskripsi detail untuk Jasa Service Listrik. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 72, '2026-04-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(280, 'jasa', 'Jasa Pipa Air', NULL, '<p>Deskripsi detail untuk Jasa Pipa Air. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 73, '2026-03-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(281, 'jasa', 'Jasa Renovasi Rumah', NULL, '<p>Deskripsi detail untuk Jasa Renovasi Rumah. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 74, '2026-04-07 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(282, 'jasa', 'Jasa Cat Tembok', NULL, '<p>Deskripsi detail untuk Jasa Cat Tembok. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 75, '2026-05-16 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(283, 'jasa', 'Jasa Pindahan', NULL, '<p>Deskripsi detail untuk Jasa Pindahan. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 76, '2026-03-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(284, 'jasa', 'Jasa Packing & Moving', NULL, '<p>Deskripsi detail untuk Jasa Packing & Moving. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 77, '2026-05-06 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(285, 'jasa', 'Jasa Penyimpanan Barang', NULL, '<p>Deskripsi detail untuk Jasa Penyimpanan Barang. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 78, '2026-03-08 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(286, 'jasa', 'Jasa Self Storage', NULL, '<p>Deskripsi detail untuk Jasa Self Storage. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 79, '2026-05-24 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(287, 'jasa', 'Jasa Vending Machine', NULL, '<p>Deskripsi detail untuk Jasa Vending Machine. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 80, '2026-05-09 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(288, 'jasa', 'Jasa ATM Management', NULL, '<p>Deskripsi detail untuk Jasa ATM Management. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 81, '2026-04-16 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(289, 'jasa', 'Jasa Payment Gateway', NULL, '<p>Deskripsi detail untuk Jasa Payment Gateway. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 82, '2026-04-11 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(290, 'jasa', 'Jasa E-Commerce Platform', NULL, '<p>Deskripsi detail untuk Jasa E-Commerce Platform. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 83, '2026-05-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(291, 'jasa', 'Jasa Digital Payment', NULL, '<p>Deskripsi detail untuk Jasa Digital Payment. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 84, '2026-05-29 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(292, 'jasa', 'Jasa Blockchain', NULL, '<p>Deskripsi detail untuk Jasa Blockchain. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 85, '2026-05-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(293, 'jasa', 'Jasa Cyber Security', NULL, '<p>Deskripsi detail untuk Jasa Cyber Security. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 86, '2026-03-28 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(294, 'jasa', 'Jasa Penetration Testing', NULL, '<p>Deskripsi detail untuk Jasa Penetration Testing. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 87, '2026-03-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(295, 'jasa', 'Jasa Compliance Audit', NULL, '<p>Deskripsi detail untuk Jasa Compliance Audit. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 88, '2026-03-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(296, 'jasa', 'Jasa Risk Management', NULL, '<p>Deskripsi detail untuk Jasa Risk Management. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 89, '2026-03-19 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(297, 'jasa', 'Jasa Business Intelligence', NULL, '<p>Deskripsi detail untuk Jasa Business Intelligence. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 90, '2026-04-30 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(298, 'jasa', 'Jasa Data Analytics', NULL, '<p>Deskripsi detail untuk Jasa Data Analytics. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 91, '2026-05-21 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(299, 'jasa', 'Jasa Artificial Intelligence', NULL, '<p>Deskripsi detail untuk Jasa Artificial Intelligence. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 92, '2026-04-26 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(300, 'jasa', 'Jasa Machine Learning', NULL, '<p>Deskripsi detail untuk Jasa Machine Learning. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 93, '2026-05-12 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(301, 'jasa', 'Jasa Internet of Things', NULL, '<p>Deskripsi detail untuk Jasa Internet of Things. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 94, '2026-04-17 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(302, 'jasa', 'Jasa Virtual Reality', NULL, '<p>Deskripsi detail untuk Jasa Virtual Reality. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 95, '2026-05-18 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(303, 'jasa', 'Jasa Augmented Reality', NULL, '<p>Deskripsi detail untuk Jasa Augmented Reality. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 96, '2026-04-15 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(304, 'jasa', 'Jasa 3D Printing', NULL, '<p>Deskripsi detail untuk Jasa 3D Printing. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 97, '2026-05-03 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(305, 'jasa', 'Jasa Drone Services', NULL, '<p>Deskripsi detail untuk Jasa Drone Services. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 98, '2026-04-21 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(306, 'jasa', 'Jasa Satellite imagery', NULL, '<p>Deskripsi detail untuk Jasa Satellite imagery. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 99, '2026-04-13 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(307, 'jasa', 'Jasa Remote Sensing', NULL, '<p>Deskripsi detail untuk Jasa Remote Sensing. Ini adalah unit bisnis yang bergerak di sektor jasa dan perdagangan yang berlokasi di Aceh.</p><p>Bidang ini memiliki potensi besar untuk perkembangan dan kontribusi terhadap perekonomian daerah.</p>', NULL, NULL, NULL, '[\"jasa\",\"perdagangan\",\"aceh\"]', 100, '2026-03-14 19:49:38', '2026-06-06 20:02:09', '2026-06-06 20:02:09'),
(308, 'migas', '123', NULL, '<div>123</div>', NULL, NULL, 'businesses/3OEJgBbWv5mXIKrDwGNUMm8gS90FghPEXQlV3fQv.jpg', '[\"123\"]', 99, '2026-06-06 19:51:08', '2026-06-06 20:02:01', '2026-06-06 20:02:01'),
(309, 'agroindustri', 'Komersialisasi Hasil Perikanan', 'Provinsi Aceh kaya akan potensi sumber daya kelautan dan perikanan, dengan luas lautan Aceh mencapai 295.370 km2 terdiri dari 56.563 km2 perairan teritorial dan kepulauan dan 238.807 km2 berupa Zona Ekonomi Eksklusif (ZEE).', '<div>Dengan luasnya perairan Aceh, terdapat potensi besar dalam hasil tangkap ikan, dan produksi ikan beku menjadi solusi untuk menjaga kualitas ikan yang dijual ke berbagai pasar lokal dan pasar global, termasuk Amerika Serikat, Eropa, dan Asia untuk itu PEMA membentuk unit bisnis KSO yang berfokus pada bisnis dagang perikanan, khususnya penjualan ikan beku (Frozen Fish).<br><br></div><div>Perlu diketahui KSO merupakan kerjasama operasi PT Pembangunan Aceh Perseroda dengan mitra lokal sebagai salah satu upaya untuk menambah PAD dari sektor perikanan Provinsi Aceh.<br><br></div><div><br></div>', NULL, NULL, 'businesses/ejRhqHNJAyz7cGQb22FzbABdgxEW2qUMYVDw0oK2.webp', '[]', 1, '2026-06-07 00:35:57', '2026-06-07 01:23:20', NULL),
(310, 'agroindustri', 'Komersialisasi Komoditi Cangkang Sawit', 'Provinsi Aceh memiliki lahan perkebunan kelapa sawit seluas 242.820 ha yang dikelola oleh masyarakat dengan produksi tahunan sebesar  459.727  ton  pada  2022  dengan  60 Pabrik Kelapa Sawit (PKS) yang aktif di Provinsi  Aceh.', '<div>Cangkang  sawit  yang merupakan limbah hasil pengolahan sawit memiliki nilai jual yang tinggi untuk diolah menjadi beberapa  briket, campuran pakan ternak, bahan bakar boiler, agregat ringan beton, dan produk lainnya.<br><br></div><div>Bisnis ini menggunakan skema trading dimana PEMA akan membeli cangkang sawit dari beberapa  supplier  PKS  yang  terdapat  di Provinsi    Aceh  untuk  diselanjutnya dikumpulkan pada stockpile cangkang sawit. <br><br></div><div>Pangsa pasar dari bisnis komersialisasi cangkang  sawit  menargetkan  pasar domestik dan pasar internasional meliputi Malaysia, Singapura, Nigeria, Amerika Serikat dan Britania Raya.<br><br></div><div>Operasional bisnis komersialisasi cangkang sawit ini bekerjasama dengan BUMD daerah penghasil sawit. Adapun target penjualan cangkang sawit pada tahun pertama ditargetkan mencapai 100.000 ton dengan calon buyer yang berasal dari Jepang. <br><br></div><div><br></div>', NULL, NULL, 'businesses/5ST4ADkTIEMuEpcvHzaoDd8M0QT497PGpIqOajvo.webp', '[]', 2, '2026-06-07 00:37:57', '2026-06-07 20:15:56', NULL),
(311, 'jasa', 'Kawasan Industri Aceh (KIA) Ladong', 'Geliat ekonomi Provinsi Aceh juga ditunjang dengan penyediaan Kawasan Industri Aceh (KIA) dan memberikan kesempatan pengembangan industri.', '<div>KIA adalah kawasan industri milik Pemerintah Aceh yang menawarkan cara hemat biaya untuk menghilirisasi komoditas berharga menjadi produk bernilai tinggi. KIA Ladong diresmikan pada tanggal 20 Desember 2018.  <br><br></div><div>Keunggulan akses untuk KIA Ladong, Lokasi Strategis Didukung: Jarak ke Pusat Kota (22,8 km), ke Bandara Sultan Iskandar Muda (33 km), ke Pelabuhan Malahayati (11,6 km) dan Gerbang Tol Blang Bintang (11 km). <br><br></div><div>Kawasan industri ini, dilengkapi dengan infrastruktur pendukung. Kawasan ini juga didukung dengan pelayanan penyediaan Persediaan air, Listrik, Pengolahan Air Limbah serta Keamanan yang profesional. <br><br></div><div>Bisnis ini menggunakan skema trading dimana PEMA akan membeli cangkang sawit dari beberapa  supplier  PKS  yang  terdapat  di Provinsi Aceh  untuk  diselanjutnya dikumpulkan pada stockpile cangkang sawit. <br><br></div><div>KIA  Ladong  didukung  dengan  luasan  lahan 71,5 Ha dengan status  Hak Pengelolaan Lahan, serta  Rencana  Pengembangan  Hak  Penge- lolaan mencapai 250 Ha. <br><br></div>', NULL, NULL, 'businesses/hthstOTa0HWOYFS18mGihcsGQdj7OjlwOO0fosC4.webp', '[]', 0, '2026-06-07 00:45:46', '2026-06-07 20:15:56', NULL),
(312, 'jasa', 'Kawasan Ekonomi Khusus (KEK) Arun Lhokseumawe', 'KEK Arun Lhokseumawe terletak di Kabu- paten Aceh Utara dan Kota Lhokseumawe, Provinsi  Aceh  dan  dibentuk  berdasarkan Peraturan  Pemerintah  Nomor  5  Tahun 2017.', '<div>KEK Arun Lhokseumawe diresmikan oleh Presiden Republik Indonesia, Bapak Ir. H. Joko Widodo pada tanggal 14 Desember 2018.  KEK  Arun  dikelola  oleh  PT  Patriot Nusantara  Aceh,  sebuah  anak  usaha  patungan antara PT PEMA dengan PT Pupuk Iskandar  Muda,  PT  Pertamina  dan  PT Pelindo.<br><br></div><div>KEK ini berfokus pada beberapa sektor yaitu energi, petrokimia, agro industri pendukung ketahanan pangan, logistik serta industri penghasil kertas kraft. Dari sektor energi (minyak dan gas) akan dikembangkan regasifikasi LNG, LNG Hub/ Trading, LPG Hub/ Trading dan Mini LNG Plant dari sektor energi lainnya (Pem- bangkit Listrik) akan dikembangakan pembakit Listrik Tenaga Gas yang ramah lingkungan atau Clean Energy Solution.<br><br></div><div>Infrastruktur logistik juga dikembangkan untuk mendukung input dan output dari industri minyak dan gas, petro- kimia dan agro industri, melalui peningkatan infrastruktur  pelabuhan  dan  dermaga  berstandar Internasional. <br><br></div><div>Penyediaan  KEK  Arun  dalam  rangka  mempercepat  pencapaian  pembangunan  eko- nomi nasional, diperlukan peningkatan pena- naman  modal  melalui  penyiapan  kawasan yang  memiliki  keunggulan  ekonomi  dan geostrategis. Kawasan tersebut dipersiapkan untuk  memaksimalkan  kegiatan  industri, ekspor,  impor  dan  kegiatan  ekonomi  lain yang memiliki nilai ekonomi tinggi. <br><br></div>', NULL, NULL, 'businesses/3ikrAzIBWCuF5oTCCiXlGXFlZGjemcLBDMWoGJwI.webp', '[]', 1, '2026-06-07 00:46:31', '2026-06-07 20:15:56', NULL),
(313, 'jasa', 'Maintenance Tower Telekomunikasi & Fiber Optik', 'Provinsi Aceh memiliki  jumlah tower telekomunikasi sebanyak 1.593 tower  merupakan yang terbesar ke-6 di Indonesia.', '<div>Bentuk kerjasama bisnis maintenance tower  telekomunikasi  dan  fiber  optic yang  dijalankan  oleh  PEMA  berupa kerjasama operasi (Joint Operation).<br><br></div><div>Adapun yang menjadi fokus utama kerjasama bisnisnya adalah jasa kelola perawatan terampil dan professional bidang teknologi telekomuniksi.<br><br></div><div>PEMA hadir sebagai keterwakilan perusahaan lokal daerah Aceh sebagai salah satu upaya pemberdayaan tenaga kerja lokal, menciptakan lapangan pekerjaan demi peningkatan ekonomi masyarakat Aceh. Pada tahapan awal, KSO ini menargetkan ruang lingkup kegiatan perawatan menara tower telekomunikasi dan perawatan jaringan fiber optic.<br><br></div>', NULL, NULL, 'businesses/PWJ7Wwc2vJ41oPYYsgugNcKZiWOtCfJBhY3bm22O.webp', '[]', 2, '2026-06-07 00:47:19', '2026-06-07 20:15:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(500) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `image`, `caption`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Penandatanganan Kerjasama Blok B', 'gallery/VlsAj886Ng5sQsohDXIlasoTd8Ny4MDG5ljc3MHM.jpg', 'Penandatanganan perjanjian kerjasama pengembangan Blok B', 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(2, 'Ekspor Kopi Gayo Perdana', 'gallery/ItypU8dRy8MUBSx290L9TFDJawEwqN3rnge1oeAc.jpg', 'Pelepasan ekspor perdana kopi Gayo ke pasar Eropa', 2, '2026-06-05 15:52:09', '2026-06-07 01:23:56', NULL),
(3, 'Penghargaan BUMD Terbaik', 'gallery/penghargaan.jpg', 'PEMA meraih penghargaan BUMD Terbaik 2026', 3, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_listings`
--

CREATE TABLE `job_listings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'fulltime',
  `salary_range` varchar(255) DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `google_form_link` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_listings`
--

INSERT INTO `job_listings` (`id`, `title`, `description`, `department`, `location`, `type`, `salary_range`, `requirements`, `google_form_link`, `thumbnail`, `is_active`, `deadline`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', 'test', 'test', 'test', 'contract', 'test', 'test', 'https://docs.google.com/forms/d/...', 'jobs/VU6ZnjhfLWJXbrIvKDvJSdq0RPYGH4bx0jPSyeAc.webp', 1, '2026-06-08', '2026-06-07 00:56:20', '2026-06-07 01:02:42', '2026-06-07 01:02:42'),
(2, 'test', 'test', 'test', 'test', 'internship', NULL, 'test', 'https://docs.google.com/forms/d/...', 'jobs/pkJ1qZrCIDTEjrNiOit38Q0MPMJLwHJVkKsVWVgM.webp', 1, '2026-06-06', '2026-06-07 00:57:43', '2026-06-07 01:00:56', '2026-06-07 01:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_01_000001_create_profile_contents_table', 1),
(5, '2026_01_01_000002_create_businesses_table', 1),
(6, '2026_01_01_000003_create_news_table', 1),
(7, '2026_01_01_000004_create_galleries_table', 1),
(8, '2026_01_01_000005_create_reports_table', 1),
(9, '2026_01_01_000006_create_agenda_table', 1),
(10, '2026_01_01_000007_create_teams_table', 1),
(11, '2026_01_01_000008_create_partners_table', 1),
(12, '2026_01_01_000009_create_settings_table', 1),
(13, '2026_05_29_000001_create_enquiries_table', 1),
(14, '2026_05_31_181733_create_permission_tables', 1),
(15, '2026_05_31_190000_add_soft_deletes_to_tables', 1),
(16, '2026_06_05_000001_add_image_to_businesses_table', 1),
(17, '2026_06_05_000002_create_banners_table', 2),
(18, '2026_06_06_181827_add_images_to_businesses_table', 3),
(19, '2026_06_06_184101_create_activities_table', 4),
(20, '2026_06_06_210342_add_coordinates_to_agenda_table', 5),
(21, '2026_06_07_002002_create_job_listings_table', 6),
(22, '2026_06_07_010316_add_subtitle_to_businesses_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `type`, `title`, `content`, `image`, `date`, `author`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'berita', 'PEMA Tandatangani Kerjasama Pengembangan Blok B', '<div>PT Pembangunan Aceh (PEMA) resmi menandatangani perjanjian kerjasama pengembangan Blok B dengan mitra strategis nasional. Kerjasama ini bertujuan untuk mengoptimalkan potensi migas di wilayah Aceh melalui teknologi terkini dan praktik industri yang bertanggung jawab.</div><div>Penandatanganan dilakukan di Banda Aceh dan disaksikan oleh pejabat Pemerintah Aceh serta para pemangku kepentingan terkait. Direktur Utama PEMA menyatakan bahwa kerjasama ini merupakan langkah maju dalam mewujudkan kemandirian energi Aceh.</div>', NULL, '2026-03-15', 'Tim Humas PEMA', 1, '2026-06-05 15:52:09', '2026-06-06 16:25:54', NULL),
(2, 'berita', 'Kopi Gayo PEMA Tembus Pasar Eropa', '<p>Kopi Arabika Gayo yang dikembangkan oleh PT Pembangunan Aceh (PEMA) berhasil menembus pasar Eropa. Ekspor perdana dilakukan ke Belanda dan Jerman dengan volume 20 ton.</p><p>Keberhasilan ini menandai babak baru bagi pengembangan sektor agroindustri Aceh. Kopi Gayo dikenal memiliki cita rasa khas dengan acidity rendah dan body yang kuat, menjadikannya salah satu kopi terbaik di dunia.</p>', NULL, '2026-04-20', 'Tim Humas PEMA', 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(3, 'berita', 'PEMA Raih Penghargaan BUMD Terbaik 2026', '<p>PT Pembangunan Aceh (PEMA) meraih penghargaan sebagai Badan Usaha Milik Daerah (BUMD) Terbaik Tahun 2026 dalam acara Aceh Investment and Business Award yang diselenggarakan oleh Pemerintah Aceh.</p><p>Penghargaan ini diberikan atas kinerja keuangan yang solid, tata kelola perusahaan yang baik, serta kontribusi nyata terhadap pembangunan ekonomi Aceh. Penerimaan penghargaan diterima langsung oleh Direktur Utama PEMA di Banda Aceh.</p>', NULL, '2026-05-10', 'Tim Humas PEMA', 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(4, 'pengumuman', 'Pengumuman Seleksi Calon Mitra Kerja Sama Blok B', '<p>Sehubungan dengan pengembangan Blok B, PT Pembangunan Aceh (PEMA) membuka seleksi calon mitra kerjasama. Pendaftaran dibuka mulai tanggal 1 Juni hingga 30 Juni 2026.</p><p>Persyaratan lengkap dapat diunduh melalui website resmi PEMA. Informasi lebih lanjut dapat menghubungi Sekretariat PEMA di Banda Aceh.</p>', NULL, '2026-05-25', 'Sekretariat PEMA', 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `logo`, `website`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'PT Pupuk Iskandar Muda', 'partners/pupuk-iskandar-muda.gif', 'https://pim.co.id', 1, '2026-06-05 22:10:22', '2026-06-05 22:10:22', NULL),
(7, 'CHL', 'partners/chl.webp', NULL, 2, '2026-06-05 22:10:22', '2026-06-05 22:10:22', NULL),
(8, 'Koperasi Karyawan PEMA Syariah', 'partners/koperasi-karyawan-pema-syariah.webp', NULL, 3, '2026-06-05 22:10:22', '2026-06-05 22:10:22', NULL),
(9, 'Cemindo Sari Gemilang', 'partners/cemindo-sari-gemilang.webp', NULL, 4, '2026-06-05 22:10:22', '2026-06-05 22:10:22', NULL),
(10, 'Mitra Strategis PEMA', 'partners/3.webp', NULL, 5, '2026-06-05 22:10:22', '2026-06-05 22:10:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile_contents`
--

CREATE TABLE `profile_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile_contents`
--

INSERT INTO `profile_contents` (`id`, `type`, `title`, `content`, `image`, `additional_info`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'sambutan', 'Mawardi Nur, SE', 'Direktur Utama PT PEMA', 'team/foto-direktur.png', 'PT PEMA merupakan Perseroan Daerah (Perseroda) dengan saham 100% dimiliki Pemerintah Aceh. Mari kita terus maju, demi tujuan meningkatkan kesejahteraan serta kemandirian bagi masyarakat Aceh.', '2026-06-05 15:52:09', '2026-06-05 22:10:22', NULL),
(2, 'sejarah', 'Perjalanan PT Pembangunan Aceh', '<div>PT Pembangunan Aceh (PEMA) didirikan pada tahun 2016 berdasarkan Qanun Aceh Nomor 3 Tahun 2015 tentang Perusahaan Daerah. Sebagai Badan Usaha Milik Daerah Aceh (BUMD/BUMA), PEMA memiliki tugas mulia: mengelola potensi sumber daya alam Aceh untuk sebesar-besarnya kemakmuran rakyat.<br><br></div><div>Sejak berdiri, PEMA telah berkembang dari perusahaan yang fokus pada sektor migas menjadi korporasi yang memiliki tiga pilar bisnis utama: Migas, Agroindustri, serta Jasa &amp; Perdagangan. Perjalanan ini diwarnai dengan berbagai capaian dan pembelajaran yang menjadikan PEMA semakin kokoh sebagai penggerak ekonomi daerah.<br><br></div><div>Dengan saham 100% milik Pemerintah Aceh, PEMA berkomitmen untuk menjalankan tata kelola perusahaan yang baik (GCG) dan memberikan kontribusi nyata bagi pembangunan dan kesejahteraan masyarakat Aceh.</div>', NULL, NULL, '2026-06-05 15:52:09', '2026-06-05 21:56:11', NULL),
(3, 'visi_misi', 'Menjadi perusahaan daerah yang profesional, inovatif, dan berkelanjutan untuk kesejahteraan masyarakat Aceh.', 'Mengelola sumber daya daerah secara optimal, mendorong pertumbuhan ekonomi, dan memberikan kontribusi nyata bagi pembangunan Aceh melalui pengelolaan bisnis yang profesional dan berintegritas.', NULL, NULL, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(4, 'stakeholder', 'Pemangku Kepentingan PEMA', 'Sebagai BUMD milik Pemerintah Aceh, PEMA memiliki tanggung jawab kepada seluruh pemangku kepentingan, termasuk Pemerintah Aceh sebagai pemegang saham, masyarakat Aceh sebagai penerima manfaat, mitra bisnis, karyawan, dan regulator.', NULL, NULL, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `title`, `file`, `year`, `description`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Laporan Tahunan 2025', NULL, '2025', 'Laporan tahunan PT Pembangunan Aceh tahun buku 2025 mencakup kinerja keuangan, operasional, dan tata kelola perusahaan.', 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(2, 'Laporan Keberlanjutan 2025', NULL, '2025', 'Laporan keberlanjutan yang menguraikan komitmen PEMA terhadap aspek lingkungan, sosial, dan tata kelola (ESG).', 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(3, 'Laporan Kinerja Semester I 2026', NULL, '2026', 'Laporan kinerja semester pertama tahun 2026 yang mencakup pencapaian target dan realisasi program kerja.', 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(4, '123', 'reports/kA45XtTd2Ud9UrPGnuZaXuZp5wCXlxxNPQDNCno7.pdf', '2026', NULL, 1, '2026-06-06 20:16:19', '2026-06-06 20:39:05', '2026-06-06 20:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2026-06-05 15:52:09', '2026-06-05 15:52:09'),
(2, 'admin', 'web', '2026-06-05 15:52:09', '2026-06-05 15:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2IhLZHgW2Oz6fWbAebMLUDVNaLmqlxTfdR9oe0QS', NULL, '2001:448a:81b0:13c5:d4:ec8c:2e8f:58c6', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_5_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/148.0.7778.47 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieEZ3dndJRzZndkp4OHhrbGJlcmk4cjl5elFvZ3dHajEybnVRb0gzWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vcGVtYS54dHJhaGVyYS5jbG91ZCI7czo1OiJyb3V0ZSI7czo3OiJiZXJhbmRhIjt9fQ==', 1780837898),
('Id4ADojPcwtvh2YVuUaRxt3j4ul2N4fqEZsLbA3R', NULL, '103.3.221.103', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicFZiNUpiOGZVZEJKMHhpeXRPdEJhVXVVSEhmRG5VcGRzY3ZNdUpHRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vcGVtYS54dHJhaGVyYS5jbG91ZC9iaXNuaXMvbWlnYXMiO3M6NToicm91dGUiO3M6MTU6ImJpc25pcy5jYXRlZ29yeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1780838187);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'alamat', 'Rumah Budaya, Jl. Tgk Moh. Daud Beureueh, Kec. Kuta Alam, Kota Banda Aceh 23121', NULL, NULL, NULL),
(2, 'email', 'contact@pema.co.id', NULL, NULL, NULL),
(3, 'telepon', '0651-47414', NULL, NULL, NULL),
(4, 'fax', '0651-47414', NULL, NULL, NULL),
(5, 'instagram', 'https://instagram.com/ptpema', NULL, NULL, NULL),
(6, 'facebook', 'https://facebook.com/ptpema', NULL, NULL, NULL),
(7, 'twitter', 'https://twitter.com/ptpema', NULL, NULL, NULL),
(8, 'youtube', 'https://youtube.com/@ptpema', NULL, NULL, NULL),
(9, 'karir_link', 'https://docs.google.com/forms/d/e/1FAIpQLSezAcAnbl17IX8gURIqZWNtdFli2wYABk5JG7YocbsSTbCf6g/viewform', NULL, '2026-06-07 01:37:30', NULL),
(10, 'visi', '', NULL, NULL, NULL),
(11, 'misi', '', NULL, NULL, NULL),
(12, 'latitude', '', '2026-06-07 01:37:30', '2026-06-07 01:37:30', NULL),
(13, 'longitude', '', '2026-06-07 01:37:30', '2026-06-07 01:37:30', NULL),
(14, 'produk_link', 'https://ipro.pema.co.id/', '2026-06-07 01:52:34', '2026-06-07 01:52:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'direksi',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `position`, `photo`, `category`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dr. Teuku Muhammad Fadhil, SE, MM', 'Direktur Utama', 'team/team-1.jpg', 'direksi', 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(2, 'Ir. Cut Nuraida, MT', 'Direktur Operasional', 'team/team-2.jpg', 'direksi', 2, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(3, 'M. Ali Basyah, S.H., M.Kn.', 'Direktur Keuangan', 'team/team-3.jpg', 'direksi', 3, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(4, 'Ir. Teuku Reza Fahlevi, ST, MT', 'Direktur Teknik & Operasional', 'team/team-4.jpg', 'direksi', 4, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(5, 'Prof. Dr. Ir. Syamsul Rizal, M.Eng.', 'Komisaris Utama', 'team/team-5.jpg', 'komisaris', 1, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(6, 'Dra. Hj. Nurlelawati, M.Si.', 'Komisaris', 'team/team-6.jpg', 'komisaris', 2, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(7, 'Dr. Ir. Zulkifli, M.Si.', 'Komisaris Independen', 'team/team-7.jpg', 'komisaris', 3, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL),
(8, 'H. Muhammad Yunus, SE, Ak., MBA', 'Komisaris', 'team/team-8.jpg', 'komisaris', 4, '2026-06-05 15:52:09', '2026-06-05 15:52:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@pema.co.id', NULL, '$2y$12$eB7kJxXHV7cmRS.NnekUrOwhSLlwi.rZ./skqWmhB1Tpv.0LMYWPe', '2HN6nUGNRKZuQe68CdCWJFS3S2iG5rLJ8y84Nl4eXFqBR8LxNhFkCmd3fesP', '2026-06-05 15:52:09', '2026-06-05 15:52:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_user_id_foreign` (`user_id`),
  ADD KEY `activities_subject_type_subject_id_index` (`subject_type`,`subject_id`);

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `businesses_category_index` (`category`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_listings`
--
ALTER TABLE `job_listings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_type_index` (`type`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `profile_contents`
--
ALTER TABLE `profile_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_contents_type_index` (`type`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_listings`
--
ALTER TABLE `job_listings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile_contents`
--
ALTER TABLE `profile_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
