@extends('layouts.app-admin')

@section('title', 'Active Tasks')

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

    .progress-bar {
        height: 20px;
        background-color: #007bff;
        border-radius: 5px;
        transition: width 0.3s ease;
    }

    .progress-container {
        width: 100%;
        background-color: #e9ecef;
        border-radius: 5px;
        overflow: hidden;
    }
</style>
@section('content')
    <h1>Active Tasks</h1>

    @if(session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div id="success-message" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Task</th>
                <th>Assigned To</th>
                <th>Assigned By</th>
                <th>Progress</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($activeTasks as $activeTask)
                <tr>
                    <td>{{ $activeTask->task->title }}</td>
                    <td>{{ $activeTask->assignedTo->name }}</td>
                    <td>{{ $activeTask->assignedBy->name }}</td>
                    <td>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $activeTask->progress }}%; height: 30px;" aria-valuenow="{{ $activeTask->progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $activeTask->progress }}%
                            </div>
                        </div>
                    </td>
                    <td>{!! nl2br(e($activeTask->comment ?? 'No comments')) !!}</td>

                    <td>
                        <!-- button --->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#commentModal{{ $activeTask->id }}">Comment</button>
                          <!-- Confirm button (only if status is 'completed') -->
            @if($activeTask->task->status === 'completed')
                <form action="{{ route('admin.confirm_task', $activeTask->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">Confirm</button>
                </form>
            @endif
                    </td>
                </tr>

                 <!-- Comment Modal -->
    <div class="modal fade" id="commentModal{{ $activeTask->id }}" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">Add Comment for Task: {{ $activeTask->task->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.add_comment', $activeTask->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea name="comment" id="comment" class="form-control" rows="4">{{ $activeTask->comment }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Save Comment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

            @empty
                <tr>
                    <td colspan="6" class="text-center">No active tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


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
