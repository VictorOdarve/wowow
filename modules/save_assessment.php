<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "./includes/connection.php";

// Create assessments table if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS `tbl_assessments` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$conn->query($createTable);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $consultation_id = $_POST['consultation_id'];
    $chief_complaint = $_POST['chief_complaint'];
    $current_symptoms = $_POST['current_symptoms'];
    $blood_pressure = $_POST['blood_pressure'];
    $body_temperature = $_POST['body_temperature'];
    $pulse_rate = $_POST['pulse_rate'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $assessment_datetime = $_POST['assessment_datetime'];
    $nurse_name_id = $_POST['nurse_name_id'];

    $sql = "INSERT INTO tbl_assessments (consultation_id, chief_complaint, current_symptoms, blood_pressure, body_temperature, pulse_rate, weight, height, assessment_datetime, nurse_name_id, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $consultation_id, $chief_complaint, $current_symptoms, $blood_pressure, $body_temperature, $pulse_rate, $weight, $height, $assessment_datetime, $nurse_name_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Assessment saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error saving assessment: ' . $conn->error]);
    }
    
    $stmt->close();
    $conn->close();
}
?>