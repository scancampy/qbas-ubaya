-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2021 at 05:40 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

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

-- --------------------------------------------------------

--
-- Table structure for table `absence`
--

CREATE TABLE `absence` (
  `id` int(11) NOT NULL,
  `student_nrp` varchar(40) NOT NULL,
  `course_open_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `absence_date` datetime DEFAULT NULL,
  `qr_code` varchar(300) DEFAULT NULL,
  `authenticator_code` varchar(5) DEFAULT NULL,
  `authenticator_expired` timestamp NULL DEFAULT NULL,
  `is_absence` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absence`
--

INSERT INTO `absence` (`id`, `student_nrp`, `course_open_id`, `schedule_id`, `absence_date`, `qr_code`, `authenticator_code`, `authenticator_expired`, `is_absence`) VALUES
(1, '160418006', 12, 1, NULL, '$2y$10$KRokauELJWYk.WPh2SHn6uND/hqYi07ornLSBnmbWWCLUOc.IfoYS', NULL, NULL, 0),
(3, '160418013', 12, 1, '2020-12-15 09:30:33', '$2y$10$hRg8Ion4aygtwz9tnMGtkOJrfssGu.0cSepurt4l/3kF3CXe0DwsO', NULL, NULL, 1),
(4, '160417075', 1, 15, '2021-03-28 08:03:58', NULL, NULL, NULL, 1),
(5, '160417075', 4, 16, '2021-03-31 12:16:34', '$2y$10$pJinVzDR25xssa/vWqL14ejU9LPtL15kINu9iB5mQi.d7/cxqno6y', '24190', '2021-03-31 00:16:39', 1),
(6, '160417075', 8, 17, '2021-04-03 15:18:31', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(30) NOT NULL,
  `password` varchar(150) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `full_name`, `last_login`) VALUES
('admin', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 'Admin QBAS', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` varchar(40) NOT NULL,
  `course_name` varchar(300) NOT NULL,
  `course_short_name` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_short_name`, `is_deleted`) VALUES
('1000A001', 'KEWIRAUSAHAAN DAN INOVASI', 'KWI', 0),
('1604A053', 'Web Framework Programming', 'WFP', 0),
('1604A054', 'Manajemen Teknologi Telematika', 'MTT', 0),
('1604A201', 'Game Programming', 'GAMEPROG', 0),
('1604B035', 'Statistics', 'STAT', 0),
('1604B052', 'Native Mobile Programming', 'NATIVE', 0),
('1604B061', 'Kepemimpinan dan Etika Profesi', 'ETPROF', 0),
('1604B062', 'Advanced Native Mobile Programming', 'ADVNATIVE', 0),
('1608B054', 'Game Concept and Design', 'GCD', 0),
('32525', 'Tes delete', 'tesdel', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_open`
--

CREATE TABLE `course_open` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `course_id` varchar(40) NOT NULL,
  `KP` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `npk` varchar(15) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`npk`, `full_name`, `password`, `is_deleted`) VALUES
('208020', 'Andre, M.Sc.', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('209345', 'Marcellinus Ferdinand Suciadi, S.T., M.Comp.', '', 0),
('2535262', 'Siap del', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_course_open`
--

CREATE TABLE `lecturer_course_open` (
  `id` int(11) NOT NULL,
  `course_open_id` int(11) NOT NULL,
  `lecturer_npk` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturer_course_open`
--

INSERT INTO `lecturer_course_open` (`id`, `course_open_id`, `lecturer_npk`) VALUES
(1, 8, '208020');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `course_open_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `methods` enum('simple','auto','manual','authenticator') NOT NULL,
  `class_code` varchar(300) DEFAULT NULL,
  `class_code_expired` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `course_open_id`, `start_date`, `end_date`, `methods`, `class_code`, `class_code_expired`) VALUES
(1, 12, '2020-12-15 15:00:00', '2020-12-15 17:00:00', 'simple', NULL, '2021-04-02 10:55:10'),
(2, 12, '2020-12-20 16:48:37', '2020-12-20 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(3, 12, '2020-12-27 16:48:37', '2020-12-27 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(4, 12, '2021-01-03 16:48:37', '2021-01-03 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(5, 12, '2021-01-10 16:48:37', '2021-01-10 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(6, 12, '2021-01-17 16:48:37', '2021-01-17 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(7, 12, '2021-01-24 16:48:37', '2021-01-24 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(8, 12, '2021-01-31 16:48:37', '2021-01-31 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(9, 12, '2021-02-07 16:48:37', '2021-02-07 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(10, 12, '2021-02-14 16:48:37', '2021-02-14 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(11, 12, '2021-02-21 16:48:37', '2021-02-21 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(12, 12, '2021-02-28 16:48:37', '2021-02-28 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(13, 12, '2021-03-07 16:48:37', '2021-03-07 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(14, 12, '2021-03-14 16:48:37', '2021-03-14 19:48:37', 'simple', NULL, '2021-04-02 10:55:10'),
(15, 1, '2021-03-28 11:00:00', '2021-03-28 16:00:00', 'simple', NULL, '2021-04-02 10:55:10'),
(16, 4, '2021-04-01 10:51:53', '2021-04-01 18:51:58', 'authenticator', NULL, '2021-04-02 10:55:10'),
(17, 8, '2021-04-04 09:42:18', '2021-04-04 23:43:37', 'manual', '$2y$10$N37oSrnF76tETAYp4Kt.XucSo.shPkpbiDMezbsMo4V.vwJyi/IfG', '2021-04-03 14:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `semester_name` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester_name`, `is_active`, `is_deleted`) VALUES
(1, 'GASAL 2020/2021', 1, 0),
(2, 'GENAP 2020/2021', 0, 0),
(3, 'GASAL 2019/2020', 0, 0),
(4, 'tes delete', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `nrp` varchar(40) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `password` varchar(300) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`nrp`, `full_name`, `password`, `is_deleted`) VALUES
('160417075', 'I GEDE BAGUS NICOLAS REXADIVA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160417159', 'IYAN ARISTA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418006', 'FELIKS ADHITAMA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418008', 'SESILIA SHANIA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418010', 'JESSELIN', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418011', 'GABRIELLE AUDREY SUCAHYO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418013', 'STEFAN AXEL', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418014', 'JUAN TIMOTHY SOEBROTO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418016', 'FELIX TANJIRO SUTANTO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418017', 'RIZKA FEBRINA PURNOMO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418021', 'MARIA CHRISTABELLA WARIKY', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418024', 'STEPHEN TANTOWI', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418032', 'ANG ALEXANDER YOSHUA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418043', 'KEVIN CHRISTIAN TANUS', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418048', 'ABEDNEGO JOSHUA SURJADINATA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418051', 'BUDIARJO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418053', 'GREGORY ALFREDO LOVEN', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418058', 'PASKASIUS KRESNA PUTRA WISNU', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418062', 'VINCENTIUS PHILLIPS ZHUPUTRA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418066', 'NICKY SETYAWAN DINATA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418083', 'ANASTHASYA AVERINA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418089', 'VALENTINNO KALOKO USMAN', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418110', 'ALVIN CHANDRA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418112', 'MUHAMMAD RIZKY YUSFIAN YUSUF', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418130', 'ARISSON ABDULLAH PUTRAWITAMA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418140', 'YOSAFAT LOUDI', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160418143', 'FARREL ARGHYA TITO PRAYOGA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160419098', 'WAFI AZMI HARTONO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160718004', 'CALVIN ANTONIO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160718005', 'CHARLES EDWARD THEOJAYA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160718006', 'EMILIO LUKITO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160718010', 'KEVIN SEBASTIAN RAHARDJO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160718012', 'CLARISSA LIMOA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160718017', 'CLAIRINE WONGSO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160718020', 'FRANSISCUS HARTANTO ARYOKUSUMO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160718044', 'JASON DARYOLLA DEONANDA', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('160816052', 'REYNOLD HUGO', '$2y$10$/BROWohZsSZjr8Mx1SGAiuaIavG4Z2yTnrlv86pevXtsH9Tx10IqO', 0),
('235252', 'Siap hapus!', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `student_nrp` varchar(40) NOT NULL,
  `course_open_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`student_nrp`, `course_open_id`) VALUES
('160417075', 1),
('160417075', 4),
('160417075', 8),
('160417075', 12),
('160417159', 12),
('160418006', 8),
('160418006', 12),
('160418008', 12),
('160418010', 8),
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_open`
--
ALTER TABLE `course_open`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`npk`);

--
-- Indexes for table `lecturer_course_open`
--
ALTER TABLE `lecturer_course_open`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`nrp`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`student_nrp`,`course_open_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absence`
--
ALTER TABLE `absence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_open`
--
ALTER TABLE `course_open`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lecturer_course_open`
--
ALTER TABLE `lecturer_course_open`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
