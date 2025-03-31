@extends('layouts.app-admin')

@section('title', 'Patron Dashboard')

@section('content')
    <h1>Welcome, Patron!</h1>


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
                <a href="{{ url('/') }}" class="back-to-home-btn">Back to Home</a>

@endsection
