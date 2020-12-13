-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2020 at 07:42 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qbasdb`
--
DROP DATABASE IF EXISTS `qbasdb`;
CREATE DATABASE IF NOT EXISTS `qbasdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `qbasdb`;

-- --------------------------------------------------------

--
-- Table structure for table `absence`
--

DROP TABLE IF EXISTS `absence`;
CREATE TABLE IF NOT EXISTS `absence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_nrp` varchar(40) NOT NULL,
  `course_open_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `absence_date` datetime DEFAULT NULL,
  `qr_code` varchar(300) NOT NULL,
  `is_absence` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absence`
--

INSERT INTO `absence` (`id`, `student_nrp`, `course_open_id`, `schedule_id`, `absence_date`, `qr_code`, `is_absence`) VALUES
(1, '160418006', 12, 1, NULL, '$2y$10$KRokauELJWYk.WPh2SHn6uND/hqYi07ornLSBnmbWWCLUOc.IfoYS', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` varchar(40) NOT NULL,
  `course_name` varchar(300) NOT NULL,
  `course_short_name` varchar(50) NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_short_name`) VALUES
('1000A001', 'KEWIRAUSAHAAN DAN INOVASI', 'KWI'),
('1604A053', 'Web Framework Programming', 'WFP'),
('1604A054', 'Manajemen Teknologi Telematika', 'MTT'),
('1604A201', 'Game Programming', 'GameProg'),
('1604B035', 'Statistics', 'Stat'),
('1604B052', 'Native Mobile Programming', 'Native'),
('1604B061', 'Kepemimpinan dan Etika Profesi', 'EtProf'),
('1608B054', 'Game Concept and Design', 'GCD');

-- --------------------------------------------------------

--
-- Table structure for table `course_open`
--

DROP TABLE IF EXISTS `course_open`;
CREATE TABLE IF NOT EXISTS `course_open` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester_id` int(11) NOT NULL,
  `course_id` varchar(40) NOT NULL,
  `KP` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_open`
--

INSERT INTO `course_open` (`id`, `semester_id`, `course_id`, `KP`) VALUES
(1, 1, '1000A001', 'A'),
(2, 1, '1000A001', 'B'),
(3, 1, '1000A001', 'C'),
(4, 1, '1604A053', 'A'),
(5, 1, '1604A054', 'A'),
(6, 1, '1604A054', 'B'),
(7, 1, '1604A201', 'A'),
(8, 1, '1604A201', 'B'),
(9, 1, '1604A201', 'C'),
(10, 1, '1604A201', 'D'),
(11, 1, '1604B035', 'A'),
(12, 1, '1604B052', 'A'),
(13, 1, '1604B061', 'A'),
(14, 1, '1608B054', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_open_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `course_open_id`, `start_date`, `end_date`) VALUES
(1, 12, '2020-12-14 00:00:00', '2020-12-14 03:00:00'),
(2, 12, '2020-12-20 16:48:37', '2020-12-20 19:48:37'),
(3, 12, '2020-12-27 16:48:37', '2020-12-27 19:48:37'),
(4, 12, '2021-01-03 16:48:37', '2021-01-03 19:48:37'),
(5, 12, '2021-01-10 16:48:37', '2021-01-10 19:48:37'),
(6, 12, '2021-01-17 16:48:37', '2021-01-17 19:48:37'),
(7, 12, '2021-01-24 16:48:37', '2021-01-24 19:48:37'),
(8, 12, '2021-01-31 16:48:37', '2021-01-31 19:48:37'),
(9, 12, '2021-02-07 16:48:37', '2021-02-07 19:48:37'),
(10, 12, '2021-02-14 16:48:37', '2021-02-14 19:48:37'),
(11, 12, '2021-02-21 16:48:37', '2021-02-21 19:48:37'),
(12, 12, '2021-02-28 16:48:37', '2021-02-28 19:48:37'),
(13, 12, '2021-03-07 16:48:37', '2021-03-07 19:48:37'),
(14, 12, '2021-03-14 16:48:37', '2021-03-14 19:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

DROP TABLE IF EXISTS `semester`;
CREATE TABLE IF NOT EXISTS `semester` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester_name` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester_name`, `is_active`) VALUES
(1, 'GASAL 2020-2021', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `nrp` varchar(40) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `password` varchar(300) NOT NULL,
  PRIMARY KEY (`nrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`nrp`, `full_name`, `password`) VALUES
('160417075', 'I GEDE BAGUS NICOLAS REXADIVA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160417159', 'IYAN ARISTA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418006', 'FELIKS ADHITAMA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418008', 'SESILIA SHANIA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418010', 'JESSELIN', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418011', 'GABRIELLE AUDREY SUCAHYO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418013', 'STEFAN AXEL', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418014', 'JUAN TIMOTHY SOEBROTO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418016', 'FELIX TANJIRO SUTANTO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418017', 'RIZKA FEBRINA PURNOMO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418021', 'MARIA CHRISTABELLA WARIKY', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418024', 'STEPHEN TANTOWI', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418032', 'ANG ALEXANDER YOSHUA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418043', 'KEVIN CHRISTIAN TANUS', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418048', 'ABEDNEGO JOSHUA SURJADINATA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418051', 'BUDIARJO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418053', 'GREGORY ALFREDO LOVEN', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418058', 'PASKASIUS KRESNA PUTRA WISNU', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418062', 'VINCENTIUS PHILLIPS ZHUPUTRA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418066', 'NICKY SETYAWAN DINATA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418083', 'ANASTHASYA AVERINA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418089', 'VALENTINNO KALOKO USMAN', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418110', 'ALVIN CHANDRA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418112', 'MUHAMMAD RIZKY YUSFIAN YUSUF', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418130', 'ARISSON ABDULLAH PUTRAWITAMA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418140', 'YOSAFAT LOUDI', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160418143', 'FARREL ARGHYA TITO PRAYOGA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160419098', 'WAFI AZMI HARTONO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160718004', 'CALVIN ANTONIO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160718005', 'CHARLES EDWARD THEOJAYA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160718006', 'EMILIO LUKITO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160718010', 'KEVIN SEBASTIAN RAHARDJO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160718012', 'CLARISSA LIMOA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160718017', 'CLAIRINE WONGSO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160718020', 'FRANSISCUS HARTANTO ARYOKUSUMO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160718044', 'JASON DARYOLLA DEONANDA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO'),
('160816052', 'REYNOLD HUGO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

DROP TABLE IF EXISTS `student_course`;
CREATE TABLE IF NOT EXISTS `student_course` (
  `student_nrp` varchar(40) NOT NULL,
  `course_open_id` int(11) NOT NULL,
  PRIMARY KEY (`student_nrp`,`course_open_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`student_nrp`, `course_open_id`) VALUES
('160417075', 12),
('160417159', 12),
('160418006', 12),
('160418008', 12),
('160418010', 12),
('160418011', 12),
('160418013', 12),
('160418014', 12),
('160418016', 12),
('160418017', 12),
('160418021', 12),
('160418024', 12),
('160418032', 12),
('160418043', 12),
('160418048', 12),
('160418051', 12),
('160418053', 12),
('160418058', 12),
('160418062', 12),
('160418066', 12),
('160418083', 12),
('160418089', 12),
('160418110', 12),
('160418112', 12),
('160418130', 12),
('160418140', 12),
('160418143', 12),
('160419098', 12),
('160718004', 12),
('160718005', 12),
('160718006', 12),
('160718010', 12),
('160718012', 12),
('160718017', 12),
('160718020', 12),
('160718044', 12),
('160816052', 12);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
