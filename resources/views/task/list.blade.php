@extends('layouts.app-admin')

@section('title', 'Tasks')



@section('content')
    <!-- Page Header -->
    <div class="bdal-header">
        <h1 class="h3 mb-2">
            <i class="fas fa-tasks mr-2"></i>
            Task Management
        </h1>
        <p class="mb-0">Manage and track all project tasks</p>
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

    <!-- Tasks Table Card -->
    <div class="card bdal-card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-tasks mr-2"></i>
                All Tasks ({{ $tasks->count() }})
            </h6>
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('patron'))
                <a href="{{ route($role . '.task.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus mr-2"></i>Create New Task
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th><i class="fas fa-heading mr-1"></i>Title</th>
                            <th><i class="fas fa-align-left mr-1"></i>Description</th>
                            <th><i class="fas fa-exclamation-triangle mr-1"></i>Priority</th>
                            <th><i class="fas fa-info-circle mr-1"></i>Status</th>
                            <th><i class="fas fa-calendar mr-1"></i>Due Date</th>
                            <th><i class="fas fa-user mr-1"></i>Assigned To</th>
                            <th><i class="fas fa-user-tie mr-1"></i>Assigned By</th>
                            <th><i class="fas fa-cogs mr-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td class="font-weight-bold">{{ $task->title }}</td>
                                <td>{{ Str::limit($task->description, 50) }}</td>
                                <td>
                                    @if($task->priority == 'high')
                                        <span class="badge badge-danger">{{ ucfirst($task->priority) }}</span>
                                    @elseif($task->priority == 'medium')
                                        <span class="badge badge-warning">{{ ucfirst($task->priority) }}</span>
                                    @else
                                        <span class="badge badge-info">{{ ucfirst($task->priority) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($task->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($task->status == 'in_progress')
                                        <span class="badge badge-primary">In Progress</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($task->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $task->due_date->format('M d, Y') }}</td>
                                <td>{{ $task->assignedTo->name }}</td>
                                <td>{{ $task->assignedBy->name }}</td>
                                <td>
                                    @if ($role !== 'research_assistant')
                                        <a href="{{ route($role . '.task.edit', $task->id) }}" class="btn btn-warning btn-sm" title="Edit Task">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm delete-btn" 
                                                data-id="{{ $task->id }}" 
                                                data-name="{{ $task->title }}"
                                                title="Delete Task">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        @php
                                            // Check if this task is already activated by this research assistant
                                            $isActivated = \App\Models\ActiveTask::where('task_id', $task->id)
                                                                                 ->where('assigned_to', auth()->id())
                                                                                 ->exists();
                                        @endphp
                                        
                                        @if($isActivated)
                                            <!-- Task is already activated -->
                                            <div class="d-flex align-items-center">
                                                <span class="btn btn-sm task-status-activated me-2" title="Task Already Activated">
                                                    <i class="fas fa-check-circle"></i> Activated
                                                </span>
                                                <a href="{{ route('research_assistant.active_tasks') }}" 
                                                   class="btn btn-outline-info btn-sm" 
                                                   title="View in Active Tasks">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </div>
                                        @else
                                            <!-- Task can be activated -->
                                            <form action="{{ route('research_assistant.task.activate', $task->id) }}" method="POST" style="display: inline;" class="activate-form">
                                                @csrf
                                                <button type="submit" class="btn btn-sm task-status-pending" title="Click to Activate Task">
                                                    <i class="fas fa-play"></i> Activate
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-tasks fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-muted">No tasks found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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

    // Task activation with loading feedback
    document.addEventListener('DOMContentLoaded', function() {
        const activateForms = document.querySelectorAll('form[action*="activate"]');
        
        activateForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('.task-status-pending');
                
                if (!submitButton) return;
                
                // Prevent double submission
                if (submitButton.disabled) {
                    e.preventDefault();
                    return false;
                }
                
                // Add loading state
                const originalContent = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Activating...';
                submitButton.disabled = true;
                submitButton.classList.add('task-activated-feedback');
                
                // Set a timeout to reset button if form doesn't complete
                const timeoutId = setTimeout(() => {
                    submitButton.innerHTML = originalContent;
                    submitButton.disabled = false;
                    submitButton.classList.remove('task-activated-feedback');
                }, 10000);
                
                // Clear timeout if page unloads (successful submission)
                window.addEventListener('beforeunload', function() {
                    clearTimeout(timeoutId);
                });
                
                return true;
            });
        });
    });
</script>


@endsection
