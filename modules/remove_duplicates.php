<?php
require_once '../includes/connection.php';

// Remove duplicate prescriptions
$sql = "DELETE p1 FROM patient_prescription p1 
        INNER JOIN patient_prescription p2 
        WHERE p1.prescription_id > p2.prescription_id 
        AND p1.patient_id = p2.patient_id 
        AND p1.medication_name = p2.medication_name 
        AND p1.dosage = p2.dosage 
        AND p1.frequency = p2.frequency";

if ($conn->query($sql)) {
    echo "Duplicate prescriptions removed successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>