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
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'patron')
                <a href="{{ route($role . '.task.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus mr-2"></i>Create New Task
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tasksTable" class="table table-bordered table-hover" width="100%" cellspacing="0">
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
                                <td class="text-center">
                                    @if($task->priority == 'high')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>{{ ucfirst($task->priority) }}
                                        </span>
                                    @elseif($task->priority == 'medium')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-minus-circle mr-1"></i>{{ ucfirst($task->priority) }}
                                        </span>
                                    @else
                                        <span class="badge badge-info">
                                            <i class="fas fa-info-circle mr-1"></i>{{ ucfirst($task->priority) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($task->status == 'completed')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i>Completed
                                        </span>
                                    @elseif($task->status == 'in_progress')
                                        <span class="badge badge-primary">
                                            <i class="fas fa-play-circle mr-1"></i>In Progress
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-clock mr-1"></i>{{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <i class="fas fa-calendar-alt mr-1"></i>{{ $task->due_date->format('M d, Y') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle mr-2 text-muted"></i>
                                        <span>{{ $task->assignedTo->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-tie mr-2 text-muted"></i>
                                        <span>{{ $task->assignedBy->name }}</span>
                                    </div>
                                </td>
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

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    console.log('Tasks: Initializing DataTables and functionality');
    
    // Initialize DataTables
    $('#tasksTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']], // Sort by title by default
        columnDefs: [
            {
                targets: [7], // Actions column
                orderable: false,
                searchable: false
            },
            {
                targets: [2, 3], // Priority and Status columns
                className: 'text-center'
            },
            {
                targets: [4], // Due Date column
                type: 'date'
            }
        ],
        language: {
            search: "Search tasks:",
            lengthMenu: "Show _MENU_ tasks per page",
            info: "Showing _START_ to _END_ of _TOTAL_ tasks",
            infoEmpty: "No tasks available",
            infoFiltered: "(filtered from _MAX_ total tasks)",
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

    // Delete functionality (using event delegation for DataTables)
    let taskId = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
    const modalBody = document.querySelector('#deleteConfirmationModal .modal-body');

    // Handle delete button clicks
    $('#tasksTable').on('click', '.delete-btn', function(event) {
        event.preventDefault();
        taskId = $(this).data('id');
        const taskName = $(this).data('name');
        modalBody.innerHTML = `Are you sure you want to delete the task titled "<strong>${taskName}</strong>"?`;
        deleteModal.show();
    });

    // Confirm delete
    $('#confirmDeleteBtn').on('click', function() {
        if (taskId) {
            // Create and submit delete form
            const form = $('<form>', {
                'action': `{{ request()->route()->getPrefix() }}/task/${taskId}`,
                'method': 'POST'
            }).append('@csrf @method("DELETE")');
            
            $('body').append(form);
            form.submit();
        }
    });

    // Task activation with loading feedback (using event delegation)
    $('#tasksTable').on('submit', 'form[action*="activate"]', function(e) {
        const submitButton = $(this).find('.task-status-pending');
        
        if (submitButton.length === 0) return;
        
        // Prevent double submission
        if (submitButton.prop('disabled')) {
            e.preventDefault();
            return false;
        }
        
        // Add loading state
        const originalContent = submitButton.html();
        submitButton.html('<i class="fas fa-spinner fa-spin"></i> Activating...');
        submitButton.prop('disabled', true);
        submitButton.addClass('task-activated-feedback');
        
        // Set a timeout to reset button if form doesn't complete
        const timeoutId = setTimeout(() => {
            submitButton.html(originalContent);
            submitButton.prop('disabled', false);
            submitButton.removeClass('task-activated-feedback');
        }, 10000);
        
        // Clear timeout if page unloads (successful submission)
        $(window).on('beforeunload', function() {
            clearTimeout(timeoutId);
        });
        
        return true;
    });

    // Hide success and error messages after a few seconds
    setTimeout(function() {
        $('#success-message, #error-message').fadeOut('slow');
    }, 5000);
    
    console.log('Tasks: JavaScript initialization complete');
});
</script>


@endsection
