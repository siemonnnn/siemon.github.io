-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2023 at 10:32 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualanikan`
--

-- --------------------------------------------------------

--
-- Table structure for table `datavariabel`
--

CREATE TABLE `datavariabel` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `status` enum('data','target') NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datavariabel`
--

INSERT INTO `datavariabel` (`id`, `nama`, `status`, `keterangan`) VALUES
(10, 'X1', 'data', 'Provinsi'),
(11, 'X2', 'data', 'Tahun 2019'),
(12, 'X3', 'data', 'Tahun 2020'),
(13, 'X4', 'data', 'Tahun 2021'),
(14, 'Y', 'target', 'Target Tahun');

-- --------------------------------------------------------

--
-- Table structure for table `data_training`
--

CREATE TABLE `data_training` (
  `id` int(11) NOT NULL,
  `datavariabel_id` int(11) DEFAULT NULL,
  `data_variabel` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_training`
--

INSERT INTO `data_training` (`id`, `datavariabel_id`, `data_variabel`) VALUES
(590, NULL, '{\"X1\":\"Gresik\",\"X2\":\"2\",\"X3\":\"5\",\"X4\":\"7\",\"Y\":\"NAIK\"}'),
(591, NULL, '{\"X1\":\"Mantup\",\"X2\":\"4\",\"X3\":\"1\",\"X4\":\"2\",\"Y\":\"TURUN\"}'),
(593, NULL, '{\"X1\":\"ACEH\",\"X2\":\"47090.1\",\"X3\":\"46449.44\",\"X4\":\"10034.83\",\"Y\":\"NAIK\"}'),
(594, NULL, '{\"X1\":\"SUMATERA UTARA\",\"X2\":\"12971.46\",\"X3\":\"5696.08\",\"X4\":\"1843.93\",\"Y\":\"NAIK\"}'),
(595, NULL, '{\"X1\":\"SUMATERA BARAT\",\"X2\":\"4354.13\",\"X3\":\"2312.84\",\"X4\":\"1811.84\",\"Y\":\"NAIK\"}'),
(596, NULL, '{\"X1\":\"RIAU\",\"X2\":\"250.39\",\"X3\":\"2004.8\",\"X4\":\"-\",\"Y\":\"NAIK\"}'),
(597, NULL, '{\"X1\":\"JAMBI\",\"X2\":\"145.22\",\"X3\":\"0\",\"X4\":\"-\",\"Y\":\"TURUN\"}'),
(598, NULL, '{\"X1\":\"SUMATERA SELATAN\",\"X2\":\"0\",\"X3\":\"0\",\"X4\":\"1916.13\",\"Y\":\"NAIK\"}'),
(599, NULL, '{\"X1\":\"BENGKULU\",\"X2\":\"10763.77\",\"X3\":\"9499.61\",\"X4\":\"1278.5\",\"Y\":\"TURUN\"}'),
(600, NULL, '{\"X1\":\"LAMPUNG\",\"X2\":\"2093.58\",\"X3\":\"1387.23\",\"X4\":\"7730.09\",\"Y\":\"TURUN\"}'),
(601, NULL, '{\"X1\":\"KEP. BANGKA BELITUNG\",\"X2\":\"6782.3\",\"X3\":\"5843.56\",\"X4\":\"-\",\"Y\":\"NAIK\"}'),
(602, NULL, '{\"X1\":\"KEP. RIAU\",\"X2\":\"0\",\"X3\":\"0\",\"X4\":\"118830.74\",\"Y\":\"NAIK\"}'),
(603, NULL, '{\"X1\":\"DKI JAKARTA\",\"X2\":\"86531.44\",\"X3\":\"90534.98\",\"X4\":\"42937.32\",\"Y\":\"NAIK\"}'),
(604, NULL, '{\"X1\":\"JAWA BARAT\",\"X2\":\"50611.83\",\"X3\":\"43932.78\",\"X4\":\"222048.87\",\"Y\":\"NAIK\"}'),
(605, NULL, '{\"X1\":\"JAWA TENGAH\",\"X2\":\"182359.3\",\"X3\":\"214536.58\",\"X4\":\"2131.86\",\"Y\":\"TURUN\"}'),
(606, NULL, '{\"X1\":\"DI YOGYAKARTA\",\"X2\":\"1844.45\",\"X3\":\"2673.66\",\"X4\":\"115437.84\",\"Y\":\"NAIK\"}'),
(607, NULL, '{\"X1\":\"JAWA TIMUR\",\"X2\":\"121707.1\",\"X3\":\"111260.49\",\"X4\":\"7278.16\",\"Y\":\"TURUN\"}'),
(608, NULL, '{\"X1\":\"BANTEN\",\"X2\":\"6392.33\",\"X3\":\"6528.21\",\"X4\":\"18995.63\",\"Y\":\"NAIK\"}'),
(609, NULL, '{\"X1\":\"BALI\",\"X2\":\"26333.75\",\"X3\":\"25208.04\",\"X4\":\"1797.55\",\"Y\":\"NAIK\"}'),
(610, NULL, '{\"X1\":\"NUSA TENGGARA BARAT\",\"X2\":\"2344.88\",\"X3\":\"1474.79\",\"X4\":\"4590.38\",\"Y\":\"NAIK\"}'),
(611, NULL, '{\"X1\":\"NUSA TENGGARA TIMUR\",\"X2\":\"6675.98\",\"X3\":\"9771.4\",\"X4\":\"6862.33\",\"Y\":\"NAIK\"}'),
(612, NULL, '{\"X1\":\"KALIMANTAN BARAT\",\"X2\":\"4118.77\",\"X3\":\"7915.82\",\"X4\":\"448.36\",\"Y\":\"NAIK\"}'),
(613, NULL, '{\"X1\":\"KALIMANTAN TENGAH\",\"X2\":\"103.54\",\"X3\":\"157.22\",\"X4\":\"16146.8\",\"Y\":\"NAIK\"}'),
(614, NULL, '{\"X1\":\"KALIMANTAN SELATAN\",\"X2\":\"18294.28\",\"X3\":\"24921.64\",\"X4\":\"33205.97\",\"Y\":\"TURUN\"}'),
(615, NULL, '{\"X1\":\"KALIMANTAN TIMUR\",\"X2\":\"21440.31\",\"X3\":\"24141.52\",\"X4\":\"16421.24\",\"Y\":\"TURUN\"}'),
(616, NULL, '{\"X1\":\"KALIMANTAN UTARA\",\"X2\":\"2189.68\",\"X3\":\"6920.32\",\"X4\":\"72278.77\",\"Y\":\"NAIK\"}'),
(617, NULL, '{\"X1\":\"SULAWESI UTARA\",\"X2\":\"70949.19\",\"X3\":\"78795.31\",\"X4\":\"5060.42\",\"Y\":\"NAIK\"}'),
(618, NULL, '{\"X1\":\"SULAWESI TENGAH\",\"X2\":\"6875.45\",\"X3\":\"4525.78\",\"X4\":\"63444.92\",\"Y\":\"TURUN\"}'),
(619, NULL, '{\"X1\":\"SULAWESI SELATAN\",\"X2\":\"54207.85\",\"X3\":\"63511.58\",\"X4\":\"26535.16\",\"Y\":\"TURUN\"}'),
(620, NULL, '{\"X1\":\"SULAWESI TENGGARA\",\"X2\":\"29474.87\",\"X3\":\"29536.39\",\"X4\":\"5330.73\",\"Y\":\"TURUN\"}'),
(621, NULL, '{\"X1\":\"GORONTALO\",\"X2\":\"19977.79\",\"X3\":\"5375.29\",\"X4\":\"579.89\",\"Y\":\"NAIK\"}'),
(622, NULL, '{\"X1\":\"SULAWESI BARAT\",\"X2\":\"781.22\",\"X3\":\"356.32\",\"X4\":\"2384.51\",\"Y\":\"TURUN\"}'),
(623, NULL, '{\"X1\":\"MALUKU\",\"X2\":\"914.16\",\"X3\":\"0\",\"X4\":\"6010.38\",\"Y\":\"TURUN\"}'),
(624, NULL, '{\"X1\":\"MALUKU UTARA\",\"X2\":\"12123.28\",\"X3\":\"9905.71\",\"X4\":\"-\",\"Y\":\"NAIK\"}'),
(625, NULL, '{\"X1\":\"PAPUA BARAT\",\"X2\":\"0\",\"X3\":\"0\",\"X4\":\"17650.61\",\"Y\":\"TURUN\"}'),
(626, NULL, '{\"X1\":\"PAPUA\",\"X2\":\"6242.92\",\"X3\":\"5607.98\",\"X4\":\"-\",\"Y\":\"TURUN\"}'),
(627, NULL, '{\"X1\":\"Lamongan\",\"X2\":\"11\",\"X3\":\"12\",\"X4\":\"13\",\"Y\":\"NAIK\"}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, '123', '', '$2y$10$N0./ChJveQub6G/7l6BSZuXeu2Re5vevqkb7Kb2qbkWvM1NGu/6oC'),
(4, '1234', '', '1234'),
(6, 'fia', 'fia@gmail.com', '$2y$10$zmh8WZ5gtuCU2il3jlRDCekG8bCJOwZJ7nSZShhZgivYREP.3FL5i'),
(7, 'naufal', 'naufal@gmail.com', '$2y$10$V9f3w.b7xlZNfp.T9jnzbeuQ8X78At0aOgeUuSx1A1bxjrGy4YB2q'),
(8, 'edo', 'edo@gmail.com', '$2y$10$6MYk6frHs5aSJ/SmxczHFOEm2mYrkAHQyLo55YiAUDnXNkEqYtmAO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datavariabel`
--
ALTER TABLE `datavariabel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_nama_status` (`nama`,`status`);

--
-- Indexes for table `data_training`
--
ALTER TABLE `data_training`
  ADD PRIMARY KEY (`id`),
  ADD KEY `datavariabel_id` (`datavariabel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datavariabel`
--
ALTER TABLE `datavariabel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `data_training`
--
ALTER TABLE `data_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=628;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_training`
--
ALTER TABLE `data_training`
  ADD CONSTRAINT `data_training_ibfk_1` FOREIGN KEY (`datavariabel_id`) REFERENCES `datavariabel` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
