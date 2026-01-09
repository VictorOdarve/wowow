<?php
// consultation_header.php
if (!isset($page_title)) {
    $page_title = "MediCare Clinic";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - MediCare Clinic</title>
    
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
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            background-color: var(--light-gray);
            min-height: 100vh;
        }
        
        .content-wrapper {
            padding: 30px;
        }
        
        .form-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary-blue);
        }
        
        .form-header h1 {
            color: var(--primary-blue);
            font-weight: 700;
        }
        
        .form-card {
            background: var(--white);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .form-card h5 {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--pale-blue);
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
        }
        
        .btn-submit {
            background: var(--primary-blue);
            border: none;
            color: var(--white);
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            background: var(--light-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(44, 90, 160, 0.2);
        }
        
        .required::after {
            content: " *";
            color: #dc3545;
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
                    <a href="consultation_form.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'consultation_form.php') ? 'active' : ''; ?>">
                        <i class="bi bi-person-plus"></i> New Consultation
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="appointments.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'appointments.php') ? 'active' : ''; ?>">
                        <i class="bi bi-calendar-check"></i> Appointments
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="consultation_history.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'consultation_history.php') ? 'active' : ''; ?>">
                        <i class="bi bi-clipboard-data"></i> Consultation History
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="pending_patient.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'pending_patient.php') ? 'active' : ''; ?>">
                        <i class="bi bi-people"></i> Pending Patients
                    </a>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="quick-stats">
                <h6><i class="bi bi-graph-up me-2"></i>QUICK STATS</h6>
                <?php
                if (isset($conn)) {
                    // Fetch real stats from database
                    $total_patients = 0;
                    $total_appointments = 0;
                    $pending_cases = 0;
                    
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
                    
                    // Pending Cases - patients without appointments
                    $sql3 = "SELECT COUNT(*) as count FROM pending_patient pp LEFT JOIN appointments a ON pp.patient_id = a.patient_id WHERE a.patient_id IS NULL";
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
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="content-wrapper">