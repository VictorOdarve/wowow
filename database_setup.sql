-- Create tbl_doctors table
CREATE TABLE IF NOT EXISTS `tbl_doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample doctors
INSERT INTO `tbl_doctors` (`id`, `full_name`, `specialization`, `status`) VALUES
(1, 'Dr. John Smith', 'Cardiology', 'active'),
(2, 'Dr. Sarah Johnson', 'Pediatrics', 'active'),
(3, 'Dr. Michael Brown', 'Internal Medicine', 'active'),
(4, 'Dr. Emily Davis', 'Dermatology', 'active'),
(5, 'Dr. Robert Wilson', 'Orthopedics', 'active');

-- Create tbl_consultation table if it doesn't exist
CREATE TABLE IF NOT EXISTS `tbl_consultation` (
  `consultation_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `complete_address` text DEFAULT NULL,
  `reason_for_consultation` text DEFAULT NULL,
  `main_reason` text DEFAULT NULL,
  `intensity` varchar(50) DEFAULT NULL,
  `date_consultation` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`consultation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;