@extends('layouts.app') <!-- Inherit from a layout file -->

@section('content') <!-- Define the content section -->
<div class="container">
    <h1>All Projects</h1>
    @if($projects->isEmpty())
        <p>No projects available.</p>
    @else
        <div class="project-grid">
            @foreach($projects as $project)
                <div class="project-card">
                    <h2>{{ $project->title }}</h2>
                    <p>{{ $project->description }}</p>
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                    @endif
                    <a href="{{ $project->url }}" target="_blank">Visit Project</a>
                </div>
            @endforeach
        </div>
    @endif
</div>


@endsection