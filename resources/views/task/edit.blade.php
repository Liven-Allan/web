@extends('layouts.app-admin')

@section('title', 'Edit Task')

<style>
    body {
        color: black !important;
    }

   
</style>

@section('content')
<h1>Edit Task</h1>
<p>Role: {{ ucfirst($role) }}</p>

<form action="{{ route($role . '.task.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="title" class="form-label">Task Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Task Description (Optional)</label>
        <textarea class="form-control" id="description" name="description" rows="4">{{ $task->description }}</textarea>
    </div>

    <div class="mb-3">
    <label for="assigned_to" class="form-label">Assign To</label>
    <select class="form-select" id="assigned_to" name="assigned_to" required>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
        @endforeach
    </select>
    </div>


    <div class="mb-3">
        <label for="priority" class="form-label">Priority</label>
        <select class="form-select" id="priority" name="priority" required>
            <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>High</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $task->due_date->format('Y-m-d') }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Update Task</button>
</form>
@endsection
