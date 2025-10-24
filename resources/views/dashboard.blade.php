<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="bdal-header mb-4">
                <h1 class="text-2xl font-bold mb-2">Welcome to Big Data Analytics Lab</h1>
                <p class="mb-0">You're successfully logged in to your dashboard.</p>
            </div>
            
            <!-- Main Content Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg bdal-card">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mb-3">Dashboard Overview</h3>
                            <p class="text-muted">Access your projects, tasks, and lab resources from the navigation menu.</p>
                            
                            <div class="mt-4">
                                <h5>Quick Actions:</h5>
                                <div class="d-flex gap-2 mt-2">
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('patron'))
                                        <a href="{{ route('patron.createProject') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Create Project
                                        </a>
                                    @endif
                                    <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-home"></i> View Public Site
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="bdal-badge badge p-3 mb-3">
                                    <i class="fas fa-user fa-2x mb-2"></i><br>
                                    {{ ucfirst(auth()->user()->role) }}
                                </div>
                                <p class="small text-muted">Logged in as {{ auth()->user()->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
