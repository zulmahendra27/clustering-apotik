-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 22, 2023 at 04:12 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_fuzzy_cmeans`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `stok` int NOT NULL,
  `harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga`) VALUES
(1, 'Parasetamol 500 tab*', 22, 11000),
(2, 'Ketokonazole 2% krim*', 8, 19000),
(3, 'Salticin 5gr krim', 12, 15000),
(4, 'kasa steril', 45, 16000),
(5, 'Kasa steril hidrophile', 39, 7000),
(6, 'NaCl 0,9% inf 500ml', 37, 10000),
(7, 'Flamoxi kaplet', 11, 18000),
(8, 'Verband roll 15cm', 24, 6000),
(9, 'Dulcolax 5 tab', 25, 7000),
(10, 'Albothyl 10ml', 32, 10000),
(11, 'Vitamin C 50 tab*', 33, 20000),
(12, 'Ranitidin 150 tab*', 17, 5000),
(13, 'Oksimetazolin (obt tetes mata)', 33, 14000),
(14, 'Ibuprofen 200 tab*', 50, 19000),
(15, 'Tramadol 50 tab*', 46, 9000),
(16, 'Ketorolac 30mg/ml inj 1ml*', 30, 7000),
(17, 'Ambroxol 30mg tab*', 11, 14000),
(18, 'Panadol drop 15ml', 33, 11000),
(19, 'Ulsikur inj 100mg/ml 2ml', 42, 8000),
(20, 'Antasida syr 60ml*', 45, 15000),
(21, 'Cytrodox 500 mg', 26, 11000),
(22, 'D5% inf 500ml', 37, 19000),
(23, 'Domperidon syr 60ml*', 46, 17000),
(24, 'Betametason krim 0,1% 5gr*', 45, 14000),
(25, 'Asam mefenamat 500 tab*', 30, 8000);

-- --------------------------------------------------------

--
-- Table structure for table `dataset`
--

CREATE TABLE `dataset` (
  `id_dataset` int NOT NULL,
  `id_barang` int NOT NULL,
  `bulan` int NOT NULL,
  `penjualan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `dataset`
--

INSERT INTO `dataset` (`id_dataset`, `id_barang`, `bulan`, `penjualan`) VALUES
(1, 1, 2, 120),
(2, 2, 2, 131),
(3, 3, 2, 116),
(4, 4, 2, 114),
(5, 5, 2, 127),
(6, 6, 2, 139),
(7, 7, 2, 129),
(8, 8, 2, 113),
(9, 9, 2, 127),
(10, 10, 2, 126),
(11, 11, 2, 131),
(12, 12, 2, 109),
(13, 13, 2, 126),
(14, 14, 2, 135),
(15, 15, 2, 116),
(16, 16, 2, 98),
(17, 17, 2, 137),
(18, 18, 2, 103),
(19, 19, 2, 84),
(20, 20, 2, 138),
(21, 21, 2, 137),
(22, 22, 2, 115),
(23, 23, 2, 132),
(24, 24, 2, 126),
(25, 25, 2, 102),
(26, 1, 3, 106),
(27, 2, 3, 88),
(28, 3, 3, 96),
(29, 4, 3, 98),
(30, 5, 3, 107),
(31, 6, 3, 137),
(32, 7, 3, 131),
(33, 8, 3, 103),
(34, 9, 3, 132),
(35, 10, 3, 114),
(36, 11, 3, 132),
(37, 12, 3, 86),
(38, 13, 3, 94),
(39, 14, 3, 108),
(40, 15, 3, 104),
(41, 16, 3, 116),
(42, 17, 3, 108),
(43, 18, 3, 124),
(44, 19, 3, 74),
(45, 20, 3, 93),
(46, 21, 3, 96),
(47, 22, 3, 129),
(48, 23, 3, 98),
(49, 24, 3, 118),
(50, 25, 3, 80),
(51, 1, 4, 133),
(52, 2, 4, 128),
(53, 3, 4, 91),
(54, 4, 4, 87),
(55, 5, 4, 117),
(56, 6, 4, 114),
(57, 7, 4, 89),
(58, 8, 4, 87),
(59, 9, 4, 83),
(60, 10, 4, 131),
(61, 11, 4, 129),
(62, 12, 4, 97),
(63, 13, 4, 87),
(64, 14, 4, 120),
(65, 15, 4, 95),
(66, 16, 4, 94),
(67, 17, 4, 122),
(68, 18, 4, 82),
(69, 19, 4, 126),
(70, 20, 4, 83),
(71, 21, 4, 87),
(72, 22, 4, 94),
(73, 23, 4, 102),
(74, 24, 4, 91),
(75, 25, 4, 78),
(76, 1, 5, 108),
(77, 2, 5, 102),
(78, 3, 5, 83),
(79, 4, 5, 95),
(80, 5, 5, 97),
(81, 6, 5, 81),
(82, 7, 5, 112),
(83, 8, 5, 92),
(84, 9, 5, 108),
(85, 10, 5, 105),
(86, 11, 5, 102),
(87, 12, 5, 82),
(88, 13, 5, 79),
(89, 14, 5, 108),
(90, 15, 5, 86),
(91, 16, 5, 88),
(92, 17, 5, 84),
(93, 18, 5, 98),
(94, 19, 5, 87),
(95, 20, 5, 89),
(96, 21, 5, 89),
(97, 22, 5, 103),
(98, 23, 5, 82),
(99, 24, 5, 85),
(100, 25, 5, 103),
(101, 1, 6, 56),
(102, 5, 6, 21),
(103, 22, 6, 324),
(104, 24, 6, 12),
(105, 17, 7, 32),
(106, 23, 7, 2),
(107, 25, 6, 321),
(108, 1, 7, 67),
(109, 25, 7, 21),
(110, 24, 7, 21),
(111, 1, 8, 12),
(112, 18, 10, 7),
(113, 23, 10, 892),
(114, 2, 7, 3),
(115, 9, 7, 5),
(116, 10, 7, 2),
(117, 11, 7, 1),
(118, 12, 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `id_detail` int NOT NULL,
  `id_penjualan` int NOT NULL,
  `id_barang` int NOT NULL,
  `qty` int NOT NULL,
  `harga_barang` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`id_detail`, `id_penjualan`, `id_barang`, `qty`, `harga_barang`) VALUES
