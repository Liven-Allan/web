@extends('layouts.app-admin')

@section('title', 'Edit Description')

@section('content') 

    <h2> Edit Main Page </h2>
    <form action="{{ route('admin.updateDescription') }}" method="POST">
        @csrf
        <label for="content">enter text :</label>
        <textarea name="content" id="content" rows="10" cols="100" required>{{ auth()->user()->heroText->content ?? '' }}</textarea>
        <br>
        <button type="submit">Update</button>
    </form>
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
