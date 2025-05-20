<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm">
    <div class="container">
        <!-- Logo and Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/bigdata.png') }}" alt="Big Data Analytics Lab" class="bdal-logo me-2"
                style="height: 35px;">
            <span>Big Data Analytics Lab</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('peoplepage') ? 'active' : '' }}" href="{{ route('peoplepage') }}">
                        People
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('Allprojects') ? 'active' : '' }}"
                        href="{{ route('Allprojects') }}">
                        Projects
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('publications') ? 'active' : '' }}"
                        href="{{ route('publications') }}">
                        Publications
                    </a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('newz') ? 'active' : '' }}" href="{{ route('newz') }}">
                        News
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}">
                        Events
                    </a>
                </li>
            </ul>

            <!-- Login Button -->
            <div class="nav-item">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-cog me-2"></i>Profile
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route(Auth::user()->role . '.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
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
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-1"></i>LOG IN
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>