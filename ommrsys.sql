-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 01:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ommrsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `divsections`
--

CREATE TABLE `divsections` (
  `divSecId` int(11) NOT NULL,
  `divSecName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divsections`
--

INSERT INTO `divsections` (`divSecId`, `divSecName`) VALUES
(1, 'IT'),
(2, 'Sales AUTO 1'),
(3, 'Sales AUTO 2'),
(4, 'Sales AUTO 3'),
(5, 'LM / Machine'),
(6, 'AUTO 1 ASSY'),
(7, 'Production Operation Division'),
(8, 'Auto 3 & ABCI Assembly'),
(9, 'PQS / FI'),
(11, 'Product Development Group / SM'),
(12, 'Jig'),
(13, 'Sales & Development Division'),
(14, 'Sales & Plan CID'),
(15, 'Sales & Plan ABD'),
(16, 'Logistics'),
(17, 'Warehouse / IQC'),
(18, 'Warehouse'),
(19, 'IQC XRF'),
(20, 'HRDA'),
(21, 'HRD'),
(22, 'Admin'),
(23, 'FMS'),
(24, 'QCA'),
(25, 'Finance'),
(26, 'PQC'),
(29, 'IMS'),
(30, 'AED / AMS'),
(31, 'ABD Machine'),
(32, 'CID Machine'),
(33, 'Sales AOD'),
(34, 'ABCI Machine'),
(35, 'SDD/AUTO-COSTING-GP/IT'),
(36, 'POD/AUTO3-ABCI ASSY'),
(37, 'SDD/CID-ABD-LOGISTICS'),
(38, 'POD/ENGG-JIG'),
(39, 'QCA/IMS'),
(40, 'MIS'),
(41, 'POD/AUTO1-2 ASSY'),
(42, 'ADMIN / FMS'),
(43, 'POD/PQS-TRAINING'),
(44, 'Tube Cutting'),
(45, 'HCTI - IT'),
(46, 'PQS Engineer'),
(47, 'Subcon'),
(48, 'POD - Support'),
(49, 'AUTO 2 Others'),
(50, 'AUTO 2 ASSY'),
(51, 'POD ENG\'G - PDG / PES'),
(52, 'POD ENG&#039;G - SML / Cross Section'),
(53, 'AMS Machine'),
(54, 'ABCI Machine Pre ASSY'),
(55, 'ABD Machine Pre ASSY'),
(56, 'CID Machine Pre ASSY'),
(57, 'AMS Machine Pre ASSY'),
(58, '200% QCA'),
(59, 'Indirect-Employee'),
(60, 'CID ASSY'),
(61, 'NOAH Assistant'),
(62, 'Sample Division'),
(63, 'QCA / SPC'),
(64, 'QCA / Auto'),
(65, 'QCA / FMEA'),
(66, 'QCA / ABCI'),
(67, 'MSA / Calibration'),
(68, 'QAO'),
(69, 'IWASAKI'),
(70, 'Executive Office');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `resID` varchar(255) NOT NULL COMMENT 'either make it auto increment or do some fancy php shtick--up to you',
  `resType` varchar(255) NOT NULL COMMENT 'regular, customer or executive',
  `resRoom` varchar(255) NOT NULL COMMENT 'which room(room ID)?',
  `resUser` varchar(255) NOT NULL COMMENT 'who reserved this? (username)',
  `resDate` datetime NOT NULL COMMENT 'when the reservation is made',
  `resMeet` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' COMMENT 'when is the meeting? [start,end]' CHECK (json_valid(`resMeet`)),
  `resPurp` longtext NOT NULL COMMENT 'purpose of meeting',
  `resAttendants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'number of attendees' CHECK (json_valid(`resAttendants`)),
  `resReq` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'special requirements',
  `resStatus` varchar(255) NOT NULL COMMENT 'approved, rejected, or pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`resID`, `resType`, `resRoom`, `resUser`, `resDate`, `resMeet`, `resPurp`, `resAttendants`, `resReq`, `resStatus`) VALUES
('0', 'regular', '1', 'ticman', '0000-00-00 00:00:00', '{\"start\":\"2025-06-05 15:15\",\"end\":\"2025-06-05 16:00\"}', 'AAAAAAAAAAAAA', '[{\"name\":\"Covi Rosario\",\"email\":\"marks2nd2020@outlook.com\"}]', 'aaaaaaaaaaaaaaaaaaaaaa', 'PENDING'),
('1', 'customer', '2', 'ticman', '2025-06-05 06:47:05', '{\"start\":\"2025-06-06 06:00\",\"end\":\"2025-06-06 08:00\"}', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '[{\"name\":\"a\",\"email\":\"a@a\"},{\"name\":\"a\",\"email\":\"a@a\"},{\"name\":\"a\",\"email\":\"a@a\"},{\"name\":\"a\",\"email\":\"a@a\"}]', 'aaaa', 'PENDING'),
('2', 'regular', '2', 'ticman', '2025-06-05 07:02:37', '{\"start\":\"2025-06-09 13:00\",\"end\":\"2025-06-09 15:00\"}', 'a', '[{\"name\":\"aaaaaa\",\"email\":\"a@a\"}]', 'aaaaa', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomID` varchar(255) NOT NULL,
  `roomName` varchar(255) NOT NULL COMMENT 'room name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomID`, `roomName`) VALUES
('1', 'Guest Room 1'),
('2', 'Guest Room 2'),
('3', 'Canteen Training Room');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uName` varchar(255) NOT NULL COMMENT 'username to login',
  `uDept` varchar(255) NOT NULL COMMENT 'department',
  `uEmail` varchar(255) NOT NULL COMMENT 'email address',
  `uPass` varchar(255) NOT NULL COMMENT 'password (encrypt in sha1)',
  `uType` varchar(255) NOT NULL COMMENT 'user or admin?',
  `uDisplayName` varchar(255) NOT NULL COMMENT 'First Name + Last Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uName`, `uDept`, `uEmail`, `uPass`, `uType`, `uDisplayName`) VALUES
('admin', 'a', 'aurora.jimenez@hayakawa.com.ph', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'Aurora Jiminez'),
('ticman', 'IT', 'kticman@hayakawa.com.ph', '1a3a7b03226cb5a137c253f0252b09f648258782', 'Employee', 'Kyle Ticman');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divsections`
--
ALTER TABLE `divsections`
  ADD PRIMARY KEY (`divSecId`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`resID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divsections`
--
ALTER TABLE `divsections`
  MODIFY `divSecId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
