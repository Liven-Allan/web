<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Data Analytics Lab</title>
    <link rel="stylesheet" href="{{ asset('css/pstyles.css') }}">
</head>

<body>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <header class="main-header">
        <div class="nav-container">
            <div class="logo-section">
                <img src="{{ asset('assets/images/bigdata.png') }}" alt="Big Data Analytics Lab" class="bdal-logo">
                Big Data Analytics Lab
            </div>
            <nav class="nav-links">
                <a href="{{ route('projects') }}">Projects</a>
                <a href="people.blade.php">People</a>
                <a href="publications.blade.php">Publications</a>
                <a href="courses.blade.php">Courses</a>
                <a href="news.blade.php">News</a>
                <a href="events.blade.php">Events</a>
            </nav>
            <div class="login-btn">
                <a href="{{ route('login') }}" class="btn-login">LOG IN</a>
            </div>
        </div>
    </header>

    <div class="projectshero">
        <span class="text-white p-2 px-sm-3 py-sm-2 page-banner-name rounded text-uppercase fw-bolder">Projects</span>
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
</body>
</html>
