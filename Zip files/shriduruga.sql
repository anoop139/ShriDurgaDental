-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 29, 2026 at 06:19 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shriduruga`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(20) DEFAULT 'staff',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`, `role`) VALUES
(15, 'superadmin', '$2y$10$EjpCRmAI44zfptqDGI6YyO3mqJ7jT4sAYfSkvHDwPh3NdyagIoO4e', '2026-07-28 07:46:38', 'admin'),
(2, 'shriduruga', '$2y$10$E0.tFfXPDaDF/Sllc4TX1eKboGwuDciqdvngKfDSgF77Hq5yTrfiG', '2026-02-17 08:31:09', 'staff'),
(16, 'venki', '$2y$10$wG.YAqCpJ4URzi1ozMR2R.X9f14kG/O8HmVasmUL2ef1zrJ095K7a', '2026-07-28 08:20:29', 'user'),
(14, 'abijeet', '$2y$10$/W1G9CTSO0UV5X2d4z3B2uWyM.EsrUFSLDRZr0on..v9GF8npIryi', '2026-07-23 05:36:21', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `date` varchar(20) DEFAULT NULL,
  `sno` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gen` varchar(10) DEFAULT NULL,
  `phoNo` varchar(10) DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  PRIMARY KEY (`sno`),
  UNIQUE KEY `unique_admin_phone` (`admin_id`,`phoNo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`date`, `sno`, `name`, `age`, `gen`, `phoNo`, `admin_id`) VALUES
('2026-07-23', 1, 'Sumathi', 23, 'Female', '9819565543', 14),
('2026-07-24', 2, 'Sumathi', 62, 'Female', '9819565543', 12);

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

DROP TABLE IF EXISTS `treatment`;
CREATE TABLE IF NOT EXISTS `treatment` (
  `date` varchar(20) DEFAULT NULL,
  `dueDate` varchar(20) DEFAULT NULL,
  `tid` int NOT NULL AUTO_INCREMENT,
  `treatment` varchar(255) DEFAULT NULL,
  `advance` int DEFAULT NULL,
  `online` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `sno` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `sno` (`sno`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`date`, `dueDate`, `tid`, `treatment`, `advance`, `online`, `amount`, `sno`, `admin_id`) VALUES
('2026-07-23', NULL, 1, 'checkup', 0, 1000, 0, 1, 14),
('2026-07-23', '2026-08-03', 2, 'filling1', 1500, 0, 1500, 1, 14);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
