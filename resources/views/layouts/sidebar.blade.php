<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
    style="position: fixed; top: 0; left: 0; width: 250px; height: 100vh; overflow-y: auto; overflow-x: hidden; z-index: 1050;">

    <!-- Sidebar content here -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#" >
        <div class="sidebar-brand-text mx-3">Big Data Lab</div>
    </a>
    <hr class="sidebar-divider my-0">
    <!-- Dashboard Link -->
    <li class="nav-item">
        @if(auth()->user()->hasRole('admin'))
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        @elseif(auth()->user()->hasRole('patron'))
            <a class="nav-link" href="{{ route('patron.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        @elseif(auth()->user()->hasRole('research_assistant'))
            <a class="nav-link" href="{{ route('research_assistant.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        @endif
    </li>
    
     <!-- View users -->
@if(auth()->user()->hasRole('admin'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users.list') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>
@elseif(auth()->user()->hasRole('patron'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patron.users.list') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>
@endif


     <!-- Task Menu -->
     @if(auth()->user()->hasRole('admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.task.list') }}">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Tasks</span>
            </a>
        </li>
    @elseif(auth()->user()->hasRole('patron'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('patron.task.list') }}">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Tasks</span>
            </a>
        </li>
    @endif
    <!--  Research Assistant -->
    @if(auth()->user()->hasRole('research_assistant'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('research_assistant.task.list') }}">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Tasks</span>
            </a>
        </li>
    @endif
    @if(auth()->user()->hasRole('research_assistant'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('research_assistant.active_tasks') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Active Tasks</span>
        </a>
    </li>
    @endif

<!-- Active tasks for admin and patron -->
@if(auth()->user()->hasRole('admin'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.active_tasks') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Active Tasks</span>
        </a>
    </li>
@elseif(auth()->user()->hasRole('patron'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patron.active_tasks') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Active Tasks</span>
        </a>
    </li>
    @endif
  
    @endif

    @if(auth()->user()->hasRole('admin'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.editDescription') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Edit Page Description</span>
        </a>
    </li>
@elseif(auth()->user()->hasRole('patron'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patron.editDescription') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Edit Page Description</span>
        </a>
    </li>


@endif




    @if(auth()->user()->hasRole('admin'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.editDescription') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Edit Page Description</span>
        </a>
    </li>
@elseif(auth()->user()->hasRole('patron'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patron.editDescription') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Edit Page Description</span>
        </a>
    </li>


@endif


</ul>

 