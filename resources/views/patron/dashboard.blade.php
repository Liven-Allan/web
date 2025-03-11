@extends('layouts.app-admin')

@section('title', 'Patron Dashboard')

@section('content')
    <h1>Welcome, Patron!</h1>

    <!-- Check if the user needs to change their password -->
    @if($needsPasswordChange)
    
    <div id="passwordModal" class="modal" style="display: block;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Change Your Password</h2>
        <form id="passwordForm" method="POST" action="{{ route('patron.change-password') }}">
            @csrf
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new-password" required>
            <br>
            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" required>
            <br><br>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</div>
    @endif

    <p>You're logged in as a Patron.</p>

    <!-- Inside frontend/master.blade.php -->
    <h2>BDL Publications</h2>
                <ul>
                    @if(isset($publications) && count($publications) > 0)
                        @foreach ($publications as $publication)
                            <li>{{ strtoupper(substr($publication->title, 0, 3)) }} - {{ $publication->title }}</li>
                        @endforeach
                    @else
                        <li>No publications available.</li>
                    @endif
                </ul>
    
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('passwordModal');
            const passwordForm = document.getElementById('passwordForm');
            const newPasswordInput = document.getElementById('new-password');
            const confirmPasswordInput = document.getElementById('confirm-password');

            // Ensure the modal is displayed when needed
            if (modal) {
                modal.style.display = "block";
            }

            // Function to close the modal
            function closeModal() {
                if (modal) modal.style.display = "none";
            }

            // Validate password form submission
            if (passwordForm) {
                passwordForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const newPassword = newPasswordInput.value;
                    const confirmPassword = confirmPasswordInput.value;

                    if (newPassword === confirmPassword) {
                        passwordForm.submit();
                    } else {
                        alert("Passwords do not match. Please try again.");
                    }
                });
            }
        });
    </script>
@endsection
