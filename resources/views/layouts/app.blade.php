<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Add Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Add Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- BDAL Theme -->
        <link href="{{ asset('css/auth-theme.css') }}" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
        <!-- Authenticated Navigation Bar -->
        @include('components.auth-navbar')

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900" style="padding-top: 1rem;">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="container-fluid">
                {{ $slot }}
            </main>
        </div>

        <!-- Add Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        
        <!-- Additional dropdown initialization -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('App layout: Initializing dropdowns');
                
                // Ensure Bootstrap dropdowns are initialized
                if (typeof bootstrap !== 'undefined') {
                    try {
                        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                            return new bootstrap.Dropdown(dropdownToggleEl);
                        });
                        console.log('App layout: Bootstrap dropdowns initialized successfully');
                    } catch (error) {
                        console.log('App layout: Bootstrap dropdown initialization failed', error);
                    }
                } else {
                    console.log('App layout: Bootstrap not found');
                }
                
                // Additional manual initialization for user dropdown
                const userDropdown = document.getElementById('userDropdown');
                const dropdownMenu = document.getElementById('userDropdownMenu');
                
                if (userDropdown && dropdownMenu) {
                    console.log('App layout: Setting up manual dropdown handlers');
                    
                    // Ensure the dropdown works
                    userDropdown.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('App layout: User dropdown clicked');
                        
                        // Toggle dropdown
                        if (dropdownMenu.classList.contains('show')) {
                            dropdownMenu.classList.remove('show');
                        } else {
                            // Hide other dropdowns
                            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                                menu.classList.remove('show');
                            });
                            dropdownMenu.classList.add('show');
                        }
                    });
                } else {
                    console.log('App layout: Dropdown elements not found');
                }
            });
        </script>
    </body>
</html>
