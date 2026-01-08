<?php
// pending_patient.php
$page_title = "Pending Patients";
require_once '../includes/connection.php';
require_once '../includes/header.php';

// Create pending_patient table if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS pending_patient (
    patient_id INT PRIMARY KEY,
    patient_name VARCHAR(255),
    age INT,
    gender VARCHAR(50),
    complete_address TEXT,
    chief_complaint VARCHAR(255),
    severity VARCHAR(50),
    date_started DATE,
    action VARCHAR(50) DEFAULT 'Pending'
)";
$conn->query($createTable);

// Handle appointment saving
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_appointment'])) {
    $patient_id = $_POST['patient_id'];
    $patient_name = $_POST['patient_name'];
    $chief_complaint = $_POST['chief_complaint'];
    $description = $_POST['description'];
    $email = $_POST['email'];
    $clinic_location = $_POST['clinic_location'];
    $schedule_date = $_POST['schedule_date'];
    $schedule_time = $_POST['schedule_time'];
    
    // Create appointments table if it doesn't exist
    $create_table = "CREATE TABLE IF NOT EXISTS appointments (
        appointment_id INT AUTO_INCREMENT PRIMARY KEY,
        patient_id INT,
        patient_name VARCHAR(255),
        chief_complaint VARCHAR(255),
        description TEXT,
        email VARCHAR(255),
        clinic_location VARCHAR(255),
        schedule_date DATE,
        schedule_time TIME,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($create_table);
    
    $sql = "INSERT INTO appointments (patient_id, patient_name, chief_complaint, description, email, clinic_location, schedule_date, schedule_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssss", $patient_id, $patient_name, $chief_complaint, $description, $email, $clinic_location, $schedule_date, $schedule_time);
    
    if ($stmt->execute()) {
        echo "<script>alert('Appointment scheduled successfully!');</script>";
    } else {
        echo "<script>alert('Error scheduling appointment');</script>";
    }
    $stmt->close();
}

// Fetch all consultation data with proper field selection
$sql = "SELECT 
    cf.patient_id,
    CONCAT(cf.fname, ' ', cf.lname) as patient_name,
    cf.age,
    cf.gender,
    cf.contact_no,
    CONCAT(cf.barangay, ', ', cf.city) as complete_address,
    cf.chief_complaint,
    cf.severerity_level as severity,
    cf.date_started,
    cf.dob,
    cf.description,
    cf.associated_symptoms,
    cf.email_address,
    'Pending' as action
FROM consultation_form cf
LEFT JOIN pending_patient pp ON cf.patient_id = pp.patient_id
WHERE pp.patient_id IS NULL
ORDER BY cf.patient_id DESC";

$result = $conn->query($sql);

// Insert into pending_patient table if not exists
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $insert_sql = "INSERT IGNORE INTO pending_patient (patient_id, patient_name, age, gender, complete_address, chief_complaint, severity, date_started, action) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("isissssss", $row['patient_id'], $row['patient_name'], $row['age'], $row['gender'], $row['complete_address'], $row['chief_complaint'], $row['severity'], $row['date_started'], $row['action']);
        $stmt->execute();
        $stmt->close();
    }
}

// Now fetch from both tables with proper JOIN to get all needed data and check appointment status
$sql = "SELECT 
    pp.*,
    COALESCE(cf.contact_no, '') as contact_no,
    COALESCE(cf.dob, '') as dob,
    COALESCE(cf.description, '') as description,
    COALESCE(cf.associated_symptoms, '') as associated_symptoms,
    COALESCE(cf.email_address, '') as email_address,
    CASE WHEN a.patient_id IS NOT NULL THEN 'Scheduled' ELSE 'Pending' END as status
