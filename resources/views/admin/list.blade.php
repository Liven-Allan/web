@extends('layouts.app-admin')

@section('title', 'User List')



@section('content')
    <!-- Page Header -->
    <div class="bdal-header">
        <h1 class="h3 mb-2">
            <i class="fas fa-users mr-2"></i>
            User Management
        </h1>
        <p class="mb-0">Manage system users and their roles</p>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div id="success-message" class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Users Table Card -->
    <div class="card bdal-card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-users mr-2"></i>
                System Users ({{ $users->count() }})
            </h6>
            <a href="{{ route('admin.register_user') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus mr-1"></i>Register User
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-bordered table-hover" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th><i class="fas fa-user mr-1"></i>First Name</th>
                    <th><i class="fas fa-user mr-1"></i>Last Name</th>
                    <th><i class="fas fa-envelope mr-1"></i>Email</th>
                    <th><i class="fas fa-phone mr-1"></i>Contact</th>
                    <th><i class="fas fa-image mr-1"></i>Profile</th>
                    <th><i class="fas fa-user-tag mr-1"></i>Role</th>
                    <th><i class="fas fa-toggle-on mr-1"></i>Status</th>
                    <th><i class="fas fa-cogs mr-1"></i>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="font-weight-bold">{{ $user->first_name }}</td>
                        <td class="font-weight-bold">{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->contact ?? 'N/A' }}</td>
                        <td class="text-center">
                            <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('img/undraw_profile.svg') }}" 
                                 alt="Profile Picture" 
                                 class="rounded-circle" 
                                 width="40" height="40">
                        </td>
                        <td>
                            <span class="badge 
                                @if($user->role === 'admin') badge-danger
                                @elseif($user->role === 'patron') badge-primary
                                @else badge-success
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if(($user->status ?? 'active') === 'active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Disabled</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="btn btn-warning btn-sm" 
                               title="Edit User">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            @if(($user->status ?? 'active') === 'active')
                                <form action="{{ route('admin.users.disable', $user->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-secondary btn-sm" 
                                            title="Disable User">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.enable', $user->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-success btn-sm" 
                                            title="Enable User">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <button class="btn btn-danger btn-sm delete-btn" 
                                    data-id="{{ $user->id }}" 
                                    data-name="{{ $user->first_name }} {{ $user->last_name }}"
                                    title="Delete User">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No users found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the user "<span id="user-name"></span>"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#usersTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']], // Sort by first name by default
        columnDefs: [
            {
                targets: [4, 7], // Profile picture and Actions columns
                orderable: false,
                searchable: false
            },
            {
                targets: [5, 6], // Role and Status columns
                className: 'text-center'
            },
            {
                targets: [4], // Profile picture column
                className: 'text-center'
            }
        ],
        language: {
            search: "Search users:",
            lengthMenu: "Show _MENU_ users per page",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            infoEmpty: "No users available",
            infoFiltered: "(filtered from _MAX_ total users)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
    });

    // Delete functionality
    let userId = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
    const userNameSpan = document.getElementById('user-name');

    // Handle delete button clicks (using event delegation for DataTables)
    $('#usersTable').on('click', '.delete-btn', function() {
        userId = $(this).data('id');
        const userName = $(this).data('name');
        userNameSpan.textContent = userName;
        deleteModal.show();
    });

    // Confirm delete
    $('#confirmDeleteBtn').on('click', function() {
        if (userId) {
            const form = $('<form>', {
                'action': `/admin/users/${userId}/delete`,
                'method': 'POST'
            }).append('@csrf @method("DELETE")');
            
            $('body').append(form);
            form.submit();
        }
    });

    // Hide success and error messages after a few seconds
    setTimeout(function() {
        $('#success-message, #error-message').fadeOut('slow');
    }, 5000);
});
</script>

@endsection
