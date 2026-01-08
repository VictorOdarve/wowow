<?php
// consultation_form.php
$page_title = "Consultation Form";
require_once '../includes/connection.php';

// Create table with proper auto-increment if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS consultation_form (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(100) NOT NULL,
    lname VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    age INT NOT NULL,
    gender VARCHAR(10) NOT NULL,
    contact_no VARCHAR(15) NOT NULL,
    barangay VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    email_address VARCHAR(150) NOT NULL,
    chief_complaint VARCHAR(255) NOT NULL,
    description TEXT,
    date_started DATE NOT NULL,
    severerity_level VARCHAR(50) NOT NULL,
    associated_symptoms TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) AUTO_INCREMENT=1";
$conn->query($createTable);

require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $dob = $_POST['date_of_birth'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $contact_no = $_POST['contact_number'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $email_address = $_POST['email'];
    $chief_complaint = $_POST['chief_complaint'];
    $description = $_POST['description'];
    $date_started = $_POST['date_started'];
    $severerity_level = $_POST['severity'];
    $associated_symptoms = $_POST['symptoms'];
    
    // Handle "others" specification
    if ($chief_complaint === 'others' && isset($_POST['others_specify'])) {
        $chief_complaint = $_POST['others_specify'];
    }
    
    $sql = "INSERT INTO consultation_form (fname, lname, dob, age, gender, contact_no, barangay, city, email_address, chief_complaint, description, date_started, severerity_level, associated_symptoms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissssssssss", $fname, $lname, $dob, $age, $gender, $contact_no, $barangay, $city, $email_address, $chief_complaint, $description, $date_started, $severerity_level, $associated_symptoms);
    
    if ($stmt->execute()) {
        $patient_id = $conn->insert_id;
        echo "<script>
                alert('Consultation form submitted successfully! Patient ID: ' + $patient_id);
                window.location.href = '../index.php';
              </script>";
    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
    }
    
    $stmt->close();
}
?>

