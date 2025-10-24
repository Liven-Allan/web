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
                All Users ({{ $users->count() }})
            </h6>
            <a href="{{ route('patron.register_user') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-user-plus mr-2"></i>Register New User
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th><i class="fas fa-user mr-1"></i>Name</th>
                            <th><i class="fas fa-envelope mr-1"></i>Email</th>
                            <th><i class="fas fa-phone mr-1"></i>Contact</th>
                            <th><i class="fas fa-image mr-1"></i>Profile</th>
                            <th><i class="fas fa-user-tag mr-1"></i>Role</th>
                            <th><i class="fas fa-cogs mr-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="font-weight-bold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->contact ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('img/undraw_profile.svg') }}" 
                                         alt="Profile Picture" 
                                         class="rounded-circle border" 
                                         width="40" height="40">
                                </td>
                                <td>
                                    <span class="badge bdal-badge">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm delete-btn" 
                                            data-id="{{ $user->id }}" 
                                            data-name="{{ $user->name }}"
                                            title="Delete User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
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
    <div class="table-responsive">
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Profile Picture</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->contact }}</td>
                    <td class="text-center">
                        <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('img/undraw_profile.svg') }}" 
                             alt="Profile Picture" 
                             class="rounded-circle" 
                             width="50" height="50">
                    </td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ ucfirst($user->status ?? 'active') }}</td>
                    <td style="white-space: nowrap;">
                        <a href="{{ route('patron.users.edit', $user->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                        @if(($user->status ?? 'active') === 'active')
                            <form action="{{ route('patron.users.disable', $user->id) }}" method="POST" class="d-inline me-2">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Disable</button>
                            </form>
                        @else
                            <form action="{{ route('patron.users.enable', $user->id) }}" method="POST" class="d-inline me-2">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Enable</button>
                            </form>
                        @endif
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let userId = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const cancelBtn = document.querySelector('#deleteConfirmationModal .btn-secondary'); // This is the cancel button
        const userNameSpan = document.getElementById('user-name');

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                userId = btn.getAttribute('data-id');
                const userName = btn.getAttribute('data-name');
                userNameSpan.textContent = userName;
                deleteModal.show();
            });
        });

        confirmDeleteBtn.addEventListener('click', function () {
            if (userId) {
                const form = document.createElement('form');
                form.action = `/patron/users/${userId}/delete`;  // Change the route according to your route setup
                form.method = 'POST';
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Handle the cancel button click event to hide the modal
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function () {
                deleteModal.hide();
            });
        }
    });
     // Function to hide success and error messages after a few seconds
     window.onload = function() {
        // Success message
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 3000); // Hide after 3 seconds
        }

        // Error message
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 3000); // Hide after 3 seconds
        }
    }
</script>


@endsection
