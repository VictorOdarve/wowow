<?php
// patient_diagnosis.php
$page_title = "Patient Diagnosis";
require_once '../includes/connection.php';
require_once '../includes/header.php';

$createTable = "CREATE TABLE IF NOT EXISTS `patient_diagnosis` (
  `consultation_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `diagnosis` text,
  `clinical_findings` text,
  `notes` text,
  `treatment_plan` text,
  `recommended_test` text,
  `diagnosis_dateandtime` datetime,
  `doctor_nameorid` varchar(255),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($createTable)) {
    echo "Error creating table: " . $conn->error;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_diagnosis'])) {
    $consultation_id = $_POST['consultation_id'];
    $patient_id = $_POST['patient_id'];
    $diagnosis = $_POST['diagnosis'];
    $clinical_findings = $_POST['clinical_findings'];
    $notes = $_POST['notes'];
    $treatment_plan = $_POST['treatment_plan'];
    $recommended_test = $_POST['recommended_test'];
    $diagnosis_dateandtime = $_POST['diagnosis_dateandtime'];
    $doctor_nameorid = $_POST['doctor_nameorid'];
    
    $sql = "INSERT INTO patient_diagnosis (consultation_id, patient_id, diagnosis, clinical_findings, notes, treatment_plan, recommended_test, diagnosis_dateandtime, doctor_nameorid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssss", $consultation_id, $patient_id, $diagnosis, $clinical_findings, $notes, $treatment_plan, $recommended_test, $diagnosis_dateandtime, $doctor_nameorid);
    
    if ($stmt->execute()) {
        echo "<script>alert('Diagnosis saved successfully!');</script>";
    } else {
        echo "<script>alert('Error saving diagnosis');</script>";
    }
    $stmt->close();
}

// Fetch diagnosis records
$sql = "SELECT * FROM patient_diagnosis ORDER BY diagnosis_dateandtime DESC";
$result = $conn->query($sql);
?>

<div class="pagetitle">
  <h1>Patient Diagnosis</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
      <li class="breadcrumb-item active">Patient Diagnosis</li>
    </ol>
  </nav>
</div>

<section class="section">
  <!-- Diagnosis Form -->
  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">New Diagnosis</h5>
          
          <form method="POST" action="">
            <input type="hidden" name="save_diagnosis" value="1">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Consultation ID</label>
                <input type="number" class="form-control" name="consultation_id" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Patient ID</label>
                <input type="number" class="form-control" name="patient_id" required>
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
                <input type="datetime-local" class="form-control" name="diagnosis_dateandtime" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Save Diagnosis</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Diagnosis Records -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Diagnosis Records</h5>

          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th>Consultation ID</th>
                  <th>Patient ID</th>
                  <th>Diagnosis</th>
                  <th>Clinical Findings</th>
                  <th>Treatment Plan</th>
                  <th>Recommended Test</th>
                  <th>Doctor</th>
                  <th>Date & Time</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["consultation_id"] . "</td>";
                    echo "<td>" . $row["patient_id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["diagnosis"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["clinical_findings"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["treatment_plan"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["recommended_test"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["doctor_nameorid"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["diagnosis_dateandtime"] ?? '') . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='8' class='text-center'>No diagnosis records found</td></tr>";
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

<?php
require_once '../includes/footer.php';
$conn->close();
?>