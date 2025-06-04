-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 03 Jun 2025 pada 07.56
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pondok`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pembayaran`
--

CREATE TABLE `kategori_pembayaran` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kategori_pembayaran`
--

INSERT INTO `kategori_pembayaran` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'SPP', 'Biaya bulanan pondok pesantren'),
(2, 'Uang Makan', 'Biaya konsumsi santri'),
(3, 'Biaya Kegiatan', 'Biaya untuk kegiatan ekstrakurikuler dan event');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_pembayaran`
--

CREATE TABLE `log_pembayaran` (
  `id_log` int NOT NULL,
  `id_pembayaran` int NOT NULL,
  `status_lama` enum('belum_bayar','menunggu_konfirmasi','diterima','ditolak') DEFAULT NULL,
  `status_baru` enum('belum_bayar','menunggu_konfirmasi','diterima','ditolak') NOT NULL,
  `catatan` text,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `log_pembayaran`
--

INSERT INTO `log_pembayaran` (`id_log`, `id_pembayaran`, `status_lama`, `status_baru`, `catatan`, `created_by`, `created_at`) VALUES
(1, 2, 'menunggu_konfirmasi', 'diterima', 'Bguss', 39, '2025-06-01 12:13:15'),
(2, 7, 'menunggu_konfirmasi', 'ditolak', 'kkkllllll', 39, '2025-06-03 00:52:22'),
(3, 7, 'ditolak', 'menunggu_konfirmasi', 'Upload ulang bukti pembayaran oleh santri', 40, '2025-06-03 01:12:29'),
(4, 7, 'menunggu_konfirmasi', 'diterima', 'okk', 39, '2025-06-03 01:14:03'),
(5, 12, 'menunggu_konfirmasi', 'ditolak', 'jjjj', 39, '2025-06-03 05:05:09'),
(6, 12, 'ditolak', 'menunggu_konfirmasi', 'Upload ulang bukti pembayaran oleh santri', 40, '2025-06-03 05:11:47'),
(7, 12, 'menunggu_konfirmasi', 'diterima', 'kk', 39, '2025-06-03 05:12:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran_santri`
--

CREATE TABLE `pembayaran_santri` (
  `id_pembayaran` int NOT NULL,
  `id_tagihan` int NOT NULL,
  `id_santri` int NOT NULL,
  `status` enum('belum_bayar','menunggu_konfirmasi','diterima','ditolak') NOT NULL DEFAULT 'belum_bayar',
  `nominal_bayar` decimal(15,2) DEFAULT NULL,
  `tanggal_bayar` datetime DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `catatan_santri` text,
  `catatan_admin` text,
  `konfirmasi_by` int DEFAULT NULL,
  `tanggal_konfirmasi` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pembayaran_santri`
--

INSERT INTO `pembayaran_santri` (`id_pembayaran`, `id_tagihan`, `id_santri`, `status`, `nominal_bayar`, `tanggal_bayar`, `bukti_pembayaran`, `catatan_santri`, `catatan_admin`, `konfirmasi_by`, `tanggal_konfirmasi`, `created_at`) VALUES
(1, 1, 4, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-01 04:52:27'),
(2, 1, 5, 'diterima', 5000000.00, '2025-06-01 12:07:22', '7573c2172e4840007a02bacf9c156aa4.jpg', '', 'Bguss', 39, '2025-06-01 12:13:15', '2025-06-01 04:52:27'),
(3, 1, 6, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-01 04:52:27'),
(4, 1, 7, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-01 04:52:27'),
(5, 1, 8, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-01 04:52:27'),
(6, 2, 4, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02 17:49:56'),
(7, 2, 5, 'diterima', 50000.00, '2025-06-03 01:12:29', '0ac91b99abb8a96218702fc1d532a208.jpg', '', 'okk', 39, '2025-06-03 01:14:03', '2025-06-02 17:49:56'),
(8, 2, 6, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02 17:49:56'),
(9, 2, 7, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02 17:49:56'),
(10, 2, 8, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02 17:49:56'),
(11, 3, 4, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02 21:59:19'),
(12, 3, 5, 'diterima', 1000000000.00, '2025-06-03 05:11:47', '844a497dc267cbd13ff69664bbbdd2ed.jpg', 'jjjjj', 'kk', 39, '2025-06-03 05:12:09', '2025-06-02 21:59:19'),
(13, 3, 6, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02 21:59:19'),
(14, 3, 7, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02 21:59:19'),
(15, 3, 8, 'belum_bayar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02 21:59:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
--

CREATE TABLE `rekening` (
  `id_rekening` int NOT NULL,
  `nama_bank` varchar(100) NOT NULL,
  `no_rekening` varchar(50) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `rekening`
--

INSERT INTO `rekening` (`id_rekening`, `nama_bank`, `no_rekening`, `atas_nama`, `is_active`, `created_at`) VALUES
(1, 'BRI', '123456789', 'Yayasan Pondok Darussurur', 1, '2025-06-01 10:59:01'),
(2, 'BNI', '987654321', 'Yayasan Pondok Darussurur', 1, '2025-06-01 10:59:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'Santri');

-- --------------------------------------------------------

--
-- Struktur dari tabel `santri`
--

CREATE TABLE `santri` (
  `id_santri` int NOT NULL,
  `id_user` int NOT NULL,
  `nis` varchar(50) NOT NULL,
  `alamat` text,
  `no_wa` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `santri`
--

INSERT INTO `santri` (`id_santri`, `id_user`, `nis`, `alamat`, `no_wa`, `tanggal_lahir`) VALUES
(4, 36, '1222', 'Bantul', '82360776765', '2003-05-19'),
(5, 40, '294787375375', 'hutankk', '81353244360', '2025-05-08'),
(6, 41, '098765', 'jln gatak', '86543', '2025-05-16'),
(7, 42, '2345753', 'kasihan', '765473892', '2025-05-15'),
(8, 43, '456732', 'bima', '234342334', '2025-05-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` int NOT NULL,
  `id_kategori` int NOT NULL,
  `nama_tagihan` varchar(100) NOT NULL,
  `deskripsi` text,
  `nominal` decimal(15,2) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `id_rekening` int NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_kategori`, `nama_tagihan`, `deskripsi`, `nominal`, `tanggal_mulai`, `tanggal_jatuh_tempo`, `id_rekening`, `created_by`, `created_at`) VALUES
(1, 1, 'SPP bulan juli', 'JJJJ', 5000000.00, '2025-06-01', '2025-07-02', 2, 39, '2025-06-01 11:52:27'),
(2, 3, 'Listrik', 'jjjjjjjjjjjjjjjjjjj', 50000.00, '2025-06-03', '2025-07-03', 1, 39, '2025-06-03 00:49:56'),
(3, 3, 'jjjjjjjjjj', 'jjjjjjjj', 1000000000.00, '2025-06-03', '2025-07-03', 2, 39, '2025-06-03 04:59:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `foto_user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `email`, `password`, `id_role`, `nik`, `jenis_kelamin`, `foto_user`) VALUES
(9, 'Mei Albert', '213100205@almaata.ac.id', '$2y$10$45okUXQpFBOURq6jCBE7eOvZilZZwkb6dmAJN1s8RZFSuKrx3Aah6', 1, '', 'L', 'bcd11dad5db3f04944ff674015c81bc8.jpg'),
(36, 'Mei Albert Zendrato', 'meialbertzend@gmail.com', '$2y$10$pOsO/tmvreR4fZlHWf3nkehcBR4M4QTK9bdtwdIb/EfIFc0XiEDuy', 2, NULL, 'L', '9116e28bee231f163f0e1d3573953343.jpg'),
(39, 'Theodorus keraf', 'theo@gmail.com', '$2y$10$YIbMkKapHAi3QcsFirkcqe9M8nDrT88n/AMoLafLsjTWhk9EZoH42', 1, NULL, 'L', 'b2aa491fc9c588c8827f8da5ee1dbc36.png'),
(40, 'Maulana', 'maulana@gmail.com', '$2y$10$eQiaska9k3/EGUOnQ8kQb.q1FHbs8ZPProqrdtTH2JeLMNBAu59l6', 2, NULL, 'L', 'a0590a61a373223953eecee563a13422.jpg'),
(41, 'Risky Fadilah Gunawan', 'fadill@gmail.com', '$2y$10$wzabFzzH8r00R75TXsj2kO8uRr8BPscLLVP/imU3Ep.YhxNUtLAVu', 2, NULL, 'L', NULL),
(42, 'Abdul Rozaq', 'abdul@gmail.com', '$2y$10$JdkcbWs8V/5BMEz/qZnMsut5Jt1BPzhGDEjLzEFj9XW5EQCD1fy12', 2, NULL, 'L', NULL),
(43, 'Medy Febry', 'medy@gmail.com', '$2y$10$wqv1J6OK7zjpdIvoyA31Z.po5ysySn0CqBnU89UAVHY0i5saZMTsu', 2, NULL, 'L', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori_pembayaran`
--
ALTER TABLE `kategori_pembayaran`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `log_pembayaran`
--
ALTER TABLE `log_pembayaran`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_pembayaran` (`id_pembayaran`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `pembayaran_santri`
--
ALTER TABLE `pembayaran_santri`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_tagihan` (`id_tagihan`),
  ADD KEY `id_santri` (`id_santri`),
  ADD KEY `konfirmasi_by` (`konfirmasi_by`);

--
-- Indeks untuk tabel `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id_rekening`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id_santri`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `id_rekening` (`id_rekening`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori_pembayaran`
--
ALTER TABLE `kategori_pembayaran`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `log_pembayaran`
--
ALTER TABLE `log_pembayaran`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pembayaran_santri`
--
ALTER TABLE `pembayaran_santri`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id_rekening` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `santri`
--
ALTER TABLE `santri`
  MODIFY `id_santri` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id_tagihan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `log_pembayaran`
--
ALTER TABLE `log_pembayaran`
  ADD CONSTRAINT `log_pembayaran_fk` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran_santri` (`id_pembayaran`) ON DELETE CASCADE,
  ADD CONSTRAINT `log_user_fk` FOREIGN KEY (`created_by`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran_santri`
--
ALTER TABLE `pembayaran_santri`
  ADD CONSTRAINT `pembayaran_santri_fk` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_tagihan_fk` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihan` (`id_tagihan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_user_fk` FOREIGN KEY (`konfirmasi_by`) REFERENCES `user` (`id_user`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD CONSTRAINT `santri_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_kategori_fk` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_pembayaran` (`id_kategori`) ON DELETE RESTRICT,
  ADD CONSTRAINT `tagihan_rekening_fk` FOREIGN KEY (`id_rekening`) REFERENCES `rekening` (`id_rekening`) ON DELETE RESTRICT,
  ADD CONSTRAINT `tagihan_user_fk` FOREIGN KEY (`created_by`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- Struktur dari tabel `pemasukan`
CREATE TABLE `pemasukan` (
  `id_pemasukan` int NOT NULL,
  `id_pembayaran` int NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `keterangan` text,
  `tanggal_pemasukan` datetime NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pemasukan`),
  KEY `id_pembayaran` (`id_pembayaran`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `pemasukan_pembayaran_fk` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran_santri` (`id_pembayaran`) ON DELETE RESTRICT,
  CONSTRAINT `pemasukan_user_fk` FOREIGN KEY (`created_by`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Struktur dari tabel `pengeluaran`
CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int NOT NULL,
  `nama_pengeluaran` varchar(100) NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `keterangan` text,
  `tanggal_pengeluaran` datetime NOT NULL,
  `bukti_pengeluaran` varchar(255) DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengeluaran`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `pengeluaran_user_fk` FOREIGN KEY (`created_by`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Struktur dari tabel `laporan_keuangan`
CREATE TABLE `laporan_keuangan` (
  `id_laporan` int NOT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `total_pemasukan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_pengeluaran` decimal(15,2) NOT NULL DEFAULT '0.00',
  `saldo_awal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `saldo_akhir` decimal(15,2) NOT NULL DEFAULT '0.00',
  `keterangan` text,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_laporan`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `laporan_user_fk` FOREIGN KEY (`created_by`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Trigger untuk auto insert ke tabel pemasukan saat pembayaran diterima
DELIMITER //
CREATE TRIGGER `tr_pembayaran_diterima` 
AFTER UPDATE ON `pembayaran_santri`
FOR EACH ROW
BEGIN
  IF NEW.status = 'diterima' AND OLD.status != 'diterima' THEN
    INSERT INTO `pemasukan` (
      id_pembayaran,
      nominal,
      keterangan,
      tanggal_pemasukan,
      created_by
    ) VALUES (
      NEW.id_pembayaran,
      NEW.nominal_bayar,
      CONCAT('Pembayaran dari santri untuk ', (SELECT nama_tagihan FROM tagihan WHERE id_tagihan = NEW.id_tagihan)),
      NEW.tanggal_konfirmasi,
      NEW.konfirmasi_by
    );
  END IF;
END//
DELIMITER ;
