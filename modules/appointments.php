<?php
// appointments.php
$page_title = "Appointments";
require_once '../includes/connection.php';
require_once '../includes/header.php';

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $action = $_POST['action'];
    
    if ($action == 'assessment') {
        // Get patient info from appointment
        $patient_sql = "SELECT patient_id, patient_name FROM appointments WHERE appointment_id = ?";
        $stmt = $conn->prepare($patient_sql);
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $patient_result = $stmt->get_result();
        $patient_data = $patient_result->fetch_assoc();
        $stmt->close();
        
        // Create assessments table if not exists
        $create_assessment_table = "CREATE TABLE IF NOT EXISTS assessments (
            assessment_id INT AUTO_INCREMENT PRIMARY KEY,
            patient_id INT,
            patient_name VARCHAR(255),
            blood_pressure VARCHAR(20),
            body_temp DECIMAL(4,1),
            pulse_rate INT,
            respiratory_rate INT,
            weight DECIMAL(5,1),
            height INT,
            assessment_datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->query($create_assessment_table);
        
        // Insert assessment data
        $insert_assessment = "INSERT INTO assessments (patient_id, patient_name, blood_pressure, body_temp, pulse_rate, respiratory_rate, weight, height) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_assessment);
        $stmt->bind_param("issdiidd", $patient_data['patient_id'], $patient_data['patient_name'], $_POST['blood_pressure'], $_POST['body_temp'], $_POST['pulse_rate'], $_POST['respiratory_rate'], $_POST['weight'], $_POST['height']);
        $stmt->execute();
        $stmt->close();
    } elseif ($action == 'diagnosis') {
        // Create diagnosis table if not exists
        $create_diagnosis_table = "CREATE TABLE IF NOT EXISTS patient_diagnosis (
            consultation_id INT,
            patient_id INT,
            diagnosis TEXT,
            clinical_findings TEXT,
            notes TEXT,
            treatment_plan TEXT,
            recommended_test TEXT,
            diagnosis_dateandtime DATETIME,
            doctor_nameorid VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->query($create_diagnosis_table);
        
        // Insert diagnosis data
        $insert_diagnosis = "INSERT INTO patient_diagnosis (consultation_id, patient_id, diagnosis, clinical_findings, notes, treatment_plan, recommended_test, diagnosis_dateandtime, doctor_nameorid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_diagnosis);
        $consultation_id = $appointment_id; // Use appointment_id as consultation_id
        $patient_id = $_POST['patient_id'];
        $stmt->bind_param("iisssssss", $consultation_id, $patient_id, $_POST['diagnosis'], $_POST['clinical_findings'], $_POST['notes'], $_POST['treatment_plan'], $_POST['recommended_test'], $_POST['diagnosis_dateandtime'], $_POST['doctor_nameorid']);
        $stmt->execute();
        $stmt->close();
    } elseif ($action == 'prescription') {
        // Create prescription table if not exists
        $create_prescription_table = "CREATE TABLE IF NOT EXISTS patient_prescription (
            prescription_id INT AUTO_INCREMENT PRIMARY KEY,
            patient_id INT,
            consultation_id INT,
            medication_name VARCHAR(255),
            dosage VARCHAR(100),
            frequency VARCHAR(100),
            route VARCHAR(50),
            duration VARCHAR(100),
            additional_notes TEXT,
            prescribing_doctor_nameorid VARCHAR(255),
            prescription_datetime DATETIME,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->query($create_prescription_table);
        
        // Insert prescription data
        $insert_prescription = "INSERT INTO patient_prescription (patient_id, consultation_id, medication_name, dosage, frequency, route, duration, additional_notes, prescribing_doctor_nameorid, prescription_datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_prescription);
        $consultation_id = $appointment_id;
        $patient_id = $_POST['patient_id'];
        $stmt->bind_param("iissssssss", $patient_id, $consultation_id, $_POST['medication_name'], $_POST['dosage'], $_POST['frequency'], $_POST['route'], $_POST['duration'], $_POST['additional_notes'], $_POST['prescribing_doctor_nameorid'], $_POST['prescription_datetime']);
        $stmt->execute();
        $stmt->close();
    }
    
    // Update the specific action status
    $update_sql = "UPDATE appointments SET {$action}_completed = 1 WHERE appointment_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $stmt->close();
    
    // Check if all actions are completed to mark as done
    $check_sql = "SELECT assessment_completed, diagnosis_completed, prescription_completed FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result_check = $stmt->get_result();
    $row_check = $result_check->fetch_assoc();
    
    if ($row_check['assessment_completed'] && $row_check['diagnosis_completed'] && $row_check['prescription_completed']) {
        $done_sql = "UPDATE appointments SET status = 'Done' WHERE appointment_id = ?";
        $stmt_done = $conn->prepare($done_sql);
        $stmt_done->bind_param("i", $appointment_id);
        $stmt_done->execute();
        $stmt_done->close();
    }
    $stmt->close();
}

