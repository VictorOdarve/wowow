<?php
require_once '../includes/connection.php';

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];
    
    $sql = "SELECT appointment_id, patient_id FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['appointment_id' => $appointment_id, 'patient_id' => 0]);
    }
    
    $stmt->close();
}
$conn->close();
?>