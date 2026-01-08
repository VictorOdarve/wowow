<?php
require_once '../includes/connection.php';

if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];
    
    // Get patient basic information
    $patient_sql = "SELECT * FROM consultation_form WHERE patient_id = ? LIMIT 1";
    $stmt = $conn->prepare($patient_sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $patient_result = $stmt->get_result();
    $patient = $patient_result->fetch_assoc();
    $stmt->close();
    
    if ($patient) {
        // Get assessment history
        $assessment_sql = "SELECT * FROM assessments WHERE patient_id = ? ORDER BY assessment_datetime DESC";
        $stmt = $conn->prepare($assessment_sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $assessment_result = $stmt->get_result();
        $assessments = [];
        while ($row = $assessment_result->fetch_assoc()) {
            $assessments[] = $row;
        }
        $stmt->close();
        
        // Get diagnosis history
        $diagnosis_sql = "SELECT * FROM patient_diagnosis WHERE patient_id = ? ORDER BY diagnosis_dateandtime DESC";
        $stmt = $conn->prepare($diagnosis_sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $diagnosis_result = $stmt->get_result();
        $diagnoses = [];
        while ($row = $diagnosis_result->fetch_assoc()) {
            $diagnoses[] = $row;
        }
        $stmt->close();
        
        // Get prescription history
        $prescription_sql = "SELECT * FROM patient_prescription WHERE patient_id = ? GROUP BY medication_name, dosage, frequency ORDER BY prescription_datetime DESC";
        $stmt = $conn->prepare($prescription_sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $prescription_result = $stmt->get_result();
        $prescriptions = [];
        while ($row = $prescription_result->fetch_assoc()) {
            $prescriptions[] = $row;
        }
        $stmt->close();
        
        // Get appointment history
        $appointment_sql = "SELECT * FROM appointments WHERE patient_id = ? ORDER BY schedule_date DESC, schedule_time DESC";
        $stmt = $conn->prepare($appointment_sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $appointment_result = $stmt->get_result();
        $appointments = [];
        while ($row = $appointment_result->fetch_assoc()) {
            $appointments[] = $row;
        }
        $stmt->close();
        
        echo json_encode([
            'success' => true,
            'patient' => $patient,
            'assessments' => $assessments,
            'diagnoses' => $diagnoses,
            'prescriptions' => $prescriptions,
            'appointments' => $appointments
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Patient not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Patient ID not provided']);
}

$conn->close();
?>