@extends('layouts.app-admin')

@section('title', 'Manage Projects')

@section('content')
    <!-- Page Header -->
    <div class="bdal-header">
        <h1 class="h3 mb-2">
            <i class="fas fa-project-diagram mr-2"></i>
            Manage Projects
        </h1>
        <p class="mb-0">Create and manage research projects</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Create Project Button -->
    <div class="mb-4">
        <a href="{{ route('admin.createProject') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Create New Project
        </a>
    </div>

    <!-- Projects List -->
    <div class="card bdal-card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Projects</h6>
        </div>
        <div class="card-body">
            @if($projects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>URL</th>
                                <th>Priority</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>
                                        @if($project->image)
                                            <img src="{{ asset('storage/' . $project->image) }}" 
                                                 alt="{{ $project->title }}" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div style="width: 80px; height: 80px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ Str::limit($project->description, 100) }}</td>
                                    <td>
                                        @if($project->url)
                                            <a href="{{ $project->url }}" target="_blank" class="text-primary">
                                                <i class="fas fa-external-link-alt"></i> Link
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project->priority == 1)
                                            <span class="badge badge-danger">High</span>
                                        @elseif($project->priority == 2)
                                            <span class="badge badge-warning">Medium</span>
                                        @else
                                            <span class="badge badge-secondary">Low</span>
                                        @endif
                                    </td>
                                    <td>{{ $project->patron->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.projects.edit', $project->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.projects.destroy', $project->id) }}" 
                                              method="POST" 
                                              style="display:inline;"
                                              onsubmit="return confirm('Are you sure you want to delete this project?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-project-diagram fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted">No projects created yet.</p>
                    <a href="{{ route('admin.createProject') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>Create Your First Project
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
