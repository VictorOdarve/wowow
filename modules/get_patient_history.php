<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinic_consultationdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

if (!isset($_GET['patient_id'])) {
    echo json_encode(['success' => false, 'error' => 'Patient ID not provided']);
    exit;
}

$patient_id = intval($_GET['patient_id']);

// Fetch patient information
$patient_sql = "SELECT * FROM consultation_form WHERE patient_id = ?";
$patient_stmt = $conn->prepare($patient_sql);
$patient_stmt->bind_param("i", $patient_id);
$patient_stmt->execute();
$patient_result = $patient_stmt->get_result();

if ($patient_result->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Patient not found']);
    exit;
}

$patient = $patient_result->fetch_assoc();

// Fetch appointments history
$appointments_sql = "SELECT * FROM appointments WHERE patient_id = ? ORDER BY schedule_date DESC, schedule_time DESC";
$appointments_stmt = $conn->prepare($appointments_sql);
$appointments_stmt->bind_param("i", $patient_id);
$appointments_stmt->execute();
$appointments_result = $appointments_stmt->get_result();

$appointments = [];
while ($row = $appointments_result->fetch_assoc()) {
    $appointments[] = $row;
}

echo json_encode([
    'success' => true,
    'patient' => $patient,
    'appointments' => $appointments
]);

$patient_stmt->close();
$appointments_stmt->close();
$conn->close();
?>