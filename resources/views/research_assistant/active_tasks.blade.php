@extends('layouts.app-admin')

@section('title', 'Active Tasks')

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

    /* Style for the progress bar */
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
        <div id="error-message" class="alert alert-danger">
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    @forelse ($activeTasks as $activeTask)
        <tr>
            <td>{{ $activeTask->task->title }}</td>
            <td>{{ $activeTask->assignedTo->name }}</td>
            <td>{{ $activeTask->assignedBy->name }}</td>
            <td>
    <div class="progress" style="height: 30px;"> <!-- Adjust container height -->
        <div 
            class="progress-bar" 
            role="progressbar" 
            style="width: {{ $activeTask->progress }}%; height: 30px;" 
            aria-valuenow="{{ $activeTask->progress }}" 
            aria-valuemin="0" 
            aria-valuemax="100">
            {{ $activeTask->progress }}%
        </div>
    </div>
</td>

<td>{!! nl2br(e($activeTask->comment ?? 'No comments')) !!}</td>
            <td>
            <form action="{{ route('research_assistant.task.update_progress', $activeTask->id) }}" method="POST">

                    @csrf
                    @method('PATCH')
                    <input type="number" name="progress" min="0" max="100" class="form-control" placeholder="Enter progress">
                    <button type="submit" class="btn btn-primary btn-sm mt-2">Record Progress</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">No active tasks found.</td>
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
