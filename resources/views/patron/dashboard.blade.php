@extends('layouts.app-admin')

@section('title', 'Patron Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="bdal-header">
        <h1 class="h3 mb-2">
            <i class="fas fa-user-tie mr-2"></i>
            Patron Dashboard
        </h1>
        <p class="mb-0">Manage your projects and research activities</p>
    </div>

    <!-- Dashboard Cards -->
    <div class="row">
        <!-- My Projects Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bdal-card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                My Projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $myProjectsCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bdal-card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Tasks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $activeTasksCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bdal-card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Completed Tasks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $completedTasksCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Research Assistants Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bdal-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Research Assistants</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $researchAssistantsCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Projects Section -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card bdal-card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">My Recent Projects</h6>
                    <a href="{{ route('patron.createProject') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>New Project
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($projects) && count($projects) > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($projects->take(5) as $project)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $project->title }}</h6>
                                        <p class="mb-1 text-muted small">{{ Str::limit($project->description, 80) }}</p>
                                        @if($project->url)
                                            <small><a href="{{ $project->url }}" target="_blank" class="text-primary">{{ $project->url }}</a></small>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-project-diagram fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No projects created yet.</p>
                            <a href="{{ route('patron.createProject') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>Create Your First Project
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card bdal-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('patron.createProject') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>Create Project
                        </a>
                        <a href="{{ route('patron.task.list') }}" class="btn btn-success">
                            <i class="fas fa-tasks mr-2"></i>Manage Tasks
                        </a>
                        <a href="{{ route('patron.users.list') }}" class="btn btn-info">
                            <i class="fas fa-users mr-2"></i>View Users
                        </a>
                        <a href="{{ route('news.create') }}" class="btn btn-warning">
                            <i class="fas fa-newspaper mr-2"></i>Add News
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-home mr-2"></i>Public Site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
