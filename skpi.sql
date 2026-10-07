-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Apr 2026 pada 03.43
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skpi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_kegiatan_mahasiswa`
--

CREATE TABLE `detail_kegiatan_mahasiswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_nim` varchar(15) NOT NULL,
  `kegiatan_id_ref` bigint(20) UNSIGNED NOT NULL,
  `poin` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_organisasi_mahasiswa`
--

CREATE TABLE `detail_organisasi_mahasiswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `id_organisasi` varchar(255) NOT NULL,
  `nama_organisasi` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `status_keanggotaan` varchar(255) DEFAULT NULL,
  `tanggal_bergabung` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_organisasi_mahasiswa`
--

INSERT INTO `detail_organisasi_mahasiswa` (`id`, `nim`, `nama`, `id_organisasi`, `nama_organisasi`, `jabatan`, `status_keanggotaan`, `tanggal_bergabung`, `tanggal_berakhir`, `periode`, `created_at`, `updated_at`) VALUES
(320, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', '67', 'HIMA Fakultas Teknologi Informasi', 'wakil', 'nonaktif', '2022-10-20', '2023-10-20', '2022/2023', '2026-03-09 06:46:15', '2026-03-09 06:46:15'),
(324, '2232090', 'Alvario Marbun Bjr', '70', 'Badan Eksekutif Mahasiswa', 'bendahara', 'aktif', '2026-03-10', NULL, '2026/Sekarang', '2026-03-09 17:50:34', '2026-03-09 17:50:34'),
(325, '2232090', 'Alvario Marbun Bjr', '69', 'HIMA Fakultas Ekonomi', 'Ketua', 'aktif', '2026-03-10', '2027-03-10', '2026/2027', NULL, NULL),
(326, '2281071', 'Mark Steward Hamonangan Siregar', '67', 'HIMA Fakultas Teknologi Informasi', 'Sekretaris', 'nonaktif', '2020-10-20', '2021-10-20', NULL, '2026-03-09 20:09:31', '2026-03-09 20:09:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `kegiatans`
--

CREATE TABLE `kegiatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_kegiatan` varchar(255) NOT NULL,
  `id_organisasi` varchar(255) DEFAULT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `tanggal_kegiatan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kegiatans`
--

INSERT INTO `kegiatans` (`id`, `jenis_kegiatan`, `id_organisasi`, `nama_kegiatan`, `tanggal_kegiatan`, `created_at`, `updated_at`) VALUES
(80, 'Major', '69', 'Event Malam Minggus', '2022-04-04', '2026-03-11 21:30:48', '2026-03-11 21:30:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `temp_lahir` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `sex` enum('L','P') NOT NULL,
  `agama` varchar(255) NOT NULL,
  `hobi` varchar(255) NOT NULL,
  `angkatan` varchar(255) NOT NULL,
  `fakultas` varchar(100) DEFAULT NULL,
  `prodi` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mahasiswas`
--

INSERT INTO `mahasiswas` (`id`, `nama`, `nim`, `temp_lahir`, `tgl_lahir`, `sex`, `agama`, `hobi`, `angkatan`, `fakultas`, `prodi`, `email`, `created_at`, `updated_at`, `online`) VALUES
(28, 'Rhesa Ivander Sihol Azaria Panjaitan', '2282004', 'Tangerang', '2003-10-30', 'L', 'Kristen Advent', 'Main Game', '2022', 'Teknologi Informasi', 'Sistem Informasi', '2282004@unai.edu', '2026-01-21 08:17:02', '2026-03-03 18:25:02', 0),
(29, 'Siti Nuraini Tambunan', '2282036', 'Toba Samosir', '2003-09-08', 'P', 'Kristen Advent', 'Memasak', '2022', 'Teknologi Informasi', 'Sistem Informasi', '2282036@unai.edu', '2026-01-21 08:33:55', '2026-03-05 01:17:08', 0),
(30, 'Gervino Rufus', '2282011', 'Jakarta', '2004-10-09', 'L', 'Kristen', 'Main Game', '2022', 'Teknologi Informasi', 'Sistem Informasi', '2282011@unai.edu', '2026-01-21 18:11:12', '2026-03-05 01:18:53', 0),
(31, 'Mark Steward Hamonangan Siregar', '2281071', 'Jakarta', '2003-10-29', 'L', 'Kristen Advent', 'Main Game', '2022', 'Teknologi Informasi', 'Teknik Informatika', '2281071@unai.edu', '2026-01-26 21:31:56', '2026-03-05 01:18:41', 0),
(32, 'Dian Martogi Hutabalian', '2282022', 'Pontianak', '2004-10-10', 'L', 'Kristen Advent', 'Main Game', '2022', 'Teknologi Informasi', 'Sistem Informasi', 'dianbalian30@gmail.com', '2026-01-26 22:23:00', '2026-03-05 01:19:16', 0),
(33, 'Nathan Lim', '2282012', 'Jakarta', '2003-10-24', 'L', 'Kristen Advent', 'Main Game', '2022', 'Teknologi Informasi', 'Sistem Informasi', '2282012@unai.edu', '2026-01-27 06:01:32', '2026-03-05 01:19:04', 0),
(34, 'Rose Valencia', '2382026', 'Bekasi', '2005-07-20', 'P', 'Kristen Advent', 'Memasak', '2023', 'Teknologi Informasi', 'Sistem Informasi', '2382026@unai.edu', '2026-01-27 06:33:29', '2026-03-05 02:15:01', 0),
(35, 'Audi Citra Tarigan', '2382033', 'Medan', '2005-08-16', 'P', 'Kristen Advent', 'Badminton', '2023', 'Teknologi Informasi', 'Sistem Informasi', '2382033@unai.edu', '2026-01-27 06:36:32', '2026-03-05 02:15:22', 0),
(36, 'Felicia Anastasya ketaren', '2381064', 'Kabanjahe', '2005-04-24', 'P', 'Advent', 'Coding', '23', 'Teknologi Informasi', 'Teknik Informatika', '2381064@unai.edu', '2026-01-27 22:04:03', '2026-03-05 02:15:51', 0),
(38, 'Alvario Marbun Bjr', '2232090', 'Toba Samosir', '2004-10-30', 'L', 'Kristen', 'Badminton', '2022', 'Ekonomi', 'Akuntansi', '2232090@unai.edu', '2026-03-03 08:40:22', '2026-03-03 18:24:33', 0),
(39, 'Ravel Silaen', '2211016', 'Bandung', '2001-02-23', 'L', 'Kristen Advent', 'Main Basket', '22', 'Filsafat', 'Kependetaan', '2211016@unai.edu', '2026-03-10 07:01:18', '2026-03-10 07:01:18', 0),
(40, 'Mark Glenn Sitanggang', '2211018', 'Tangerang', '2003-02-14', 'L', 'Kristen Advent', 'Main Basket', '2022', 'Filsafat', 'Kependetaan', '2211018@unai.edu', '2026-03-10 07:25:33', '2026-03-10 07:25:33', 0),
(41, 'Nathan Hasibuan', '2211020', 'Bekasi', '2004-08-02', 'L', 'Kristen Advent', 'Futsal', '2022', 'Filsafat', 'Kependetaan', '2211020@unai.edu', '2026-03-10 07:46:43', '2026-03-10 07:46:43', 0),
(42, 'Kaleb Simbolon', '2232070', 'Medan', '2004-07-13', 'L', 'Kristen Advent', 'Sepak Bola', '2022', 'Ekonomi', 'Akuntansi', '2232070@unai.edu', '2026-03-10 07:53:55', '2026-03-10 07:53:55', 0),
(43, 'Rapael Nainggolan', '2232065', 'Balikpapan', '2004-03-22', 'L', 'Kristen', 'Sepak Bola', '2022', 'Ekonomi', 'Akuntansi', '2232065@unai.edu', '2026-03-10 07:56:30', '2026-03-10 07:56:30', 0),
(44, 'Putriana Silitonga', '2232055', 'Medan', '2004-08-11', 'P', 'Kristen Advent', 'Volley', '2022', 'Ekonomi', 'Akuntansi', '2232055@unai.edu', '2026-03-10 07:58:47', '2026-03-10 07:58:47', 0),
(45, 'Desirely Gabriela Alexander', '2232068', 'Pontianak', '2003-05-16', 'P', 'Kristen Advent', 'Memasak', '2022', 'Ekonomi', 'Akuntansi', '2232068@unai.edu', '2026-03-10 08:00:31', '2026-03-10 08:00:31', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_05_08_031059_create_kegiatans_table', 1),
(4, '2025_05_12_023543_create_mahasiswa_table', 1),
(5, '2025_05_12_052314_create_sessions_table', 1),
(6, '2025_05_12_065219_change_absensi_column_type_in_organisasi_table', 1),
(7, '2025_05_12_095929_create_organisasi_table', 1),
(8, '2025_05_13_034216_create_poin_mahasiswas_table', 1),
(9, '2025_05_15_034714_create_absensi_table', 1),
(10, '2025_05_21_032428_create_skpis_table', 1),
(11, '2025_05_30_065114_create_detail_kegiatan_mahasiswa_table', 1),
(12, '2025_06_03_060601_create_detail_organisasi_mahasiswa_table', 2),
(13, '2025_09_21_032004_create_penentuan_poins_table', 2),
(14, '2025_10_14_032609_create_users_table', 2),
(15, '2025_11_23_010723_create_detail_kegiatan_mahasiswa_table', 3),
(16, '2026_01_06_074106_create_temens_table', 4),
(17, '2026_01_06_082835_create_teman_requests_table', 5),
(18, '2026_01_07_003412_add_online_to_mahasiswas_table', 6),
(19, '2026_01_07_032904_add_status_to_temans_table', 7),
(20, '2026_01_20_144443_add_tanggal_bergabung_to_detail_organisasi_mahasiswa_table', 8),
(21, '2026_01_21_024109_change_poin_to_int_in_detail_kegiatan_mahasiswa_table', 9),
(22, '2026_01_21_024325_ubah_poin_detail_kegiatan_mahasiswa', 10),
(23, '2026_01_21_035613_update_enum_tipe_poin_mahasiswas', 11),
(24, '2026_01_21_095617_add_poin_tambahan_to_poin_mahasiswas_table', 12),
(25, '2026_01_22_011312_update_default_poin_on_poin_mahasiswas_table', 13),
(26, '2026_01_23_075921_add_id_organisasi_to_kegiatans_table', 14),
(27, '2026_01_25_003430_add_tanggal_berakhir_to_detail_organisasi_mahasiswa_table', 15),
(28, '2026_01_27_032204_create_password_resets_table', 16),
(29, '2026_01_27_034340_add_otp_to_password_resets_table', 17),
(30, '2026_01_27_034621_add_updated_at_to_password_resets_table', 18),
(31, '2026_03_03_002404_add_periode_to_detail_organisasi_mahasiswa_table', 18),
(32, '2026_03_03_042832_drop_id_organisasi_from_organisasis_table', 19),
(33, '2026_03_05_030859_add_alasan_to_poin_mahasiswas_table', 20),
(34, '2026_03_05_093251_add_fakultas_to_organisasis_table', 21),
(35, '2026_03_05_093442_add_fakultas_to_organisasis_table', 22);

-- --------------------------------------------------------

--
-- Struktur dari tabel `organisasis`
--

CREATE TABLE `organisasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_organisasi` varchar(255) NOT NULL,
  `fakultas` varchar(255) NOT NULL,
  `id_kegiatan` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `organisasis`
--

INSERT INTO `organisasis` (`id`, `nama_organisasi`, `fakultas`, `id_kegiatan`, `created_at`, `updated_at`) VALUES
(67, 'HIMA Fakultas Teknologi Informasi', 'Teknologi Informasi', NULL, '2026-03-05 23:54:20', '2026-03-07 18:33:55'),
(69, 'HIMA Fakultas Ekonomi', 'Ekonomi', NULL, '2026-03-07 18:36:50', '2026-03-07 18:36:50'),
(70, 'Badan Eksekutif Mahasiswa', 'Universitas', NULL, '2026-03-09 17:48:53', '2026-03-09 17:48:53'),
(71, 'Hima Fakultas Ilmu Pendidikan', 'Ilmu Pendidikan', NULL, '2026-03-09 20:02:27', '2026-03-09 20:02:27'),
(72, 'Hima Fakultas Ilmu Filsafat', 'Filsafat', NULL, '2026-03-10 07:52:51', '2026-03-10 07:52:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`, `otp`, `expired_at`, `updated_at`) VALUES
(7, '2282036@unai.edu', '', '2026-01-27 00:42:06', '858292', '2026-01-27 00:52:06', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penentuan_poin`
--

CREATE TABLE `penentuan_poin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `poin` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penentuan_poin`
--

INSERT INTO `penentuan_poin` (`id`, `keterangan`, `poin`, `created_at`, `updated_at`) VALUES
(3, 'Mengikuti Kegiatan yang Dilaksanan Oleh Organisasi', 100, '2025-12-22 03:15:54', '2026-01-04 18:27:59'),
(8, 'Mengikuti Organisasi', 250, '2026-01-04 04:35:22', '2026-01-04 04:35:22'),
(10, 'Mengikuti Lomba ( Tingkat Kecamatan / Keluarahan )', 250, '2026-01-27 06:21:03', '2026-01-27 06:21:03'),
(11, 'Mengikuti Lomba ( Tingkat Kabupaten/ Kota )', 300, '2026-01-27 06:21:32', '2026-01-27 06:21:32'),
(12, 'Mengikuti Lomba ( Tingkat Provinsi )', 400, '2026-01-27 06:21:57', '2026-01-27 06:21:57'),
(13, 'Mengikuti Lomba ( Tingkat Nasional )', 500, '2026-01-27 06:22:17', '2026-01-27 06:22:17'),
(14, 'Mengikuti Lomba ( Tingkat Internasional )', 1000, '2026-01-27 06:22:41', '2026-01-27 06:22:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `poin_mahasiswas`
--

CREATE TABLE `poin_mahasiswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tipe` enum('kegiatan','organisasi','manual') NOT NULL DEFAULT 'manual',
  `nama_kegiatan` varchar(255) DEFAULT NULL,
  `jenis_kegiatan` varchar(255) DEFAULT NULL,
  `tanggal_kegiatan` date DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `status_keanggotaan` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `poin` int(11) NOT NULL DEFAULT 0,
  `alasan` text DEFAULT NULL,
  `poin_tambahan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `poin_mahasiswas`
--

INSERT INTO `poin_mahasiswas` (`id`, `nim`, `nama`, `tipe`, `nama_kegiatan`, `jenis_kegiatan`, `tanggal_kegiatan`, `jabatan`, `status_keanggotaan`, `deskripsi`, `poin`, `alasan`, `poin_tambahan`, `created_at`, `updated_at`) VALUES
(80, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Juara 9', 0, '2026-01-21 08:17:47', '2026-03-04 22:43:55'),
(83, '2282036', 'Siti Nuraini Tambunan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, '2026-01-21 18:02:20', '2026-01-23 00:24:54'),
(84, '2282011', 'Gervino Rufus', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, '2026-01-21 18:14:29', '2026-01-23 00:19:19'),
(85, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, -500, '2026-03-04 23:21:25', '2026-03-04 23:21:25'),
(86, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Juara 1', 300, '2026-03-04 23:21:41', '2026-03-04 23:21:41'),
(87, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, -300, '2026-03-05 23:49:17', '2026-03-05 23:49:17'),
(88, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, -500, '2026-03-05 23:59:51', '2026-03-05 23:59:51'),
(89, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1000, '2026-03-06 00:00:00', '2026-03-06 00:00:00'),
(92, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Juara 1', 1000, '2026-03-07 21:12:37', '2026-03-07 21:12:37'),
(93, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, -1000, '2026-03-07 21:34:41', '2026-03-07 21:34:41'),
(94, '2282004', 'Rhesa Ivander Sihol Azaria Panjaitan', 'manual', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Juara 1 Cybercup', 350, '2026-03-09 20:11:18', '2026-03-09 20:11:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `skpis`
--

CREATE TABLE `skpis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `ttl` varchar(255) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `masuk` varchar(255) NOT NULL,
  `lulus` varchar(255) NOT NULL,
  `no_ijazah` varchar(255) NOT NULL,
  `gelar` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `bahasa` varchar(255) NOT NULL,
  `jenjang` varchar(255) NOT NULL,
  `karakter` varchar(255) NOT NULL,
  `tanggal_surat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `skpis`
--

INSERT INTO `skpis` (`id`, `nama`, `ttl`, `nim`, `masuk`, `lulus`, `no_ijazah`, `gelar`, `prodi`, `bahasa`, `jenjang`, `karakter`, `tanggal_surat`, `created_at`, `updated_at`) VALUES
(1, 'Siti Nuraini Tambunan', '24 Oktober 2003', '2282012', '2022', '2026', '12', 'S.kom', 'Sistem Informasi', 'Indonesia, Inggris', 'Sarjana', 'Disiplin , ,Bertanggung Jawab', '2025-12-07', '2025-11-27 01:31:42', '2025-12-06 23:25:08'),
(2, 'Rhesa Ivander Sihol Azaria Panjaitan', 'Tangerang, 30 Oktober 2003', '2282004', '2022', '2026', '1234567', 'S.kom', 'Sistem Informasi', 'inggirs indonesia', 'Sarjana (S1)', 'Displin , Jujur, Bertanggung Jawab', '2026-06-20', '2025-12-04 05:48:47', '2026-03-02 02:27:02'),
(3, 'Siti Nuraini Tambunan', 'Sipagabu 08-09-25', '2282036', '2022', '2026', '12', 'S.kom', 'Sistem Informasi', 'Indonesia, Inggris', 'Sarjana', 'Disiplin , ,Bertanggung Jawab', '2025-12-07', '2025-12-06 23:21:47', '2025-12-06 23:21:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `temans`
--

CREATE TABLE `temans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_nim` varchar(255) NOT NULL,
  `teman_nim` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `teman_requests`
--

CREATE TABLE `teman_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengirim_nim` varchar(255) NOT NULL,
  `penerima_nim` varchar(255) NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `teman_requests`
--

INSERT INTO `teman_requests` (`id`, `pengirim_nim`, `penerima_nim`, `status`, `created_at`, `updated_at`) VALUES
(31, '2282011', '2282004', 'accepted', '2026-01-06 23:29:27', '2026-01-06 23:29:45'),
(32, '2282036', '2282004', 'accepted', '2026-01-06 23:30:46', '2026-01-06 23:31:02'),
(33, '2282004', '2282011', 'accepted', '2026-01-07 02:10:53', '2026-01-07 02:11:09'),
(34, '2282011', '2282036', 'accepted', '2026-01-12 20:24:55', '2026-01-12 20:27:59'),
(35, '2282004', '2282036', 'accepted', '2026-01-21 03:25:44', '2026-01-21 03:25:56'),
(36, '2282004', '2282036', 'accepted', '2026-01-21 18:20:41', '2026-01-21 18:20:58'),
(37, '2282004', '2282036', 'accepted', '2026-01-25 07:26:55', '2026-01-25 07:27:09'),
(38, '2282004', '2282011', 'accepted', '2026-03-01 21:39:29', '2026-03-01 21:39:49'),
(39, '2282011', '2282011', 'rejected', '2026-03-01 21:43:00', '2026-03-01 21:43:50'),
(40, '2282011', '2282004', 'accepted', '2026-03-01 21:44:05', '2026-03-01 21:44:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','mahasiswa','organisasi','warek') NOT NULL,
  `organisasi_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `organisasi_id`, `created_at`, `updated_at`) VALUES
(2, 'Admin SKPI', 'admin@unai.ac.id', '$2y$12$1IgA3dyFoWeJgnN0hVQaP.S7eIytZXJl7B487aW.baI63SmlYErPO', 'admin', NULL, '2025-11-16 03:51:09', '2025-11-27 23:55:50'),
(5, 'Mahasiswa UNAI', 'mahasiswa@unai.ac.id', '$2y$12$jOZOW93f0N3l3L9fikzW9u4GEnj3fPRXdPNhFs2NPTtJTevql5OUi', 'mahasiswa', NULL, '2025-12-07 20:02:43', '2025-12-07 20:02:43'),
(6, 'Mahasiswa UNAI', '2282004@unai.edu', '$2y$12$HIB/w81EN5RR4WJ/0qiYluZoDyPxk2sXI.a8bRmeOuDzq1y/Eyw..', 'mahasiswa', NULL, '2025-12-09 05:51:40', '2026-01-26 21:45:57'),
(7, 'Mahasiswa UNAI', '2282036@unai.edu', '$2y$12$h3roX.LtY/xkzzUBCsKwx.WT7b6Eif3cayGszXuIITC4D1Y67jH7C', 'mahasiswa', NULL, '2025-12-09 05:53:40', '2025-12-09 05:53:40'),
(8, 'Mahasiswa UNAI', '2282011@unai.edu', '$2y$12$BPPnkALwMs2h5lzOtE5sC.VcC5wZ025mVBhpFKJiKyu6GN16FWnhe', 'mahasiswa', NULL, '2026-01-06 21:19:42', '2026-01-26 21:24:46'),
(11, 'Mahasiswa UNAI', '2282012@unai.edu', '$2y$12$o4smGRhsFO.VFFjsLpYSxOU0T99C0yg9Ss/7cnUw022lyaHohZrIm', 'mahasiswa', NULL, '2026-01-11 17:04:04', '2026-01-11 17:04:04'),
(12, 'Mahasiswa UNAI', '2281071@unai.edu', '$2y$12$Emknu1LSdHEUto4S8k49C.tGorvPXJBk3xnq9/5Y.09DiNB0MNE7W', 'mahasiswa', NULL, '2026-01-26 21:32:15', '2026-01-26 21:34:32'),
(14, 'Mahasiswa UNAI', 'dianbalian30@gmail.com', '$2y$12$FNbr5xm3MRU0LZ6Dg4PeOedmqDLeWgdJxJ7mKC979TEq1f36EpeIu', 'mahasiswa', NULL, '2026-01-26 22:28:48', '2026-01-26 22:33:57'),
(15, 'Mahasiswa UNAI', '2381064@unai.edu', '$2y$12$LFopeIeS4dh8h2hWz6R47Od1iEiaiX6YIKUmNkQlKr8N3GPCZWdAa', 'mahasiswa', NULL, '2026-01-27 21:59:08', '2026-01-27 21:59:08'),
(22, 'HIMA Fakultas Teknologi Informasi', 'himafti@unai.edu', '$2y$12$oqovPk2/HD/tli7spjdaoOq5sfwTHX.NahzCIKFq6bgaTbxUXLJku', 'organisasi', 67, '2026-03-05 23:54:21', '2026-03-05 23:54:21'),
(24, 'HIMA Fakultas Ekonomi', 'himafekon@unai.edu', '$2y$12$X7coRfrysgJIiFOj5ijjB.HbhaZDnBkFUi69Z/Ee6zNuN.LJKjdAa', 'organisasi', 69, '2026-03-07 18:36:50', '2026-03-07 18:36:50'),
(25, 'Badan Eksekutif Mahasiswa', 'bem@unai.edu', '$2y$12$93y.RGdHylegWiyg7DdpmuACMBWullxJ/ba1q5NOWY2Zi8AvnSVCO', 'organisasi', 70, '2026-03-09 17:48:53', '2026-03-09 17:48:53'),
(26, 'Hima Fakultas Ilmu Pendidikan', 'fkip@unai.edu', '$2y$12$26ZEt2uSLdCObY2AVVwMyeFmmx3HQJyLwaFA0FV3wPKdJfdGXMidq', 'organisasi', 71, '2026-03-09 20:02:28', '2026-03-09 20:02:28'),
(27, 'Wakil Rektor 3', 'warek3@unai.edu', '$2y$12$.19rImLMI8fuqxraHxAt2eDjUyb7lEt4Kr0qJnyR8g8npVDxon1/2', 'warek', NULL, '2026-03-10 06:41:58', '2026-03-10 06:41:58'),
(32, 'Mahasiswa UNAI', '2211016@unai.edu', '$2y$12$9FXSyuML5NH6bdTlPT/DJegtLU1sBrggQRsyyy2uUJb/rMgUSk7vG', 'mahasiswa', NULL, '2026-03-10 07:50:35', '2026-03-10 07:50:35'),
(33, 'Mahasiswa UNAI', '2211018@unai.edu', '$2y$12$lZslqFoEeA.0Jhif18v7lefDbvM4aBYAvHY9Etn4JvoQz5UxstL52', 'mahasiswa', NULL, '2026-03-10 07:50:42', '2026-03-10 07:50:42'),
(34, 'Mahasiswa UNAI', '2211020@unai.edu', '$2y$12$NT4sYN/CZj0uyUnu6KukweuF1fHPm4dq05aR7/cCS8edXut5aHm8i', 'mahasiswa', NULL, '2026-03-10 07:50:48', '2026-03-10 07:50:48'),
(35, 'Mahasiswa UNAI', '2232070@unai.edu', '$2y$12$/8Wgt/niWNc6bhiGa6RIsuKwACg2B6htw2vxUoA8DlwVHb1pjx7ne', 'mahasiswa', NULL, '2026-03-10 07:50:56', '2026-03-10 07:50:56'),
(36, 'Hima Fakultas Ilmu Filsafat', 'ffil@unai.edu', '$2y$12$fd6yE.Kva9PR1t67hqN.cOxz6PGsx3diwxvbp9Fsn4x2nu5VMISDy', 'organisasi', 72, '2026-03-10 07:52:52', '2026-03-10 07:52:52'),
(40, 'Mahasiswa UNAI', '2232065@unai.edu', '$2y$12$.9gqEVzhge6qquQ8ra5OCuii762fX3ff1lx5jIR1yAT10S1F9TpPi', 'mahasiswa', NULL, '2026-03-10 08:02:27', '2026-03-10 08:02:27'),
(41, 'Mahasiswa UNAI', '2232055@unai.edu', '$2y$12$MRN5vUr5M62A2TakFmbHp.XVoSqwqXQPwcY5eah28zypcbpnz.4Ci', 'mahasiswa', NULL, '2026-03-10 08:02:38', '2026-03-10 08:02:38'),
(42, 'Mahasiswa UNAI', '2232068@unai.edu', '$2y$12$8yMXC/D4cRKPHmdC8pFMpeC9NFFh7rCeqB3ZCDstYTs7y6RRJrQD2', 'mahasiswa', NULL, '2026-03-10 08:02:49', '2026-03-10 08:02:49');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `detail_kegiatan_mahasiswa`
--
ALTER TABLE `detail_kegiatan_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mahasiswa_kegiatan_unique` (`mahasiswa_nim`,`kegiatan_id_ref`),
  ADD KEY `detail_kegiatan_mahasiswa_kegiatan_id_ref_foreign` (`kegiatan_id_ref`);

--
-- Indeks untuk tabel `detail_organisasi_mahasiswa`
--
ALTER TABLE `detail_organisasi_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mahasiswas_nim_unique` (`nim`),
  ADD UNIQUE KEY `mahasiswas_email_unique` (`email`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `organisasis`
--
ALTER TABLE `organisasis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penentuan_poin`
--
ALTER TABLE `penentuan_poin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `poin_mahasiswas`
--
ALTER TABLE `poin_mahasiswas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `skpis`
--
ALTER TABLE `skpis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skpis_nim_unique` (`nim`);

--
-- Indeks untuk tabel `temans`
--
ALTER TABLE `temans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `temans_mahasiswa_nim_teman_nim_unique` (`mahasiswa_nim`,`teman_nim`),
  ADD KEY `temans_teman_nim_foreign` (`teman_nim`);

--
-- Indeks untuk tabel `teman_requests`
--
ALTER TABLE `teman_requests`
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
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_kegiatan_mahasiswa`
--
ALTER TABLE `detail_kegiatan_mahasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT untuk tabel `detail_organisasi_mahasiswa`
--
ALTER TABLE `detail_organisasi_mahasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kegiatans`
--
ALTER TABLE `kegiatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT untuk tabel `mahasiswas`
--
ALTER TABLE `mahasiswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `organisasis`
--
ALTER TABLE `organisasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `penentuan_poin`
--
ALTER TABLE `penentuan_poin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `poin_mahasiswas`
--
ALTER TABLE `poin_mahasiswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT untuk tabel `skpis`
--
ALTER TABLE `skpis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `temans`
--
ALTER TABLE `temans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT untuk tabel `teman_requests`
--
ALTER TABLE `teman_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_kegiatan_mahasiswa`
--
ALTER TABLE `detail_kegiatan_mahasiswa`
  ADD CONSTRAINT `detail_kegiatan_mahasiswa_kegiatan_id_ref_foreign` FOREIGN KEY (`kegiatan_id_ref`) REFERENCES `kegiatans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_kegiatan_mahasiswa_mahasiswa_nim_foreign` FOREIGN KEY (`mahasiswa_nim`) REFERENCES `mahasiswas` (`nim`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `temans`
--
ALTER TABLE `temans`
  ADD CONSTRAINT `temans_mahasiswa_nim_foreign` FOREIGN KEY (`mahasiswa_nim`) REFERENCES `mahasiswas` (`nim`) ON DELETE CASCADE,
  ADD CONSTRAINT `temans_teman_nim_foreign` FOREIGN KEY (`teman_nim`) REFERENCES `mahasiswas` (`nim`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
