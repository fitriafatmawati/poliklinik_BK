-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2024 at 06:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poli`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `tanggal`) VALUES
(1, 1, 1, 'Infeksi Saluran Reproduksi', 1, '2023-12-31 14:21:00'),
(2, 1, 1, 'Gangguan Menstruasi', 2, '2023-12-31 14:20:16'),
(3, 1, 1, 'Konseling Prakonsepsi ', 3, '2023-12-31 14:20:43'),
(4, 5, 3, 'Demam', 1, '2023-12-31 14:17:57'),
(5, 4, 2, 'cabut gigi', 1, '2024-01-02 18:17:31'),
(6, 4, 3, 'Batuk', 2, '2024-01-02 18:20:38'),
(7, 6, 2, 'sakit gigi', 2, '2024-01-04 17:29:33'),
(10, 4, 2, 'Gigi bengkak', 3, '2024-01-05 12:31:33'),
(11, 8, 2, 'Gusi bengkak', 4, '2024-01-05 13:21:37'),
(12, 2, 2, 'Gigi bolong', 5, '2024-01-05 13:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) NOT NULL,
  `id_periksa` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
(20, 18, 4),
(21, 19, 2),
(22, 20, 1),
(23, 21, 1),
(24, 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`, `id_poli`) VALUES
(3, 'Farah Aryaresta ', 'Jl. Pemuda No.5, Semarang', '08125468545', 1),
(4, 'Cantika Sari', 'Jl. Merpati No.25, Semarang', '08523564578', 3),
(5, 'Bianka Putri', 'Jl. Pahlawan No.125, Surakarta', '0852365425685', 4),
(6, 'Andreas Dika Putra', 'Jl. Semangka No.55, Semarang', '0852365452579', 6),
(7, 'Adit Saputra', 'Jl. Mekar No.22, Semarang', '08523659575', 5);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 7, 'Senin', '22:33:33', '23:33:33'),
(2, 3, 'Senin', '07:05:00', '10:00:00'),
(3, 4, 'Selasa', '08:14:58', '13:14:58'),
(4, 5, 'Rabu', '09:14:58', '14:14:58'),
(5, 4, 'Kamis', '08:16:49', '15:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `kemasan` varchar(50) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
(1, 'Paramex', 'Strip', 5000),
(2, 'Bisolvon Extra Sirup', 'Botol', 20000),
(3, 'Konidin OBH', 'Sachet', 3000),
(4, 'Paracetamol', 'Strip', 15000),
(5, 'Aspirin', 'Strip', 18000);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `no_rm` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
(1, 'lala', 'Jl. Pemuda no.05, Semarang', '0558265546565985', '085236547852', '202312-1'),
(2, 'Cinta', 'Jl.Pemuda no.66, Semarang', '852445632556632', '08521548552566', '202312-2'),
(3, 'Melati', 'Jl.Mawar no.45, Semarang', '852259625858556', '085215486659', '202312-3'),
(4, 'Bungaa', 'Jl. Pahlawan no.05, Semarang', '82254545785', '085423567854', '202312-4'),
(5, 'Amanda Suci', 'Jl. Mekar no.85, Semarang', '8521152552258', '08524565247', '202312-5'),
(6, 'Adelya Yahya', 'Jl.Melati no.85, Semarang', '085214523657522', '08936635665', '202401-6'),
(7, 'Erin Eriana', 'Jl.Sirsak no.45, Semarang', '088521354625482', '0852364251785', '202401-7'),
(8, 'Zahra Ratriana ', 'Jl. Solo no.75, Semarang', '08854623268925', '08523541265', '202401-8');

-- --------------------------------------------------------

--
-- Table structure for table `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) NOT NULL,
  `id_daftar_poli` int(11) NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text NOT NULL,
  `biaya_periksa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
(1, 6, '2024-01-04 19:46:26', 'jangan minum es', 150000),
(18, 4, '2024-01-04 21:12:22', 'minum obat teratur', 165000),
(19, 7, '2024-01-05 13:07:09', 'minum obat teratur ', 170000),
(20, 10, '2024-01-05 14:24:26', 'minum obat teratur', 155000),
(21, 11, '2024-01-05 14:43:42', 'Obat teratur', 155000),
(22, 12, '2024-01-05 14:45:16', 'obat teratur', 155000);

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int(11) NOT NULL,
  `nama_poli` varchar(25) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(1, 'Poli Gigi', 'Spesialis gigi menangani perawatan gigi, mulut, dan rongga mulut. Pelayanan meliputi pembersihan gigi, penambalan, pencabutan gigi, dan perawatan ortodonti.'),
(3, 'Poli Anak', 'Disediakan untuk perawatan dan konsultasi kesehatan anak-anak. Dokter anak atau pediatri memberikan imunisasi, pemeriksaan tumbuh kembang, dan penanganan penyakit anak.'),
(4, 'Poli Mata', 'Spesialis mata (oftalmolog) menangani pemeriksaan mata dan perawatan berbagai kondisi mata. Pemeriksaan mata, pengukuran kacamata, dan penanganan masalah mata seperti infeksi atau penyakit mata.'),
(5, 'Poli Kandungan', 'Menyediakan perawatan untuk perempuan terkait kehamilan, persalinan, dan masalah reproduksi. Pemeriksaan kehamilan, persalinan, dan perawatan ginekologi umum.'),
(6, 'Poli Syaraf', 'Spesialis syaraf atau neurolog merawat gangguan saraf. Pemeriksaan dan pengelolaan kondisi neurologis seperti migrain, stroke, atau epilepsi.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`) VALUES
(1, '', 'farah12', '$2y$10$xUXx3XOLSdVZhxydC97F.eI3fyCMTktJjTFxghlpqHvIuilJyiKf2'),
(2, '', 'faraya', '$2y$10$GLPwz87eWGRDeyNG95R/p.MVB5I2WLpzr1YGtOCL/pGxvk7CaBfkO'),
(3, '', 'faraharyaresta', '$2y$10$pgbwY6TkYSv33BRvjZ1O4erxFGTHo.Q.mnPbuoWdlHgrjZxvNJMtu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pasien_daftar_poli` (`id_pasien`),
  ADD KEY `fk_jadwal_periksa_daftar_poli` (`id_jadwal`);

--
-- Indexes for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_periksa_obat` (`id_obat`),
  ADD KEY `fk_periksa_detail_periksa` (`id_periksa`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dokter_poli` (`id_poli`);

--
-- Indexes for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jadwal_periksa_dokter` (`id_dokter`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_daftar_poli_periksa` (`id_daftar_poli`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `fk_jadwal_periksa_daftar_poli` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`),
  ADD CONSTRAINT `fk_pasien_daftar_poli` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);

--
-- Constraints for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `fk_detail_periksa_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`),
  ADD CONSTRAINT `fk_periksa_detail_periksa` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_poli` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`);

--
-- Constraints for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `fk_jadwal_periksa_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Constraints for table `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `fk_daftar_poli_periksa` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
