-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2025 at 01:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `consultation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_consultation`
--

CREATE TABLE `tbl_consultation` (
  `consultation_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `complete_address` text NOT NULL,
  `reason_for_consultation` varchar(50) NOT NULL,
  `main_reason` text NOT NULL,
  `intensity` varchar(50) NOT NULL,
  `date_consultation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_consultation`
--

INSERT INTO `tbl_consultation` (`consultation_id`, `full_name`, `age`, `gender`, `barangay`, `complete_address`, `reason_for_consultation`, `main_reason`, `intensity`, `date_consultation`) VALUES
(1, 'Victor Odarve', 21, 'Male', 'lumbia', 'Xavier Ecoville, Lumbia Cagayan de Oro', 'pain', 'Sakit kay iyang gi buhat sako', 'severe', '2025-12-12'),
(2, 'Gabriel, Madridano', 20, 'Male', 'balulang', 'taguanao, Cagayan de Oro ', 'fever', 'hilantanon inig dili maka sigarilyo', 'severe', '2025-12-12'),
(3, 'Japhet, Doroin', 21, 'Male', 'lumbia', 'Xavier Ecoville, Lumbia Cagayan de Oro', 'cough_cold', 'cold nakay sya sako', 'severe', '2025-12-12'),
(4, 'Burbur, Lights', 23, 'Male', 'canito-an', 'Canito-an, Cagayan de Oro', 'followup', 'follow up sa tambal sako anak', 'others', '2025-12-12'),
(5, 'Ren, Dosol', 23, 'Male', 'canito-an', 'Canito-an, Cagayan de Oro', 'wound7', 'disgrasya motor bali ako tiil', 'severe', '2025-12-12'),
(6, 'Harle Jean, Bruce', 24, 'Female', 'consolacion', 'Consolacion, Cagayan de Oro', 'bp_check', 'Highblooron kayo murag bae', 'moderate', '2025-12-12'),
(7, 'Juan Dela Cruz', 24, 'Male', 'carmen', 'Zone 3, Carmen', 'checkup', 'Routine health check', 'mild', '2025-01-05'),
(9, 'Maria Santos', 31, 'Female', 'balulang', 'Phase 1', 'cough_cold', 'Cough & clogged nose', 'moderate', '2025-01-06'),
(10, 'Leo Ramirez', 19, 'Male', 'bugo', 'Riverside, Bugo', 'wound7', 'Minor cut on foot', 'mild', '2025-01-06'),
(11, 'Angela Flores', 28, 'Female', 'lapasan', 'Village A, Lapasan', 'pain', 'Migraine', 'moderate', '2025-01-07'),
(12, 'Carlo Gutierrez', 35, 'Male', 'macasandig', 'Zone 5, Macasandig', 'bp_check', 'High BP monitoring', 'mild', '2025-01-08'),
(13, 'Nina Olarte', 22, 'Female', 'gusa', 'Zone 2, Gusa', 'medication', 'Refill for migraine meds', 'mild', '2025-01-08'),
(14, 'Ryan Villanueva', 27, 'Male', 'puerto', 'Purok 4, Puerto', 'pain', 'Back pain', 'moderate', '2025-01-09'),
(15, 'Melissa Tan', 30, 'Female', 'camaman-an', 'Upper, Camaman-an', 'skin', 'Skin allergy', 'severe', '2025-01-10'),
(16, 'Patrick Gomez', 40, 'Male', 'canito-an', 'Zone, Canito-an', 'bp_check', 'BP evaluation', 'moderate', '2025-01-11'),
(17, 'Jenna Ramos', 21, 'Female', 'nazareth', '6th Street, Nazareth', 'cough_cold', 'Sore throat', 'mild', '2025-01-11'),
(18, 'Daniel Lee', 25, 'Male', 'cugman', 'Sitio Luna, Cugman', 'followup', 'Sleep issue check', 'others', '2025-01-12'),
(19, 'Krisha Bandojo', 23, 'Female', 'patag', 'Block 8, Patag', 'checkup', 'Chest discomfort', 'mild', '2025-01-13'),
(20, 'Mark Salcedo', 29, 'Others', 'indahag', 'Zone 1, Indahag', 'pain', 'Shoulder pain', 'moderate', '2025-01-13'),
(21, 'japjap, doroin', 21, 'Others', 'bonbon', 'punta, bonbon', 'cough_cold', 'cold nakay si honey sako', 'severe', '2025-12-12'),
(22, 'Ogag ko', 0, 'Others', 'agusan', 'Zone 2, Agusan', 'medication', 'ga marijuana ko', 'moderate', '2025-02-01'),
(23, 'buang ko', 0, 'Male', 'baikingon', 'Baikingon', 'bp_check', 'highblood ko ', 'mild', '2025-12-12'),
(24, 'bagak alimaping', 42, 'Male', 'lumbia', 'Palalan, Lumbia', 'wound7', 'nasamad ang sampot', 'mild', '2025-12-12'),
(25, 'animal ko', 21, 'Female', 'carmen', 'Market, Carmen', 'cough_cold', 'ubo ug sip on', 'moderate', '2025-12-12'),
(26, 'james harden', 32, 'Male', 'carmen', 'Vamenta, Carmen ', 'pain', 'gi train nasakitan', 'mild', '2025-12-12'),
(27, 'LEBRON JAMES', 42, 'Male', 'lumbia', 'Lumbia cdo', 'skin', 'kagid', 'mild', '2025-12-12'),
(28, 'Stephen kokoy', 34, 'Male', 'bonbon', 'Raagas, Bonbon', 'pain', 'sakit likod ', 'severe', '2025-12-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_consultation`
--
ALTER TABLE `tbl_consultation`
  ADD PRIMARY KEY (`consultation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_consultation`
--
ALTER TABLE `tbl_consultation`
  MODIFY `consultation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Table structure for table `tbl_doctors`
--

CREATE TABLE `tbl_doctors` (
  `doctor_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `available_days` varchar(255) NOT NULL,
  `available_time_start` time NOT NULL,
  `available_time_end` time NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_doctors`
--
ALTER TABLE `tbl_doctors`
  ADD PRIMARY KEY (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_doctors`
--
ALTER TABLE `tbl_doctors`
  MODIFY `doctor_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `tbl_nurses`
--

CREATE TABLE `tbl_nurses` (
  `nurse_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `assigned_department` varchar(100) NOT NULL,
  `work_schedule` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_nurses`
--
ALTER TABLE `tbl_nurses`
  ADD PRIMARY KEY (`nurse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_nurses`
--
ALTER TABLE `tbl_nurses`
  MODIFY `nurse_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
