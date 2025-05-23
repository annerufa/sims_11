-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2025 at 05:58 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sims_11`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id_agenda` int UNSIGNED NOT NULL,
  `kode_bagian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_bagian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id_agenda`, `kode_bagian`, `nama_bagian`, `created_at`, `updated_at`) VALUES
(4, '800.1.11.1', 'Surat Tugas', '2025-04-18 00:06:35', '2025-05-02 17:25:49'),
(5, '400.3.8.1', 'Kurikulum', '2025-04-18 00:07:22', '2025-04-18 00:07:22'),
(6, '005', 'Undangan', '2025-04-18 00:10:13', '2025-05-02 17:25:36'),
(7, '800.01.13', 'Kepegawaian', '2025-04-18 00:10:49', '2025-05-02 17:25:43'),
(8, '900.1.3.5', 'Keuangan', '2025-04-18 00:11:45', '2025-05-02 17:25:30'),
(9, '400.03.08', 'Umum', '2025-05-06 06:59:41', '2025-05-06 06:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `id_disposisi` bigint UNSIGNED NOT NULL,
  `surat_masuk_id` bigint UNSIGNED NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `perintah` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_disposisi` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disposisi`
--

INSERT INTO `disposisi` (`id_disposisi`, `surat_masuk_id`, `catatan`, `perintah`, `tanggal_disposisi`, `created_at`, `updated_at`) VALUES
(21, 8, 'tolong', 'Koordinasi konfirmasi', '2025-05-14', '2025-05-13 21:55:18', '2025-05-13 21:55:18'),
(22, 9, 'catatan', 'Koordinasi konfirmasi', '2025-05-14', '2025-05-14 00:28:05', '2025-05-14 00:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `disposisi_penerima`
--

CREATE TABLE `disposisi_penerima` (
  `disposisi_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status_tugas` tinyint(1) NOT NULL DEFAULT '0',
  `catatan_balasan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disposisi_penerima`
--

INSERT INTO `disposisi_penerima` (`disposisi_id`, `user_id`, `status_tugas`, `catatan_balasan`, `created_at`, `updated_at`, `is_read`) VALUES
(21, 10, 1, NULL, '2025-05-13 21:55:18', '2025-05-13 21:57:13', 1),
(22, 10, 1, NULL, '2025-05-14 00:28:05', '2025-05-14 00:28:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `id_instansi` bigint UNSIGNED NOT NULL,
  `nama_instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'di tempat',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`id_instansi`, `nama_instansi`, `jabatan_pengirim`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'SMPN 2 Blitar', 'Kepala', 'Jl Melati', '2025-04-18 03:24:50', '2025-04-18 03:24:50'),
(3, 'Dinas Pendidikan Kota Blitar', 'Kepala', 'Jalan Ahmad Yani No.100, Kec. Sananwetan, Kota Blitar, Jawa Timur (Kode Pos 66137)', '2025-04-27 05:58:47', '2025-04-27 05:58:57'),
(4, 'UNISBA', 'Dekan Teknik Informatika', 'alamat', '2025-05-03 03:02:40', '2025-05-03 03:02:40'),
(5, 'NamaInstansi_1', NULL, 'Jalan abc', '2025-05-04 05:46:28', '2025-05-04 05:46:28'),
(6, 'INSTANSI 2', 'Kepala Instansi 2', 'Blitar', '2025-05-04 07:00:36', '2025-05-04 07:00:36'),
(7, 'Umum', 'Wali Murid SMKN 2 Blitar', 'di tempat', NULL, NULL),
(8, 'Umum', 'umum', 'di tempat', NULL, NULL),
(10, 'UMUM', 'Ketua Paguyuban', 'di tempat', '2025-05-13 21:46:57', '2025-05-13 21:46:57');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_18_021914_create_instansi_table', 2),
(5, '2025_04_18_022423_create_surat_masuk_table', 2),
(6, '2025_04_18_050307_create_agenda_table', 3),
(7, '2025_05_01_060145_create_disposisi_table', 4),
(8, '2025_05_01_060215_create_disposisi_penerima_table', 4),
(9, '2025_05_02_091027_create_surat_keluars_table', 5),
(10, '2025_05_02_091058_create_surat_keluar_table', 5),
(11, '2025_05_03_232516_create_disposisi_penerima_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3qtWwZdajOHyEQJ5MsRWrrwSXIy7iM9zia2GrJkF', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoicVhHdjU2aXZSVmJLTWFQU0RlVTNwUUpscGRBbzRsdWtnQzZzZnZRbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9zaW1zXzExLnRlc3Q6ODA4MC9zdXJhdC1tYXN1ayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo3OiJqYWJhdGFuIjtzOjU6ImFkbWluIjtzOjQ6Im5hbWEiO3M6MzoiSWtlIjt9', 1747208218),
('8fd066VlMsPg6mTxn7f1Z6SGliazSAoMxtxMHDRI', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiM3lXUHU0ZzZVRVRYb3d4ME80bUl6SGhlRGdkbEpuRnpRVlhBTGpDSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9zaW1zX3Y3LnRlc3Q6ODA4MCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo3OiJqYWJhdGFuIjtzOjU6ImFkbWluIjtzOjQ6Im5hbWEiO3M6MzoiSWtlIjt9', 1747632886),
('LWLaqv7WdGGCts8Mw21cAvnYndeqERJliNbaESEK', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiazM1UmxxcWxPd2tFelNjOFlPYVh0bFNPNWhzaEU0cHVKbkJwektNRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9zaW1zXzExLnRlc3Q6ODA4MC9zdXJhdC1rZWx1YXIvMTIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDtzOjc6ImphYmF0YW4iO3M6Mjoia3MiO3M6NDoibmFtYSI7czoyNDoiWmFpbiBBc3JvcmksIFMuU0kuLCBNLlNpIjt9', 1747207801),
('YvcKP5KpPkhGcOYBvZmBpf2KkWJs3D4FR8iuhSjf', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibDRiZHk4REZJb0t2cUY3ZndhckQzQWdXUVB6dEZ1RGJnNXJFRnJnNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9zaW1zXzExLnRlc3Q6ODA4MC9zdXJhdC1rZWx1YXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDtzOjc6ImphYmF0YW4iO3M6MTA6IldBS0EgSFVNQVMiO3M6NDoibmFtYSI7czoxOToiWnVkZGF0aSBIdXNuYSwgUy5QZCI7fQ==', 1747207794);

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id_sk` bigint UNSIGNED NOT NULL,
  `pengaju` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validator_id` bigint UNSIGNED NOT NULL,
  `jenis_srt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agenda_id` int UNSIGNED NOT NULL,
  `nomor_urut` int DEFAULT NULL,
  `file_draft` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_fiks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tujuan` bigint UNSIGNED NOT NULL,
  `status_validasi` enum('draft','disetujui','telah direvisi','direvisi','final') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `catatan_revisi` longtext COLLATE utf8mb4_unicode_ci,
  `tanggal_srt` date DEFAULT NULL,
  `perihal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_keluar`
--

INSERT INTO `surat_keluar` (`id_sk`, `pengaju`, `validator_id`, `jenis_srt`, `agenda_id`, `nomor_urut`, `file_draft`, `file_fiks`, `tujuan`, `status_validasi`, `catatan_revisi`, `tanggal_srt`, `perihal`, `created_at`, `updated_at`, `is_read`) VALUES
(1, 'Anne Rufaedah', 10, 'Undangan', 6, 1, 'suratKeluar/2.pdf', NULL, 4, 'direvisi', 'Tolong direvisi', '2025-05-01', 'Undangan Penutupan', '2025-05-03 03:23:14', '2025-05-12 10:17:31', 1),
(3, 'Bita', 8, 'Surat Izin', 7, 1, 'suratKeluar/2.pdf', 'suratKeluar/surat-final.pdf', 3, 'final', NULL, '2025-05-09', 'cdcdcd', '2025-05-03 07:23:09', '2025-05-04 21:57:43', 0),
(8, 'Rizkiaaa', 10, 'Undangan', 4, 1, 'suratKeluar/2.pdf', NULL, 4, 'draft', NULL, '2025-05-13', 'xasxssx', '2025-05-04 20:39:33', '2025-05-06 00:44:41', 0),
(11, 'Perintah Atasan', 9, 'Surat Pemberitahuan', 5, 5, 'suratKeluar/surat-1747198772.pdf', NULL, 7, 'disetujui', NULL, '2025-05-14', 'Pemberitahuan Pengambilan Rapot Semester 2', '2025-05-13 21:59:32', '2025-05-13 22:00:25', 1),
(12, 'Perintah Atasan', 10, 'Surat Pemberitahuan', 9, 1, 'suratKeluar/surat-1747207760.pdf', NULL, 7, 'disetujui', NULL, '2025-05-14', 'catatan', '2025-05-14 00:29:20', '2025-05-14 00:29:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id_sm` bigint UNSIGNED NOT NULL,
  `id_pengirim` bigint UNSIGNED NOT NULL,
  `sifat_srt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_srt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_srt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_srt` date NOT NULL,
  `tanggal_terima` date NOT NULL,
  `perihal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `agenda_id` int UNSIGNED DEFAULT NULL,
  `nomor_urut` int DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_masuk`
--

INSERT INTO `surat_masuk` (`id_sm`, `id_pengirim`, `sifat_srt`, `jenis_srt`, `nomor_srt`, `tanggal_srt`, `tanggal_terima`, `perihal`, `file`, `keterangan`, `agenda_id`, `nomor_urut`, `is_read`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 3, 'Sangat segera', 'Surat Dinas', 'bb/hh800/90', '2025-05-20', '2025-05-21', 'Pemberitahuan agenda rapat Pemberitahuan agenda rapat Pemberitahuan agenda rapat ', 'suratMasuk/surat-1746362939.pdf', NULL, 5, 1, 1, 3, '2025-04-22 09:58:10', '2025-05-03 14:54:59'),
(8, 10, 'Biasa', 'Surat Dinas', '-', '2025-05-14', '2025-05-14', 'permohonan izin pengadaan acara paguyuban', 'suratMasuk/surat-1747198017.pdf', NULL, 9, 1, 1, 3, '2025-05-13 21:46:57', '2025-05-13 21:52:42'),
(9, 10, 'Biasa', 'Surat Permohonan', '-', '2025-05-14', '2025-05-14', 'perihal', 'suratMasuk/surat-1747207635.pdf', NULL, 9, 2, 1, 3, '2025-05-14 00:27:15', '2025-05-14 00:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `no_pegawai`, `jabatan`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `foto`) VALUES
(3, 'Ike', 'k@email.co', '5', 'admin', NULL, '$2y$12$JMnVtZac1ZrRaswGIwO3HeNjzO3gq/qns9PaGvzJJBAvRrbQiTjaK', NULL, '2025-04-09 12:55:41', '2025-04-09 12:55:41', NULL),
(7, 'Asrori Ahmad, S.Pd.', 'aa@mail.c', '198510242009011004', 'WAKA KURIKULUM', NULL, '$2y$12$3l/tL8kBMAKazvM0tqSLz.0aUQiCxFe1BMFSgNYcffBW8BRUsD.IW', NULL, '2025-05-12 22:55:23', '2025-05-12 22:55:23', NULL),
(8, 'Suwarno, S.Ag.', 's@mail.com', '197104012005011011', 'WAKA SARPRAS', NULL, '$2y$12$RtEqo29q35D9Ch51e9xzSOh73K0.Su5EmwO.33s5ksj/xt.23K8Ua', NULL, '2025-05-12 22:56:25', '2025-05-12 22:56:25', NULL),
(9, 'Nafidh Fauzi, S.T.', 'n@email.co', '197804142010011010', 'WAKA KESISWAAN', NULL, '$2y$12$.ZvUjjstVmByasQvblUuuOfiZy8lgDOKQ.ufxi40e33vdtIFZGy5i', NULL, '2025-05-12 22:59:17', '2025-05-12 22:59:17', NULL),
(10, 'Zuddati Husna, S.Pd', 'z@mail.c', '198210312006042004', 'WAKA HUMAS', NULL, '$2y$12$6TEVBLxCD7hOJpWAnDXt5O9e8P57qwwRl565.MKeZzJ3PhtEKy2eW', NULL, '2025-05-12 23:00:03', '2025-05-12 23:00:03', NULL),
(11, 'Medi Wijaya', 'm@mail.b', '197707212008011007', 'admin', NULL, '$2y$12$1nwPF4/ymTUqNmhMBuooUuvEQY20kffTD4rEdgDmXfwKozDgMzDRi', NULL, '2025-05-12 23:01:33', '2025-05-12 23:01:33', NULL),
(14, 'Zain Asrori, S.SI., M.Si', 'kss@mai.c', '888', 'ks', NULL, '$2y$12$sTNO1CCi42XtUX/gxWOSWuMRDNtE0/m18C/w2kr92Clk82js7qTya', NULL, '2025-05-13 21:52:21', '2025-05-13 21:52:21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_agenda`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id_disposisi`),
  ADD KEY `disposisi_surat_masuk_id_foreign` (`surat_masuk_id`);

--
-- Indexes for table `disposisi_penerima`
--
ALTER TABLE `disposisi_penerima`
  ADD PRIMARY KEY (`disposisi_id`,`user_id`),
  ADD KEY `disposisi_penerima_disposisi_id_index` (`disposisi_id`),
  ADD KEY `disposisi_penerima_user_id_index` (`user_id`),
  ADD KEY `disposisi_penerima_status_tugas_index` (`status_tugas`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id_instansi`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id_sk`),
  ADD KEY `surat_keluar_tujuan_foreign` (`tujuan`),
  ADD KEY `surat_masuk_validator_foreign` (`validator_id`),
  ADD KEY `surat_keluar_no_agenda_unique` (`agenda_id`) USING BTREE;

--
-- Indexes for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id_sm`),
  ADD KEY `surat_masuk_id_pengirim_foreign` (`id_pengirim`),
  ADD KEY `surat_masuk_user_id_foreign` (`user_id`),
  ADD KEY `surat_masuk_agenda_foreign` (`agenda_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_no_pegawai_unique` (`no_pegawai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_agenda` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id_disposisi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id_instansi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id_sk` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id_sm` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `disposisi_surat_masuk_id_foreign` FOREIGN KEY (`surat_masuk_id`) REFERENCES `surat_masuk` (`id_sm`) ON DELETE CASCADE;

--
-- Constraints for table `disposisi_penerima`
--
ALTER TABLE `disposisi_penerima`
  ADD CONSTRAINT `disposisi_penerima_disposisi_id_foreign` FOREIGN KEY (`disposisi_id`) REFERENCES `disposisi` (`id_disposisi`) ON DELETE CASCADE,
  ADD CONSTRAINT `disposisi_penerima_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `surat_keluar_no_agenda` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id_agenda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `surat_keluar_tujuan_foreign` FOREIGN KEY (`tujuan`) REFERENCES `instansi` (`id_instansi`) ON DELETE CASCADE,
  ADD CONSTRAINT `surat_masuk_validator_foreign` FOREIGN KEY (`validator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD CONSTRAINT `surat_masuk_ibfk_1` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id_agenda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `surat_masuk_id_pengirim_foreign` FOREIGN KEY (`id_pengirim`) REFERENCES `instansi` (`id_instansi`) ON DELETE CASCADE,
  ADD CONSTRAINT `surat_masuk_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
