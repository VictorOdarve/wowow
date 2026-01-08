<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Consultation Form - Step 2 - NiceAdmin</title>
  
  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

  <main id="main" class="main d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
      <div class="pagetitle text-center mb-4">
        <h1>Consultation Form - Step 2</h1>
        <nav>
          <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active">Consultation Step 2</li>
          </ol>
        </nav>
      </div>

      <section class="section">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">Medical Information</h5>

                <form class="row g-3" method="POST" action="">
                  <!-- Chief Complaint -->
                  <div class="col-12">
                    <label for="chiefComplaint" class="form-label">Chief Complaint</label>
                    <textarea class="form-control" id="chiefComplaint" name="chief_complaint" rows="3" required></textarea>
                  </div>

                  <!-- Medical History -->
                  <div class="col-12">
                    <label for="medicalHistory" class="form-label">Medical History</label>
                    <textarea class="form-control" id="medicalHistory" name="medical_history" rows="3"></textarea>
                  </div>

                  <!-- Current Medications -->
                  <div class="col-12">
                    <label for="medications" class="form-label">Current Medications</label>
                    <textarea class="form-control" id="medications" name="medications" rows="2"></textarea>
                  </div>

                  <!-- Allergies -->
                  <div class="col-12">
                    <label for="allergies" class="form-label">Allergies</label>
                    <textarea class="form-control" id="allergies" name="allergies" rows="2"></textarea>
                  </div>

                  <!-- Navigation Buttons -->
                  <div class="text-center">
                    <button type="button" class="btn btn-secondary" onclick="previousPage()">Previous</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>

  <script>
    function previousPage() {
      window.location.href = 'consultation_form.php';
    }
  </script>

</body>
</html>