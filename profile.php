<?php 
session_start();
include('database.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Employee - Employee Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #166088;
            --accent-color: #17a2b8;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --header-height: 70px;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #333;
            overflow-x: hidden;
        }
        
        /* Layout */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            position: fixed;
            height: 100vh;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-header {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }
        
        .sidebar-header .logo i {
            font-size: 1.8rem;
        }
        
        .sidebar.collapsed .logo-text {
            display: none;
        }
        
        .sidebar.collapsed .logo i {
            font-size: 2rem;
        }
        
        .sidebar-menu {
            padding: 20px 0;
            overflow-y: auto;
            height: calc(100vh - var(--header-height));
        }
        
        .nav-item {
            position: relative;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            border-left: 3px solid transparent;
            text-decoration: none;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent-color);
        }
        
        .nav-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        .sidebar.collapsed .nav-text {
            display: none;
        }
        
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 15px 0;
        }
        
        /* Main Content */
        .main {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
        }
        
        .sidebar.collapsed ~ .main {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Top Header */
        .top-header {
            height: var(--header-height);
            background-color: white;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .toggle-sidebar {
            background: none;
            border: none;
            color: var(--dark-color);
            font-size: 1.3rem;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .toggle-sidebar:hover {
            color: var(--primary-color);
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-btn {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--dark-color);
            position: relative;
            cursor: pointer;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        /* Content Area */
        .content {
            padding: 25px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title h1 {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
        }
        
        .page-title p {
            color: #6c757d;
            margin-bottom: 0;
        }
        
        /* Form Styling */
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .form-section {
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eee;
        }
        
        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            font-size: 1.1rem;
        }
        
        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
        }
        
        .form-label.required:after {
            content: " *";
            color: var(--danger-color);
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: var(--transition);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(74, 111, 165, 0.25);
        }
        
        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        /* File Upload Styling */
        .file-upload-container {
            margin-top: 10px;
        }
        
        .file-upload-area {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background-color: #f9f9f9;
        }
        
        .file-upload-area:hover {
            border-color: var(--primary-color);
            background-color: #f0f7ff;
        }
        
        .file-upload-area.drag-over {
            border-color: var(--primary-color);
            background-color: #e8f4ff;
        }
        
        .file-upload-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .file-upload-text {
            margin-bottom: 10px;
            color: #555;
        }
        
        .file-upload-text span {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .file-upload-info {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .file-preview {
            margin-top: 20px;
        }
        
        .file-preview-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #eee;
        }
        
        .file-preview-item .file-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .file-icon {
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .file-name {
            font-weight: 500;
            color: #333;
        }
        
        .file-size {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .file-remove {
            background: none;
            border: none;
            color: var(--danger-color);
            cursor: pointer;
            font-size: 1.1rem;
            transition: var(--transition);
        }
        
        .file-remove:hover {
            color: #b02a37;
        }
        
        /* Form Action Buttons */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .btn-custom {
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-custom-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .btn-custom-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 111, 165, 0.3);
        }
        
        .btn-custom-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        
        .btn-custom-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            color: white;
        }
        
        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
        }
        
        .password-container {
            position: relative;
        }
        
        /* Status Toggle */
        .status-toggle {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        
        .status-option {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .status-radio {
            display: none;
        }
        
        .status-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border-radius: 8px;
            border: 2px solid #ddd;
            transition: var(--transition);
            cursor: pointer;
        }
        
        .status-radio:checked + .status-label {
            border-color: var(--primary-color);
            background-color: rgba(74, 111, 165, 0.05);
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        .status-active .status-indicator {
            background-color: var(--success-color);
        }
        
        .status-inactive .status-indicator {
            background-color: var(--danger-color);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main {
                margin-left: 0;
            }
            
            .sidebar.collapsed ~ .main {
                margin-left: 0;
            }
            
            .sidebar.collapsed {
                margin-left: calc(-1 * var(--sidebar-collapsed-width));
            }
        }
        
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn-custom {
                width: 100%;
                justify-content: center;
            }
        }
        
        /* Form Validation */
        .is-invalid {
            border-color: var(--danger-color);
        }
        
        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }
        
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include('sidebar.php'); ?>
        <main class="main">
            <!-- Top Header -->
            <header class="top-header">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="header-actions">
                    <div class="user-dropdown">
                        <button class="user-btn">
                            <div class="user-info">
                                <div class="user-avatar">AD</div>
                                <div class="user-name d-none d-md-block">Admin User</div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </div>
                        </button>
                    </div>
                </div>
            </header>
            
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h1>Profile</h1>
                        <p>Please update your profile information below. Fields marked with * are required.</p>
                    </div>
                </div>
                
                <div class="form-container">
                    <form id="addEmployeeForm">
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-user"></i>
                                Personal Information
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label required">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter employee full name" required>
                                    <div class="invalid-feedback">Please enter a valid name.</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label required">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="employee@example.com" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mobile" class="form-label required">Mobile Number</label>
                                    <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Enter 10-digit mobile number" pattern="[0-9]{10}" required>
                                    <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="reset" class="btn btn-custom btn-custom-secondary">
                                <i class="fas fa-redo me-1"></i> Reset Form
                            </button>
                            <button type="submit" class="btn btn-custom btn-custom-primary">
                                <i class="fas fa-user-plus me-1"></i> Add Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebarBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            
            toggleSidebarBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
        });
    </script>
</body>
</html>