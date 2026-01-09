-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 08:54 AM
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
-- Database: `clinic_consultationdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `chief_complaint` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `clinic_location` varchar(255) DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `schedule_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Scheduled') DEFAULT NULL,
  `assessment_completed` tinyint(1) DEFAULT 0,
  `diagnosis_completed` tinyint(1) DEFAULT 0,
  `prescription_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `patient_name`, `chief_complaint`, `description`, `email`, `clinic_location`, `schedule_date`, `schedule_time`, `created_at`, `status`, `assessment_completed`, `diagnosis_completed`, `prescription_completed`) VALUES
(1, 0, 'paolo pasia', 'dizziness', 'subrtaan butoy', 'torensodarve@gmail.com', 'lumbia clinic', '2026-01-31', '01:40:00', '2026-01-09 06:37:45', '', 1, 1, 1),
(2, 2, 'japjap  doroin', 'fever', 'dsadsadsa', 'japjap@gmail.com', 'lumbia clinic', '2026-01-31', '07:00:00', '2026-01-09 06:55:07', '', 1, 1, 1),
(3, 3, 'baren dosol', 'wound', 'bali tiil', 'baren@gmail.com', 'lumbia clinic', '2026-01-31', '19:40:00', '2026-01-09 07:37:56', '', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `assessment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `blood_pressure` varchar(20) DEFAULT NULL,
  `body_temp` decimal(4,1) DEFAULT NULL,
  `pulse_rate` int(11) DEFAULT NULL,
  `respiratory_rate` int(11) DEFAULT NULL,
  `weight` decimal(5,1) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `assessment_datetime` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`assessment_id`, `patient_id`, `patient_name`, `blood_pressure`, `body_temp`, `pulse_rate`, `respiratory_rate`, `weight`, `height`, `assessment_datetime`, `created_at`) VALUES
