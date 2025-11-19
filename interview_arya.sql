-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 19 Nov 2025 pada 16.06
-- Versi server: 11.3.2-MariaDB-log
-- Versi PHP: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `interview_arya`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `asesmen`
--

CREATE TABLE `asesmen` (
  `id` int(11) NOT NULL,
  `kunjunganid` int(11) NOT NULL,
  `keluhan_utama` text NOT NULL,
  `keluhan_tambahan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `asesmen`
--

INSERT INTO `asesmen` (`id`, `kunjunganid`, `keluhan_utama`, `keluhan_tambahan`) VALUES
(2, 2, 'aa', 'aa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `group`
--

INSERT INTO `group` (`id`, `name`, `notes`, `isactive`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Superadmin', 'Administrator dapat mengakses seluruh akses (all control)', 1, NULL, NULL, 1, '2025-11-19 22:53:56'),
(2, 'Admisi', '', 1, 1, '2025-11-19 22:46:10', 1, '2025-11-19 22:54:02'),
(3, 'Perawat', '', 1, 1, '2025-11-19 22:46:17', 1, '2025-11-19 22:54:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `group_role`
--

CREATE TABLE `group_role` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `group_role`
--

INSERT INTO `group_role` (`id`, `group_id`, `role_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 2, 4),
(8, 2, 5),
(9, 1, 7),
(10, 1, 8),
(11, 1, 9),
(12, 1, 10),
(13, 2, 8),
(14, 2, 9),
(15, 3, 4),
(16, 3, 5),
(17, 3, 6),
(18, 3, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id` int(11) NOT NULL,
  `pendaftaranpasienid` int(11) NOT NULL,
  `jeniskunjungan` enum('baru','lama') NOT NULL,
  `tglkunjungan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kunjungan`
--

INSERT INTO `kunjungan` (`id`, `pendaftaranpasienid`, `jeniskunjungan`, `tglkunjungan`) VALUES
(2, 2, 'baru', '2025-11-19 21:29:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_login`
--

CREATE TABLE `log_login` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `log_login`
--

INSERT INTO `log_login` (`id`, `user_id`, `tanggal`, `ip`) VALUES
(1, 1, '2025-11-19 10:02:20', '::1'),
(2, 1, '2025-11-19 12:29:47', '::1'),
(3, 1, '2025-11-19 16:04:54', '::1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `action_active` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `role_id`, `parent_id`, `code`, `name`, `action`, `action_active`, `icon`, `isactive`) VALUES
(1, NULL, NULL, '001', 'Home', 'home', 'home', 'fa fa-th-large', 1),
(2, 3, NULL, '002', 'Pasien', 'pasien', 'pasien', NULL, 1),
(3, 4, NULL, '003', 'Pendaftaran', 'pendaftaran', 'pendaftaran', NULL, 1),
(4, 5, NULL, '004', 'Kunjungan', 'kunjungan', 'kunjungan', NULL, 1),
(5, 6, NULL, '005', 'Asesmen', 'asesmen', 'asesmen', NULL, 1),
(6, NULL, NULL, '006', 'Sistem', NULL, NULL, 'fa fa-cogs', 1),
(7, 1, 6, '006.001', 'Pengguna', 'user', 'user', 'fa fa-user-lock', 1),
(8, 2, 6, '006.002', 'Group', 'group', 'group', 'fa fa-users-cog', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-05-22-040509', 'App\\Database\\Migrations\\CreateInitialTables', 'default', 'App', 1763546470, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `norm` varchar(10) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `norm`, `alamat`) VALUES
(5, 'Leanne Graham', '1', 'Kulas Light Apt. 556 Gwenborough 92998-3874'),
(6, 'Ervin Howell', '2', 'Victor Plains Suite 879 Wisokyburgh 90566-7771'),
(7, 'Clementine Bauch', '3', 'Douglas Extension Suite 847 McKenziehaven 59590-4157'),
(8, 'Patricia Lebsack', '4', 'Hoeger Mall Apt. 692 South Elvis 53919-4257'),
(9, 'Chelsey Dietrich', '5', 'Skiles Walks Suite 351 Roscoeview 33263'),
(10, 'Mrs. Dennis Schulist', '6', 'Norberto Crossing Apt. 950 South Christy 23505-1337'),
(11, 'Kurtis Weissnat', '7', 'Rex Trail Suite 280 Howemouth 58804-1099'),
(12, 'Nicholas Runolfsdottir V', '8', 'Ellsworth Summit Suite 729 Aliyaview 45169'),
(13, 'Glenna Reichert', '9', 'Dayna Park Suite 449 Bartholomebury 76495-3109'),
(14, 'Clementina DuBuque', '10', 'Kattie Turnpike Suite 198 Lebsackbury 31428-2261');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL,
  `pasienid` int(11) NOT NULL,
  `noregistrasi` varchar(20) NOT NULL,
  `tglregistrasi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `pasienid`, `noregistrasi`, `tglregistrasi`) VALUES
(2, 5, 'ww', '2025-11-19 21:17:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `parent_id`, `code`, `name`, `order`) VALUES
(1, NULL, 'user', 'Pengguna', '009'),
(2, NULL, 'group', 'Group', '010'),
(3, NULL, 'pasien', 'Pasien', '001'),
(4, NULL, 'pendaftaran', 'Pendaftaran', '003'),
(5, NULL, 'kunjungan', 'Kunjungan', '005'),
(6, NULL, 'asesmen', 'Asesmen', '007'),
(7, 3, 'crud_pasien', 'CRUD', '002'),
(8, 4, 'crud_pendaftaran', 'CRUD', '004'),
(9, 5, 'crud_kunjungan', 'CRUD', '006'),
(10, 6, 'crud_asesmen', 'CRUD', '008');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `email`, `isactive`, `last_login`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'admin', '$2y$12$UbjZrXswyg9aJeY5vQI.fOcJspi/yIa6HtyeDvR5m0AykEW76LWci', 'Administrator', '', 1, '2025-11-19 23:04:54', NULL, NULL, NULL, NULL),
(2, 'admisi', '$2y$10$ZYCGDUSBj32kshXi9O0/lOKl2Nrq2QeihepWfQt1aZa4eVHMnUTjm', 'Admisi', '', 1, NULL, 1, '2025-11-19 23:04:25', NULL, '2025-11-19 23:04:25'),
(3, 'perawat', '$2y$10$qBzbq29IAn7P9L3plhlK1.TzMTxI/TEO.gc0kV0ine3htjYkUZBWe', 'Perawat', '', 1, NULL, 1, '2025-11-19 23:04:44', NULL, '2025-11-19 23:04:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_group`
--

INSERT INTO `user_group` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 1, 2),
(5, 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `asesmen`
--
ALTER TABLE `asesmen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunjunganid` (`kunjunganid`);

--
-- Indeks untuk tabel `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `group_role`
--
ALTER TABLE `group_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_role_group_id_foreign` (`group_id`),
  ADD KEY `group_role_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaranpasienid` (`pendaftaranpasienid`);

--
-- Indeks untuk tabel `log_login`
--
ALTER TABLE `log_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_login_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `menu_role_id_foreign` (`role_id`),
  ADD KEY `menu_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasienid` (`pasienid`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `role_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_group_user_id_foreign` (`user_id`),
  ADD KEY `user_group_group_id_foreign` (`group_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `asesmen`
--
ALTER TABLE `asesmen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `group_role`
--
ALTER TABLE `group_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `log_login`
--
ALTER TABLE `log_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `asesmen`
--
ALTER TABLE `asesmen`
  ADD CONSTRAINT `asesmen_ibfk_1` FOREIGN KEY (`kunjunganid`) REFERENCES `kunjungan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `group_role`
--
ALTER TABLE `group_role`
  ADD CONSTRAINT `group_role_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD CONSTRAINT `kunjungan_ibfk_1` FOREIGN KEY (`pendaftaranpasienid`) REFERENCES `pendaftaran` (`id`);

--
-- Ketidakleluasaan untuk tabel `log_login`
--
ALTER TABLE `log_login`
  ADD CONSTRAINT `log_login_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Ketidakleluasaan untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`pasienid`) REFERENCES `pasien` (`id`);

--
-- Ketidakleluasaan untuk tabel `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `user_group_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_group_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
