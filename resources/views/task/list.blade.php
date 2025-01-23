@extends('layouts.app-admin')

@section('title', 'Tasks')

<style>
    body, .table th, .table td {
        color: black !important;
    }

    /* Set the background color of the table headers to blue */
    .table th {
        background-color: #007bff; /* Blue color */
        color: white !important; /* Ensure text is white */
    }

    /* Optional: Change hover effect for the table headers */
    .table th:hover {
        background-color: #0056b3; /* Darker blue on hover */
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

<div class="d-flex justify-content-between mb-4">
        <h1>Tasks</h1>
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('patron'))
    <a href="{{ route($role . '.task.create') }}" class="btn btn-primary btn-lg btn-register">
        <i class="fas fa-fw fa-tasks"></i><span>Create Task</span>
    </a>
@endif
</div>
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

<!--<p>Role: {{ ucfirst($role) }}</p> --> <!-- Display role dynamically -->


<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Assigned To</th>
                <th>Assigned By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ ucfirst($task->priority) }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->due_date->format('Y-m-d') }}</td>
                    <td>{{ $task->assignedTo->name }}</td>
                    <td>{{ $task->assignedBy->name }}</td>
                    <td>
    @if ($role !== 'research_assistant')
        <a href="{{ route($role . '.task.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route($role . '.task.destroy', $task->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm delete-btn" 
        data-id="{{ $task->id }}" 
        data-name="{{ $task->title }}">
    Delete
</button>

        </form>
        @else
        <form action="{{ route('research_assistant.task.activate', $task->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">Activate</button>
        </form>
    @endif
</td>

                </tr>
            @empty
                <tr>
                    <td colspan="8">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this task?
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
        let taskId = null; // To store the ID of the task to be deleted
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const cancelBtn = document.querySelector('.btn-secondary'); // Cancel button
        const modalBody = document.querySelector('#deleteConfirmationModal .modal-body');

        // Attach click event listeners to delete buttons
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent form submission for delete buttons
                taskId = btn.getAttribute('data-id'); // Get the task ID
                const taskName = btn.getAttribute('data-name'); // Get the task title
                modalBody.innerHTML = `Are you sure you want to delete the task titled "<strong>${taskName}</strong>"?`;
                deleteModal.show(); // Show the modal
            });
        });

        // Attach click event listener to the confirm delete button
        confirmDeleteBtn.addEventListener('click', function () {
            if (taskId) {
                const form = document.querySelector(`form[action$="${taskId}"]`); // Select the correct form for the task
                if (form) {
                    form.submit(); // Submit the form to delete the task
                }
            }
        });

        // Attach click event listener to the cancel button
        cancelBtn.addEventListener('click', function () {
            deleteModal.hide(); // Hide the modal when cancel is clicked
        });
    });

    // Function to hide success and error messages after a few seconds
    window.onload = function () {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function () {
                successMessage.style.display = 'none';
            }, 3000); // Hide after 3 seconds
        }

        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(function () {
                errorMessage.style.display = 'none';
            }, 3000); // Hide after 3 seconds
        }
    }
</script>


@endsection
