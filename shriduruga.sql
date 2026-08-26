-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 13, 2026 at 08:11 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`, `role`) VALUES
(11, 'Ceramco', '$2y$10$tEVFDv3W/wSi/b48er7F1e4ZsVRzVKWRTeXOiLMpA/C8FvV/Gtgt2', '2026-05-19 08:45:05', 'staff'),
(2, 'shriduruga', '$2y$10$E0.tFfXPDaDF/Sllc4TX1eKboGwuDciqdvngKfDSgF77Hq5yTrfiG', '2026-02-17 08:31:09', 'staff'),
(12, 'admin', '$2y$10$hxX0jr1vYahKl0Mt9buCwuBHeWnUrYkOyFuSNLbhCQR.6I8Y4eyaK', '2026-05-19 08:45:21', 'staff'),
(4, 'swathi', '$2y$10$84lFG9A5hy6XqHcJ3EA8QOCyYKC0r/Z84fpW8ka9KVT271B/D.7w6', '2026-05-18 11:42:25', 'staff'),
(10, 'crr', '$2y$10$.sWyA9vtZNGlFn6KMvhZ9eFod1ICfY5pG11/IkWAshqFR31PJQHWa', '2026-05-19 08:43:16', 'staff'),
(13, 'Test', '$2y$10$NFDh3sFyvWHuWMPemspjf.jeRQMPcryggPGJYJ52bpty10shU4AQq', '2026-07-08 07:03:00', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `date` date DEFAULT NULL,
  `sno` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gen` varchar(10) DEFAULT NULL,
  `phoNo` varchar(10) DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  PRIMARY KEY (`sno`),
  UNIQUE KEY `phoNo` (`phoNo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`date`, `sno`, `name`, `age`, `gen`, `phoNo`, `admin_id`) VALUES
('2026-07-08', 1, 'Jishnu Rao', 5, 'Male', '8431459418', 2),
('2026-07-08', 2, 'Saurabh Shukla', 7, 'Male', '9819565543', 2),
('2026-07-10', 4, 'Test User', 34, 'Male', '9876543210', 2);

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

DROP TABLE IF EXISTS `treatment`;
CREATE TABLE IF NOT EXISTS `treatment` (
  `date` date DEFAULT NULL,
  `dueDate` date DEFAULT NULL,
  `tid` int NOT NULL AUTO_INCREMENT,
  `treatment` varchar(255) DEFAULT NULL,
  `advance` int DEFAULT NULL,
  `online` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `sno` int NOT NULL,
  `admin_id` int NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `sno` (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`date`, `dueDate`, `tid`, `treatment`, `advance`, `online`, `amount`, `sno`, `admin_id`) VALUES
('2026-07-08', NULL, 1, 'rct', 1000, 800, 100, 1, 2),
('2026-07-08', '2026-08-01', 2, 'filling', 800, 10000, 800, 1, 2),
('2026-07-08', NULL, 3, 'check up', 0, 0, 0, 2, 2),
('2026-07-08', NULL, 4, 'rct', 0, 1000, 0, 2, 2),
('2026-07-10', '2026-07-13', 9, 'rv', 1000, 0, 2300, 4, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
  ADD CONSTRAINT `treatment_ibfk_1` FOREIGN KEY (`sno`) REFERENCES `patient` (`sno`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
