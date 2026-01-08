CREATE TABLE IF NOT EXISTS `tbl_consultation` (
  `consultation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `complete_address` text NOT NULL,
  `reason_for_consultation` varchar(100) NOT NULL,
  `main_reason` text NOT NULL,
  `intensity` varchar(50) NOT NULL,
  `date_consultation` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`consultation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;