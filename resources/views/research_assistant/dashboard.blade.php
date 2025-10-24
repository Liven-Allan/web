@extends('layouts.app-admin')

@section('title', 'Research Assistant Dashboard')

@section('content')
    <!-- Check if the user needs to change their password -->
    @if($needsPasswordChange)
        <!-- Password Change Modal -->
        <div id="passwordModal" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Change Your Password</h2>
                <form id="passwordForm" method="POST" action="{{ route('research-assistant.change-password') }}">
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

    <!-- Page Header -->
    <div class="bdal-header">
        <h1 class="h3 mb-2">
            <i class="fas fa-user-graduate mr-2"></i>
            Research Assistant Dashboard
        </h1>
        <p class="mb-0">Track your tasks and research progress</p>
    </div>

    <!-- Dashboard Cards -->
    <div class="row">
        <!-- Assigned Tasks Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card bdal-card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Assigned Tasks</div>
                            <div class="h5 mb-0 font-weight-bold" style="color: #000000 !important; font-size: 2rem !important;">
                                {{ $assignedTasksCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Tasks Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card bdal-card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Tasks</div>
                            <div class="h5 mb-0 font-weight-bold" style="color: #28a745 !important; font-size: 2rem !important;">
                                {{ $activeTasksCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Tasks Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card bdal-card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Completed Tasks</div>
                            <div class="h5 mb-0 font-weight-bold" style="color: #17a2b8 !important; font-size: 2rem !important;">
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
    </div>

    <!-- Recent Tasks Section -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card bdal-card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Tasks</h6>
                    <a href="{{ route('research_assistant.task.list') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-list mr-1"></i>View All
                    </a>
                </div>
                <div class="card-body">

                    
                    @if($recentTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($recentTasks as $task)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $task->title }}</h6>
                                        <p class="mb-1 text-muted small">{{ Str::limit($task->description, 80) }}</p>
                                        <small class="text-muted">Due: {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</small>
                                    </div>
                                    <div class="text-right">
                                        @if($task->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($task->status == 'in_progress')
                                            <span class="badge badge-success">In Progress</span>
                                        @elseif($task->status == 'completed')
                                            <span class="badge badge-primary">Completed</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tasks fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No tasks assigned yet.</p>
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
                        <a href="{{ route('research_assistant.active_tasks') }}" class="btn btn-primary mb-2">
                            <i class="fas fa-play-circle mr-2"></i>Active Tasks
                        </a>
                        <a href="{{ route('research_assistant.task.list') }}" class="btn btn-success mb-2">
                            <i class="fas fa-list mr-2"></i>All Tasks
                        </a>
                        <a href="{{ route('research_assistant.active_tasks') }}" class="btn btn-info mb-2">
                            <i class="fas fa-chart-line mr-2"></i>Manage Progress
                        </a>
                        <a href="{{ route('patron.createProject') }}" class="btn btn-warning mb-2">
                            <i class="fas fa-plus mr-2"></i>Create Project
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
