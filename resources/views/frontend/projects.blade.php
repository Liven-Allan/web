<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Data Analytics Lab</title>
    <link rel="stylesheet" href="{{ asset('css/pstyles.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar {
            background-color: #28a745 !important;
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: 500;
            color: white !important;
        }

        .navbar-nav .nav-link {
            font-size: 0.95rem;
            padding: 0.5rem 0.75rem;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
        }

        .navbar-nav .nav-link.active {
            color: white !important;
            font-weight: 500;
        }

        .btn-primary {
            padding: 0.375rem 1rem;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .btn-outline-primary {
            color: white !important;
            border-color: white !important;
        }

        .btn-outline-primary:hover {
            background-color: white !important;
            color: #28a745 !important;
        }

        .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, .1);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, .1);
        }

        .dropdown-item {
            padding: 0.375rem 1rem;
            font-size: 0.95rem;
        }

        .dropdown-item i {
            width: 1.25rem;
            margin-right: 0.5rem;
        }

        .navbar-toggler {
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
            border-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Adjust the margin-top for the content below navbar */
     
    </style>
</head>

<body>
    @include('components.navbar')

    <div class="content-wrapper">
        <div class="projectshero">
            <span
                class="text-white p-2 px-sm-3 py-sm-2 page-banner-name rounded text-uppercase fw-bolder">Projects</span>
        </div>

        <div class="body">
            <h1>{{ $ProjectsDetails->title }}</h1>
            <p>{{ $ProjectsDetails->description }}</p>

            <h2>People</h2>
            <ul class="people-list">
                @foreach(explode(',', $ProjectsDetails->people) as $person)
                    <li>{{ trim($person) }}</li>
                @endforeach
            </ul>

            <h2>Acknowledgements</h2>
            <p class="acknowledgements">{{ $ProjectsDetails->acknowledgement }}</p>

            <h2>Publications</h2>
            @foreach(explode(',', $ProjectsDetails->publication) as $index => $publication)
                <li>{{ $index + 1 }} {{ trim($publication) }}</li>
            @endforeach
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-text">
                © 2025 Big Data Analytics Lab
            </div>
            <div class="social-links">
                <a href="#" title="Email"><span>✉</span></a>
                <a href="#" title="Twitter"><span>𝕏</span></a>
                <a href="#" title="GitHub"><span>⌥</span></a>
                <a href="#" title="LinkedIn"><span>in</span></a>
            </div>
        </div>
    </footer>

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>