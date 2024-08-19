-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 23, 2023 at 09:32 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `face_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_orang`
--

CREATE TABLE `data_orang` (
  `id_orang` int(11) NOT NULL,
  `image_single` varchar(255) NOT NULL,
  `nomor_id` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tmpt_lhr` varchar(255) NOT NULL,
  `tgl_lhr` varchar(20) NOT NULL,
  `kelamin` varchar(20) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_orang`
--

INSERT INTO `data_orang` (`id_orang`, `image_single`, `nomor_id`, `nama`, `tmpt_lhr`, `tgl_lhr`, `kelamin`, `pekerjaan`, `no_hp`, `email`, `alamat`, `tgl_input`) VALUES
(11, '1.jpg', 'jason1222111', 'Jason Statham', 'New York', '2023-03-02', 'Laki-Laki', 'Artis', '0811234', 'jason@gmail.com', 'New York', '2023-03-23 05:43:00'),
(12, '1.jpg', 'tom112211', 'Tom Cruise', 'Dallas', '2023-02-08', 'Laki-Laki', 'Artis', '08112211222', 'tom@gmail.com', 'Dallas, USA', '2023-03-23 05:43:53'),
(13, '1.jpg', 'stallone21112', 'Sylvester Stallone', 'Washington', '2023-03-03', 'Laki-Laki', 'Artis', '08211122', 'stallone@gmail.com', 'Washington', '2023-03-23 05:44:51'),
(14, '1.jpg', 'taylor2211', 'Taylor Swift', 'Manhattan', '2023-01-11', 'Perempuan', 'Artis', '08522111', 'swift@gmail.com', 'Manhattan', '2023-03-23 05:45:50'),
(15, '1.jpg', 'arnold22111', 'Arnold Schwageneger', 'Maryland', '2023-02-10', 'Laki-Laki', 'Artis', '0833222333', 'arnold@gmail.com', 'Maryland', '2023-03-23 05:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `id_foto` int(11) NOT NULL,
  `orang_id` int(11) NOT NULL,
  `nomor_id_foto` varchar(255) NOT NULL,
  `nama_foto` varchar(30) NOT NULL,
  `uploaded_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`id_foto`, `orang_id`, `nomor_id_foto`, `nama_foto`, `uploaded_on`) VALUES
(54, 7, '43', '1.jpg', '2023-03-23 05:32:10'),
(62, 11, 'jason1222111', '1.jpg', '2023-03-23 12:43:00'),
(63, 11, 'jason1222111', '2.jpg', '2023-03-23 12:43:00'),
(64, 11, 'jason1222111', '3.jpg', '2023-03-23 12:43:00'),
(65, 11, 'jason1222111', '4.jpg', '2023-03-23 12:43:00'),
(66, 11, 'jason1222111', '5.jpg', '2023-03-23 12:43:00'),
(67, 12, 'tom112211', '1.jpg', '2023-03-23 12:43:53'),
(68, 12, 'tom112211', '2.jpg', '2023-03-23 12:43:53'),
(69, 12, 'tom112211', '3.jpg', '2023-03-23 12:43:53'),
(70, 12, 'tom112211', '4.jpg', '2023-03-23 12:43:53'),
(71, 12, 'tom112211', '5.jpg', '2023-03-23 12:43:53'),
(72, 13, 'stallone21112', '1.jpg', '2023-03-23 12:44:51'),
(73, 13, 'stallone21112', '2.jpg', '2023-03-23 12:44:51'),
(74, 13, 'stallone21112', '3.jpg', '2023-03-23 12:44:51'),
(75, 13, 'stallone21112', '4.jpg', '2023-03-23 12:44:51'),
(76, 13, 'stallone21112', '5.jpg', '2023-03-23 12:44:51'),
(77, 14, 'taylor2211', '1.jpg', '2023-03-23 12:45:50'),
(78, 14, 'taylor2211', '2.jpg', '2023-03-23 12:45:50'),
(79, 14, 'taylor2211', '3.jpg', '2023-03-23 12:45:50'),
(80, 14, 'taylor2211', '4.jpg', '2023-03-23 12:45:50'),
(81, 14, 'taylor2211', '5.jpg', '2023-03-23 12:45:50'),
(82, 15, 'arnold22111', '1.jpg', '2023-03-23 12:46:59'),
(83, 15, 'arnold22111', '2.jpg', '2023-03-23 12:46:59'),
(84, 15, 'arnold22111', '3.jpg', '2023-03-23 12:46:59'),
(85, 15, 'arnold22111', '4.jpg', '2023-03-23 12:46:59'),
(86, 15, 'arnold22111', '5.jpg', '2023-03-23 12:46:59'),
(87, 15, 'arnold22111', '6.jpg', '2023-03-23 12:46:59');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_foto`
-- (See below for the actual view)
--
CREATE TABLE `view_foto` (
`nomor_id_foto` varchar(255)
,`nama_foto` mediumtext
);

-- --------------------------------------------------------

--
-- Structure for view `view_foto`
--
DROP TABLE IF EXISTS `view_foto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_foto`  AS SELECT `foto`.`nomor_id_foto` AS `nomor_id_foto`, group_concat(`foto`.`nama_foto` separator ' ') AS `nama_foto` FROM `foto` GROUP BY `foto`.`nomor_id_foto` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_orang`
--
ALTER TABLE `data_orang`
  ADD PRIMARY KEY (`id_orang`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `orang_id` (`orang_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_orang`
--
ALTER TABLE `data_orang`
  MODIFY `id_orang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
