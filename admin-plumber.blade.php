<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Santa Fe Water Billing System - Plumbers</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
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

        /* Add Plumber Button Styles */
        #addPlumberBtn {
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

        #addPlumberBtn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(211, 47, 47, 0.3);
        }

        #addPlumberBtn:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(211, 47, 47, 0.2);
        }

        #addPlumberBtn i {
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

        .badge-status-busy {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
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
                <a class="nav-link" href="admin-dashboard">
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
                <a class="nav-link active" href="admin-plumber">
                    <i class="bi bi-wrench"></i> Plumbers
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
        <h2 class="h5 mb-0">Plumber Management</h2>
        
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
                <h3 class="mb-0">Plumber Management</h3>
                <button class="btn btn-primary" id="addPlumberBtn" data-bs-toggle="modal" data-bs-target="#plumberModal">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Add New Plumber
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="plumbersTable">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Full Name</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th width="120">Status</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plumbers as $plumber)
                    <tr id="plumberRow_{{ $plumber->id }}">
                        <td class="fw-semibold">{{ $plumber->id }}</td>
                        <td>{{ $plumber->full_name }}</td>
                        <td>{{ $plumber->contact_number }}</td>
                        <td>{{ $plumber->address }}</td>  
                        <td>
                            <span class="badge 
                                @if($plumber->status == 'active') badge-status-active
                                @elseif($plumber->status == 'inactive') badge-status-inactive
                                @else badge-status-busy @endif">
                                <i class="bi 
                                    @if($plumber->status == 'active') bi-check-circle
                                    @elseif($plumber->status == 'inactive') bi-pause-circle
                                    @else bi-hourglass @endif"></i>
                                {{ ucfirst($plumber->status) }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <button class="btn btn-action btn-warning edit-plumber" data-id="{{ $plumber->id }}" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-action btn-danger delete-plumber" data-id="{{ $plumber->id }}" title="Delete">
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

<!-- Plumber Modal (Add/Edit) -->
<div class="modal fade" id="plumberModal" tabindex="-1" aria-labelledby="plumberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add New Plumber</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="plumberForm">
                    <input type="hidden" id="plumberId">
                    <div class="mb-3">
                        <label for="fullName" class="form-label required">Full Name</label>
                        <input type="text" class="form-control" id="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactNumber" class="form-label required">Contact Number</label>
                        <input type="tel" class="form-control" id="contactNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label required">Address</label>
                        <input type="text" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select" id="status" required>
                            <option value="" selected disabled>Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="savePlumber">Save Plumber</button>
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
                Are you sure you want to delete this plumber? This action cannot be undone.
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
        // Initialize DataTable
        $('#plumbersTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "",
                searchPlaceholder: "Search plumbers...",
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
            }
        });

        // Reset form when modal is closed
        $('#plumberModal').on('hidden.bs.modal', function() {
            $('#plumberForm')[0].reset();
            $('#plumberId').val('');
            $('#modalTitle').text('Add New Plumber');
        });

        // Add Plumber button click
        $('#addPlumberBtn').click(function() {
            $('#modalTitle').text('Add New Plumber');
            $('#plumberId').val('');
        });

        // Save Plumber (Add/Edit)
        $('#savePlumber').click(function() {
            const formData = {
                full_name: $('#fullName').val(),
                contact_number: $('#contactNumber').val(),
                address: $('#address').val(),
                status: $('#status').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            // Basic validation
            if (!formData.full_name || !formData.contact_number || !formData.address || !formData.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill all required fields'
                });
                return;
            }

            // Phone number validation
            const phoneRegex = /^[0-9]{10,15}$/;
            if (!phoneRegex.test(formData.contact_number)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please enter a valid phone number (10-15 digits)'
                });
                return;
            }

            const plumberId = $('#plumberId').val();
            const url = plumberId ? `/admin-plumber/${plumberId}` : '/admin-plumber';
            const method = plumberId ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    $('#plumberModal').modal('hide');
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

        // Edit Plumber
        $(document).on('click', '.edit-plumber', function() {
            const plumberId = $(this).data('id');
            
            $.ajax({
                url: `/admin-plumber/${plumberId}/edit`,
                type: 'GET',
                success: function(response) {
                    $('#modalTitle').text('Edit Plumber');
                    $('#plumberId').val(response.id);
                    $('#fullName').val(response.full_name);
                    $('#contactNumber').val(response.contact_number);
                    $('#address').val(response.address);
                    $('#status').val(response.status);
                    
                    $('#plumberModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to fetch plumber data'
                    });
                }
            });
        });

        // Delete Plumber
let deletePlumberId = null;

$(document).on('click', '.delete-plumber', function() {
    deletePlumberId = $(this).data('id');
    $('#deleteModal').modal('show');
});

$('#confirmDelete').click(function() {
    if (!deletePlumberId) return;
    
    $.ajax({
        url: `/admin-plumber/${deletePlumberId}`,
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
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
                $('#plumberRow_' + deletePlumberId).remove();
                deletePlumberId = null;
            });
        },
        error: function(xhr) {
            $('#deleteModal').modal('hide');
            let errorMessage = xhr.responseJSON?.message || 'Failed to delete plumber';
            
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
        // Toggle sidebar on mobile
        $('#sidebarToggle').click(function() {
            $('.sidebar').toggleClass('active');
            $('.main-content').toggleClass('active');
        });
    });
</script>

</body>
</html>