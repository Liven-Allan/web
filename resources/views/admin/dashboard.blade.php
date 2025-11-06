@extends('layouts.app-admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="bdal-header">
        <h1 class="h3 mb-2">
            <i class="fas fa-tachometer-alt mr-2"></i>
            Admin Dashboard
        </h1>
        <p class="mb-0">Manage users, projects, and system settings</p>
    </div>

    <!-- Dashboard Cards -->
    <div class="row">
        <!-- Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bdal-card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bdal-card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Project::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bdal-card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Active Tasks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Task::whereRaw("status IN ('pending', 'in_progress')")->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bdal-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                News Articles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\News::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card bdal-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.list') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-users mr-2"></i>Manage Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.task.list') }}" class="btn btn-success btn-block">
                                <i class="fas fa-tasks mr-2"></i>Manage Tasks
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('patron.createProject') }}" class="btn btn-info btn-block">
                                <i class="fas fa-plus mr-2"></i>Create Project
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('news.create') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-newspaper mr-2"></i>Add News
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <hr>
                            <h6 class="text-muted mb-3">System Maintenance</h6>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button id="syncTasksBtn" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-sync mr-2"></i>Sync Task Progress
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Task synchronization button
    $('#syncTasksBtn').on('click', function() {
        const btn = $(this);
        const originalText = btn.html();
        
        // Show loading state
        btn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Syncing...');
        btn.prop('disabled', true);
        
        // Make AJAX request
        $.ajax({
            url: '{{ route("admin.sync_task_progress") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('✅ ' + response.message);
                // Optionally reload the page to show updated counts
                location.reload();
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.error || 'Synchronization failed';
                alert('❌ ' + errorMsg);
            },
            complete: function() {
                // Reset button
                btn.html(originalText);
                btn.prop('disabled', false);
            }
        });
    });
});
</script>
@endsection