(7, 8, 19, 4, 52000),
(8, 8, 11, 1, 104000),
(9, 8, 10, 1, 229000),
(10, 8, 12, 3, 221000),
(11, 9, 19, 1, 52000),
(12, 9, 18, 3, 166000),
(13, 9, 17, 5, 186000),
(14, 9, 16, 12, 160000),
(15, 10, 4, 1, 70000),
(16, 11, 2, 3, 19000),
(17, 11, 17, 2, 14000),
(18, 12, 9, 1, 7000),
(19, 12, 10, 2, 10000),
(20, 13, 9, 1, 7000),
(21, 13, 11, 1, 20000),
(22, 14, 9, 1, 7000),
(23, 15, 9, 1, 7000),
(24, 16, 9, 1, 7000),
(25, 16, 12, 3, 5000),
(26, 17, 9, 3, 7000);

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int NOT NULL,
  `id_barang` int NOT NULL,
  `cluster` int NOT NULL,
  `nilai` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `id_barang`, `cluster`, `nilai`) VALUES
(1, 1, 0, 0.22277163353604),
(2, 1, 1, 0.25035300904569),
(3, 1, 2, 0.52687535741827),
(4, 2, 0, 0.26414300528425),
(5, 2, 1, 0.27435024614135),
(6, 2, 2, 0.46150674857439),
(7, 3, 0, 0.57115556900334),
(8, 3, 1, 0.28612981450577),
(9, 3, 2, 0.14271461649089),
(10, 4, 0, 0.55644899009172),
(11, 4, 1, 0.30704317894867),
(12, 4, 2, 0.1365078309596),
(13, 5, 0, 0.099455622232243),
(14, 5, 1, 0.12507451948388),
(15, 5, 2, 0.77546985828388),
(16, 6, 0, 0.28102753144524),
(17, 6, 1, 0.33806655587679),
(18, 6, 2, 0.38090591267798),
(19, 7, 0, 0.3065471024585),
(20, 7, 1, 0.385632910907),
(21, 7, 2, 0.30781998663451),
(22, 8, 0, 0.5695185310616),
(23, 8, 1, 0.3122807481437),
(24, 8, 2, 0.1182007207947),
(25, 9, 0, 0.32101799226134),
(26, 9, 1, 0.39430347389499),
(27, 9, 2, 0.28467853384366),
(28, 10, 0, 0.19285028088199),
(29, 10, 1, 0.22736908629574),
(30, 10, 2, 0.57978063282226),
(31, 11, 0, 0.2367810549453),
(32, 11, 1, 0.28647159904752),
(33, 11, 2, 0.47674734600718),
(34, 12, 0, 0.45772152223012),
(35, 12, 1, 0.31927209177613),
(36, 12, 2, 0.22300638599375),
(37, 13, 0, 0.46744042966097),
(38, 13, 1, 0.33664509905675),
(39, 13, 2, 0.19591447128228),
(40, 14, 0, 0.1881748567204),
(41, 14, 1, 0.22652877095372),
(42, 14, 2, 0.58529637232588),
(43, 15, 0, 0.58201348425596),
(44, 15, 1, 0.31215019919569),
(45, 15, 2, 0.10583631654836),
(46, 16, 0, 0.3841069794719),
(47, 16, 1, 0.38472319301747),
(48, 16, 2, 0.23116982751063),
(49, 17, 0, 0.24205927502315),
(50, 17, 1, 0.27743159540472),
(51, 17, 2, 0.48050912957213),
(52, 18, 0, 0.3660881846774),
(53, 18, 1, 0.39736087603274),
(54, 18, 2, 0.23655093928986),
(55, 19, 0, 0.34843429504994),
(56, 19, 1, 0.32188583341884),
(57, 19, 2, 0.32967987153122),
(58, 20, 0, 0.40474906391879),
(59, 20, 1, 0.35786133999014),
(60, 20, 2, 0.23738959609107),
(61, 21, 0, 0.40229000731089),
(62, 21, 1, 0.36513376832266),
(63, 21, 2, 0.23257622436645),
(64, 22, 0, 0.30818734141295),
(65, 22, 1, 0.41254963222064),
(66, 22, 2, 0.27926302636641),
(67, 23, 0, 0.37140688745266),
(68, 23, 1, 0.356648412616),
(69, 23, 2, 0.27194469993134),
(70, 24, 0, 0.3362521494044),
(71, 24, 1, 0.45883954207979),
(72, 24, 2, 0.20490830851581),
(73, 25, 0, 0.41752610985533),
(74, 25, 1, 0.33893824366755),
(75, 25, 2, 0.24353564647711);

