-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 03:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_prestasi_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','operator') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `role`) VALUES
(7, 'admin', '$2y$10$g3JyZJ5ixI8qbCizc73XKOqQsqOF3Q3ShRMnCknZ7Ds/8kuiPpKnq', 'admin'),
(13, 'operator1', '$2y$10$OkYkpd3FKosHXbAAwqDpY.2fVegwwAl0X3tTf5NRCjXO3kFVfhQkO', 'operator'),
(14, 'operator2', '$2y$10$AFhbclP1VyJai6epV7OtKOC6GMSfcOI7KNG7pmNJKQM7QV0hF4DnW', 'operator'),
(15, 'admin2', '$2y$10$bx8CCGeZ/ZQZY7mNW.0aguJ3zIUMabdWSsye7UYMnnAfm7GlWKeBa', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(255) NOT NULL,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`, `status`) VALUES
(1, 'OTKP', 'Aktif'),
(2, 'AKL', 'Aktif'),
(3, 'BDP', 'Aktif'),
(4, 'MPLB', 'Aktif'),
(5, 'RPL', 'Aktif'),
(6, 'MM', 'Aktif'),
(7, 'BPTV', 'Aktif'),
(8, 'PPLG', 'Aktif'),
(9, 'TJKT', 'Aktif'),
(10, 'TKJ', 'Aktif'),
(11, 'PM', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `aktivitas` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `user`, `aktivitas`, `waktu`) VALUES
(1, 'admin', 'Menambahkan data prestasi NIS 123', '2025-04-16 00:33:55'),
(2, 'admin', 'Menghapus data prestasi NIS 123', '2025-04-16 00:43:19'),
(3, 'admin', 'Menambahkan data prestasi NIS 123', '2025-04-16 01:21:42'),
(4, 'admin', 'Menambahkan data prestasi NIS 123', '2025-04-16 01:36:59'),
(5, 'admin', 'Menghapus data prestasi NIS 123', '2025-04-16 01:37:06'),
(6, 'admin', 'Menambahkan data prestasi NIS 123', '2025-04-16 05:20:33'),
(7, 'admin', 'Menambahkan data prestasi NIS 123', '2025-04-16 05:20:51'),
(8, 'admin', 'Menghapus data prestasi ID 9', '2025-04-16 06:38:46'),
(9, 'admin', 'Menambahkan data prestasi NIS 123', '2025-04-16 07:17:17'),
(10, 'admin', 'Menghapus data prestasi ID 10', '2025-04-16 07:17:24'),
(11, 'operator1', 'Menghapus data prestasi ID 8', '2025-04-16 08:00:18'),
(12, 'operator1', 'Menambahkan data prestasi NIS 123', '2025-04-16 08:00:41'),
(13, 'admin', 'Menghapus data prestasi ID 4', '2025-04-17 01:39:30'),
(14, 'admin', 'Menambahkan data prestasi NIS 129', '2025-04-17 01:40:46'),
(15, 'admin', 'Menghapus data prestasi ID 12', '2025-04-17 01:42:07'),
(16, 'admin', 'Menghapus data prestasi ID 5', '2025-04-17 01:42:22'),
(17, 'admin', 'Menghapus data prestasi ID 4', '2025-04-17 06:05:05'),
(18, 'admin', 'Menambahkan data prestasi NIS 123', '2025-04-17 06:05:30'),
(19, 'admin', 'Menghapus data prestasi ID 13', '2025-04-17 06:05:46'),
(20, 'admin', 'Menambahkan data prestasi NIS 127', '2025-04-17 07:26:15'),
(21, 'admin', 'Menghapus data prestasi ID 10', '2025-04-17 07:29:55'),
(22, 'admin', 'Menghapus data prestasi ID 9', '2025-04-17 07:30:10'),
(23, 'admin', 'Menghapus data prestasi ID 4', '2025-04-17 07:31:13'),
(24, 'admin', 'Menghapus data prestasi ID 4', '2025-04-17 07:44:57'),
(25, 'admin', 'Menambahkan data prestasi NIS 129', '2025-04-17 07:46:10'),
(26, 'admin', 'Menghapus data prestasi ID 10', '2025-04-17 07:48:09'),
(27, 'admin', 'Menghapus data prestasi ID 6', '2025-04-17 07:50:31'),
(28, 'admin', 'Menghapus data prestasi ID 6', '2025-04-17 07:50:43'),
(29, 'admin', 'Menghapus data spmb ID 14', '2025-04-17 08:02:36'),
(30, 'admin', 'Menambahkan data prestasi NIS 131', '2025-04-22 02:55:27'),
(31, 'admin', 'Menghapus data prestasi ID 16', '2025-04-22 02:55:35'),
(32, 'admin', 'Menghapus data spmb ID 17', '2025-04-22 02:59:42'),
(33, 'admin', 'Menambahkan data prestasi NIS 133', '2025-04-22 04:54:41'),
(34, 'admin', 'Mengedit data prestasi ID 16', '2025-04-24 08:22:14'),
(35, 'admin', 'Mengedit data prestasi ID 15', '2025-04-24 08:22:44'),
(36, 'admin', 'Mengedit data prestasi ID 18', '2025-04-24 08:40:58'),
(37, 'admin', 'Mengedit data prestasi ID 19', '2025-04-24 08:41:37'),
(38, 'admin', 'Mengedit data prestasi ID 2', '2025-04-24 08:42:32'),
(39, 'admin', 'Mengedit data prestasi ID 1', '2025-04-24 08:43:04'),
(40, 'admin', 'Mengedit data prestasi ID 19', '2025-04-24 08:43:35'),
(41, 'admin', 'Mengedit data prestasi ID 3', '2025-04-24 08:44:03'),
(42, 'admin', 'Mengedit data prestasi ID 1', '2025-04-24 08:45:31'),
(43, 'admin', 'Mengedit data prestasi ID 1', '2025-04-24 08:45:50'),
(44, 'admin', 'Mengedit data prestasi ID 1', '2025-04-24 08:47:47'),
(45, 'admin', 'Mengedit data prestasi ID 2', '2025-04-24 08:48:16'),
(46, 'admin', 'Mengedit data prestasi ID 3', '2025-04-24 08:48:32'),
(47, 'admin', 'Mengedit data prestasi ID 1', '2025-04-24 09:00:25'),
(48, 'admin', 'Mengedit data prestasi ID 1', '2025-04-24 09:00:41'),
(49, 'admin', 'Mengedit data prestasi ID 3', '2025-04-24 09:04:17'),
(50, 'admin', 'Mengedit data prestasi ID 3', '2025-04-24 09:05:02'),
(51, 'admin', 'Mengedit data prestasi ID 3', '2025-04-24 09:05:40'),
(52, 'admin', 'Mengedit data prestasi ID 15', '2025-04-28 02:47:48'),
(53, 'admin', 'Mengedit data prestasi ID 11', '2025-04-29 07:38:00'),
(54, 'admin', 'Mengedit data prestasi ID 11', '2025-04-29 07:39:44'),
(55, 'admin', 'Menambahkan data prestasi NIS 133', '2025-04-29 08:00:56'),
(56, 'admin', 'Menambahkan data prestasi NIS 132', '2025-04-29 08:03:52'),
(57, 'admin', 'Menghapus data prestasi ID 18', '2025-04-29 08:04:09'),
(58, 'admin', 'Mengedit data prestasi ID 2', '2025-04-30 01:10:34'),
(59, 'admin', 'Menambahkan data SPMB NIS 127', '2025-04-30 01:40:13'),
(60, 'admin', 'Mengedit data prestasi ID 20', '2025-04-30 01:41:48'),
(61, 'admin', 'Mengedit data prestasi ID 3', '2025-04-30 01:56:42'),
(62, 'admin', 'Mengedit data prestasi ID 14', '2025-04-30 01:58:00'),
(63, 'admin', 'Mengedit data prestasi ID 14', '2025-04-30 01:59:00'),
(64, 'admin', 'Mengedit data prestasi ID 14', '2025-04-30 01:59:16'),
(65, 'admin', 'Mengedit data prestasi ID 1', '2025-04-30 02:02:27'),
(66, 'admin', 'Mengedit data prestasi ID 1', '2025-04-30 02:02:32'),
(67, 'admin', 'Mengedit data prestasi ID 1', '2025-04-30 02:04:15'),
(68, 'admin', 'Mengedit data prestasi ID 1', '2025-04-30 02:04:35'),
(69, 'admin', 'Mengedit data prestasi ID 15', '2025-04-30 02:54:06'),
(70, 'admin', 'Mengedit data prestasi ID 14', '2025-04-30 02:56:56'),
(71, 'admin', 'Mengedit data prestasi ID 14', '2025-04-30 02:57:32'),
(72, 'admin', 'Mengedit data prestasi ID 11', '2025-04-30 03:05:05'),
(73, 'admin', 'Mengedit data prestasi ID 11', '2025-04-30 03:05:08'),
(74, 'admin', 'Mengedit data prestasi ID 11', '2025-04-30 03:09:40'),
(75, 'admin', 'Mengedit data prestasi ID 11', '2025-04-30 03:09:56'),
(76, 'admin', 'Mengedit data prestasi ID 1', '2025-04-30 03:10:17'),
(77, 'admin', 'Mengedit data prestasi ID 1', '2025-04-30 03:10:25'),
(78, 'admin', 'Mengedit data prestasi ID 2', '2025-04-30 03:10:39'),
(79, 'admin', 'Mengedit data prestasi ID 2', '2025-04-30 03:10:43'),
(80, 'admin', 'Mengedit data prestasi ID 3', '2025-04-30 03:15:36'),
(81, 'admin', 'Mengedit data prestasi ID 14', '2025-04-30 03:15:45'),
(82, 'admin', 'Mengedit data prestasi ID 15', '2025-04-30 03:15:58'),
(83, 'admin', 'Mengedit data prestasi ID 1', '2025-04-30 08:07:50'),
(84, 'admin', 'Menambahkan data prestasi NIS 131', '2025-05-04 23:50:22'),
(85, 'admin', 'Menghapus data prestasi ID 19', '2025-05-05 00:08:47'),
(86, 'admin', 'Menambahkan data prestasi NIS 131', '2025-05-05 00:10:21'),
(87, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 01:29:52'),
(88, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 01:30:40'),
(89, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 01:31:52'),
(90, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 01:45:09'),
(91, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 01:45:24'),
(92, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 01:46:01'),
(93, 'admin', 'Mengedit data prestasi ID 19', '2025-05-05 01:46:46'),
(94, 'admin', 'Mengedit data prestasi ID 19', '2025-05-05 01:46:53'),
(95, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 01:52:25'),
(96, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 01:55:12'),
(97, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 01:56:09'),
(98, 'admin', 'Mengedit data prestasi ID 19', '2025-05-05 01:56:22'),
(99, 'admin', 'Mengedit data prestasi ID 19', '2025-05-05 01:56:29'),
(100, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:16:33'),
(101, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:23:26'),
(102, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:23:40'),
(103, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:26:02'),
(104, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:31:18'),
(105, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:31:43'),
(106, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:31:52'),
(107, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:33:00'),
(108, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:36:56'),
(109, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:37:29'),
(110, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:37:37'),
(111, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:38:03'),
(112, 'admin', 'Mengedit data prestasi ID 20', '2025-05-05 06:38:26'),
(113, 'admin', 'Mengedit data SNPMB ID 19', '2025-05-05 06:43:05'),
(114, 'admin', 'Mengedit data SNPMB ID 19', '2025-05-05 06:43:21'),
(115, 'admin', 'Mengedit data SNPMB ID 20', '2025-05-05 06:43:44'),
(116, 'admin', 'Mengedit data SNPMB ID 20', '2025-05-05 06:44:46'),
(117, 'admin', 'Mengedit data SNPMB ID 20', '2025-05-05 06:45:13'),
(118, 'admin', 'Mengedit data SNPMB ID 19', '2025-05-05 06:46:36'),
(119, 'admin', 'Menambahkan data SPMB NIS 133', '2025-05-05 06:55:36'),
(120, 'admin', 'Menghapus data spmb ID 19', '2025-05-05 06:57:20'),
(121, 'admin', 'Menambahkan data SPMB NIS 135', '2025-05-05 07:17:56'),
(122, 'admin', 'Menghapus data spmb ID 22', '2025-05-05 07:21:01'),
(123, 'admin', 'Menambahkan data SPMB NIS 135', '2025-05-05 07:21:33'),
(124, 'admin', 'Mengedit data SNPMB ID 23', '2025-05-05 07:34:40'),
(125, 'admin', 'Menghapus data spmb ID 23', '2025-05-05 07:34:52'),
(126, 'admin', 'Menambahkan data SPMB NIS 135', '2025-05-05 07:35:14'),
(127, 'admin', 'Menghapus data spmb ID 24', '2025-05-05 07:41:48'),
(128, 'admin', 'Menambahkan data SPMB NIS 135', '2025-05-05 07:42:17'),
(129, 'admin', 'Menghapus data spmb ID 25', '2025-05-05 07:42:25'),
(130, 'admin', 'Menambahkan data SPMB NIS 135', '2025-05-05 07:42:49'),
(131, 'admin', 'Menghapus data spmb ID 26', '2025-05-05 07:47:00'),
(132, 'admin', 'Menambahkan data SPMB NIS 135', '2025-05-05 07:47:22'),
(133, 'admin', 'Menghapus data prestasi ID 20', '2025-05-05 07:49:08'),
(134, 'admin', 'Menambahkan data prestasi NIS 131', '2025-05-05 07:49:38'),
(135, 'admin', 'Menghapus data prestasi ID 21', '2025-05-05 07:52:34'),
(136, 'admin', 'Menambahkan data prestasi NIS 131', '2025-05-05 07:52:58'),
(137, 'admin', 'Menambahkan data prestasi NIS 125', '2025-05-08 07:49:13'),
(138, 'admin', 'Menghapus data prestasi ID 113', '2025-05-08 07:49:29'),
(139, 'admin', 'Menambahkan data prestasi NIS 125', '2025-05-08 07:59:44'),
(140, 'admin', 'Menambahkan data prestasi NIS 125', '2025-05-09 01:00:58'),
(141, 'admin', 'Menghapus data prestasi ID 115', '2025-05-09 01:01:05'),
(142, 'admin', 'Menghapus data prestasi ID 114', '2025-05-09 01:01:09'),
(143, 'admin', 'Menambahkan data prestasi NIS 125', '2025-05-09 01:05:41'),
(144, 'admin', 'Mengedit data prestasi ID 116', '2025-05-09 01:06:04'),
(145, 'admin', 'Menambahkan data prestasi NIS 125', '2025-05-09 01:13:04'),
(146, 'admin', 'Menghapus data prestasi ID 117', '2025-05-09 01:13:12'),
(147, 'admin', 'Menghapus data prestasi ID 116', '2025-05-09 01:13:15'),
(148, 'admin', 'Menambahkan data prestasi NIS 125', '2025-05-09 01:13:26'),
(149, 'admin', 'Mengedit data prestasi ID 118', '2025-05-09 01:13:45'),
(150, 'admin', 'Mengedit data prestasi ID 118', '2025-05-09 01:15:50'),
(151, 'admin', 'Mengedit data prestasi ID 118', '2025-05-09 01:17:35'),
(152, 'admin', 'Mengedit data prestasi ID 118', '2025-05-09 01:17:47'),
(153, 'admin', 'Mengedit data prestasi ID 1', '2025-05-14 02:09:07'),
(154, 'admin', 'Mengedit data prestasi ID 118', '2025-05-14 02:11:13'),
(155, 'admin', 'Mengedit data prestasi ID 118', '2025-05-14 02:11:44'),
(156, 'admin', 'Mengedit data prestasi ID 118', '2025-05-14 02:11:52'),
(157, 'admin', 'Mengedit data prestasi ID 2', '2025-05-14 02:13:32'),
(158, 'admin', 'Mengedit data prestasi ID 3', '2025-05-14 02:13:54'),
(159, 'admin', 'Menambahkan data SPMB NIS 17463', '2025-05-14 02:14:57'),
(160, 'admin', 'Menghapus data spmb ID 28', '2025-05-14 02:18:53'),
(161, 'admin', 'Mengedit data SNPMB ID 29', '2025-05-14 02:52:34'),
(162, 'admin', 'Mengedit data SNPMB ID 29', '2025-05-14 02:52:46'),
(163, 'admin', 'Mengedit data SNPMB ID 29', '2025-05-14 02:52:54'),
(164, 'admin', 'Mengedit data SNPMB ID 29', '2025-05-14 02:53:10'),
(165, 'admin', 'Menghapus data spmb ID 29', '2025-05-14 02:53:30'),
(166, 'admin', 'Mengedit data prestasi ID 118', '2025-05-14 02:54:56'),
(167, 'admin', 'Mengedit data prestasi ID 118', '2025-05-14 02:55:01'),
(168, 'admin', 'Mengedit data prestasi ID 4', '2025-05-14 23:53:11'),
(169, 'admin', 'Mengedit data prestasi ID 5', '2025-05-14 23:54:01'),
(170, 'admin', 'Mengedit data prestasi ID 6', '2025-05-14 23:54:51'),
(171, 'admin', 'Mengedit data prestasi ID 7', '2025-05-14 23:55:12'),
(172, 'admin', 'Mengedit data prestasi ID 8', '2025-05-14 23:55:39'),
(173, 'admin', 'Mengedit data prestasi ID 9', '2025-05-14 23:57:07'),
(174, 'admin', 'Mengedit data prestasi ID 17', '2025-05-15 03:36:37'),
(175, 'admin', 'Mengedit data prestasi ID 14', '2025-05-15 03:36:58'),
(176, 'admin', 'Mengedit data prestasi ID 18', '2025-05-15 03:37:41'),
(177, 'admin', 'Mengedit data prestasi ID 11', '2025-05-15 03:37:59'),
(178, 'admin', 'Mengedit data prestasi ID 15', '2025-05-15 03:38:16'),
(179, 'admin', 'Mengedit data prestasi ID 13', '2025-05-15 03:38:42'),
(180, 'admin', 'Mengedit data prestasi ID 19', '2025-05-15 03:39:05'),
(181, 'admin', 'Mengedit data prestasi ID 10', '2025-05-15 03:39:47'),
(182, 'admin', 'Mengedit data prestasi ID 10', '2025-05-15 03:40:36'),
(183, 'admin', 'Mengedit data prestasi ID 10', '2025-05-15 03:42:25'),
(184, 'admin', 'Mengedit data prestasi ID 10', '2025-05-15 03:42:52'),
(185, 'admin', 'Menambahkan data prestasi NIS 16587', '2025-05-15 03:43:48'),
(186, 'admin', 'Mengedit data prestasi ID 16', '2025-05-15 03:44:35'),
(187, 'admin', 'Mengedit data prestasi ID 16', '2025-05-15 03:44:57'),
(188, 'admin', 'Mengedit data prestasi ID 12', '2025-05-15 04:00:40'),
(189, 'admin', 'Mengedit data prestasi ID 38', '2025-05-15 04:01:09'),
(190, 'admin', 'Mengedit data prestasi ID 35', '2025-05-15 04:01:40'),
(191, 'admin', 'Mengedit data prestasi ID 36', '2025-05-15 04:03:23'),
(192, 'admin', 'Mengedit data prestasi ID 34', '2025-05-15 04:04:19'),
(193, 'admin', 'Mengedit data prestasi ID 39', '2025-05-15 04:06:18'),
(194, 'admin', 'Mengedit data prestasi ID 28', '2025-05-15 04:06:45'),
(195, 'admin', 'Mengedit data prestasi ID 37', '2025-05-15 04:08:49'),
(196, 'admin', 'Mengedit data prestasi ID 29', '2025-05-15 04:09:15'),
(197, 'admin', 'Mengedit data prestasi ID 30', '2025-05-15 04:10:30'),
(198, 'admin', 'Mengedit data prestasi ID 31', '2025-05-15 04:11:09'),
(199, 'admin', 'Mengedit data prestasi ID 32', '2025-05-15 04:11:36'),
(200, 'admin', 'Mengedit data prestasi ID 33', '2025-05-15 04:12:21'),
(201, 'admin', 'Mengedit data SNPMB ID 3', '2025-05-15 04:13:16'),
(202, 'admin', 'Mengedit data SNPMB ID 3', '2025-05-15 04:13:39'),
(203, 'admin', 'Mengedit data SNPMB ID 3', '2025-05-15 04:13:50'),
(204, 'admin', 'Mengedit data SNPMB ID 3', '2025-05-15 04:14:02'),
(205, 'admin', 'Menghapus data spmb ID 30', '2025-05-15 04:15:41'),
(206, 'admin', 'Mengedit data prestasi ID 18', '2025-05-15 08:27:50'),
(207, 'admin', 'Mengedit data prestasi ID 14', '2025-05-15 08:28:01'),
(208, 'admin', 'Mengedit data prestasi ID 13', '2025-05-15 08:28:12'),
(209, 'admin', 'Mengedit data prestasi ID 15', '2025-05-15 08:28:24'),
(210, 'admin', 'Mengedit data prestasi ID 19', '2025-05-15 08:28:33'),
(211, 'operator1', 'Mengedit data SNPMB ID 21', '2025-05-15 08:29:40'),
(212, 'admin', 'Menambahkan data SNBP 125', '2025-05-15 08:43:22'),
(213, 'admin', 'Menghapus data spmb ID 32', '2025-05-15 08:44:53'),
(214, 'admin', 'Menghapus data spmb ID 31', '2025-05-15 08:44:57'),
(215, 'admin', 'Menghapus data prestasi ID 118', '2025-05-15 09:00:54'),
(216, 'admin', 'Menambahkan data SNBP 125', '2025-05-15 09:01:09'),
(217, 'admin', 'Menghapus data spmb ID 33', '2025-05-15 09:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `nama_lomba` varchar(255) NOT NULL,
  `tingkat` enum('Nasional','Keresidenan','Provinsi','Kabupaten','Kecamatan','Sekolah') NOT NULL,
  `juara` varchar(50) DEFAULT NULL,
  `tahun` date DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id`, `nis`, `nisn`, `nama_siswa`, `jurusan`, `nama_lomba`, `tingkat`, `juara`, `tahun`, `kategori`, `foto_bukti`, `deskripsi`) VALUES
