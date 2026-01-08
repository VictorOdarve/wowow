<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinic_consultationdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Don't die, just show error in development
    // die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare Clinic - Dashboard</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #2c5aa0;
            --light-blue: #4a7bc8;
            --pale-blue: #e8f0fe;
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --text-dark: #2c3e50;
            --border-color: #dee2e6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fb;
            margin: 0;
            padding: 0;
        }
        
        .app-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--white);
            border-right: 1px solid var(--border-color);
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .logo-area {
            padding: 25px;
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            text-align: center;
        }
        
        .logo-area h3 {
            margin: 0;
            font-weight: 700;
        }
        
        .logo-area small {
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .nav-menu {
            padding: 20px 0;
        }
        
        .nav-item {
            padding: 0 15px;
            margin-bottom: 5px;
        }
        
        .nav-link {
            padding: 12px 15px;
            color: var(--text-dark);
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: var(--pale-blue);
            color: var(--primary-blue);
        }
        
        .nav-link i {
            width: 24px;
            margin-right: 10px;
            font-size: 18px;
        }
        
        .badge-notification {
            background: #dc3545;
            color: white;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.75rem;
            margin-left: auto;
        }
        
        .quick-stats {
            padding: 20px;
            margin: 20px 15px;
            background: var(--light-gray);
            border-radius: 10px;
            border: 1px solid var(--border-color);
        }
        
        .quick-stats h6 {
            color: var(--primary-blue);
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .stat-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        
        .doctor-profile {
            padding: 20px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
            background-color: var(--light-gray);
            min-height: 100vh;
        }
        
        .dashboard-header {
            background: var(--white);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid var(--primary-blue);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .service-card {
            background: var(--white);
            border-radius: 12px;
            padding: 25px;
            height: 100%;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            transition: all 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            border-color: var(--primary-blue);
        }
        
        .service-icon {
            width: 60px;
            height: 60px;
            background: var(--pale-blue);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--primary-blue);
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: var(--white);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        
        .btn-custom {
            background: var(--primary-blue);
            border: none;
            color: var(--white);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Logo -->
            <div class="logo-area">
                <h3><i class="bi bi-hospital me-2"></i>MediCare Clinic</h3>
                <small>Patient Management System</small>
            </div>
            
<!-- Navigation Menu -->
<div class="nav-menu">
    <div class="nav-item">
        <a href="index.php" class="nav-link active">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </div>
    
    <div class="nav-item">
        <a href="modules/consultation_form.php" class="nav-link">
            <i class="bi bi-person-plus"></i> New Consultation
        </a>
    </div>
    
    <div class="nav-item">
        <a href="modules/appointments.php" class="nav-link">
            <i class="bi bi-calendar-check"></i> Appointments
            <?php
            // Count today's appointments
            $today_count = 0;
            if ($conn) {
                $sql = "SELECT COUNT(*) as count FROM appointments WHERE schedule_date = CURDATE()";
                $result = $conn->query($sql);
                if ($result) {
                    $row = $result->fetch_assoc();
                    $today_count = $row['count'];
                }
            }
            if ($today_count > 0): ?>
            <span class="badge-notification"><?php echo $today_count; ?></span>
            <?php endif; ?>
        </a>
    </div>
    
    <div class="nav-item">
        <a href="modules/consultation_history.php" class="nav-link">
            <i class="bi bi-clipboard-data"></i> Consultation History
        </a>
    </div>
    <div class="nav-item">
        <a href="modules/pending_patient.php" class="nav-link">
            <i class="bi bi-people"></i> Pending Patients
        </a>
    </div>
</div>
                
                <div class="nav-item">
                    <a href="modules/consultation_history.php" class="nav-link">
                        <i class="bi bi-clipboard-data"></i> Consultation History
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="modules/patients.php" class="nav-link">
                        <i class="bi bi-people"></i> All Patients
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="modules/reports.php" class="nav-link">
                        <i class="bi bi-bar-chart"></i> Reports
                    </a>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="quick-stats">
                <h6><i class="bi bi-graph-up me-2"></i>QUICK STATS</h6>
                <?php
                // Fetch real stats from database
                $total_patients = 0;
                $total_appointments = 0;
                $pending_cases = 0;
                
                if ($conn) {
                    // Total Patients
                    $sql1 = "SELECT COUNT(*) as count FROM consultation_form";
                    $result1 = $conn->query($sql1);
                    if ($result1) {
                        $row1 = $result1->fetch_assoc();
                        $total_patients = $row1['count'];
                    }
                    
                    // Total Appointments
                    $sql2 = "SELECT COUNT(*) as count FROM appointments";
                    $result2 = $conn->query($sql2);
                    if ($result2) {
                        $row2 = $result2->fetch_assoc();
                        $total_appointments = $row2['count'];
                    }
                    
                    // Pending Cases (appointments with status Scheduled)
                    $sql3 = "SELECT COUNT(*) as count FROM appointments WHERE status = 'Scheduled'";
                    $result3 = $conn->query($sql3);
                    if ($result3) {
                        $row3 = $result3->fetch_assoc();
                        $pending_cases = $row3['count'];
                    }
                }
                ?>
                
                <div class="stat-item">
                    <span>Total Patients</span>
                    <strong><?php echo $total_patients; ?></strong>
                </div>
                <div class="stat-item">
                    <span>Total Appointments</span>
                    <strong><?php echo $total_appointments; ?></strong>
                </div>
                <div class="stat-item">
                    <span>Pending Cases</span>
                    <strong class="text-warning"><?php echo $pending_cases; ?></strong>
                </div>
            </div>
            
            <!-- Doctor Profile -->
            <div class="doctor-profile">
                <div class="mb-3">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-person-fill text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
                <div class="fw-bold">Dr. Sarah Johnson</div>
                <small class="text-muted">General Practitioner</small>
                <div class="mt-3">
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="mb-2">Clinic Dashboard</h1>
                        <p class="text-muted mb-0">
                            <i class="bi bi-calendar-check me-1"></i>
                            <?php echo date('l, F j, Y'); ?>
                            <span class="mx-2">•</span>
                            <i class="bi bi-clock me-1"></i>
                            <span id="currentTime"><?php echo date('h:i A'); ?></span>
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="modules/pending_patient.php" class="btn btn-custom">
                            <i class="bi bi-plus-circle me-1"></i> New Appointment
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Service Cards -->
            <h4 class="mb-4 text-primary">Clinic Services</h4>
            <div class="row mb-5">
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h5 class="mb-3">Consultation</h5>
                        <p class="text-muted small mb-4">Patient medical evaluation and assessment</p>
                        <a href="modules/pending_patient.php" class="btn btn-custom w-100">
                            <i class="bi bi-person-plus me-1"></i> New Consultation
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h5 class="mb-3">Appointments</h5>
                        <p class="text-muted small mb-4">Schedule and manage patient appointments</p>
                        <a href="modules/appointments.php" class="btn btn-custom w-100">
                            <i class="bi bi-calendar-check me-1"></i> View Appointments
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-file-medical"></i>
                        </div>
                        <h5 class="mb-3">Diagnosis</h5>
                        <p class="text-muted small mb-4">Patient diagnosis and treatment planning</p>
                        <a href="modules/diagnosis.php" class="btn btn-custom w-100">
                            <i class="bi bi-file-medical me-1"></i> View Diagnosis
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-prescription"></i>
                        </div>
                        <h5 class="mb-3">Prescriptions</h5>
                        <p class="text-muted small mb-4">Medication and treatment prescriptions</p>
                        <a href="modules/prescription.php" class="btn btn-custom w-100">
                            <i class="bi bi-prescription me-1"></i> View Prescriptions
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <h4 class="mb-4 text-primary">Clinic Statistics</h4>
            <div class="row mb-5">
                <!-- Total Patients -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Patients</h6>
                                <h2 class="mb-0 text-primary"><?php echo $total_patients; ?></h2>
                                <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 0.75rem;">
                                    +5 this week
                                </span>
                            </div>
                            <div class="service-icon" style="width: 50px; height: 50px; font-size: 22px;">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Appointments -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Appointments</h6>
                                <h2 class="mb-0 text-primary"><?php echo $total_appointments; ?></h2>
                                <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.75rem;">
                                    +12 this month
                                </span>
                            </div>
                            <div class="service-icon" style="width: 50px; height: 50px; font-size: 22px;">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Appointments -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Today's Appointments</h6>
                                <h2 class="mb-0 text-primary"><?php echo $today_count; ?></h2>
                                <span class="badge bg-warning bg-opacity-10 text-warning" style="font-size: 0.75rem;">
                                    <?php echo $pending_cases; ?> pending
                                </span>
                            </div>
                            <div class="service-icon" style="width: 50px; height: 50px; font-size: 22px;">
                                <i class="bi bi-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Monthly Revenue</h6>
                                <h2 class="mb-0 text-primary">₱64,500</h2>
                                <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.75rem;">
                                    +15% growth
                                </span>
                            </div>
                            <div class="service-icon" style="width: 50px; height: 50px; font-size: 22px;">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="row">
                <!-- Recent Consultations -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 text-primary">Recent Consultations</h5>
                            <a href="modules/consultation_history.php" class="text-primary small">View All</a>
                        </div>
                        <?php
                        $recent_consultations = [];
                        if ($conn) {
                            $sql = "SELECT patient_id, fname, lname, chief_complaint, severerity_level, date_started 
                                    FROM consultation_form 
                                    ORDER BY patient_id DESC 
                                    LIMIT 3";
                            $result = $conn->query($sql);
                            if ($result) {
                                while($row = $result->fetch_assoc()) {
                                    $recent_consultations[] = $row;
                                }
                            }
                        }
                        ?>
                        
                        <?php if (!empty($recent_consultations)): ?>
                        <div class="list-group">
                            <?php foreach($recent_consultations as $consult): ?>
                            <div class="list-group-item border-0 px-0 py-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1"><?php echo htmlspecialchars($consult['fname'] . ' ' . $consult['lname']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($consult['chief_complaint']); ?></small>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted"><?php echo $consult['date_started']; ?></small><br>
                                        <?php
                                        $severity = strtolower($consult['severerity_level']);
                                        $badge_color = $severity == 'mild' ? 'success' : ($severity == 'moderate' ? 'warning' : 'danger');
                                        ?>
                                        <span class="badge bg-<?php echo $badge_color; ?>"><?php echo $consult['severerity_level']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p class="text-muted text-center py-3">No recent consultations</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Upcoming Appointments -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 text-primary">Upcoming Appointments</h5>
                            <a href="modules/appointments.php" class="text-primary small">View All</a>
                        </div>
                        <?php
                        $upcoming_appointments = [];
                        if ($conn) {
                            $sql = "SELECT appointment_id, patient_name, clinic_location, schedule_date, schedule_time 
                                    FROM appointments 
                                    WHERE schedule_date >= CURDATE() 
                                    ORDER BY schedule_date, schedule_time 
                                    LIMIT 3";
                            $result = $conn->query($sql);
                            if ($result) {
                                while($row = $result->fetch_assoc()) {
                                    $upcoming_appointments[] = $row;
                                }
                            }
                        }
                        ?>
                        
                        <?php if (!empty($upcoming_appointments)): ?>
                        <div class="list-group">
                            <?php foreach($upcoming_appointments as $appt): ?>
                            <div class="list-group-item border-0 px-0 py-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1"><?php echo htmlspecialchars($appt['patient_name']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($appt['clinic_location']); ?></small>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">
                                            <?php echo $appt['schedule_date']; ?><br>
                                            <?php echo date('g:i A', strtotime($appt['schedule_time'])); ?>
                                        </small><br>
                                        <span class="badge bg-primary">Scheduled</span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p class="text-muted text-center py-3">No upcoming appointments</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Update time every second
        function updateTime() {
            const now = new Date();
            const timeElement = document.getElementById('currentTime');
            if (timeElement) {
                timeElement.textContent = now.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });
            }
        }
        
        setInterval(updateTime, 1000);
        
        // Navigation highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                // Remove active class from all
                link.classList.remove('active');
                
                // Check if this link matches current page
                if (currentPath.includes(href) || 
                    (currentPath.endsWith('index.php') && href === 'index.php')) {
                    link.classList.add('active');
                }
            });
            
            // Highlight dashboard on index.php
            if (currentPath.endsWith('index.php') || currentPath.endsWith('/')) {
                document.querySelector('a[href="index.php"]').classList.add('active');
            }
        });
    </script>
    
    <?php
    // Close database connection
    if ($conn) {
        $conn->close();
    }
    ?>
</body>
</html>