FROM pending_patient pp
LEFT JOIN consultation_form cf ON pp.patient_id = cf.patient_id
LEFT JOIN appointments a ON pp.patient_id = a.patient_id
ORDER BY pp.patient_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pending Patients - NiceAdmin</title>
  
  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Pending Patients</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
          <li class="breadcrumb-item active">Pending Patients</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Patient Consultation Records</h5>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Chief Complaint</th>
                    <th>Severity</th>
                    <th>Date Started</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          echo "<td>" . $row["patient_id"] . "</td>";
                          echo "<td>" . $row["patient_name"] . "</td>";
                          echo "<td>" . $row["age"] . "</td>";
                          echo "<td>" . ucfirst($row["gender"]) . "</td>";
                          echo "<td>" . ($row["contact_no"] ?? '') . "</td>";
                          echo "<td>" . $row["complete_address"] . "</td>";
                          echo "<td>" . ucfirst(str_replace('_', ' ', $row["chief_complaint"])) . "</td>";
                          echo "<td>";
                          $severity = strtolower(trim($row["severity"]));
                          if ($severity == 'mild') {
                              echo "<span class='badge bg-success'>Mild</span>";
                          } elseif ($severity == 'moderate') {
                              echo "<span class='badge bg-warning text-dark'>Moderate</span>";
                          } elseif ($severity == 'severe') {
                              echo "<span class='badge bg-danger'>Severe</span>";
                          } else {
                              echo "<span class='badge bg-secondary'>" . ucfirst($severity) . "</span>";
                          }
                          echo "</td>";
                          echo "<td>" . $row["date_started"] . "</td>";
                          echo "<td>";
                          if ($row["status"] == 'Scheduled') {
                              echo "<span class='badge bg-info'>Scheduled</span>";
                          } else {
                              echo "<button class='btn btn-primary btn-sm' onclick='viewPatient(\"" . $row["patient_id"] . "\", \"" . addslashes($row["patient_name"]) . "\", \"" . ($row["dob"] ?? 'N/A') . "\", \"" . $row["age"] . "\", \"" . $row["gender"] . "\", \"" . addslashes(str_replace('_', ' ', $row["chief_complaint"])) . "\", \"" . addslashes($row["description"] ?? 'N/A') . "\", \"" . $row["date_started"] . "\", \"" . addslashes($row["severity"]) . "\", \"" . addslashes($row["associated_symptoms"] ?? 'N/A') . "\")'>View</button> ";
                              echo "<button class='btn btn-success btn-sm' onclick='setSchedule(\"" . $row["patient_id"] . "\", \"" . addslashes($row["patient_name"]) . "\", \"" . addslashes(str_replace('_', ' ', $row["chief_complaint"])) . "\", \"" . addslashes($row["email_address"] ?? 'N/A') . "\", \"" . addslashes($row["description"] ?? 'N/A') . "\")'>Set Schedule</button>";
                          }
                          echo "</td>";
                          echo "</tr>";
                      }
                  } else {
                      echo "<tr><td colspan='10' class='text-center'>No pending patients found</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Patient Details Modal -->
    <div class="modal fade" id="patientModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Patient Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" id="modalContent">
            <!-- Patient details will be loaded here -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Schedule Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Set Schedule</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" id="scheduleContent">
            <!-- Schedule form will be loaded here -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" form="scheduleForm">Save Schedule</button>
          </div>
        </div>
      </div>
    </div>

  </main>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

  <script>
    function setSchedule(patientId, patientName, chiefComplaint, email, description) {
      const scheduleContent = `
        <form id="scheduleForm" method="POST" action="">
          <input type="hidden" name="save_appointment" value="1">
          <input type="hidden" name="patient_id" value="${patientId}">
          <input type="hidden" name="patient_name" value="${patientName}">
          <input type="hidden" name="chief_complaint" value="${chiefComplaint}">
          <input type="hidden" name="description" value="${description}">
          <input type="hidden" name="email" value="${email}">
          <div class="mb-3">
            <label class="form-label"><strong>Patient ID:</strong></label>
            <input type="text" class="form-control" value="${patientId}" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Patient Name:</strong></label>
            <input type="text" class="form-control" value="${patientName}" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Chief Complaint:</strong></label>
            <input type="text" class="form-control" value="${chiefComplaint}" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Description:</strong></label>
            <textarea class="form-control" rows="3" readonly>${description || 'N/A'}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Email:</strong></label>
            <input type="email" class="form-control" value="${email}" readonly>
          </div>
          <div class="mb-3">
            <label for="clinicLocation" class="form-label"><strong>Clinic's Location:</strong></label>
            <input type="text" class="form-control" name="clinic_location" required>
          </div>
          <div class="mb-3">
            <label for="scheduleDate" class="form-label"><strong>Schedule Date:</strong></label>
            <input type="date" class="form-control" name="schedule_date" required>
          </div>
          <div class="mb-3">
            <label for="scheduleTime" class="form-label"><strong>Schedule Time:</strong></label>
            <input type="time" class="form-control" name="schedule_time" required>
          </div>
        </form>
      `;
      
      document.getElementById('scheduleContent').innerHTML = scheduleContent;
      new bootstrap.Modal(document.getElementById('scheduleModal')).show();
    }

    function viewPatient(patientId, fullName, dob, age, gender, complaint, description, dateStarted, severity, symptoms) {
      const modalContent = `
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card border-0">
                <div class="card-header bg-primary text-white">
                  <h5 class="mb-0"><i class="bi bi-person-circle"></i> ${fullName} (ID: ${patientId})</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <h6 class="text-primary mb-3"><i class="bi bi-person-lines-fill"></i> Personal Information</h6>
                      <table class="table table-borderless">
                        <tr><td><strong>Patient ID:</strong></td><td>${patientId}</td></tr>
                        <tr><td><strong>Full Name:</strong></td><td>${fullName}</td></tr>
                        <tr><td><strong>Date of Birth:</strong></td><td>${dob}</td></tr>
                        <tr><td><strong>Age:</strong></td><td>${age} years old</td></tr>
                        <tr><td><strong>Gender:</strong></td><td>${gender.charAt(0).toUpperCase() + gender.slice(1)}</td></tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <h6 class="text-primary mb-3"><i class="bi bi-heart-pulse"></i> Medical Information</h6>
                      <table class="table table-borderless">
                        <tr><td><strong>Chief Complaint:</strong></td><td>${complaint.charAt(0).toUpperCase() + complaint.slice(1)}</td></tr>
                        <tr><td><strong>Description:</strong></td><td>${description || 'N/A'}</td></tr>
                        <tr><td><strong>Date Started:</strong></td><td>${dateStarted}</td></tr>
                        <tr><td><strong>Severity:</strong></td><td>${severity.charAt(0).toUpperCase() + severity.slice(1)}</td></tr>
                        <tr><td><strong>Associated Symptoms:</strong></td><td>${symptoms || 'None reported'}</td></tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      `;
      
      document.getElementById('modalContent').innerHTML = modalContent;
      new bootstrap.Modal(document.getElementById('patientModal')).show();
    }
  </script>

</body>
</html>

<?php
require_once '../includes/footer.php';
$conn->close();
?>