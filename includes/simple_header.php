<?php
// simple_header.php
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
            padding: 20px;
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