<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Data Analytics Lab</title>
     <link rel="stylesheet" href="{{ asset('css/styles.css') }}" > 
</head>

<body>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <header class="main-header">

        <div class="nav-container">
            <div class="logo-section">
                <img src="{{ asset('assets/images/bigdata.png') }}" alt="Big Data Analytics Lab" class="bdal-logo">Big
                Data Analytics Lab
            </div>
            <nav class="nav-links">
                <a href="people.blade.php">People</a>
                <!-- <a href="projects.blade.php">Projects</a> -->
                <a href="{{ route('projects') }}">Projects</a>
                <a href="publications.blade.php">Publications</a>
                <a href="courses.blade.php">Courses</a>
                <a href="news.blade.php">News</a>
                <a href="events.blade.php">Events</a>
            </nav>
            <!-- <div class="login-btn"> -->
                <!-- <a href="{{ route('login') }}" class="btn-login">LOG IN</a> -->
                @auth
    <div class="user-dropdown">
        <button class="user-btn">
            {{ Auth::user()->name }} ▼
        </button>
        <div class="dropdown-content">
            <a href="/dashboard">Dashboard</a>
            <a href="/profile">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Log Out</button>
            </form>
        </div>
    </div>
@else
    <a href="{{ route('login') }}" class="login-btn">LOG IN</a>
@endauth
            </div>
        </div>
    </header>
    <div class="hero">
        <div class="hero-content">
            <h1 class="hero-title">BIG DATA ANALYTICS LAB</h1>
            <p class="hero-text">
                {{ $descriptionText->content ?? 'No description available' }}
            </p>
        </div>
    </div>

    <section class="projects">
        <div class="section-title">
            <h2>CURRENT RESEARCH PROJECTS</h2>
                <!-- Check if the current route is the main page and display the 'VIEW ALL' button -->
                @if(Route::currentRouteName() == '') <!-- Assuming the main page is named 'home' -->
         
                    <a href="{{ route('projects') }}" class="view-all-btn"> <!-- Add link to projects page -->
                    VIEW ALL <span class="next-icon">▶</span>
                    </a>
                @endif

        </div>
        <div class="card-grid">
             <!-- Loop through each project -->
            @foreach($projects as $project)
                <div class="project-card">
                    <div class="card-image">
                       <!-- Display the project image -->
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

                    <!-- Display edit and delete buttons only if user is the owner -->
                    @if(auth()->check() && $project->patron_id === auth()->id())
                       <div class="project-actions">
                          <!-- Edit button -->
                          <a href="{{ route('projects.edit', $project->id) }}" class="edit-btn">Edit</a>

                          <!-- Delete button inside a form -->
                          <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
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

        <div class="pagination-container">
             <!-- Pagination Container -->
             @if(isset($projects) && $projects instanceof \Illuminate\Pagination\LengthAwarePaginator)
               <div class="flex justify-center mt-6">
                 <div class="pagination bg-white shadow-md rounded-lg p-4">
                   {{ $projects->links() }}
                 </div>
               </div>
              @endif
        </div>
       


                </div><a href="{{ url('/') }}" class="back-to-home-btn">Back to Home</a>

            </div>
    </section>
 


    <!-- Add this section before the footer -->
    <section class="news-events-section">
        <div class="news-events-container">
            <!-- Left Column - Featured Event -->
            <div class="featured-event">
                <h2>News & Upcoming Events</h2>
                <img src="{{ asset('assets/images/calculator-image.png') }}" alt="SQL OR DEATH" class="featured-image">
                <div class="date">January 30, 2025</div>
                <h3>SQL OR DEATH SEMINAR SERIES – SPRING 2025</h3>
                <p>Pittsburgh, PA — The Carnegie Mellon University Database Research Group is pleased to announce the
                    spring semester of our database systems seminar series...</p>
                <a href="#" class="read-more">READ MORE ›</a>
            </div>

            <!-- Right Column - News and Events Lists -->
            <div class="news-events-lists">
                <!-- Recent News Section -->
                <div class="news-section">
                    <div class="section-header">
                        <h2>Recent News</h2>
                        <div class="view-all">
                            <a href="#" class="nav-arrow">◀</a>
                            <a href="#" class="nav-arrow">▶</a>

                        </div>
                    </div>
                    <ul class="news-list">
                        <li class="news-item">
                            <div class="item-date">
                                <div class="date-day">09</div>
                                <div class="date-month">Sep</div>
                            </div>
                            <div class="item-content">
                                <h3><a href="#">Announcing CMU's Database Industry Affiliates Program</a></h3>
                            </div>
                        </li>
                        <li class="news-item">
                            <div class="item-date">
                                <div class="date-day">15</div>
                                <div class="date-month">Aug</div>
                            </div>
                            <div class="item-content">
                                <h3><a href="#">ML/DB Seminar Series — Fall 2023</a></h3>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Upcoming Events Section -->
                <div class="events-section">
                    <div class="section-header">
                        <h2>Upcoming Events</h2>
                        <div class="view-all">
                            <a href="#" class="nav-arrow">◀</a>
                            <a href="#" class="nav-arrow">▶</a>
                        </div>
                    </div>
                    <ul class="events-list">
                        <li class="event-item">
                            <div class="item-date">
                                <div class="date-day">31</div>
                                <div class="date-month">Jan</div>
                            </div>
                            <div class="item-content">
                                <h3><a href="#">[SQL Death] Larry Ellison was Right About TypeScript</a></h3>
                                <p>Signal Processing in the Modern Age</p>
                            </div>
                        </li>
                        <li class="event-item">
                            <div class="item-date">
                                <div class="date-day">17</div>
                                <div class="date-month">Feb</div>
                            </div>
                            <div class="item-content">
                                <h3><a href="#">[SQL Death] Towards Safety in Query Languages</a></h3>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

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

</html>