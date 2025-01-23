@extends('layouts.app-admin')

@section('title', 'Record Progress')

@section('content')
    <h1>Record Progress for Task: {{ $activeTask->task->title }}</h1>

    <form method="POST" action="{{ route('research_assistant.task.update_progress', $activeTask->id) }}">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="progress">Progress (%)</label>
            <input 
                type="number" 
                name="progress" 
                id="progress" 
                class="form-control" 
                value="{{ $activeTask->progress }}" 
                min="0" 
                max="100" 
                required>
        </div>

        <button type="submit" class="btn btn-success">Update Progress</button>
    </form>
@endsection
