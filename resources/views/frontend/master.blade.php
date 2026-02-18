<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Data Analytics Lab</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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
            font-size: 1.1rem;
            padding: 0.5rem 1rem;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.2s ease;
            font-weight: 400;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
        }

        .navbar-nav .nav-link.active {
            color: white !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link i {
            margin-right: 0.25rem;
            font-size: 1rem;
        }

        .btn-primary {
            padding: 0.5rem 1.25rem;
            font-size: 1.05rem;
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
        .content-wrapper {
            margin-top: -10px;
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

        .card-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            justify-content: center;
            margin: 2rem auto;
            max-width: 1200px;
        }

        .project-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            width: 100%;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card-image {
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: transparent;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            display: block;
        }

        .card-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-content h3 {
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            color: #333;
        }

        .card-content a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .card-content p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 0.75rem;
        }

        .project-actions {
            display: flex;
            gap: 1rem;
            margin-top: auto;
            padding-top: 1rem;
        }

        .edit-btn,
        .delete-btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            flex: 1;
            text-align: center;
        }

        .edit-btn {
            background: #28a745;
            color: white !important;
            border: none;
            text-decoration: none;
            display: inline-block;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
        }

        .edit-btn:hover {
            background: #218838;
            color: white !important;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .card-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .card-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }
    </style>
</head>

<body>
       @include('components.navbar')
    <!-- Navigation Bar -->
   


    <!-- Add margin-top to account for fixed navbar -->
    <div class="content-wrapper">
        <!-- Hero Section -->
        <div class="hero">
            <div class="hero-content">
                <h1 class="hero-title">BIG DATA ANALYTICS LAB</h1>
                <p class="hero-text">
                    {{ $descriptionText->content ?? 'No description available' }}
                </p>
            </div>
        </div>

        <!-- Projects Section -->
        <section class="projects">
            <div class="container">
                <div class="section-title d-flex justify-content-between align-items-center mb-4">
                    <h2>CURRENT RESEARCH PROJECTS</h2>
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
                                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                                @else
                                    <img src="{{ asset('images/default-project.png') }}" alt="Default Image">
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

        <!-- News & Events Section -->
        <section class="news-events-section">
            <div class="news-events-container">
                <!-- Left Column - Featured Section -->
                <div class="featured-event">
                    <h2>News & Upcoming Events</h2>
                    
                    @if(isset($recentNews) && $recentNews->count() > 0)
                        @php $featuredNews = $recentNews->first(); @endphp
                        @if($featuredNews->image)
                            <img src="{{ asset('storage/' . $featuredNews->image) }}" alt="{{ $featuredNews->title }}" class="featured-image">
                        @else
                            <img src="{{ asset('assets/images/calculator-image.png') }}" alt="Featured" class="featured-image">
                        @endif
                        <div class="date">{{ $featuredNews->date ? \Carbon\Carbon::parse($featuredNews->date)->format('F d, Y') : 'Recent' }}</div>
                        <h3>{{ $featuredNews->title }}</h3>
                        <p>{{ $featuredNews->description }}</p>
                        @if($featuredNews->url)
                            <a href="{{ $featuredNews->url }}" target="_blank" class="read-more">READ MORE ›</a>
                        @else
                            <a href="{{ route('newz') }}" class="read-more">READ MORE ›</a>
                        @endif
                    @else
                        <img src="{{ asset('assets/images/calculator-image.png') }}" alt="Featured" class="featured-image">
                        <div class="date">Stay Connected</div>
                        <h3>Latest Updates from Our Lab</h3>
                        <p>Stay informed about our latest research findings, upcoming events, and lab activities. Check the Recent News and Upcoming Events sections for the most current information about our work and community engagement.</p>
                    @endif
                </div>

                <!-- Right Column - News and Events Lists -->
                <div class="news-events-lists">
                    <!-- Recent News Section -->
                    <div class="news-section">
                        <div class="section-header">
                            <h2>Recent News</h2>
                            <div class="view-all">
                                <a href="{{ route('newz') }}" class="nav-arrow" title="View All News">→</a>
                            </div>
                        </div>
                        <ul class="news-list">
                            @if(isset($recentNews) && $recentNews->count() > 0)
                                @foreach($recentNews as $news)
                                    <li class="news-item">
                                        <div class="item-date">
                                            <div class="date-day">{{ $news->date ? \Carbon\Carbon::parse($news->date)->format('d') : '--' }}</div>
                                            <div class="date-month">{{ $news->date ? \Carbon\Carbon::parse($news->date)->format('M') : '--' }}</div>
                                        </div>
                                        <div class="item-content">
                                            <h3>
                                                @if($news->url)
                                                    <a href="{{ $news->url }}" target="_blank">{{ $news->title }}</a>
                                                @else
                                                    <a href="{{ route('newz') }}">{{ $news->title }}</a>
                                                @endif
                                            </h3>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="event-item">
                                    <div class="item-content" style="padding-left: 0;">
                                        <p style="color: #999; font-size: 0.9rem;">No recent news available. Check back later for updates!</p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Upcoming Events Section -->
                    <div class="events-section">
                        <div class="section-header">
                            <h2>Upcoming Events</h2>
                            <div class="view-all">
                                <a href="{{ route('events') }}" class="nav-arrow" title="View All Events">→</a>
                            </div>
                        </div>
                        <ul class="events-list">
                            <li class="event-item">
                                <div class="item-date">
                                    <div class="date-day">--</div>
                                    <div class="date-month">---</div>
                                </div>
                                <div class="item-content">
                                    <h3><a href="{{ route('events') }}">No upcoming events</a></h3>
                                    <p>Visit our events page for future announcements</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
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

    <!-- Your existing scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('hero-text-form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    fetch('/api/update-hero-text', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({
                            hero_text: document.getElementById('hero-text-editor').value
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Hero text updated successfully!');
                            } else {
                                alert('Error updating hero text');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error updating hero text');
                        });
                });
            }
        });
    </script>
</body>

</html>