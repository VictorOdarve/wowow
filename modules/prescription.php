<?php
// prescription.php
$page_title = "Prescriptions";
require_once '../includes/connection.php';
require_once '../includes/header.php';

$createTable = "CREATE TABLE IF NOT EXISTS `prescription` (
  `prescription_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `consultation_id` int(11) NOT NULL,
  `medication_name` varchar(255),
  `dosage` varchar(100),
  `frequency` varchar(100),
  `route` varchar(100),
  `duration` varchar(100),
  `additional_notes` text,
  `prescribing_doctor_nameorid` varchar(255),
  `prescription_datetime` datetime,
  PRIMARY KEY (`prescription_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($createTable)) {
    echo "Error creating table: " . $conn->error;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_prescription'])) {
    $patient_id = $_POST['patient_id'];
    $consultation_id = $_POST['consultation_id'];
    $medication_name = $_POST['medication_name'];
    $dosage = $_POST['dosage'];
    $frequency = $_POST['frequency'];
    $route = $_POST['route'];
    $duration = $_POST['duration'];
    $additional_notes = $_POST['additional_notes'];
    $prescribing_doctor_nameorid = $_POST['prescribing_doctor_nameorid'];
    $prescription_datetime = $_POST['prescription_date'] . ' ' . $_POST['prescription_time'];
    
    $sql = "INSERT INTO prescription (patient_id, consultation_id, medication_name, dosage, frequency, route, duration, additional_notes, prescribing_doctor_nameorid, prescription_datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssssss", $patient_id, $consultation_id, $medication_name, $dosage, $frequency, $route, $duration, $additional_notes, $prescribing_doctor_nameorid, $prescription_datetime);
    
    if ($stmt->execute()) {
        echo "<script>alert('Prescription saved successfully!');</script>";
    } else {
        echo "<script>alert('Error saving prescription');</script>";
    }
    $stmt->close();
}

// Fetch prescription records
$sql = "SELECT * FROM prescription ORDER BY prescription_id DESC";
$result = $conn->query($sql);
?>

<div class="pagetitle">
  <h1>Prescriptions</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
      <li class="breadcrumb-item active">Prescriptions</li>
    </ol>
  </nav>
</div>

<section class="section">
  <!-- Prescription Form -->
  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">New Prescription</h5>
          
          <form method="POST" action="">
            <input type="hidden" name="save_prescription" value="1">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Patient ID</label>
                <input type="number" class="form-control" name="patient_id" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Consultation ID</label>
                <input type="number" class="form-control" name="consultation_id" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Medication Name</label>
                <input type="text" class="form-control" name="medication_name" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Dosage</label>
                <input type="text" class="form-control" name="dosage" placeholder="e.g., 500mg" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Frequency</label>
                <select class="form-select" name="frequency" required>
                  <option value="">Select Frequency</option>
                  <option value="Once daily">Once daily</option>
                  <option value="Twice daily">Twice daily</option>
                  <option value="Three times daily">Three times daily</option>
                  <option value="Four times daily">Four times daily</option>
                  <option value="Every 4 hours">Every 4 hours</option>
                  <option value="Every 6 hours">Every 6 hours</option>
                  <option value="Every 8 hours">Every 8 hours</option>
                  <option value="As needed">As needed</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Route</label>
                <select class="form-select" name="route" required>
                  <option value="">Select Route</option>
                  <option value="Oral">Oral</option>
                  <option value="Topical">Topical</option>
                  <option value="Injection">Injection</option>
                  <option value="Intravenous">Intravenous</option>
                  <option value="Intramuscular">Intramuscular</option>
                  <option value="Subcutaneous">Subcutaneous</option>
                  <option value="Inhalation">Inhalation</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Duration</label>
                <input type="text" class="form-control" name="duration" placeholder="e.g., 7 days" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Prescribing Doctor</label>
                <input type="text" class="form-control" name="prescribing_doctor_nameorid" required>
              </div>
              <div class="col-12">
                <label class="form-label">Additional Notes</label>
                <textarea class="form-control" name="additional_notes" rows="2" placeholder="Special instructions or notes"></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Prescription Date</label>
                <input type="date" class="form-control" name="prescription_date" value="<?php echo date('Y-m-d'); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Prescription Time</label>
                <input type="time" class="form-control" name="prescription_time" value="<?php echo date('H:i'); ?>" required>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Save Prescription</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Prescription Records -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Prescription Records</h5>

          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Patient ID</th>
                  <th>Consultation ID</th>
                  <th>Medication</th>
                  <th>Dosage</th>
                  <th>Frequency</th>
                  <th>Route</th>
                  <th>Duration</th>
                  <th>Doctor</th>
                  <th>Date & Time</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["prescription_id"] . "</td>";
                    echo "<td>" . $row["patient_id"] . "</td>";
                    echo "<td>" . $row["consultation_id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["medication_name"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["dosage"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["frequency"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["route"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["duration"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["prescribing_doctor_nameorid"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["prescription_datetime"] ?? '') . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='10' class='text-center'>No prescription records found</td></tr>";
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