(1, '16611', '16611', 'Rio Reifan Rexy Rashendrya', 'TJKT', 'Lomba Robotika dan IOT Bidang Competition Robot Transporter ', 'Provinsi', 'Juara 3', '2023-12-16', 'Akademik', '', ''),
(2, '16611', '16611', 'Rio Reifan Rexy Rashendrya', 'TJKT', 'Lomba Kompetensi Siswa Tingkat Sekolah Bidang Lomba: Information Network Cabling ', 'Sekolah', 'Juara 3', '2024-01-01', 'Akademik', '', ''),
(3, '16611', '16611', 'Rio Reifan Rexy Rashendrya', 'TJKT', 'Lomba Kompetensi Siswa Tingkat Sekolah Information Network Cabling ', 'Sekolah', 'Juara 1', '2025-01-01', 'Akademik', '', ''),
(4, '16593', '16612', 'Ibnati Zalfa Qurrotu\'ain', 'TJKT', 'Vlog Gembira RAIMUNA CABANG XI KWARCAB TEGAL', 'Kabupaten', 'Juara 2', '2024-12-19', 'Akademik', '', ''),
(5, '16593', '16612', 'Ibnati Zalfa Qurrotu\'ain', 'TJKT', 'Lomba Desain Poster DEMA Creative Competition (DCC) 2024', 'Keresidenan', 'Juara 2', '2024-03-09', 'Akademik', '', ''),
(6, '16593', '16612', 'Ibnati Zalfa Qurrotu\'ain', 'TJKT', 'Lomba Iklan Layanan Masyarakat', 'Kabupaten', 'Juara 1', '2023-07-16', 'Akademik', '', ''),
(7, '16593', '16612', 'Ibnati Zalfa Qurrotu\'ain', 'TJKT', 'Lomba Internet of Things', 'Kabupaten', 'Juara 2', '2023-07-16', 'Akademik', '', ''),
(8, '16593', '16612', 'Ibnati Zalfa Qurrotu\'ain', 'TJKT', 'Lomba Karya Cipta Pramuka', 'Kabupaten', 'Juara 3', '2023-07-16', 'Akademik', '', ''),
(9, '16587', '16613', 'Astri Rajulia', 'TJKT', 'Lomba Cerdas Cermat Pramuka Saka Bakti Husada', 'Kabupaten', 'Juara 1', '2023-10-25', 'Akademik', '', ''),
(10, '16593', '16612', 'Ibnati Zalfa Qurrotu\'ain', 'TJKT', 'Lomba Cerdas Cermat Saka Bakti Husada ', 'Kabupaten', 'Juara Harapan 3', '2024-01-01', 'Akademik', '', ''),
(11, '16321', '16321', 'Selsya Dera Amanda', 'OTKP', 'Poster DEMA Creative DCC (IBN Tegal) 2024', 'Keresidenan', 'Juara 3', '2023-08-12', 'Akademik', '', ''),
(12, '16769', '16769', 'Dwi Elfarianti', 'BPTV', 'Lomba Pramuka Garuda Berprestasi  Kwartir Cabang Tegal Tahun 2023', 'Kabupaten', 'Juara 3', '2023-07-16', 'Akademik', '', ''),
(13, '16436', '16436', 'Alissya Aulia Putri', 'AKL', 'Mata Lomba Akuntansi Keuangan Lembaga Lomba Kompetensi Siswa Sekolah Menengah Kejuruan ', 'Kabupaten', 'Juara 1', '2024-03-02', 'Akademik', '', ''),
(14, '15975', '15975', 'Dian Amaliah Putri', 'TJKT', 'Mata Lomba Cyber Security Lomba Kompetensi Siswa Sekolah Menengah Kejuruan', 'Kabupaten', 'Juara 1', '2024-03-02', 'Akademik', '', ''),
(15, '16345', '16345', 'Khalifatur Rizati', 'OTKP', 'Mata Otomatisasi Tata Kelola Perkantoran Lomba Kompetensi Siswa Sekolah Menengah Kejuruan ', 'Kabupaten', 'Juara 1', '2024-03-02', 'Akademik', '', ''),
(16, '16724', '16724', 'Ailsa Rahmawati', 'BPTV', 'Mata Online Marketing Lomba Kompetensi Siswa Sekolah Menengah Kejuruan Kabupaten Tegal Tahun 2024', 'Kabupaten', 'Juara 2', '2024-03-02', 'Akademik', '', ''),
(17, '15861', '15861', 'Ahmad Zindan Chalwani', 'TJKT', 'Mata Information Network Cabling Lomba Kompetensi Siswa Sekolah Menengah Kejuruan ', 'Kabupaten', 'Juara 1', '2024-03-02', 'Akademik', '', ''),
(18, '15987', '15987', 'Muhammad Fikri Ubaidillah', 'TJKT', 'Mata Cloud Computing Lomba Kompetensi Siswa Sekolah Menengah Kejuruan ', 'Kabupaten', 'Juara 1', '2024-03-02', 'Akademik', '', ''),
(19, '16555', '16555', 'Fardan Abu Arbaz Basyari', 'PPLG', 'Mata Web Tecnologies Lomba Kompetensi Siswa Sekolah Menengah Kejuruan ', 'Kabupaten', 'Juara 1', '2024-03-02', 'Akademik', '', ''),
(20, '17209', '17209', 'Rahsya Ramadhan Izzulhaq', 'RPL', 'Mata Graphic Design Technology Lomba Kompetensi Siswa Sekolah Menengah Kejuruan', 'Kabupaten', 'Juara 2', '2024-03-02', 'Akademik', '', ''),
(21, '17769', '17769', 'Resa Naila Haya', 'OTKP', 'Pemilihan Duta genRe Kabupaten Tegal 2024', 'Kabupaten', '-', '2024-07-13', 'Non-Akademik', '', ''),
(22, '17065', '17065', 'Marselia Angelia', 'AKL', 'Accounting Competition Tingkat SMA/SMK Se-Jawa Tengah 2024', 'Provinsi', 'Juara 2', '2024-07-27', 'Akademik', '', ''),
(23, '17135', '17135', 'Nia Permatasari', 'AKL', 'Bola Voli Putri Antar Pelajar SMP/SMA Sederajat ', 'Kabupaten', 'Juara 3', '2024-01-14', 'Non-Akademik', '', ''),
(24, '17173', '17173', 'Linda Saputri', 'BPTV', 'Bola Voli Putri Antar Pelajar SMP/SMA Sederajat ', 'Kabupaten', 'Juara 3', '2024-01-14', 'Non-Akademik', '', ''),
(25, '17170', '17170', 'Inka Retno Aptiana', 'BPTV', 'Bola Voli Putri Antar Pelajar SMP/SMA Sederajat ', 'Kabupaten', 'Juara 3', '2024-01-14', 'Non-Akademik', '', ''),
(26, '16767', '16767', 'Dela Pratiwi', 'BPTV', 'Bola Voli Putri Antar Pelajar SMP/SMA Sederajat ', 'Kabupaten', 'Juara 3', '2024-01-14', 'Non-Akademik', '', ''),
(27, '17467', '17467', 'Nasya Prima ZM', 'BPTV', 'Bola Voli Putri Antar Pelajar SMP/SMA Sederajat ', 'Kabupaten', 'Juara 3', '2024-01-14', 'Non-Akademik', '', ''),
(28, '17463', '17463', 'Margareth Jesselyn A', 'BPTV', 'Bola Voli Putri Antar Pelajar SMP/SMA Sederajat ', 'Kabupaten', 'Juara 3', '2024-01-14', 'Akademik', '', ''),
(29, '17532', '17532', 'Kayla Aulianisa', 'BPTV', 'Bola Voli Putri Antar Pelajar SMP/SMA Sederajat ', 'Kabupaten', 'Juara 3', '2024-01-14', 'Akademik', '', ''),
(30, '17555', '17555', 'Aulia Rizki Dwi FA', 'BPTV', 'Bola Voli Putri Antar Pelajar SMP/SMA Sederajat ', 'Kabupaten', 'Juara 3', '2024-01-14', 'Akademik', '', ''),
(31, '18054', '18054', 'Syafira Nurlaeli', 'TJKT', 'Lari 800 M Putri SMA/ SMK/MA Pekan Olahraga Pelajar Daerah (POPDA) SD/SMP/SMA/ Sederajat ', 'Kabupaten', 'Juara 2', '2024-09-05', 'Akademik', '', ''),
(32, '18510', '18510', 'Muhammad Mirza Fadhil', 'AKL', 'Catur Klasik SMA Putra Pekan Olahraga Pelajar Daerah (POPDA) SD/SMP/SMA/ Sederajat Tingkat Kabupaten Tegal', 'Kabupaten', 'Juara 1', '2025-09-05', 'Akademik', '', ''),
(33, '18510', '18510', 'Muhammad Mirza Fadhil', 'AKL', 'Catur Cepat SMA Putra Pekan Olahraga Pelajar Daerah (POPDA) SD/SMP/SMA/ Sederajat ', 'Kabupaten', 'Juara 3', '2024-09-05', 'Akademik', '', ''),
(34, '17043', '17043', 'Salsa Ramadhani', 'AKL', 'Accounting Competition Tingkat SMA/SMK Se-Jawa Tengah 2024', 'Provinsi', 'Juara 2', '2024-07-27', 'Akademik', '', ''),
(35, '17020', '17020', 'Dwi Ayu Tresnowati', 'AKL', 'Kejuaraan Provinsi Junior U-19 Putri Cabang Olahraga Bola Tangan', 'Provinsi', 'Juara 3', '2024-07-04', 'Akademik', '', ''),
(36, '17036', '17036', 'Nova Amelia', 'AKL', 'Gajah Mada Competition 2 Tingkat Nasional', 'Nasional', 'Juara 1', '2024-09-15', 'Akademik', '', ''),
(37, '17466', '17466', 'Mutiara Ananda Putri', 'BDP', 'Olimpiade Sains Siswa Indonesia Tingkat Nasiona Tahun 2024', 'Nasional', 'Juara 1', '2024-02-25', 'Akademik', '', ''),
(38, '17015', '17015', 'Dhia Azka Nuroani', 'AKL', 'Olimpiade Pendidikan Agama Islam Nasional Ke-2 Jenjang SMA/SMK', 'Nasional', 'Juara 3', '2023-11-24', 'Akademik', '', ''),
(39, '17187', '17187', 'Vena Annisa', 'BPTV', 'Olimpiade Pendidikan Agama Islam Nasional Ke-2 Jenjang SMA/SMK', 'Nasional', 'Juara 3', '2023-11-24', 'Akademik', '', ''),
(119, '16587', '16613', 'Astri Rajulia', 'TJKT', 'Poster DEMA Creative DCC (IBN Tegal)', 'Keresidenan', 'Juara 3', '2024-01-01', 'NonAkademik', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `tahun_ajaran` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_siswa`, `jenis_kelamin`, `kelas`, `jurusan`, `tahun_ajaran`) VALUES
(41, '125', '1112223338', 'riyan', 'Laki-Laki', 'Xll ', 'TJKT', '2024/2025'),
(0, '134', '1112244444444', 'Budi Santoso', 'Laki-Laki', 'X', 'MM', '2024/2025'),
(10, '15861', '16620', 'Ahmad Zindan Chalwani', 'Laki-Laki', 'XI TJKT', 'TJKT', '2024/2025'),
(7, '15975', '16617', 'Dian Amaliah Putri', 'Perempuan', 'XI TJKT', 'TJKT', '2024/2025'),
(11, '15987', '16621', 'Muhammad Fikri Ubaidillah', 'Laki-Laki', 'XI TJKT', 'TJKT', '2024/2025'),
(4, '16321', '16614', 'Selsya Dera Amanda', 'Perempuan', 'XII OTKP 3', 'OTKP ', '2024/2025'),
(8, '16345', '16618', 'Khalifatur Rizati', 'Perempuan', 'XI OTKP', 'OTKP', '2024/2025'),
(6, '16436', '16616', 'Alissya Aulia Putri', 'Perempuan', 'XI AKL', 'AKL', '2024/2025'),
(12, '16555', '16622', 'Fardan Abu Arbaz Basyari', 'Laki-Laki', 'XII PPLG 2', 'PPLG ', '2024/2025'),
(3, '16587', '16613', 'Astri Rajulia', 'Perempuan', 'XII TJKT 1', 'TJKT', '2024/2025'),
(2, '16593', '16612', 'Ibnati Zalfa Qurrotu\'ain', 'Laki-Laki', 'XII TJKT 1', 'TJKT', '2024/2025'),
(1, '16611', '16611', 'Rio Reifan Rexy Rashendrya', 'Laki-Laki', 'XII TJKT 1', 'TJKT', '2024/2025'),
(9, '16724', '16619', 'Ailsa Rahmawati', 'Perempuan', 'XII BD 1', 'BPTV', '2024/2025'),
(19, '16767', '16629', 'Dela Pratiwi', 'Perempuan', 'XII BR 1', 'BPTV', '2024/2025'),
(5, '16769', '16615', 'Dwi Elfarianti', 'Perempuan', 'XII BR 1', 'BR ', '2024/2025'),
(31, '17015', '16640', 'Dhia Azka Nuroani', 'Laki-Laki', 'XII AKL 1', 'AKL ', '2024/2025'),
(28, '17020', '16637', 'Dwi Ayu Tresnowati', 'Perempuan', 'XII AKL 1', 'AKL ', '2024/2025'),
(29, '17036', '16638', 'Nova Amelia', 'Perempuan', 'XII AKL 1', 'AKL ', '2024/2025'),
(27, '17043', '16636', 'Salsa Ramadhani', 'Perempuan', 'XII AKL 1', 'AKL ', '2024/2025'),
(15, '17065', '16625', 'Marselia Angelia', 'Perempuan', 'XII AKL 2', 'AKL ', '2024/2025'),
(16, '17135', '16626', 'Nia Permatasari', 'Perempuan', 'XII AKL 4', 'AKL', '2024/2025'),
(18, '17170', '16628', 'Inka Retno Aptiana', 'Perempuan', 'XII BP 1', 'BPTV', '2024/2025'),
(17, '17173', '16627', 'Linda Saputri', 'Perempuan', 'XII BP 1', 'BPTV', '2024/2025'),
(32, '17187', '16641', 'Vena Annisa', 'Perempuan', 'XII BP 1', 'BPTV', '2024/2025'),
(13, '17209', '16623', 'Rahsya Ramadhan Izzulhaq', 'Laki-Laki', 'XI RPL', 'RPL', '2024/2025'),
(21, '17463', '16631', 'Margareth Jesselyn A', 'Perempuan', 'XI BD 1', 'BPTV', '2024/2025'),
(30, '17466', '16639', 'Mutiara Ananda Putri', 'Perempuan', 'XI BDP 1', 'PM', '2024/2025'),
(20, '17467', '16630', 'Nasya Prima ZM', 'Laki-Laki', 'XI BD 1', 'BPTV', '2024/2025'),
(22, '17532', '16632', 'Kayla Aulianisa', 'Laki-Laki', 'XI BR 2', 'BPTV', '2024/2025'),
(23, '17555', '16633', 'Aulia Rizki Dwi FA', 'Laki-Laki', 'XI BR 3', 'BPTV', '2024/2025'),
(14, '17769', '16624', 'Resa Naila Haya', 'Laki-Laki', 'XI OTKP', 'OTKP', '2024/2025'),
(24, '18054', '16634', 'Syafira Nurlaeli', 'Laki-Laki', 'X TJKT', 'TJKT', '2024/2025'),
(25, '18510', '16635', 'Muhammad Mirza Fadhil', 'Laki-Laki', 'X AKL 4', 'X AKL 4', '2024/2025'),
(0, 'nis', 'nisn', 'nama_siswa', 'jenis_kela', 'kelas', 'jurusan', 'tahun_ajar');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_prestasi`
--

CREATE TABLE `siswa_prestasi` (
  `NIS` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `prestasi` varchar(255) NOT NULL,
  `tingkat` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spmb`
--

CREATE TABLE `spmb` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nama_siswa` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `universitas` varchar(100) DEFAULT NULL,
  `prodi` varchar(100) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `foto_siswa` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `spmb`
--

INSERT INTO `spmb` (`id`, `nis`, `nisn`, `nama_siswa`, `jurusan`, `universitas`, `prodi`, `tahun`, `foto_siswa`, `deskripsi`) VALUES
(1, '122', '1112223333', 'Dina Lestari', 'TJKT', 'Universitas Negeri Semarang', 'Teknik Informatika', 2024, '', NULL),
(2, '121', '1112223332', 'Rama Setiawan', 'TJKT', 'Universitas Diponegoro', 'Teknik Mesin', 2024, '', NULL),
(3, '120', '1112223331', 'Nina Pratiwi', 'BDP', 'Universitas Negeri Makassar', 'Teknik Informatika', 2024, '', NULL),
(15, '129', '1112223341', 'Isnaeni', 'AKL', 'Universitas Gajah Mada', 'Teknik Informatika', 2024, '', NULL),
(16, '125', '1112223336', 'Rina Ayu', 'MPLB', 'Universitas Negeri Yogyakarta', 'Hukum', 2024, 'Screenshot 2025-03-17 132232.png', NULL),
(18, '132', '1112223343', 'Lutfi', 'MPLB', 'Universitas Negeri Makassar', 'Hukum', 2024, '', NULL),
(20, '127', '1112223338', 'Desi Novita', 'TJKT', 'Universitas Negeri Surabaya', 'Manajemen', 2024, '', NULL),
(21, '133', '1112223344', 'Rudi', 'BPTV', 'Universitas Negeri Malang', 'Teknik Mesin', 2025, '', NULL),
(27, '135', '1112223345', 'Lutfi Halimawan', 'MM', 'Universitas Gajah Mada', 'Teknik Informatika', 2024, '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indexes for table `siswa_prestasi`
--
ALTER TABLE `siswa_prestasi`
  ADD PRIMARY KEY (`NIS`);

--
-- Indexes for table `spmb`
--
ALTER TABLE `spmb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `spmb`
--
ALTER TABLE `spmb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
