<!-- Bootstrap CSS (ensure it's loaded) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Authenticated Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" style="background-color: #28a745 !important;">
    <div class="container-fluid px-4">
        <!-- Logo and Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/bigdata.png') }}" alt="Big Data Analytics Lab" class="bdal-logo me-2"
                style="height: 35px;">
            <span style="color: white; font-weight: bold;">Big Data Analytics Lab</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
            style="border-color: rgba(255,255,255,0.5);">
            <span class="navbar-toggler-icon" style="background-image: url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 30 30\'%3e%3cpath stroke=\'rgba%28255, 255, 255, 0.75%29\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' stroke-width=\'2\' d=\'M4 7h22M4 15h22M4 23h22\'/%3e%3c/svg%3e');"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                @if(auth()->user()->hasRole('admin'))
                    <!-- Admin Navigation -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.list') ? 'active' : '' }}" 
                           href="{{ route('admin.users.list') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-users me-1"></i>Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.task.list') ? 'active' : '' }}" 
                           href="{{ route('admin.task.list') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-tasks me-1"></i>Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.active_tasks') ? 'active' : '' }}" 
                           href="{{ route('admin.active_tasks') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-play-circle me-1"></i>Active Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('Allprojects') ? 'active' : '' }}"
                           href="{{ route('Allprojects') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-project-diagram me-1"></i>Projects
                        </a>
                    </li>
                @elseif(auth()->user()->hasRole('patron'))
                    <!-- Patron Navigation -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('patron.dashboard') ? 'active' : '' }}" 
                           href="{{ route('patron.dashboard') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('patron.users.list') ? 'active' : '' }}" 
                           href="{{ route('patron.users.list') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-users me-1"></i>Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('patron.task.list') ? 'active' : '' }}" 
                           href="{{ route('patron.task.list') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-tasks me-1"></i>Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('patron.active_tasks') ? 'active' : '' }}" 
                           href="{{ route('patron.active_tasks') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-play-circle me-1"></i>Active Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('Allprojects') ? 'active' : '' }}"
                           href="{{ route('Allprojects') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-project-diagram me-1"></i>Projects
                        </a>
                    </li>
                @elseif(auth()->user()->hasRole('research_assistant'))
                    <!-- Research Assistant Navigation -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('research_assistant.dashboard') ? 'active' : '' }}" 
                           href="{{ route('research_assistant.dashboard') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('research_assistant.task.list') ? 'active' : '' }}" 
                           href="{{ route('research_assistant.task.list') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-tasks me-1"></i>My Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('research_assistant.active_tasks') ? 'active' : '' }}" 
                           href="{{ route('research_assistant.active_tasks') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-play-circle me-1"></i>Active Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('Allprojects') ? 'active' : '' }}"
                           href="{{ route('Allprojects') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-project-diagram me-1"></i>Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('peoplepage') ? 'active' : '' }}" 
                           href="{{ route('peoplepage') }}" style="color: rgba(255,255,255,0.9);">
                            <i class="fas fa-users me-1"></i>People
                        </a>
                    </li>
                @endif
                
                <!-- Common Links for All Users -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('newz') ? 'active' : '' }}" 
                       href="{{ route('newz') }}" style="color: rgba(255,255,255,0.9);">
                        <i class="fas fa-newspaper me-1"></i>News
                    </a>
                </li>
            </ul>

            <!-- User Profile Dropdown -->
            <div class="nav-item">
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" 
                            type="button" 
                            id="userDropdown"
                            aria-expanded="false" 
                            style="border-color: rgba(255,255,255,0.5); cursor: pointer;"
                            onclick="toggleDropdown(); return false;">
                        <img src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : asset('img/undraw_profile.svg') }}" 
                             alt="Profile" 
                             class="rounded-circle me-2" 
                             width="24" height="24">
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        <span class="d-md-none"><i class="fas fa-user"></i></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" 
                        aria-labelledby="userDropdown" 
                        id="userDropdownMenu"
                        style="min-width: 200px;">
                        <li class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <img src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : asset('img/undraw_profile.svg') }}" 
                                     alt="Profile" 
                                     class="rounded-circle me-2" 
                                     width="32" height="32">
                                <div>
                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-cog me-2 text-primary"></i>Edit Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route(Auth::user()->role . '.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2 text-success"></i>My Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fas fa-home me-2 text-info"></i>Public Site
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Reliable JavaScript for dropdown functionality -->
<script>
// Define the function immediately and globally
function toggleDropdown() {
    console.log('Toggle dropdown called');
    
    try {
        const dropdownMenu = document.getElementById('userDropdownMenu');
        if (dropdownMenu) {
            console.log('Dropdown menu found, toggling');
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
                console.log('Dropdown closed');
            } else {
                // Hide any other open dropdowns first
                const allDropdowns = document.querySelectorAll('.dropdown-menu.show');
                allDropdowns.forEach(function(menu) {
                    menu.classList.remove('show');
                });
                
                // Show this dropdown
                dropdownMenu.classList.add('show');
                console.log('Dropdown opened');
            }
        } else {
            console.log('Dropdown menu not found');
        }
    } catch (error) {
        console.error('Error in toggleDropdown:', error);
    }
}

// Make it available globally
window.toggleDropdown = toggleDropdown;

// Initialize event listeners
function initializeDropdownListeners() {
    console.log('Initializing dropdown listeners');
    
    try {
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const userDropdown = document.getElementById('userDropdown');
            const dropdownMenu = document.getElementById('userDropdownMenu');
            
            if (userDropdown && dropdownMenu) {
                // Check if click is outside both button and menu
                if (!userDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                    console.log('Dropdown closed by outside click');
                }
            }
        });
        
        // Close dropdown when pressing Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const dropdownMenu = document.getElementById('userDropdownMenu');
                if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                    console.log('Dropdown closed by Escape key');
                }
            }
        });
        
        console.log('Dropdown listeners initialized successfully');
    } catch (error) {
        console.error('Error initializing dropdown listeners:', error);
    }
}

// Initialize immediately if DOM is ready, otherwise wait
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeDropdownListeners);
} else {
    initializeDropdownListeners();
}

console.log('Dropdown script loaded');
</script>

<style>
/* Authenticated Navbar Styling */
.navbar .nav-link:hover {
    color: white !important;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 0.375rem;
    transition: all 0.2s ease;
}

.navbar .nav-link.active {
    color: white !important;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 0.375rem;
    font-weight: 500;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1000;
    min-width: 200px;
    background-color: white;
    border-radius: 0.5rem;
    padding: 0.5rem 0;
}

.dropdown-menu.show {
    display: block !important;
}

.dropdown {
    position: relative;
}

.dropdown-item:hover {
    background-color: rgba(40, 167, 69, 0.1);
}

.dropdown-header {
    padding: 0.75rem 1rem;
    background-color: #f8f9fa;
}

/* Ensure proper spacing */
body {
    padding-top: 76px; /* Account for fixed navbar height */
}

/* Mobile responsiveness */
@media (max-width: 991px) {
    .navbar-nav {
        padding-top: 1rem;
    }
    
    .navbar-nav .nav-link {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        margin: 0.125rem 0;
    }
    
    .nav-item:last-child {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }
}
</style>