<div class="form-container">
    <!-- Form Header -->
    <div class="form-header">
        <h1><i class="bi bi-file-earmark-medical me-2"></i>Consultation Form</h1>
        <p class="text-muted">Fill out all required fields to register a new patient consultation</p>
    </div>

    <form method="POST" action="">
        <div class="row">
            <!-- Patient Information Card -->
            <div class="col-lg-6">
                <div class="form-card">
                    <h5><i class="bi bi-person-circle me-2"></i>Patient Information</h5>
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <label for="firstName" class="form-label required">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label for="lastName" class="form-label required">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-12">
                            <label for="dateOfBirth" class="form-label required">Date of Birth</label>
                            <input type="date" class="form-control" id="dateOfBirth" name="date_of_birth" required>
                        </div>

                        <!-- Age -->
                        <div class="col-12">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" min="1" max="120" readonly>
                        </div>

                        <!-- Gender -->
                        <div class="col-12">
                            <label for="gender" class="form-label required">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Contact Number -->
                        <div class="col-12">
                            <label for="contactNumber" class="form-label required">Contact Number</label>
                            <input type="tel" class="form-control" id="contactNumber" name="contact_number" 
                                   pattern="[0-9]{10,11}" placeholder="09XXXXXXXXX" required>
                            <small class="text-muted">Format: 09XXXXXXXXX (10-11 digits)</small>
                        </div>

                        <!-- Barangay -->
                        <div class="col-12">
                            <label for="barangay" class="form-label required">Barangay</label>
                            <select class="form-select" id="barangay" name="barangay" required>
                                <option value="">Select Barangay</option>
                                <option value="Agusan">Agusan</option>
                                <option value="Baikingon">Baikingon</option>
                                <option value="Balubal">Balubal</option>
                                <option value="Balulang">Balulang</option>
                                <option value="Bayabas">Bayabas</option>
                                <option value="Bayanga">Bayanga</option>
                                <option value="Besigan">Besigan</option>
                                <option value="Bonbon">Bonbon</option>
                                <option value="Bugo">Bugo</option>
                                <option value="Bulua">Bulua</option>
                                <option value="Camaman‑an">Camaman‑an</option>
                                <option value="Canito‑an">Canito‑an</option>
                                <option value="Carmen">Carmen</option>
                                <option value="Consolacion">Consolacion</option>
                                <option value="Cugman">Cugman</option>
                                <option value="Dansolihon">Dansolihon</option>
                                <option value="F.S. Catanico">F.S. Catanico</option>
                                <option value="Gusa">Gusa</option>
                                <option value="Indahag">Indahag</option>
                                <option value="Iponan">Iponan</option>
                                <option value="Kauswagan">Kauswagan</option>
                                <option value="Lapasan">Lapasan</option>
                                <option value="Lumbia">Lumbia</option>
                                <option value="Macabalan">Macabalan</option>
                                <option value="Macasandig">Macasandig</option>
                                <option value="Mambuaya">Mambuaya</option>
                                <option value="Nazareth">Nazareth</option>
                                <option value="Patag">Patag</option>
                                <option value="Pagalungan">Pagalungan</option>
                                <option value="Pagatpat">Pagatpat</option>
                                <option value="Pigsag‑an">Pigsag‑an</option>
                                <option value="Poblacion">Poblacion</option>
                                <option value="Puerto">Puerto</option>
                                <option value="Puntod">Puntod</option>
                                <option value="San Simon">San Simon</option>
                                <option value="Tablon">Tablon</option>
                                <option value="Taglimao">Taglimao</option>
                                <option value="Tagpangi">Tagpangi</option>
                                <option value="Tignapoloan">Tignapoloan</option>
                                <option value="Tuburan">Tuburan</option>
                                <option value="Tumpagon">Tumpagon</option>
                            </select>
                        </div>

                        <!-- City -->
                        <div class="col-12">
                            <label for="city" class="form-label required">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="Cagayan de Oro" required>
                        </div>

                        <!-- Email Address -->
                        <div class="col-12">
                            <label for="email" class="form-label required">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="patient@example.com" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Information Card -->
            <div class="col-lg-6">
                <div class="form-card">
                    <h5><i class="bi bi-heart-pulse me-2"></i>Medical Information</h5>
                    <div class="row g-3">
                        <!-- Chief Complaint -->
                        <div class="col-12">
                            <label for="chiefComplaint" class="form-label required">Chief Complaint</label>
                            <select class="form-select" id="chiefComplaint" name="chief_complaint" required onchange="toggleOthersField()">
                                <option value="">Select Chief Complaint</option>
                                <option value="fever">Fever</option>
                                <option value="headache">Headache</option>
                                <option value="cough">Cough</option>
                                <option value="colds">Colds / Runny nose</option>
                                <option value="sore_throat">Sore throat</option>
                                <option value="body_pain">Body pain</option>
                                <option value="stomach_ache">Stomach ache</option>
                                <option value="diarrhea">Diarrhea</option>
                                <option value="vomiting">Vomiting</option>
                                <option value="dizziness">Dizziness</option>
                                <option value="chest_pain">Chest pain</option>
                                <option value="shortness_breath">Shortness of breath</option>
                                <option value="fatigue">Fatigue / Weakness</option>
                                <option value="skin_rash">Skin rash / itchiness</option>
                                <option value="wound">Wound / injury</option>
                                <option value="toothache">Toothache</option>
                                <option value="back_pain">Back pain</option>
                                <option value="high_bp">High blood pressure</option>
                                <option value="follow_up">Follow-up check</option>
                                <option value="others">Others (please specify)</option>
                            </select>
                        </div>
                        
                        <div class="col-12" id="othersField" style="display: none;">
                            <label for="othersSpecify" class="form-label">Specify Other Complaint</label>
                            <input type="text" class="form-control" id="othersSpecify" name="others_specify" placeholder="Please specify...">
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label required">Description of Concern</label>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                      placeholder="Describe what the patient feels, symptoms duration, and any relevant details..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label for="dateStarted" class="form-label required">Date Symptoms Started</label>
                            <input type="date" class="form-control" id="dateStarted" name="date_started" required>
                        </div>
                        <div class="col-12">
                            <label for="severity" class="form-label required">Severity Level</label>
                            <select class="form-select" id="severity" name="severity" required>
                                <option value="">Select Severity</option>
                                <option value="Mild">Mild</option>
                                <option value="Moderate">Moderate</option>
                                <option value="Severe">Severe</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="symptoms" class="form-label">Associated Symptoms</label>
                            <textarea class="form-control" id="symptoms" name="symptoms" rows="3" 
                                      placeholder="List any other symptoms the patient is experiencing..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-submit me-3">
                <i class="bi bi-check-circle me-2"></i>Submit Consultation
            </button>
            <button type="reset" class="btn btn-light me-3">
                <i class="bi bi-x-circle me-2"></i>Reset Form
            </button>
            <a href="../index.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById('dateOfBirth').addEventListener('change', function() {
        const birthDate = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        document.getElementById('age').value = age;
    });
    function toggleOthersField() {
        const chiefComplaint = document.getElementById('chiefComplaint');
        const othersField = document.getElementById('othersField');
        const othersSpecify = document.getElementById('othersSpecify');
        
        if (chiefComplaint.value === 'others') {
            othersField.style.display = 'block';
            othersSpecify.required = true;
        } else {
            othersField.style.display = 'none';
            othersSpecify.required = false;
            othersSpecify.value = '';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('dateStarted').value = today;
        const maxBirthDate = new Date();
        maxBirthDate.setFullYear(maxBirthDate.getFullYear());
        document.getElementById('dateOfBirth').max = maxBirthDate.toISOString().split('T')[0];
        document.getElementById('dateStarted').max = today;
    });
</script>

<?php
require_once '../includes/footer.php';
?>