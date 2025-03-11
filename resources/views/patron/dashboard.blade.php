@extends('layouts.app-admin')

@section('title', 'Patron Dashboard')

@section('content')
    <h1>Welcome, Patron!</h1>
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
