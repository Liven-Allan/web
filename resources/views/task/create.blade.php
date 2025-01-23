@extends('layouts.app-admin')

@section('title', 'Task Creation')

<style>
    body {
        color: black !important;
    }

   
</style>

@section('content')
    <h1>Task Creation</h1>
    <p>Role: {{ ucfirst($role) }}</p> <!-- Display role dynamically -->

    

    <form action="{{ route($role . '.task.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Task Description (Optional)</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assign To</label>
            <select class="form-select" id="assigned_to" name="assigned_to" required>
                <option value="" disabled selected>Select Research Assistant</option>
                @foreach($researchAssistants as $assistant)
                    <option value="{{ $assistant->id }}">{{ $assistant->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select class="form-select" id="priority" name="priority" required>
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="pending" selected>Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
@endsection
