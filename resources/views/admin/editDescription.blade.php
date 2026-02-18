@extends('layouts.app-admin')

@section('title', 'Edit Homepage Description')

@section('content')
    <!-- Page Header -->
    <div class="bdal-header">
        <h1 class="h3 mb-2">
            <i class="fas fa-edit mr-2"></i>
            Edit Homepage Description
        </h1>
        <p class="mb-0">Update the hero section text that appears on the homepage</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Edit Form -->
    <div class="card bdal-card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Homepage Hero Section</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.updateDescription') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="content" class="font-weight-bold">Description Text:</label>
                    <textarea 
                        name="content" 
                        id="content" 
                        class="form-control" 
                        rows="8" 
                        placeholder="Enter the description text that will appear on the homepage hero section..."
                        required>{{ \App\Models\DescriptionText::latest()->first()->content ?? '' }}</textarea>
                    <small class="form-text text-muted">
                        This text will appear below "BIG DATA ANALYTICS LAB" on the homepage.
                    </small>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Description
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-info" target="_blank">
                        <i class="fas fa-eye mr-2"></i>Preview Homepage
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-hide success and error messages after 5 seconds
        window.onload = function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000);
            }

            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 5000);
            }
        }
    </script>
@endsection
