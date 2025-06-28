<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santa Fe Water Billing System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS for minor adjustments -->
    <style>
        :root {
            --primary-color: #d32f2f;
            --primary-light: #ff6659;
            --primary-dark: #9a0007;
            --sidebar-bg: linear-gradient(180deg, #d32f2f 0%, #9a0007 100%);
            --sidebar-text: rgba(255,255,255,0.9);
            --sidebar-hover: rgba(255,255,255,0.1);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f8f9fa;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header .logo {
            width: 60px;
            height: 60px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 24px;
            font-weight: bold;
            margin: 0 auto;
        }
        
        .sidebar-menu .nav-link {
            color: var(--sidebar-text);
            padding: 0.75rem 1.5rem;
            margin: 0 0.5rem;
            border-radius: 6px;
            transition: all 0.3s;
        }
        
        .sidebar-menu .nav-link:hover {
            background: var(--sidebar-hover);
            transform: translateX(5px);
        }
        
        .sidebar-menu .nav-link.active {
            background: rgba(255,255,255,0.15);
            font-weight: 500;
            position: relative;
        }
        
        .sidebar-menu .nav-link.active::after {
            content: '';
            position: absolute;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: white;
            border-radius: 2px;
        }
        
        .sidebar-menu .nav-link i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .header {
            height: 70px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: rgba(211, 47, 47, 0.05);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .login-logo {
            width: 100px;       
            height: 100px;      
            border-radius: 50%; 
            object-fit: cover;  
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .main-content.active {
                margin-left: 280px;
            }
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 12px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card h3 {
            font-weight: 700;
            color: #2c3e50;
        }

        .card h6 {
            font-size: 0.875rem;
            letter-spacing: 0.5px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header text-center">
        <img src="{{ asset('image/santafe.png') }}" class="login-logo img-fluid mb-3">
        <h1 class="h5">Santa Fe Water Billing</h1>
    </div>
    
    <nav class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="admin-dashboard">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-consumer">
                    <i class="bi bi-people"></i> Consumers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-billing">
                    <i class="bi bi-receipt"></i> Billing
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-plumber">
                    <i class="bi bi-wrench"></i> Plumber
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-report">
                    <i class="bi bi-bar-chart"></i> Reports
                </a>
            </li>
        </ul>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
      @php
        // Set default values if variables are not set
        $totalConsumers = $totalConsumers ?? 0;
        $activeConsumers = $activeConsumers ?? 0;
        $inactiveConsumers = $inactiveConsumers ?? 0;
        $disconnectedConsumers = $disconnectedConsumers ?? 0;
    @endphp
    <!-- Header -->
    <header class="header bg-white d-flex align-items-center px-3">
        <button id="sidebarToggle" class="btn d-lg-none me-3">
            <i class="bi bi-list"></i>
        </button>
        <h2 class="h5 mb-0">Dashboard Overview</h2>
        
        <div class="ms-auto d-flex align-items-center">
            <div class="position-relative me-3">
                <i class="bi bi-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                </span>
            </div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2">
                    <span>Admin User</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="admin-logout">Sign out</a></li>
                </ul>
            </div>
        </div>
    </header>
    
<!-- Replace the dashboard cards section with this enhanced version -->

<div class="container-fluid p-4">
    <div class="row g-4">
        <!-- Total Consumers Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Consumers</h6>
                            <h3 class="mb-0" id="totalConsumersCount">{{ $totalConsumers }}</h3>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> All registered
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people-fill text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Consumers Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Active Consumers</h6>
                            <h3 class="mb-0 text-success" id="activeConsumersCount">{{ $activeConsumers }}</h3>
                            <small class="text-success">
                                <i class="bi bi-check-circle"></i> Currently active
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle-fill text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inactive Consumers Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Inactive Consumers</h6>
                            <h3 class="mb-0 text-warning" id="inactiveConsumersCount">{{ $inactiveConsumers }}</h3>
                            <small class="text-warning">
                                <i class="bi bi-pause-circle"></i> Temporarily inactive
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-pause-circle-fill text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disconnected Consumers Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Disconnected</h6>
                            <h3 class="mb-0 text-danger" id="disconnectedConsumersCount">{{ $disconnectedConsumers }}</h3>
                            <small class="text-danger">
                                <i class="bi bi-x-circle"></i> Service disconnected
                            </small>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="bi bi-x-circle-fill text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity or Quick Actions -->
    <div class="row g-4 mt-2">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Consumer Status Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-3">
                            <div class="p-3">
                                <div class="h2 mb-1 text-primary" id="totalConsumersChart">{{ $totalConsumers }}</div>
                                <div class="text-muted small">TOTAL</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-3">
                                <div class="h2 mb-1 text-success" id="activeConsumersChart">{{ $activeConsumers }}</div>
                                <div class="text-muted small">ACTIVE</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-3">
                                <div class="h2 mb-1 text-warning" id="inactiveConsumersChart">{{ $inactiveConsumers }}</div>
                                <div class="text-muted small">INACTIVE</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-3">
                                <div class="h2 mb-1 text-danger" id="disconnectedConsumersChart">{{ $disconnectedConsumers }}</div>
                                <div class="text-muted small">DISCONNECTED</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="admin-consumer" class="btn btn-primary">
                            <i class="bi bi-person-plus me-2"></i>Manage Consumers
                        </a>
                        <a href="admin-billing" class="btn btn-outline-primary">
                            <i class="bi bi-receipt me-2"></i>View Billing
                        </a>
                        <a href="admin-report" class="btn btn-outline-primary">
                            <i class="bi bi-file-text me-2"></i>Generate Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
   
    // Toggle sidebar on mobile
    $('#sidebarToggle').click(function() {
        $('.sidebar').toggleClass('active');
        $('.main-content').toggleClass('active');
    });

</script>

</body>
</html>