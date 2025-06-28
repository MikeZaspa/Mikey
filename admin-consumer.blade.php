<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Santa Fe Water Billing System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            overflow-x: hidden;
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

        /* Add Consumer Button Styles */
        #addConsumerBtn {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(211, 47, 47, 0.2);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        #addConsumerBtn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(211, 47, 47, 0.3);
        }

        #addConsumerBtn:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(211, 47, 47, 0.2);
        }

        #addConsumerBtn i {
            font-size: 1.1rem;
            margin-right: 8px;
        }
                
        /* Enhanced Table Styles */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            padding: 25px;
            margin-top: 25px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            width: 100%;
            overflow: hidden;
        }

        .table-title {
            color: var(--primary-dark);
            padding-bottom: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-title h3 {
            font-weight: 600;
            margin: 0;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            --bs-table-striped-bg: rgba(211, 47, 47, 0.02);
            --bs-table-hover-bg: rgba(211, 47, 47, 0.05);
            margin-bottom: 0;
            width: 100%;
            table-layout: auto;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom-width: 2px;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-color: rgba(0, 0, 0, 0.03);
            white-space: nowrap;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Enhanced Badges */
        .badge {
            font-weight: 500;
            padding: 6px 10px;
            font-size: 0.75rem;
            border-radius: 4px;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .badge i {
            font-size: 0.65rem;
        }

        .badge-status-active {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .badge-status-inactive {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .badge-status-disconnected {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        .badge-status-cut {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .badge-type-residential {
            background-color: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }

        .badge-type-commercial {
            background-color: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .badge-type-institutional {
            background-color: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        /* Action Buttons */
        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-action i {
            font-size: 0.9rem;
        }

        .btn-action:hover {
            transform: scale(1.1);
        }

        .btn-action + .btn-action {
            margin-left: 8px;
        }

        /* Search Box */
        .search-box {
            min-width: 250px;
        }

        .search-box .form-control {
            border-right: 0;
        }

        .search-box .btn {
            border-left: 0;
            background-color: white;
        }

        .search-box .btn:hover {
            background-color: #f8f9fa;
        }

        /* Pagination */
        .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid transparent;
        }

        .dataTables_paginate .paginate_button.current {
            background: var(--primary-color);
            color: white !important;
            border-color: var(--primary-color);
        }

        .dataTables_paginate .paginate_button:hover {
            background: rgba(211, 47, 47, 0.1);
            color: var(--primary-color) !important;
            border-color: rgba(211, 47, 47, 0.2);
        }

        /* Info Text */
        .dataTables_info {
            padding-top: 12px !important;
            color: #6c757d !important;
            font-size: 0.875rem;
        }
        
        .status-active {
            color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-inactive {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .badge-residential {
            background-color: #007bff;
        }
        
        .badge-commercial {
            background-color: #6c757d;
        }
        
        .badge-industrial {
            background-color: #fd7e14;
        }
        
        .action-btn {
            padding: 5px 10px;
            font-size: 0.8rem;
            margin-right: 5px;
        }
        
        .search-box {
            max-width: 200px;
        }

        /* Modal Styles */
        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }

        .modal-footer .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .modal-footer .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .form-label.required:after {
            content: " *";
            color: var(--primary-color);
        }
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s;
            padding: 20px;
        }
        
        .header {
            height: 70px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
            background: white;
            padding: 0 20px;
        }
        
        .change.up {
            color: #4CAF50;
        }
        
        .change.down {
            color: #F44336;
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
                padding: 15px;
            }
            
            .main-content.active {
                margin-left: 280px;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadein {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        .login-logo {
            width: 100px;       
            height: 100px;      
            border-radius: 50%; 
            object-fit: cover;  
        }

        /* Better table alignment */
        .table td, .table th {
            vertical-align: middle;
        }

        /* Ensure table cells don't wrap unnecessarily */
        .table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        /* Make address column wider */
        .table td:nth-child(4) {
            white-space: normal;
            max-width: 300px;
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
    <!-- Header -->
    <header class="header d-flex align-items-center">
        <button id="sidebarToggle" class="btn d-lg-none me-3">
            <i class="bi bi-list"></i>
        </button>
        <h2 class="h5 mb-0">Consumer</h2>
        
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
   
    <div class="table-container animate-fadein">
        <div class="table-title">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h3 class="mb-0">Consumer Management</h3>
                <button class="btn btn-primary" id="addConsumerBtn" data-bs-toggle="modal" data-bs-target="#consumerModal">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Add New Consumer
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="consumersTable">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Full Name</th>
                        <th>Contact Number</th>
                        <th>Meter No.</th>
                        <th width="300">Address</th>
                        <th width="120">Status</th>
                        <th width="120">Type</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consumers as $consumer)
                    <tr id="consumerRow_{{ $consumer->id }}">
                        <td class="fw-semibold">{{ $consumer->id }}</td>
                        <td>{{ $consumer->full_name }}</td>
                        <td>{{ $consumer->contact_number }}</td>
                        <td>{{ $consumer->meter_no }}</td>
                        <td>{{ $consumer->address }}</td>  
                        <td>
                            <span class="badge 
                                @if($consumer->status == 'active') badge-status-active
                                @elseif($consumer->status == 'inactive') badge-status-inactive
                                @elseif($consumer->status == 'disconnected') badge-status-disconnected
                                @else badge-status-cut @endif">
                                <i class="bi 
                                    @if($consumer->status == 'active') bi-check-circle
                                    @elseif($consumer->status == 'inactive') bi-pause-circle
                                    @elseif($consumer->status == 'disconnected') bi-plug
                                    @else bi-x-circle @endif"></i>
                                {{ ucfirst($consumer->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                                @if($consumer->consumer_type == 'residential') badge-type-residential
                                @elseif($consumer->consumer_type == 'commercial') badge-type-commercial
                                @else badge-type-institutional @endif">
                                <i class="bi 
                                    @if($consumer->consumer_type == 'residential') bi-house-door
                                    @elseif($consumer->consumer_type == 'commercial') bi-shop
                                    @else bi-building @endif"></i>
                                {{ ucfirst($consumer->consumer_type) }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <button class="btn btn-action btn-warning edit-consumer" data-id="{{ $consumer->id }}" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-action btn-danger delete-consumer" data-id="{{ $consumer->id }}" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Consumer Modal (Add/Edit) -->
<div class="modal fade" id="consumerModal" tabindex="-1" aria-labelledby="consumerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add New Consumer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="consumerForm">
                    <input type="hidden" id="consumerId">
                    <div class="mb-3">
                        <label for="fullName" class="form-label required">Full Name</label>
                        <input type="text" class="form-control" id="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactNumber" class="form-label required">Contact Number</label>
                        <input type="tel" class="form-control" id="contactNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="meterNo" class="form-label required">Meter Number</label>
                        <input type="text" class="form-control" id="meterNo" required>
                        <small class="text-muted">Unique identifier for the water meter</small>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label required">Address</label>
                        <input type="text" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="consumerType" class="form-label required">Consumer Type</label>
                        <select class="form-select" id="consumerType" required>
                            <option value="" selected disabled>Select type</option>
                            <option value="residential">Residential</option>
                            <option value="commercial">Commercial</option>
                            <option value="institutional">Institutional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select" id="status" required>
                            <option value="" selected disabled>Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="disconnected">Disconnected</option>
                            <option value="cut">Cut</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveConsumer">Save Consumer</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this consumer? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 for notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with enhanced options
        $('#consumersTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "",
                searchPlaceholder: "Search consumers...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            initComplete: function() {
                $('.dataTables_filter input').addClass('form-control');
                $('.dataTables_length select').addClass('form-select');
            },
            columnDefs: [
                { responsivePriority: 1, targets: 0 }, // ID column
                { responsivePriority: 2, targets: -1 }, // Actions column
                { responsivePriority: 3, targets: 1 }, // Name column
                { width: '300px', targets: 3 } // Address column
            ],
            drawCallback: function() {
                // Add tooltips to action buttons
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });

        // Reset form when modal is closed
        $('#consumerModal').on('hidden.bs.modal', function() {
            $('#consumerForm')[0].reset();
            $('#consumerId').val('');
            $('#modalTitle').text('Add New Consumer');
        });

        // Add Consumer button click
        $('#addConsumerBtn').click(function() {
            $('#modalTitle').text('Add New Consumer');
            $('#consumerId').val('');
        });

        // Save Consumer (Add/Edit)
        $('#saveConsumer').click(function() {
            const formData = {
                full_name: $('#fullName').val(),
                contact_number: $('#contactNumber').val(),
                meter_no: $('#meterNo').val(),
                address: $('#address').val(),
                consumer_type: $('#consumerType').val(),
                status: $('#status').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            // Basic validation
            if (!formData.full_name || !formData.contact_number || !formData.meter_no || !formData.address || !formData.consumer_type || !formData.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill all required fields'
                });
                return;
            }

            const consumerId = $('#consumerId').val();
            const url = consumerId ? `/admin-consumer/${consumerId}` : '/admin-consumer';
            const method = consumerId ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    $('#consumerModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'Something went wrong!';
                    if (xhr.responseJSON?.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).join('\n');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        });

        // Edit Consumer
        $(document).on('click', '.edit-consumer', function() {
            const consumerId = $(this).data('id');
            
            $.ajax({
                url: `/admin-consumer/${consumerId}`,
                type: 'GET',
                success: function(response) {
                    $('#modalTitle').text('Edit Consumer');
                    $('#consumerId').val(response.id);
                    $('#fullName').val(response.full_name);
                    $('#meterNo').val(response.meter_no); 
                    $('#contactNumber').val(response.contact_number);
                    $('#address').val(response.address);
                    $('#consumerType').val(response.consumer_type);
                    $('#status').val(response.status);
                    
                    $('#consumerModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to fetch consumer data'
                    });
                }
            });
        });

        // Delete Consumer
        let deleteConsumerId = null;
        
        $(document).on('click', '.delete-consumer', function() {
            deleteConsumerId = $(this).data('id');
            $('#deleteModal').modal('show');
        });

        $('#confirmDelete').click(function() {
            if (!deleteConsumerId) return;
            
            $.ajax({
                url: `/admin-consumer/${deleteConsumerId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    $('#deleteModal').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to delete consumer'
                    });
                }
            });
        });

        // Toggle sidebar on mobile
        $('#sidebarToggle').click(function() {
            $('.sidebar').toggleClass('active');
            $('.main-content').toggleClass('active');
        });
    });
</script>