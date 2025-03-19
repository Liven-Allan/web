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
    <h2>BDL Projects</h2>
                <ul>
                    @if(isset($projects) && count($projects) > 0)
                        @foreach ($projects as $project)
                            <li>{{ strtoupper(substr($project->title, 0, 3)) }} - {{ $project->title }}</li>
                        @endforeach
                    @else
                        <li>No projects available.</li>
                    @endif
                </ul>
@endsection
