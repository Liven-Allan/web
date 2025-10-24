@extends('layouts.app-admin')

@section('title', 'Active Tasks')

@section('content')
    <!-- Page Header -->
    <div class="bdal-header">
        <h1 class="h3 mb-2">
            <i class="fas fa-play-circle mr-2"></i>
            Active Tasks Management
        </h1>
        <p class="mb-0">Monitor and manage currently active tasks and their progress</p>
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
                Active Tasks ({{ $activeTasks->count() }})
            </h6>
            <div class="d-flex gap-2">
                <span class="badge badge-info">{{ $activeTasks->where('progress', '<', 50)->count() }} Pending</span>
                <span class="badge badge-warning">{{ $activeTasks->where('progress', '>=', 50)->where('progress', '<', 100)->count() }} In Progress</span>
                <span class="badge badge-success">{{ $activeTasks->where('progress', 100)->count() }} Completed</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th><i class="fas fa-tasks mr-1"></i>Task</th>
                            <th><i class="fas fa-user mr-1"></i>Assigned To</th>
                            <th><i class="fas fa-user-tie mr-1"></i>Assigned By</th>
                            <th><i class="fas fa-chart-line mr-1"></i>Progress</th>
                            <th><i class="fas fa-comments mr-1"></i>Comment</th>
                            <th><i class="fas fa-cogs mr-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activeTasks as $activeTask)
                            <tr>
                                <td class="font-weight-bold">{{ $activeTask->task->title }}</td>
                                <td>{{ $activeTask->assignedTo->name }}</td>
                                <td>{{ $activeTask->assignedBy->name }}</td>
                                <td>
                                    <div class="progress" style="height: 25px;">
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
                                </td>
                                <td>
                                    @if($activeTask->comment)
                                        <span class="text-muted">{{ Str::limit($activeTask->comment, 30) }}</span>
                                    @else
                                        <span class="text-muted font-italic">No comments</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#commentModal{{ $activeTask->id }}" 
                                            title="Add Comment">
                                        <i class="fas fa-comment"></i> Comment
                                    </button>
                                    @if($activeTask->task->status === 'completed')
                                        <form action="{{ route('admin.confirm_task', $activeTask->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Confirm Task">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                            <!-- Comment Modal -->
                            <div class="modal fade" id="commentModal{{ $activeTask->id }}" tabindex="-1" aria-labelledby="commentModalLabel{{ $activeTask->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: var(--bdal-primary); color: white;">
                                            <h5 class="modal-title" id="commentModalLabel{{ $activeTask->id }}">
                                                <i class="fas fa-comment mr-2"></i>
                                                Add Comment: {{ $activeTask->task->title }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.add_comment', $activeTask->id) }}" method="POST" id="commentForm{{ $activeTask->id }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="comment{{ $activeTask->id }}" class="form-label">
                                                        <i class="fas fa-edit mr-1"></i>Comment:
                                                    </label>
                                                    <textarea name="comment" 
                                                              id="comment{{ $activeTask->id }}" 
                                                              class="form-control" 
                                                              rows="4" 
                                                              placeholder="Enter your comment about this task..."
                                                              required>{{ $activeTask->comment }}</textarea>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times mr-1"></i>Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save mr-1"></i>Save Comment
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-play-circle fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-muted">No active tasks found.</p>
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
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Active Tasks: Initializing comment modals');
    
    // Initialize Bootstrap modals
    if (typeof bootstrap !== 'undefined') {
        // Initialize all modals
        var modalElements = document.querySelectorAll('.modal');
        modalElements.forEach(function(modalElement) {
            new bootstrap.Modal(modalElement);
        });
        console.log('Bootstrap modals initialized');
    }
    
    // Handle comment form submissions
    const commentForms = document.querySelectorAll('[id^="commentForm"]');
    commentForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Saving...';
            submitBtn.disabled = true;
            
            // Form will submit normally, no need to prevent default
        });
    });
    
    // Function to hide success and error messages after a few seconds
    const successMessage = document.getElementById('success-message');
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 5000); // Hide after 5 seconds
    }

    const errorMessage = document.getElementById('error-message');
    if (errorMessage) {
        setTimeout(function() {
            errorMessage.style.display = 'none';
        }, 5000); // Hide after 5 seconds
    }
    
    console.log('Admin Active Tasks: JavaScript initialization complete');
});
</script>

@endsection
