<!-- Sidebar -->
<div class="sidebar">
    <!-- Logo -->
    <div class="logo">
        <h3><i class="bi bi-hospital me-2"></i>MediCare Clinic</h3>
        <small>Patient Management System</small>
    </div>
    
    <!-- Main Navigation -->
    <nav class="nav flex-column mt-4">
        <a class="nav-link" href="pending_patient.php">
            <i class="bi bi-person-plus"></i> New Consultation
        </a>

        <a class="nav-link" href="appointments.php">
            <i class="bi bi-calendar-check"></i> Appointments
            <span class="badge bg-danger float-end mt-1">3</span>
        </a>

        <a class="nav-link" href="consultation.php">
            <i class="bi bi-clipboard-data"></i> Consultation History
        </a>
    </nav>
    
    <!-- Quick Stats -->
    <div class="quick-stats">
        <h6 class="mb-3"><i class="bi bi-graph-up me-2"></i>QUICK STATS</h6>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Total Patients</span>
            <strong class="text-primary">127</strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Today's Appointments</span>
            <strong class="text-primary">8</strong>
        </div>
        <div class="d-flex justify-content-between">
            <span class="text-muted">Pending Cases</span>
            <strong class="text-warning">12</strong>
        </div>
    </div>
    
    <!-- Doctor Profile -->
    <div class="doctor-profile">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary p-2 me-3">
                <i class="bi bi-person-fill text-white" style="font-size: 20px;"></i>
            </div>
            <div>
                <div class="fw-bold">Dr. Sarah Johnson</div>
                <small class="text-muted">General Practitioner</small>
            </div>
        </div>
        <div class="mt-3 text-center">
            <button class="btn btn-outline-primary btn-sm w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </div>
    </div>
</div>