@extends('layouts.app-admin')

@section('title', 'User List')

<style>
    body, .table th, .table td {
        color: black !important;
    }

    .table th {
        background-color: #007bff;
        color: white !important;
    }

    .table th:hover {
        background-color: #0056b3;
    }

    .table td {
        background-color: white;
    }

    .btn-register {
        width: 200px;
        font-size: 18px;
        background-color: #007bff;  /* Custom blue background */
        color: white;
    }

    .btn-register:hover {
        background-color: #0056b3;  /* Darker shade for hover effect */
    }
</style>

@section('content')

<div class="container">
    @if(session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>

<div class="container">
<div class="d-flex justify-content-between mb-4">
        <h1>Users</h1>
        <a href="{{ route('admin.register_user') }}" class="btn btn-primary btn-lg btn-register"> <i class="fas fa-fw fa-user-plus"></i>
        <span>Register Users</span></a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Profile Picture</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->contact }}</td>
                    <td class="text-center">
                        <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('img/undraw_profile.svg') }}" 
                             alt="Profile Picture" 
                             class="rounded-circle" 
                             width="50" height="50">
                    </td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <!-- Delete Button with Modal Trigger -->
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
        const cancelBtn = document.querySelector('.btn-secondary'); // This is the cancel button
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
                form.action = `/admin/users/${userId}/delete`;  // Change the route according to your route setup
                form.method = 'POST';
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Handle the cancel button click event to hide the modal
        cancelBtn.addEventListener('click', function () {
            deleteModal.hide();
        });
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