(1, 0, 'paolo pasia', '120/80', 123.2, 42, 3, 123.0, 123, '2026-01-09 14:38:39', '2026-01-09 06:38:39'),
(2, 2, 'japjap  doroin', '120/80', 123.2, 42, 3, 123.0, 123, '2026-01-09 14:55:17', '2026-01-09 06:55:17'),
(3, 3, 'baren dosol', '120/80', 46.5, 72, 45, 123.0, 321, '2026-01-09 15:38:20', '2026-01-09 07:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_form`
--

CREATE TABLE `consultation_form` (
  `patient_id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `barangay` enum('Agusan','Baikingon','Balubal','Balulang','Bayabas','Bayanga','Besigan','Bonbon','Bugo','Bulua','Camaman‑an','Canito‑an','Carmen','Consolacion','Cugman','Dansolihon','F.S. Catanico','Gusa','Indahag','Iponan','Kauswagan','Lapasan','Lumbia','Macabalan','Macasandig','Mambuaya','Nazareth','Patag','Pagalungan','Pagatpat','Pigsag‑an','Poblacion','Puerto','Puntod','San Simon','Tablon','Taglimao','Tagpangi','Tignapoloan','Tuburan','Tumpagon') DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `chief_complaint` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `severerity_level` enum('Mild','Moderate','Severe') DEFAULT NULL,
  `associated_symptoms` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation_form`
--

INSERT INTO `consultation_form` (`patient_id`, `fname`, `lname`, `dob`, `age`, `gender`, `contact_no`, `barangay`, `city`, `email_address`, `chief_complaint`, `description`, `date_started`, `severerity_level`, `associated_symptoms`) VALUES
(1, 'paolo', 'pasia', '2004-05-07', 21, 'Other', '09876543210', 'Tuburan', 'Cagayan de Oro', 'torensodarve@gmail.com', 'dizziness', 'subrtaan butoy', '2026-01-08', 'Severe', 'oh'),
(2, 'japjap ', 'doroin', '2015-09-17', 10, 'Male', '09264939879', 'Dansolihon', 'Cagayan de Oro', 'japjap@gmail.com', 'fever', 'dsadsadsa', '2026-01-08', 'Mild', 'dsadasdsa'),
(3, 'baren', 'dosol', '2000-05-07', 25, 'Male', '09264939879', 'Canito‑an', 'Cagayan de Oro', 'baren@gmail.com', 'wound', 'bali tiil', '2026-01-09', 'Severe', 'wa gyud bali gyud'),
(4, 'burbur', 'lightning unkown', '2003-06-18', 22, 'Female', '09264939879', 'Gusa', 'Cagayan de Oro', 'baren@gmail.com', 'headache', 'labad ulo', '2026-01-08', 'Moderate', 'wowww hello');

-- --------------------------------------------------------

--
-- Table structure for table `patient_diagnosis`
--

CREATE TABLE `patient_diagnosis` (
  `consultation_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `clinical_findings` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `treatment_plan` text DEFAULT NULL,
  `recommended_test` text DEFAULT NULL,
  `diagnosis_dateandtime` datetime DEFAULT NULL,
  `doctor_nameorid` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_diagnosis`
--

INSERT INTO `patient_diagnosis` (`consultation_id`, `patient_id`, `diagnosis`, `clinical_findings`, `notes`, `treatment_plan`, `recommended_test`, `diagnosis_dateandtime`, `doctor_nameorid`, `created_at`) VALUES
(1, 0, 'das', 'dasda', 'sdasd', 'sad', 'asd', '2026-01-09 14:39:00', 'torens', '2026-01-09 06:39:34'),
(2, 2, 'dsadsa', 'dsadsa', 'dsadsa', 'dsadsa', 'dsadas', '2026-01-09 14:55:00', 'sadas', '2026-01-09 06:55:27'),
(3, 3, 'dsadsa', 'dsadsadsa', 'dasdsadsa', 'dsadsadsa', 'dsadasdas', '2026-01-09 15:38:00', 'dsadasdas', '2026-01-09 07:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `patient_prescription`
--

CREATE TABLE `patient_prescription` (
  `prescription_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `consultation_id` int(11) DEFAULT NULL,
  `medication_name` varchar(255) DEFAULT NULL,
  `dosage` varchar(100) DEFAULT NULL,
  `frequency` varchar(100) DEFAULT NULL,
  `route` varchar(50) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `prescribing_doctor_nameorid` varchar(255) DEFAULT NULL,
  `prescription_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_prescription`
--

INSERT INTO `patient_prescription` (`prescription_id`, `patient_id`, `consultation_id`, `medication_name`, `dosage`, `frequency`, `route`, `duration`, `additional_notes`, `prescribing_doctor_nameorid`, `prescription_datetime`, `created_at`) VALUES
(1, 0, 1, 'paracitamol', '500mg', 'wasd', 'Injection', '12', 'asd', 'asd', '2026-01-09 14:39:00', '2026-01-09 06:40:06'),
(2, 2, 2, 'dsad', '500mg', 'wasd', 'Oral', '12', 'dsadsa', 'asd', '2026-01-09 14:55:00', '2026-01-09 06:55:43'),
(3, 3, 3, 'ghfgj', '500mg', 'wasd', 'Oral', '12', 'hfgjhfgjfg', 'asd', '2026-01-09 15:38:00', '2026-01-09 07:38:43');

-- --------------------------------------------------------

--
-- Table structure for table `pending_patient`
--

CREATE TABLE `pending_patient` (
  `patient_id` int(11) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `complete_address` text DEFAULT NULL,
  `chief_complaint` text DEFAULT NULL,
  `severity` varchar(50) DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_patient`
--

INSERT INTO `pending_patient` (`patient_id`, `patient_name`, `age`, `gender`, `complete_address`, `chief_complaint`, `severity`, `date_started`, `action`) VALUES
(0, 'paolo pasia', 21, 'Other', 'Tuburan, Cagayan de Oro', 'dizziness', 'Severe', '2026-01-08', 'Pending'),
(2, 'japjap  doroin', 10, 'Male', 'Dansolihon, Cagayan de Oro', 'fever', 'Mild', '2026-01-08', 'Pending'),
(1, 'paolo pasia', 21, 'Other', 'Tuburan, Cagayan de Oro', 'dizziness', 'Severe', '2026-01-08', 'Pending'),
(3, 'baren dosol', 25, 'Male', 'Canito‑an, Cagayan de Oro', 'wound', 'Severe', '2026-01-09', 'Pending'),
(4, 'burbur lightning unkown', 22, 'Female', 'Gusa, Cagayan de Oro', 'headache', 'Moderate', '2026-01-08', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `set_schedule`
--

CREATE TABLE `set_schedule` (
  `patient_id` int(11) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `chief_complaint` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `clinic_location` varchar(255) DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `schedule_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `view_history`
--

CREATE TABLE `view_history` (
  `personal_info` tinyint(1) DEFAULT NULL,
  `medical_info` tinyint(1) DEFAULT NULL,
  `set_schedule` tinyint(1) DEFAULT NULL,
  `assessment` tinyint(1) DEFAULT NULL,
  `diagnosis` tinyint(1) DEFAULT NULL,
  `prescription` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `view_patient`
--

CREATE TABLE `view_patient` (
  `patient_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `chief_complaint` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `severity` varchar(50) DEFAULT NULL,
  `associated_symptoms` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`assessment_id`);

--
-- Indexes for table `consultation_form`
--
ALTER TABLE `consultation_form`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `patient_diagnosis`
--
ALTER TABLE `patient_diagnosis`
  ADD PRIMARY KEY (`consultation_id`);

--
-- Indexes for table `patient_prescription`
--
ALTER TABLE `patient_prescription`
  ADD PRIMARY KEY (`prescription_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `consultation_form`
--
ALTER TABLE `consultation_form`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient_prescription`
--
ALTER TABLE `patient_prescription`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
