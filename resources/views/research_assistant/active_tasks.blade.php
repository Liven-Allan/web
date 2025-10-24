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
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
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
                                    <form action="{{ route('research_assistant.task.update_progress', $activeTask->id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm" style="max-width: 120px;">
                                            <input type="number" 
                                                   name="progress" 
                                                   min="0" 
                                                   max="100" 
                                                   class="form-control" 
                                                   placeholder="0-100"
                                                   value="{{ $activeTask->progress }}"
                                                   title="Enter progress percentage">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm ml-2" title="Update Progress">
                                            <i class="fas fa-save"></i>
                                        </button>
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
<script>
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
