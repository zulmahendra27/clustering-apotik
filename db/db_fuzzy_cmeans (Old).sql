-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 18, 2023 at 03:35 AM
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
(4, 'HB FL M16 LAZZARO BLACK FLAT 180', 44, 70000),
(5, 'DV PALERMO BROWN 180', 62, 220000),
(6, 'PILLOW FLORENCE MT 48X70', 15, 175000),
(7, 'M/P FLORENCE 5OZ MT 160X200', 42, 195000),
(8, 'BOLSTER SERTA MT 37X100', 38, 98000),
(9, 'KS FL M21 SIENA AM (PT) 180', 19, 175000),
(10, 'M/P FLORENCE 5OZ MT 180X200', 45, 229000),
(11, 'KS FL M21 SIENA AM (PT) 160', 44, 104000),
(12, 'KS FL M21 GENOA AM (PT) 180', 21, 221000),
(13, 'KS FL M17 VINITTO (PT) 120', 42, 56000),
(14, 'SRG FL M15 LUXURY KIDS BLACK 120', 40, 171000),
(15, 'SRG FL M15 LUXURY KIDS BROWN 120', 21, 149000),
(16, 'SRG FL M15 LUXURY KIDS BLACK 100', 49, 160000),
(17, 'HB FL M15 LUXURY KIDS BLACK 100', 10, 186000),
(18, 'KS.FL M15 ORTHOPEDIC CARE 180', 33, 166000),
(19, 'KS GD M21 ULTIMATE 180', 40, 52000),
(20, 'KS SR M20 ANDES (ET) 180', 13, 207000),
(21, 'GOODDREAMS COMPLIMENTARY PILLOW 45X65', 37, 234000),
(22, 'KS GD M21 SUPREME (PT) 180', 71, 266000),
(23, 'BOLSTER FLORENCE MT 36X90', 56, 48000);

-- --------------------------------------------------------

--
-- Table structure for table `dataset`
--

CREATE TABLE `dataset` (
  `id_dataset` int NOT NULL,
  `id_barang` int NOT NULL,
  `penjualan` int NOT NULL,
  `all_stok` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `dataset`
--

INSERT INTO `dataset` (`id_dataset`, `id_barang`, `penjualan`, `all_stok`) VALUES
(4, 4, 36, 118),
(5, 5, 40, 152),
(6, 6, 10, 25),
(7, 7, 21, 78),
(8, 8, 26, 38),
(9, 9, 45, 60),
(10, 10, 17, 30),
(11, 11, 22, 111),
(12, 12, 25, 37),
(13, 13, 35, 69),
(14, 14, 20, 70),
(15, 15, 30, 58),
(16, 16, 34, 60),
(17, 17, 43, 88),
(18, 18, 32, 45),
(19, 19, 10, 27),
(20, 20, 10, 19),
(21, 21, 10, 20),
(22, 22, 5, 29),
(23, 23, 7, 15);

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
(15, 10, 4, 1, 70000);

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
(1, 4, 0, 0.027083),
(2, 4, 1, 0.044067),
(3, 4, 2, 0.059115),
(4, 4, 3, 0.869734),
(5, 5, 0, 0.122089),
(6, 5, 1, 0.170511),
(7, 5, 2, 0.203994),
(8, 5, 3, 0.503406),
(9, 6, 0, 0.952523),
(10, 6, 1, 0.021674),
(11, 6, 2, 0.016904),
(12, 6, 3, 0.008899),
(13, 7, 0, 0.053184),
(14, 7, 1, 0.125831),
(15, 7, 2, 0.755657),
(16, 7, 3, 0.065327),
(17, 8, 0, 0.358089),
(18, 8, 1, 0.349713),
(19, 8, 2, 0.20177),
(20, 8, 3, 0.090428),
(21, 9, 0, 0.126557),
(22, 9, 1, 0.529593),
(23, 9, 2, 0.24115),
(24, 9, 3, 0.102699),
(25, 10, 0, 0.638081),
(26, 10, 1, 0.175179),
(27, 10, 2, 0.124959),
(28, 10, 3, 0.061781),
(29, 11, 0, 0.094146),
(30, 11, 1, 0.153039),
(31, 11, 2, 0.230042),
(32, 11, 3, 0.522773),
(33, 12, 0, 0.383958),
(34, 12, 1, 0.330005),
(35, 12, 2, 0.19678),
(36, 12, 3, 0.089258),
(37, 13, 0, 0.093898),
(38, 13, 1, 0.441049),
(39, 13, 2, 0.371877),
(40, 13, 3, 0.093176),
(41, 14, 0, 0.083411),
(42, 14, 1, 0.221327),
(43, 14, 2, 0.620993),
(44, 14, 3, 0.074269),
(45, 15, 0, 0.062513),
(46, 15, 1, 0.76455),
(47, 15, 2, 0.133907),
(48, 15, 3, 0.03903),
(49, 16, 0, 0.038032),
(50, 16, 1, 0.845927),
(51, 16, 2, 0.089061),
(52, 16, 3, 0.02698),
(53, 17, 0, 0.117559),
(54, 17, 1, 0.269308),
(55, 17, 2, 0.362928),
(56, 17, 3, 0.250205),
(57, 18, 0, 0.216079),
(58, 18, 1, 0.489815),
(59, 18, 2, 0.208057),
(60, 18, 3, 0.086049),
(61, 19, 0, 0.860491),
(62, 19, 1, 0.06401),
(63, 19, 2, 0.049768),
(64, 19, 3, 0.025731),
(65, 20, 0, 0.799899),
(66, 20, 1, 0.089936),
(67, 20, 2, 0.07095),
(68, 20, 3, 0.039214),
(69, 21, 0, 0.830038),
(70, 21, 1, 0.07659),
(71, 21, 2, 0.060298),
(72, 21, 3, 0.033074),
(73, 22, 0, 0.716428),
(74, 22, 1, 0.126704),
(75, 22, 2, 0.103409),
(76, 22, 3, 0.05346),
(77, 23, 0, 0.696591),
(78, 23, 1, 0.133472),
(79, 23, 2, 0.10812),
(80, 23, 3, 0.061817);

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int NOT NULL,
  `id_kasir` int NOT NULL,
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
(7, 4, 100, 3, 0.01, '2023-07-17 16:44:44');

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
(10, 'Nuraini', 70000, '2023-07-16 05:44:19');

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
  ADD PRIMARY KEY (`id_dataset`);

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

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
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `dataset`
--
ALTER TABLE `dataset`
  MODIFY `id_dataset` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `detail`
--
ALTER TABLE `detail`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
