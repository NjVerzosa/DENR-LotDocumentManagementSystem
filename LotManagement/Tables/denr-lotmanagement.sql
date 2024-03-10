-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 05:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `denr-lotmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `land_titles`
--

CREATE TABLE `land_titles` (
  `id` int(11) NOT NULL,
  `lot_number` varchar(255) NOT NULL,
  `date_filed` date DEFAULT NULL,
  `applicant_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` varchar(5) NOT NULL DEFAULT '0' COMMENT '0 = no action, 1 subdivided, 2 = titled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `land_titles`
--

-- INSERT INTO `land_titles` (`id`, `lot_number`, `date_filed`, `applicant_name`, `location`, `remarks`, `position`, `status`) VALUES
-- (1, '001', '2024-03-04', 'John Doe', 'Manila', 'Lorem ipsum', '0', '1'),
-- (2, '002', '2024-03-05', 'Jane Doe', 'Cebu', 'Dolor sit amet', '0', '1'),
-- (3, '003', '2024-03-06', 'Alice Smith', 'Davao', 'Consectetur adipiscing elit', '0', '1'),
-- (4, '004', '2024-03-06', 'Johnny zins', 'Africa', 'pending', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `subdivided_titles`
--

CREATE TABLE `subdivided_titles` (
  `id` int(11) NOT NULL,
  `lot_number` varchar(255) NOT NULL,
  `date_filed` date DEFAULT NULL,
  `applicant_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `position` varchar(10) DEFAULT NULL,
  `status` varchar(5) NOT NULL DEFAULT '0' COMMENT '0 = no action, 1 subdivided, 2 = titled',
  `land_title_id` int(11) DEFAULT NULL,
  `subdivided_to` varchar(10) DEFAULT NULL COMMENT 'null = not subdivided, put the subdivided address if subdivided'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subdivided_titles`
--

-- INSERT INTO `subdivided_titles` (`id`, `lot_number`, `date_filed`, `applicant_name`, `location`, `remarks`, `position`, `status`, `land_title_id`, `subdivided_to`) VALUES
-- (1, '001', '2024-03-04', 'Ronnie', 'Manila', 'Pending', '1', '0', 1, NULL),
-- (2, '002', '2024-03-04', 'Norlie', 'Cebu', 'Pending', '1', '0', 2, NULL),
-- (3, '001', '2024-03-07', 'JOnathan', 'Manila', 'Pending', '2', '0', 1, NULL),
-- (4, '002', '2024-03-04', 'Jame arthur', 'Cebu', 'Pending', '2', '0', 2, NULL),
-- (5, '002', '2024-03-04', 'Jame arthur', 'Cebu', 'Pending', '2', '0', 2, NULL),
-- (6, '003', '2024-03-04', 'billie dick', 'Davao', 'Pending', '1', '0', 3, NULL),
-- (7, '004', '2024-03-06', 'popoy', 'Africa', 'Pending', '1', '1', 4, NULL),
-- (8, '004', '2024-03-06', 'hoho', 'Africa', 'Pending', '2', '0', 4, NULL),
-- (9, '004', '2024-03-05', 'loki', 'Africa', 'Pending', '2', '0', 4, NULL),
-- (10, '004', '2024-03-05', 'jungcock', 'Africa', 'Pending', '2', '0', 4, NULL),
-- (11, '004', '2024-03-05', 'kokoy', 'Africa', 'pending', '0', '1', 4, '7'),
-- (12, '004', '2024-03-22', 'momoy', 'Africa', 'pending', '0', '1', 4, '11'),
-- (13, '004', '2024-03-05', 'momoy land', 'Africa', 'Pending', '1', '0', NULL, '11'),
-- (14, '004', '2024-03-05', 'momoy 2', 'Africa', 'Pending', '1', '0', NULL, '11'),
-- (15, '004', '2024-03-05', 'momoy 2', 'Africa', 'Pending', '1', '0', NULL, '11'),
-- (16, '004', '2024-03-05', 'momoy 2', 'Africa', 'Pending', '1', '0', NULL, '11'),
-- (17, '004', '2024-03-05', 'momoy 2', 'Africa', 'Pending', '1', '0', NULL, '11'),
-- (18, '004', '2024-03-05', 'momoy divide', 'Africa', 'Pending', '1', '1', NULL, '12'),
-- (19, '004', '2024-03-05', 'momoy 1', 'Africa', 'Pending', '2', '1', NULL, '18'),
-- (20, '004', '2024-03-05', 'moom 1', 'Africa', 'Pending', '3', '0', NULL, '19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `land_titles`
--
ALTER TABLE `land_titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subdivided_titles`
--
ALTER TABLE `subdivided_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `land_title_id` (`land_title_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `land_titles`
--
ALTER TABLE `land_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subdivided_titles`
--
ALTER TABLE `subdivided_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subdivided_titles`
--
ALTER TABLE `subdivided_titles`
  ADD CONSTRAINT `subdivided_titles_ibfk_1` FOREIGN KEY (`land_title_id`) REFERENCES `land_titles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
