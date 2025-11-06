@extends('layouts.app-admin')

@section('title', 'Active Tasks')

@section('content')
    <!-- Page Header -->
    <div class="bdal-header">
        <h1 class="h3 mb-2">
            <i class="fas fa-play-circle mr-2"></i>
            My Active Tasks
        </h1>
        <p class="mb-0">Track and update progress on your assigned tasks</p>
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

    <!-- Active Tasks Table Card -->
    <div class="card bdal-card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-play-circle mr-2"></i>
                My Active Tasks ({{ $activeTasks->count() }})
            </h6>
            <div class="d-flex gap-2">
                <span class="badge badge-info">{{ $activeTasks->where('progress', '<', 50)->count() }} Pending</span>
                <span class="badge badge-warning">{{ $activeTasks->where('progress', '>=', 50)->where('progress', '<', 100)->count() }} In Progress</span>
                <span class="badge badge-success">{{ $activeTasks->where('progress', 100)->count() }} Completed</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="activeTasksTable" class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th><i class="fas fa-tasks mr-1"></i>Task</th>
                            <th><i class="fas fa-user mr-1"></i>Assigned To</th>
                            <th><i class="fas fa-user-tie mr-1"></i>Assigned By</th>
                            <th><i class="fas fa-chart-line mr-1"></i>Progress</th>
                            <th><i class="fas fa-comments mr-1"></i>Comment</th>
                            <th><i class="fas fa-cogs mr-1"></i>Update Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activeTasks as $activeTask)
                            <tr>
                                <td class="font-weight-bold">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tasks mr-2 text-primary"></i>
                                        {{ $activeTask->task->title }}
                                    </div>
                                    @if($activeTask->task->description)
                                        <small class="text-muted d-block">{{ Str::limit($activeTask->task->description, 60) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle mr-2 text-muted"></i>
                                        <span>{{ $activeTask->assignedTo->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-tie mr-2 text-muted"></i>
                                        <span>{{ $activeTask->assignedBy->name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="progress" style="height: 25px; min-width: 120px;">
                                        <div class="progress-bar 
                                            @if($activeTask->progress < 50) bg-info
                                            @elseif($activeTask->progress < 100) bg-warning
                                            @else bg-success
                                            @endif" 
                                            role="progressbar" 
                                            style="width: {{ $activeTask->progress }}%;" 
                                            aria-valuenow="{{ $activeTask->progress }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            {{ $activeTask->progress }}%
                                        </div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        @if($activeTask->progress < 50)
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        @elseif($activeTask->progress < 100)
                                            <i class="fas fa-play-circle mr-1"></i>In Progress
                                        @else
                                            <i class="fas fa-check-circle mr-1"></i>Completed
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    @if($activeTask->comment)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-comment mr-2 text-info"></i>
                                            <span class="text-muted">{{ Str::limit($activeTask->comment, 40) }}</span>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-comment-slash mr-2"></i>
                                            <span class="font-italic">No comments</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('research_assistant.task.update_progress', $activeTask->id) }}" 
                                          method="POST" 
                                          class="progress-update-form">
                                        @csrf
                                        @method('PATCH')
                                        <div class="d-flex align-items-center">
                                            <div class="input-group input-group-sm" style="max-width: 100px;">
                                                <input type="number" 
                                                       name="progress" 
                                                       min="0" 
                                                       max="100" 
                                                       class="form-control text-center" 
                                                       placeholder="0-100"
                                                       value="{{ $activeTask->progress }}"
                                                       title="Enter progress percentage"
                                                       required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            <button type="submit" 
                                                    class="btn btn-primary btn-sm ml-2" 
                                                    title="Update Progress">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-play-circle fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-muted">No active tasks assigned to you.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    console.log('Research Assistant Active Tasks: Initializing DataTables and functionality');
    
    // Initialize DataTables
    $('#activeTasksTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']], // Sort by task name by default
        columnDefs: [
            {
                targets: [3, 5], // Progress and Update Progress columns
                orderable: false,
                searchable: false
            },
            {
                targets: [3], // Progress column
                className: 'text-center'
            }
        ],
        language: {
            search: "Search my tasks:",
            lengthMenu: "Show _MENU_ tasks per page",
            info: "Showing _START_ to _END_ of _TOTAL_ active tasks",
            infoEmpty: "No active tasks available",
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

    // Handle progress update form submissions (using event delegation for DataTables)
    $('#activeTasksTable').on('submit', '.progress-update-form', function(e) {
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const progressInput = form.find('input[name="progress"]');
        const originalBtnText = submitBtn.html();
        
        // Validate progress value
        const progressValue = parseInt(progressInput.val());
        if (isNaN(progressValue) || progressValue < 0 || progressValue > 100) {
            e.preventDefault();
            alert('Please enter a valid progress percentage between 0 and 100.');
            return false;
        }
        
        // Show loading state
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i>');
        submitBtn.prop('disabled', true);
        progressInput.prop('disabled', true);
        
        // Form will submit normally, loading state will be cleared on page reload
    });

    // Add input validation for progress fields
    $('#activeTasksTable').on('input', 'input[name="progress"]', function() {
        const input = $(this);
        const value = parseInt(input.val());
        
        if (value < 0) {
            input.val(0);
        } else if (value > 100) {
            input.val(100);
        }
    });

    // Add keyboard shortcut for quick updates
    $('#activeTasksTable').on('keypress', 'input[name="progress"]', function(e) {
        if (e.which === 13) { // Enter key
            $(this).closest('form').submit();
        }
    });

    // Hide success and error messages after a few seconds
    setTimeout(function() {
        $('#success-message, #error-message').fadeOut('slow');
    }, 5000);
    
    console.log('Research Assistant Active Tasks: JavaScript initialization complete');
});
</script>
@endsection
