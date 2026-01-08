CREATE TABLE IF NOT EXISTS `tbl_assessments` (
  `assessment_id` int(11) NOT NULL AUTO_INCREMENT,
  `consultation_id` int(11) NOT NULL,
  `chief_complaint` text,
  `current_symptoms` text,
  `blood_pressure` varchar(50),
  `body_temperature` varchar(50),
  `pulse_rate` varchar(50),
  `weight` varchar(50),
  `height` varchar(50),
  `assessment_datetime` datetime,
  `nurse_name_id` varchar(100),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`assessment_id`),
  KEY `consultation_id` (`consultation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;