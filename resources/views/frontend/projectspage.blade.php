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

        /* Projects Section Styling */
        .projects {
            padding: 2rem 0;
        }

        .projects .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .section-title {
            margin-bottom: 2rem;
        }

        .section-title h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .view-all-btn {
            color: #28a745;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.2s ease;
        }

        .view-all-btn:hover {
            color: #218838;
        }

        .next-icon {
            font-size: 0.8rem;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin: 2rem auto;
        }

        .project-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .card-image {
            position: relative;
            width: 100%;
            height: 180px;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .project-card:hover .card-image img {
            transform: scale(1.05);
        }

        .card-content {
            padding: 1.25rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-content h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            line-height: 1.4;
        }

        .card-content a {
            color: #28a745;
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
            word-break: break-all;
        }

        .card-content a:hover {
            text-decoration: underline;
        }

        .card-content p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .project-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: auto;
        }

        .edit-btn,
        .delete-btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            text-align: center;
            flex: 1;
        }

        .edit-btn {
            background: #28a745;
            color: white;
            border: none;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
        }

        .edit-btn:hover {
            background: #218838;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            padding: 1rem 0;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
        }

        .pagination .page-item .page-link {
            color: #28a745;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            border-radius: 4px;
        }

        .pagination .page-item.active .page-link {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .pagination .page-item .page-link:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .card-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .card-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .card-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    @include('components.navbar')

    <div class="content-wrapper">
        <div class="projectshero">
            <span
                class="text-white p-2 px-sm-3 py-sm-2 page-banner-name rounded text-uppercase fw-bolder">Projects</span>
        </div>


        <!-- Projects Section -->
        <section class="projects">
            <div class="container">
                <div class="section-title d-flex justify-content-between align-items-center mb-4">

                    @if(Route::currentRouteName() == '')
                        <a href="{{ route('projects') }}" class="view-all-btn">
                            VIEW ALL <span class="next-icon">▶</span>
                        </a>
                    @endif
                </div>

                <div class="card-grid">
                    @foreach($projects as $project)
                        <div class="project-card">
                            <div class="card-image">
                                @if($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}"
                                        class="img-fluid">
                                @else
                                    <img src="{{ asset('images/default-project.png') }}" alt="Default Project Image"
                                        class="img-fluid">
                                @endif
                            </div>
                            <div class="card-content">
                                <h3>{{ $project->title }}</h3>
                                <a href="{{ $project->url }}" target="_blank">{{ $project->url }}</a>
                                <p>{{ $project->description }}</p>

                                @if(auth()->check() && $project->patron_id === auth()->id())
                                    <div class="project-actions">
                                        <a href="{{ route('projects.edit', $project->id) }}" class="edit-btn">Edit</a>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(isset($projects) && $projects instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="pagination-container">
                        {{ $projects->links() }}
                    </div>
                @endif
            </div>
        </section>

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