// Add columns to appointments table if they don't exist
$alter_sql = "ALTER TABLE appointments 
    ADD COLUMN IF NOT EXISTS assessment_completed TINYINT(1) DEFAULT 0,
    ADD COLUMN IF NOT EXISTS diagnosis_completed TINYINT(1) DEFAULT 0,
    ADD COLUMN IF NOT EXISTS prescription_completed TINYINT(1) DEFAULT 0,
    ADD COLUMN IF NOT EXISTS status VARCHAR(50) DEFAULT 'Scheduled'";
$conn->query($alter_sql);

// Fetch all appointments
$sql = "SELECT *, 
    CASE 
        WHEN assessment_completed = 1 AND diagnosis_completed = 1 AND prescription_completed = 1 THEN 'Done'
        ELSE COALESCE(status, 'Scheduled')
    END as current_status
FROM appointments ORDER BY schedule_date DESC, schedule_time DESC";
$result = $conn->query($sql);
?>

<div class="pagetitle">
  <h1>Appointments</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
      <li class="breadcrumb-item active">Appointments</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">APPOINTMENTS</h5>

          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Patient ID</th>
                  <th>Patient Name</th>
                  <th>Chief Complaint</th>
                  <th>Clinic Location</th>
                  <th>Schedule Date</th>
                  <th>Schedule Time</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["appointment_id"] . "</td>";
                    echo "<td>" . $row["patient_id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["patient_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["chief_complaint"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["clinic_location"]) . "</td>";
                    echo "<td>" . $row["schedule_date"] . "</td>";
                    echo "<td>" . date('g:i A', strtotime($row["schedule_time"])) . "</td>";
                    $status = $row['current_status'];
                    $status_class = $status == 'Done' ? 'bg-success' : 'bg-warning';
                    echo "<td><span class='badge {$status_class}'>{$status}</span></td>";
                    echo "<td>";
                    $appointment_id = $row['appointment_id'];
                    $assessment_done = $row['assessment_completed'];
                    $diagnosis_done = $row['diagnosis_completed'];
                    $prescription_done = $row['prescription_completed'];
                    
                    echo "<td>";
                    
                    // Assessment button
                    if (!$assessment_done) {
                        echo "<button type='button' class='btn btn-info btn-sm me-1' onclick='showAssessmentForm({$appointment_id})'>Assessment</button>";
                    } else {
                        echo "<button class='btn btn-secondary btn-sm me-1' disabled>✓ Assessment</button>";
                    }
                    
                    // Diagnosis button
                    if (!$diagnosis_done) {
                        echo "<button type='button' class='btn btn-warning btn-sm me-1' onclick='showDiagnosisForm({$appointment_id})'>Diagnosis</button>";
                    } else {
                        echo "<button class='btn btn-secondary btn-sm me-1' disabled>✓ Diagnosis</button>";
                    }
                    
                    // Prescription button
                    if (!$prescription_done) {
                        echo "<button type='button' class='btn btn-success btn-sm' onclick='showPrescriptionForm({$appointment_id})'>Prescription</button>";
                    } else {
                        echo "<button class='btn btn-secondary btn-sm' disabled>✓ Prescription</button>";
                    }
                    echo "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='9' class='text-center'>No appointments found</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Assessment Modal -->
<div class="modal fade" id="assessmentModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Patient Assessment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <input type="hidden" name="appointment_id" id="assessment_appointment_id">
          <input type="hidden" name="action" value="assessment">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Blood Pressure</label>
              <input type="text" class="form-control" name="blood_pressure" placeholder="120/80" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Body Temperature (°C)</label>
              <input type="number" class="form-control" name="body_temp" step="0.1" placeholder="36.5" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Pulse Rate (bpm)</label>
              <input type="number" class="form-control" name="pulse_rate" placeholder="72" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Respiratory Rate (per min)</label>
              <input type="number" class="form-control" name="respiratory_rate" placeholder="16" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Weight (kg)</label>
              <input type="number" class="form-control" name="weight" step="0.1" placeholder="70.5" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Height (cm)</label>
              <input type="number" class="form-control" name="height" placeholder="170" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="update_status" class="btn btn-info">Complete Assessment</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Diagnosis Modal -->
<div class="modal fade" id="diagnosisModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Patient Diagnosis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <input type="hidden" name="appointment_id" id="diagnosis_appointment_id">
          <input type="hidden" name="action" value="diagnosis">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Consultation ID</label>
              <input type="number" class="form-control" name="consultation_id" id="diagnosis_consultation_id" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Patient ID</label>
              <input type="number" class="form-control" name="patient_id" id="diagnosis_patient_id" readonly>
            </div>
            <div class="col-12">
              <label class="form-label">Diagnosis</label>
              <textarea class="form-control" name="diagnosis" rows="3" required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Clinical Findings</label>
              <textarea class="form-control" name="clinical_findings" rows="3" required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Notes</label>
              <textarea class="form-control" name="notes" rows="2" required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Treatment Plan</label>
              <textarea class="form-control" name="treatment_plan" rows="3" required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Recommended Test</label>
              <textarea class="form-control" name="recommended_test" rows="2" required></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Doctor Name/ID</label>
              <input type="text" class="form-control" name="doctor_nameorid" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Diagnosis Date & Time</label>
              <input type="datetime-local" class="form-control" name="diagnosis_dateandtime" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="update_status" class="btn btn-warning">Complete Diagnosis</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Prescription Modal -->
<div class="modal fade" id="prescriptionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Patient Prescription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <input type="hidden" name="appointment_id" id="prescription_appointment_id">
          <input type="hidden" name="action" value="prescription">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Patient ID</label>
              <input type="number" class="form-control" name="patient_id" id="prescription_patient_id" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Consultation ID</label>
              <input type="number" class="form-control" name="consultation_id" id="prescription_consultation_id" readonly>
            </div>
            <div class="col-12">
              <label class="form-label">Medication Name</label>
              <input type="text" class="form-control" name="medication_name" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Dosage</label>
              <input type="text" class="form-control" name="dosage" placeholder="500mg" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Frequency</label>
              <input type="text" class="form-control" name="frequency" placeholder="3 times daily" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Route</label>
              <select class="form-control" name="route" required>
                <option value="">Select Route</option>
                <option value="Oral">Oral</option>
                <option value="Topical">Topical</option>
                <option value="Injection">Injection</option>
                <option value="Inhalation">Inhalation</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Duration</label>
              <input type="text" class="form-control" name="duration" placeholder="7 days" required>
            </div>
            <div class="col-12">
              <label class="form-label">Additional Notes</label>
              <textarea class="form-control" name="additional_notes" rows="2"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Prescribing Doctor Name/ID</label>
              <input type="text" class="form-control" name="prescribing_doctor_nameorid" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Prescription Date & Time</label>
              <input type="datetime-local" class="form-control" name="prescription_datetime" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="update_status" class="btn btn-success">Complete Prescription</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showAssessmentForm(appointmentId) {
    document.getElementById('assessment_appointment_id').value = appointmentId;
    new bootstrap.Modal(document.getElementById('assessmentModal')).show();
}

function showDiagnosisForm(appointmentId) {
    // Get patient data from appointment
    fetch('get_appointment_data.php?id=' + appointmentId)
        .then(response => response.json())
        .then(data => {
            document.getElementById('diagnosis_appointment_id').value = appointmentId;
            document.getElementById('diagnosis_consultation_id').value = data.appointment_id;
            document.getElementById('diagnosis_patient_id').value = data.patient_id;
            new bootstrap.Modal(document.getElementById('diagnosisModal')).show();
        });
}

function showPrescriptionForm(appointmentId) {
    // Get patient data from appointment
    fetch('get_appointment_data.php?id=' + appointmentId)
        .then(response => response.json())
        .then(data => {
            document.getElementById('prescription_appointment_id').value = appointmentId;
            document.getElementById('prescription_consultation_id').value = data.appointment_id;
            document.getElementById('prescription_patient_id').value = data.patient_id;
            new bootstrap.Modal(document.getElementById('prescriptionModal')).show();
        });
}
</script>

<?php
require_once '../includes/footer.php';
$conn->close();
?>