-- --------------------------------------------------------

--
-- Table structure for table `keanggotaanawal`
--

CREATE TABLE `keanggotaanawal` (
  `id_keanggotaanawal` int NOT NULL,
  `id_barang` int NOT NULL,
  `cluster` int NOT NULL,
  `nilai_awal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `keanggotaanawal`
--

INSERT INTO `keanggotaanawal` (`id_keanggotaanawal`, `id_barang`, `cluster`, `nilai_awal`) VALUES
(1, 1, 0, 0.3),
(2, 2, 0, 0.3),
(3, 3, 0, 0.8),
(4, 4, 0, 0.5),
(5, 5, 0, 0.5),
(6, 6, 0, 0.2),
(7, 7, 0, 0.3),
(8, 8, 0, 0.6),
(9, 9, 0, 0.4),
(10, 10, 0, 0.5),
(11, 11, 0, 0.3),
(12, 12, 0, 0.5),
(13, 13, 0, 0.7),
(14, 14, 0, 0.4),
(15, 15, 0, 0.3),
(16, 16, 0, 0.2),
(17, 17, 0, 0.5),
(18, 18, 0, 0.3),
(19, 19, 0, 0.3),
(20, 20, 0, 0.4),
(21, 21, 0, 0.2),
(22, 22, 0, 0.2),
(23, 23, 0, 0.3),
(24, 24, 0, 0.3),
(25, 25, 0, 0.2),
(26, 1, 1, 0.3),
(27, 2, 1, 0.5),
(28, 3, 1, 0.1),
(29, 4, 1, 0.2),
(30, 5, 1, 0.1),
(31, 6, 1, 0.1),
(32, 7, 1, 0.4),
(33, 8, 1, 0.2),
(34, 9, 1, 0.3),
(35, 10, 1, 0.3),
(36, 11, 1, 0.4),
(37, 12, 1, 0.1),
(38, 13, 1, 0.1),
(39, 14, 1, 0.5),
(40, 15, 1, 0.5),
(41, 16, 1, 0.4),
(42, 17, 1, 0.4),
(43, 18, 1, 0.1),
(44, 19, 1, 0.4),
(45, 20, 1, 0.2),
(46, 21, 1, 0.7),
(47, 22, 1, 0.6),
(48, 23, 1, 0.4),
(49, 24, 1, 0.3),
(50, 25, 1, 0.7),
(51, 1, 2, 0.4),
(52, 2, 2, 0.2),
(53, 3, 2, 0.1),
(54, 4, 2, 0.3),
(55, 5, 2, 0.4),
(56, 6, 2, 0.7),
(57, 7, 2, 0.3),
(58, 8, 2, 0.2),
(59, 9, 2, 0.3),
(60, 10, 2, 0.2),
(61, 11, 2, 0.3),
(62, 12, 2, 0.4),
(63, 13, 2, 0.2),
(64, 14, 2, 0.1),
(65, 15, 2, 0.2),
(66, 16, 2, 0.4),
(67, 17, 2, 0.1),
(68, 18, 2, 0.6),
(69, 19, 2, 0.3),
(70, 20, 2, 0.4),
(71, 21, 2, 0.1),
(72, 22, 2, 0.2),
(73, 23, 2, 0.3),
(74, 24, 2, 0.4),
(75, 25, 2, 0.1);

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int NOT NULL,
  `id_kasir` int DEFAULT NULL,
  `id_barang` int NOT NULL,
  `qty` int NOT NULL,
  `harga_beli` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int NOT NULL,
  `jumlah_cluster` int NOT NULL,
  `max_iterasi` int NOT NULL,
  `pembobot` int NOT NULL,
  `epsilon` double NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `jumlah_cluster`, `max_iterasi`, `pembobot`, `epsilon`, `log_time`) VALUES
(1, 3, 100, 3, 5, '2023-07-17 14:16:14'),
(2, 3, 100, 3, 5, '2023-07-17 14:20:51'),
(3, 3, 100, 3, 5, '2023-07-17 14:22:33'),
(4, 3, 100, 3, 5, '2023-07-17 14:24:54'),
(5, 3, 100, 3, 5, '2023-07-17 15:05:12'),
(6, 3, 100, 3, 5, '2023-07-17 16:13:10'),
(7, 4, 100, 3, 0.01, '2023-07-17 16:44:44'),
(8, 3, 100, 3, 10, '2023-07-22 03:42:43'),
(9, 3, 100, 3, 10, '2023-07-22 03:44:35'),
(10, 3, 100, 3, 10, '2023-07-22 04:08:06'),
(11, 3, 100, 3, 10, '2023-07-22 04:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int NOT NULL,
  `nama_pembeli` varchar(30) NOT NULL,
  `total_harga` int NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `nama_pembeli`, `total_harga`, `waktu`) VALUES
(8, 'Rian', 1245000, '2023-06-23 16:08:27'),
(9, 'Dani', 3400000, '2023-07-16 05:43:26'),
(10, 'Nuraini', 70000, '2023-07-16 05:44:19'),
(11, 'Rianto', 85000, '2023-07-22 04:02:56'),
(12, 'ATT', 27000, '2023-07-22 04:04:18'),
(13, 'Main', 27000, '2023-07-22 04:04:59'),
(14, 'Madi', 7000, '2023-07-22 04:05:37'),
(15, 'Rianto', 7000, '2023-07-22 04:06:11'),
(16, 'Bella', 22000, '2023-07-22 04:07:10'),
(17, 'Aini', 21000, '2023-07-22 04:07:36');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `nama_user` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `level` enum('admin','kasir','manager') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_user`, `level`) VALUES
(1, 'admin', '$2y$10$MI1s1tka2NTdvqypLGOHNuh2iWPMJCLyMKiDSAWkbECA.iUMvMY7O', 'Administrator', 'admin'),
(2, 'kasir', '$2y$10$Gpfj/JauYM.n70.RNTCRHeG7koM7wAVsYRNvl1rj4zKE2JDnmR4ha', 'Kasir', 'kasir'),
(3, 'manager', '$2y$10$eZzjfC1Gj4txjt7ROPqBXeOlftupzBnjRtjp2HSZ9WnnsTrxi8MCO', 'Manager', 'manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `dataset`
--
ALTER TABLE `dataset`
  ADD PRIMARY KEY (`id_dataset`),
  ADD KEY `FK_dataset_barang` (`id_barang`);

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `FK_detail_penjualan` (`id_penjualan`),
  ADD KEY `FK_detail_barang` (`id_barang`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `FK_hasil_barang` (`id_barang`);

--
-- Indexes for table `keanggotaanawal`
--
ALTER TABLE `keanggotaanawal`
  ADD PRIMARY KEY (`id_keanggotaanawal`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `FK_keranjang_user` (`id_kasir`),
  ADD KEY `FK_keranjang_barang` (`id_barang`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `dataset`
--
ALTER TABLE `dataset`
  MODIFY `id_dataset` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `detail`
--
ALTER TABLE `detail`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `keanggotaanawal`
--
ALTER TABLE `keanggotaanawal`
  MODIFY `id_keanggotaanawal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dataset`
--
ALTER TABLE `dataset`
  ADD CONSTRAINT `FK_dataset_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail`
--
ALTER TABLE `detail`
  ADD CONSTRAINT `FK_detail_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_detail_penjualan` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `FK_hasil_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `FK_keranjang_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_keranjang_user` FOREIGN KEY (`id_kasir`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
