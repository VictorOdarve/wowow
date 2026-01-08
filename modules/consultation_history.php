<?php
// consultation_history.php
$page_title = "Consultation History";
require_once '../includes/connection.php';
require_once '../includes/header.php';

// Fetch consultation history with appointment data
$sql = "SELECT 
    cf.patient_id,
    cf.fname,
    cf.lname,
    cf.dob,
    cf.age,
    cf.gender,
    cf.contact_no,
    cf.barangay,
    cf.city,
    cf.email_address,
    cf.chief_complaint,
    cf.description,
    cf.date_started,
    cf.severerity_level,
    cf.associated_symptoms,
    a.appointment_id,
    a.clinic_location,
    a.schedule_date,
    a.schedule_time,
    a.created_at as appointment_created
FROM consultation_form cf
LEFT JOIN appointments a ON cf.patient_id = a.patient_id
ORDER BY cf.patient_id DESC, a.schedule_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Consultation History - NiceAdmin</title>
  
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
  <h1>Consultation History</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
      <li class="breadcrumb-item active">Consultation History</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Complete Patient Medical History</h5>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Age/Gender</th>
                <th>Contact</th>
                <th>Chief Complaint</th>
                <th>Severity</th>
                <th>Consultation Date</th>
                <th>Appointment Status</th>
                <th>Last Visit</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($result->num_rows > 0) {
                  $current_patient = null;
                  while($row = $result->fetch_assoc()) {
                      // Only show one row per patient (latest record)
                      if ($current_patient != $row["patient_id"]) {
                          $current_patient = $row["patient_id"];
                          
                          echo "<tr>";
                          echo "<td>" . $row["patient_id"] . "</td>";
                          echo "<td>" . $row["fname"] . " " . $row["lname"] . "</td>";
                          echo "<td>" . $row["age"] . " / " . ucfirst($row["gender"]) . "</td>";
                          echo "<td>" . $row["contact_no"] . "</td>";
                          echo "<td>" . ucfirst(str_replace('_', ' ', $row["chief_complaint"])) . "</td>";
                          echo "<td>";
                          $severity = strtolower(trim($row["severerity_level"]));
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
                          if ($row["appointment_id"]) {
                              echo "<span class='badge bg-info'>Scheduled</span>";
                          } else {
                              echo "<span class='badge bg-secondary'>Pending</span>";
                          }
                          echo "</td>";
                          echo "<td>";
                          if ($row["schedule_date"]) {
                              echo $row["schedule_date"] . " " . date('g:i A', strtotime($row["schedule_time"]));
                          } else {
                              echo "No appointment";
                          }
                          echo "</td>";
                          echo "<td>";
                          echo "<button class='btn btn-primary btn-sm' onclick='viewHistory(\"" . $row["patient_id"] . "\")'>View History</button>";
                          echo "</td>";
                          echo "</tr>";
                      }
                  }
              } else {
                  echo "<tr><td colspan='10' class='text-center'>No consultation history found</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- Patient History Modal -->
    <div class="modal fade" id="historyModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Complete Patient History</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" id="historyContent">
            <!-- Patient history will be loaded here -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    function viewHistory(patientId) {
      // Fetch patient history via AJAX
      fetch('get_patient_history.php?patient_id=' + patientId)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            displayPatientHistory(data.patient, data.appointments);
          } else {
            alert('Error loading patient history');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error loading patient history');
        });
    }

    function displayPatientHistory(patient, appointments) {
      let historyContent = `
        <div class="container-fluid">
          <!-- Patient Information Section -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                  <h5 class="mb-0"><i class="bi bi-person-circle"></i> Patient Information</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table table-borderless">
                        <tr><td><strong>Patient ID:</strong></td><td>${patient.patient_id}</td></tr>
                        <tr><td><strong>Full Name:</strong></td><td>${patient.fname} ${patient.lname}</td></tr>
                        <tr><td><strong>Date of Birth:</strong></td><td>${patient.dob}</td></tr>
                        <tr><td><strong>Age:</strong></td><td>${patient.age} years old</td></tr>
                        <tr><td><strong>Gender:</strong></td><td>${patient.gender.charAt(0).toUpperCase() + patient.gender.slice(1)}</td></tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-borderless">
                        <tr><td><strong>Contact Number:</strong></td><td>${patient.contact_no}</td></tr>
                        <tr><td><strong>Email:</strong></td><td>${patient.email_address}</td></tr>
                        <tr><td><strong>Address:</strong></td><td>${patient.barangay}, ${patient.city}</td></tr>
                        <tr><td><strong>Chief Complaint:</strong></td><td>${patient.chief_complaint.replace(/_/g, ' ')}</td></tr>
                        <tr><td><strong>Severity:</strong></td><td><span class="badge bg-${getSeverityColor(patient.severerity_level)}">${patient.severerity_level}</span></td></tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Medical History Section -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="card border-success">
                <div class="card-header bg-success text-white">
                  <h5 class="mb-0"><i class="bi bi-heart-pulse"></i> Medical History</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <h6 class="text-success">Initial Consultation</h6>
                      <p><strong>Date Started:</strong> ${patient.date_started}</p>
                      <p><strong>Description:</strong> ${patient.description || 'N/A'}</p>
                    </div>
                    <div class="col-md-6">
                      <h6 class="text-success">Associated Symptoms</h6>
                      <p>${patient.associated_symptoms || 'None reported'}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Appointments History Section -->
          <div class="row">
            <div class="col-12">
              <div class="card border-info">
                <div class="card-header bg-info text-white">
                  <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Appointments History</h5>
                </div>
                <div class="card-body">
      `;

      if (appointments && appointments.length > 0) {
        historyContent += `
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Appointment ID</th>
                  <th>Clinic Location</th>
                  <th>Schedule Date</th>
                  <th>Schedule Time</th>
                  <th>Status</th>
                  <th>Created</th>
                </tr>
              </thead>
              <tbody>
        `;
        
        appointments.forEach(appointment => {
          historyContent += `
            <tr>
              <td>${appointment.appointment_id}</td>
              <td>${appointment.clinic_location}</td>
              <td>${appointment.schedule_date}</td>
              <td>${formatTime(appointment.schedule_time)}</td>
              <td><span class="badge bg-success">Scheduled</span></td>
              <td>${formatDateTime(appointment.created_at)}</td>
            </tr>
          `;
        });
        
        historyContent += `
              </tbody>
            </table>
          </div>
        `;
      } else {
        historyContent += `
          <div class="text-center py-4">
            <i class="bi bi-calendar-x display-4 text-muted"></i>
            <p class="text-muted mt-2">No appointments scheduled yet</p>
          </div>
        `;
      }

      historyContent += `
                </div>
              </div>
            </div>
          </div>
        </div>
      `;

      document.getElementById('historyContent').innerHTML = historyContent;
      new bootstrap.Modal(document.getElementById('historyModal')).show();
    }

    function getSeverityColor(severity) {
      const level = severity.toLowerCase();
      if (level === 'mild') return 'success';
      if (level === 'moderate') return 'warning';
      if (level === 'severe') return 'danger';
      return 'secondary';
    }

    function formatTime(timeString) {
      const time = new Date('1970-01-01T' + timeString + 'Z');
      return time.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
      });
    }

    function formatDateTime(dateTimeString) {
      const date = new Date(dateTimeString);
      return date.toLocaleDateString('en-US') + ' ' + date.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
      });
    }
  </script>

</body>
</html>

<?php
require_once '../includes/footer.php';
$conn->close();
?>