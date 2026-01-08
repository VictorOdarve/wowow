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
                          echo "<button class='btn btn-primary btn-sm' onclick='viewHistory(" . $row["patient_id"] . ")'>View History</button>";
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function viewHistory(patientId) {
  fetch('get_patient_history.php?patient_id=' + patientId)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        displayPatientHistory(data.patient, data.assessments, data.diagnoses, data.prescriptions, data.appointments);
      } else {
        alert('Error loading patient history');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error loading patient history');
    });
}

function displayPatientHistory(patient, assessments, diagnoses, prescriptions, appointments) {
  let historyContent = `
    <div class="container-fluid">
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
                    <tr><td><strong>Age:</strong></td><td>${patient.age} years old</td></tr>
                    <tr><td><strong>Gender:</strong></td><td>${patient.gender}</td></tr>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table table-borderless">
                    <tr><td><strong>Contact:</strong></td><td>${patient.contact_no}</td></tr>
                    <tr><td><strong>Email:</strong></td><td>${patient.email_address}</td></tr>
                    <tr><td><strong>Address:</strong></td><td>${patient.barangay}, ${patient.city}</td></tr>
                    <tr><td><strong>Chief Complaint:</strong></td><td>${patient.chief_complaint}</td></tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-secondary">
            <div class="card-header bg-secondary text-white">
              <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Appointment Schedule</h5>
            </div>
            <div class="card-body">
              ${appointments && appointments.length > 0 ? appointments.map(appointment => `
                <div class="mb-3 p-3 border rounded">
                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>Appointment ID:</strong> ${appointment.appointment_id}</p>
                      <p><strong>Clinic Location:</strong> ${appointment.clinic_location}</p>
                    </div>
                    <div class="col-md-6">
                      <p><strong>Schedule Date:</strong> ${appointment.schedule_date}</p>
                      <p><strong>Schedule Time:</strong> ${new Date('1970-01-01T' + appointment.schedule_time).toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true})}</p>
                    </div>
                  </div>
                </div>
              `).join('') : '<p>No appointment records found.</p>'}
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-info">
            <div class="card-header bg-info text-white">
              <h5 class="mb-0"><i class="bi bi-clipboard-pulse"></i> Assessment History</h5>
            </div>
            <div class="card-body">
              ${assessments.length > 0 ? assessments.map(assessment => `
                <div class="mb-3 p-3 border rounded">
                  <h6>Assessment - ${assessment.assessment_datetime}</h6>
                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>Blood Pressure:</strong> ${assessment.blood_pressure}</p>
                      <p><strong>Body Temperature:</strong> ${assessment.body_temp}°C</p>
                      <p><strong>Pulse Rate:</strong> ${assessment.pulse_rate} bpm</p>
                    </div>
                    <div class="col-md-6">
                      <p><strong>Respiratory Rate:</strong> ${assessment.respiratory_rate}/min</p>
                      <p><strong>Weight:</strong> ${assessment.weight} kg</p>
                      <p><strong>Height:</strong> ${assessment.height} cm</p>
                    </div>
                  </div>
                </div>
              `).join('') : '<p>No assessment records found.</p>'}
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
              <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Diagnosis History</h5>
            </div>
            <div class="card-body">
              ${diagnoses.length > 0 ? diagnoses.map(diagnosis => `
                <div class="mb-3 p-3 border rounded">
                  <h6>Diagnosis - ${diagnosis.diagnosis_dateandtime}</h6>
                  <p><strong>Doctor:</strong> ${diagnosis.doctor_nameorid}</p>
                  <p><strong>Diagnosis:</strong> ${diagnosis.diagnosis}</p>
                  <p><strong>Clinical Findings:</strong> ${diagnosis.clinical_findings}</p>
                  <p><strong>Treatment Plan:</strong> ${diagnosis.treatment_plan}</p>
                  <p><strong>Recommended Tests:</strong> ${diagnosis.recommended_test}</p>
                  <p><strong>Notes:</strong> ${diagnosis.notes}</p>
                </div>
              `).join('') : '<p>No diagnosis records found.</p>'}
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-success">
            <div class="card-header bg-success text-white">
              <h5 class="mb-0"><i class="bi bi-prescription2"></i> Prescription History</h5>
            </div>
            <div class="card-body">
              ${prescriptions.length > 0 ? prescriptions.map(prescription => `
                <div class="mb-3 p-3 border rounded">
                  <h6>Prescription - ${prescription.prescription_datetime}</h6>
                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>Medication:</strong> ${prescription.medication_name}</p>
                      <p><strong>Dosage:</strong> ${prescription.dosage}</p>
                      <p><strong>Frequency:</strong> ${prescription.frequency}</p>
                    </div>
                    <div class="col-md-6">
                      <p><strong>Route:</strong> ${prescription.route}</p>
                      <p><strong>Duration:</strong> ${prescription.duration}</p>
                      <p><strong>Doctor:</strong> ${prescription.prescribing_doctor_nameorid}</p>
                    </div>
                  </div>
                  ${prescription.additional_notes ? `<p><strong>Notes:</strong> ${prescription.additional_notes}</p>` : ''}
                </div>
              `).join('') : '<p>No prescription records found.</p>'}
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  
  document.getElementById('historyContent').innerHTML = historyContent;
  new bootstrap.Modal(document.getElementById('historyModal')).show();
}
</script>

<?php
require_once '../includes/footer.php';
$conn->close();
?>