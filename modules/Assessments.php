<?php
// Assessments.php
$page_title = "Patient Assessments";
require_once '../includes/connection.php';
require_once '../includes/header.php';

$createTable = "CREATE TABLE IF NOT EXISTS `patient_assessment` (
  `assessment_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(255),
  `blood_pressure` varchar(50),
  `body_temp` varchar(50),
  `pulse_rate` varchar(50),
  `respiratory_rate` varchar(50),
  `weight` varchar(50),
  `height` varchar(50),
  `assessment_datetime` datetime,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`assessment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($createTable)) {
    echo "Error creating table: " . $conn->error;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_assessment'])) {
    $patient_id = $_POST['patient_id'];
    $patient_name = $_POST['patient_name'];
    $blood_pressure = $_POST['blood_pressure'];
    $body_temp = $_POST['body_temp'];
    $pulse_rate = $_POST['pulse_rate'];
    $respiratory_rate = $_POST['respiratory_rate'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $assessment_datetime = $_POST['assessment_date'] . ' ' . $_POST['assessment_time'];
    
    $sql = "INSERT INTO patient_assessment (patient_id, patient_name, blood_pressure, body_temp, pulse_rate, respiratory_rate, weight, height, assessment_datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssss", $patient_id, $patient_name, $blood_pressure, $body_temp, $pulse_rate, $respiratory_rate, $weight, $height, $assessment_datetime);
    
    if ($stmt->execute()) {
        echo "<script>alert('Assessment saved successfully!');</script>";
    } else {
        echo "<script>alert('Error saving assessment');</script>";
    }
    $stmt->close();
}

// Fetch assessment records
$sql = "SELECT * FROM patient_assessment ORDER BY assessment_id DESC";
$result = $conn->query($sql);
?>

<div class="pagetitle">
  <h1>Patient Assessments</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
      <li class="breadcrumb-item active">Patient Assessments</li>
    </ol>
  </nav>
</div>

<section class="section">
  <!-- Assessment Form -->
  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">New Assessment</h5>
          
          <form method="POST" action="">
            <input type="hidden" name="save_assessment" value="1">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Patient ID</label>
                <input type="number" class="form-control" name="patient_id" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Patient Name</label>
                <input type="text" class="form-control" name="patient_name" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Blood Pressure</label>
                <input type="text" class="form-control" name="blood_pressure" placeholder="120/80">
              </div>
              <div class="col-md-4">
                <label class="form-label">Body Temperature (°C)</label>
                <input type="text" class="form-control" name="body_temp" placeholder="36.5">
              </div>
              <div class="col-md-4">
                <label class="form-label">Pulse Rate</label>
                <input type="text" class="form-control" name="pulse_rate" placeholder="72">
              </div>
              <div class="col-md-4">
                <label class="form-label">Respiratory Rate</label>
                <input type="text" class="form-control" name="respiratory_rate" placeholder="16">
              </div>
              <div class="col-md-4">
                <label class="form-label">Weight (kg)</label>
                <input type="text" class="form-control" name="weight" placeholder="70">
              </div>
              <div class="col-md-4">
                <label class="form-label">Height (cm)</label>
                <input type="text" class="form-control" name="height" placeholder="170">
              </div>
              <div class="col-md-6">
                <label class="form-label">Assessment Date</label>
                <input type="date" class="form-control" name="assessment_date" value="<?php echo date('Y-m-d'); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Assessment Time</label>
                <input type="time" class="form-control" name="assessment_time" value="<?php echo date('H:i'); ?>" required>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Save Assessment</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Assessment Records -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Assessment Records</h5>

          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Patient ID</th>
                  <th>Patient Name</th>
                  <th>Blood Pressure</th>
                  <th>Body Temperature</th>
                  <th>Pulse Rate</th>
                  <th>Respiratory Rate</th>
                  <th>Weight</th>
                  <th>Height</th>
                  <th>Assessment Date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["assessment_id"] . "</td>";
                    echo "<td>" . $row["patient_id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["patient_name"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["blood_pressure"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["body_temp"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["pulse_rate"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["respiratory_rate"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["weight"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["height"] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row["assessment_datetime"] ?? '') . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='10' class='text-center'>No assessments found</td></tr>";
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