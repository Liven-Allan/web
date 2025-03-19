



@extends('layouts.app-admin')

@section('title', 'Create Project')

@section('content')
<style>.form-control {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    width: 100%;
}</style>
<div class="container">
    <h1>Create a New Project</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div id="error-message" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
    </div>

    <div class="form-group">
        <label for="url">URL</label>
        <input type="url" id="url" name="url" class="form-control">
    </div>

    <div class="form-group">
        <label for="priority">Priority</label>
        <select id="priority" name="priority" class="form-control" required>
            <option value="">Select Priority</option>
            <option value="1">High (1)</option>
            <option value="2">Medium (2)</option>
            <option value="3">Low (3)</option>
        </select>
    </div>

    <div class="form-group">
        <label for="patron_id">Patron ID</label>
        <input type="number" id="patron_id" name="patron_id" class="form-control" required>
    </div>


    <button type="submit" class="btn btn-primary">Create</button>
</form>

</div>

<script>
    // Function to hide success and error messages after a few seconds
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            let successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }

            let errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 3000); // Hide messages after 3 seconds
    });
</script>

@endsection
