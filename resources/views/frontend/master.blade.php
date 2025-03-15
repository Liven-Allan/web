<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Data Analytics Lab</title>
    
    <style>
/* Main Header Styles */
.main-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 100px;
    background-color: #009900;
    z-index: 1000;
    display: flex;
    justify-content: space-between; /* Separate logo and nav */
    align-items: center; /* Vertically center items */
    padding: 0 20px; /* Add some padding to the sides */
    font-family: Arial, sans-serif;
}

.logo-section {
    display: flex;
    align-items: center;
    padding-left: 0; 
    height: 100%;
}
.bdal-logo {
    height: 80px;
    margin-right: 5px;
}

.nav-container {
    display: flex;
    height: 100%;
    align-items: center;
    justify-content: space-between; /* Space between logo, links and login */
    width: 100%;
    max-width: 1000px; /* Match other sections */
    padding: 0 2rem; /* Match other sections' padding */
}


.nav-links {
    display: flex;
    height: 100%;
    margin-left: auto; /* Push links to the center */
    margin-right: 0px; /* Space between links and login button */
}


.nav-links a {
    color: #ffffff;
    text-decoration: none;
    text-transform: uppercase;
    font-size: 15px;
    font-weight: bold;
    padding: 0 15px;
    height: 100%;
    display: flex;
    align-items: center;
    font-weight: 400;
    letter-spacing: 0.5px;
}

.nav-links a:hover {
    color: #C41230;
}

.login-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: black;
    color: white;
    font-size: 15px;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-login {
    color: #ffffff;
    font-size: 15px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    border-radius: 5px;
}

.login-btn:hover {
    background-color: #C41230;
}

/* Root Variables and Global Styles */
:root {
    --primary-color: #009900;
    --text-light: #ffffff;
    --card-gap: 20px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    padding-top: 100px;
}

/* Hero Section */
.hero {
    position: relative;
    height: 400px;
    background: url('/assets/images/bck.png');
    background-size: cover;
    background-position: center;
    color: #ffffff;
    font-weight: bold;
    font-size: 30px;
    padding: 0px;
    display: flex;
    justify-content: center;
    
    position: relative;
}

.hero-content {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 2rem;
    text-align: left;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    
}

.hero-title {
    
    font-size: 2.5rem;
    color: var(--text-light);
    background-color: var(--primary-color);
    padding: 1rem;
    width: 100%;
    text-align: left;
    background-color: rgba(0, 153, 0, 0.9);
    box-shadow: 0 0px 0px rgba(0, 0, 0, 0.4);
}

.hero-text {
    font-size: 1.1rem;
    max-width: 600px;
    line-height: 1.6;
    margin-top: 1rem;
    text-align:left;
    padding: 5px;
   box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    background-color: rgba(0, 0, 0, 0.7);
    
     
}

/*hero section 2 */
.hero-text-container {
    max-width: 600px;
}

.hero-text-editor {
    width: 100%;
    min-height: 100px;
    padding: 10px;
    margin-bottom: 10px;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1.1rem;
    line-height: 1.6;
    color: #333;
}

.hero-save-btn {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}

.hero-save-btn:hover {
    background: #007700;
}

/* Projects Section */
.projects {
    max-width: 1000px;
    margin: 0 auto;
    padding: 3rem 2rem;
}

.section-title {
    font-size: 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #eee;
}

.view-all-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: black;
    color: white;
    font-size: 15px;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.view-all-btn:hover {
    background-color: #C41230;
}

.next-icon {
    margin-left: 8px;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
    margin: 0 auto;
}

/* .project-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
    height: 100%;
} */

.project-card:hover {
    transform: translateY(-5px);
}

.card-image {
    
    display: grid; /* Enable Grid */
    place-items:center; /* Center both vertically and horizontally */
    text-align:start; /* Ensure text is centered */

    width: 200px !important;
    padding-left: 10px ;  /* Increased width */  
    padding-top: 100px;
    padding-right: 10px; 
    padding-bottom: 50px;
    margin-left: 2px;
    height: 300px;
    /* padding-right: 25% ;   */
    /* position: relative; */
    background-color:rgb(163, 233, 148);
    border-radius: 10px; /* Added border radius */
  

    
}

/* .card-image img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 60%;
    max-height: 60%;
} */

.card-content {
    padding: 1.5rem;
    text-align: center;
}

.card-title {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    color: #000000;
}

.card-description {
    font-size: 0.9rem;
    color: #666;
}

/* News & Events Section */
.news-events-section {
    background: #000000;
    color: #ffffff;
    padding: 4rem 0;
    margin-top: 3rem;
}

.news-events-container {
    max-width: 1000px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 45% 55%;
    gap: 4rem;
    padding: 0 2rem;
}

.featured-event {
    padding-right: 2rem;
    border-right: 1px solid #333;
}

.featured-event h2 {
    color: #ffffff;
    font-size: 24px;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.featured-image {
    width: 100%;
    margin-bottom: 20px;
}

.featured-event h3 {
    font-size: 20px;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.featured-event .date {
    color: #999;
    font-size: 14px;
    margin-bottom: 10px;
}

.featured-event p {
    color: #cccccc;
    margin-bottom: 15px;
    line-height: 1.6;
}

.read-more {
    color: #C41230;
    text-decoration: none;
    text-transform: uppercase;
    font-size: 14px;
}

.news-events-lists {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.news-section, .events-section {
    background: #1a1a1a;
    padding: 20px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #333;
}

.section-header h2 {
    color: #ffffff;
    font-size: 16px;
    text-transform: uppercase;
}

.news-list, .events-list {
    list-style: none;
}

.news-item, .event-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.item-date {
    min-width: 40px;
    text-align: center;
}

.date-day {
    font-size: 24px;
    font-weight: bold;
    line-height: 1;
}

.date-month {
    font-size: 12px;
    color: #999;
}

.item-content h3 {
    font-size: 14px;
    margin-bottom: 5px;
}

.item-content h3 a {
    color: #ffffff;
    text-decoration: none;
}

.item-content h3 a:hover {
    color: #C41230;
}

.item-content p {
    font-size: 13px;
    color: #999;
    line-height: 1.4;
}

/* Footer */
.footer {
    background: #009900;
    color: #fff;
    padding: 1rem 0;
}

.footer-container {
    max-width: 1000px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 2rem;
}

.footer-text {
    font-size: 0.8rem;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-links a {
    color: #ffffff;
    text-decoration: none;
    width: 40px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #000000;
    border-radius: 3px;
}

.social-links a:hover {
    background: #C41230;
}

/* Responsive Styles */
@media (max-width: 1024px) {
    .card-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .news-events-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .featured-event {
        padding-right: 0;
        border-right: none;
    }
}

@media (max-width: 768px) {
    .card-grid {
        grid-template-columns: 1fr;
    }
    
    .hero-content {
        padding: 0 1rem;
    }
    
    .nav-links {
        display: none;
    }
    
    .logo-section {
        padding-left: 0px;
        display: flex;
    justify-content: flex-start; /* Aligns the logo to the start */
    align-items: center; /* Vertically centers the logo */
    padding-left: 0; /* Ensures no left padding */
    margin-left: 0; /* Ensures no left margin */
    
    }
}

/*arrow */
.nav-arrow {
    display: inline-block;
    width: 32px;
    height: 32px;
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    text-align: center;
    line-height: 32px;
    text-decoration: none;
    color: #333;
    margin: 0 4px;
    cursor: pointer;
}

.nav-arrow:hover {
    background-color: #C41230;
}

/* Optional: if you want to add a subtle shadow like CMU's design */
.nav-arrow {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.projects-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 columns */
    gap: 20px; /* Space between grid items */
    padding: 20px;
}

.project-card {
    text-align: center;
    padding: 10px;
    box-sizing: border-box;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.project-card:hover {
    transform: scale(1.05); /* Add a hover effect */
}

.project-card img {
    max-width: 100%; /* Ensures the image doesn't exceed the card's width */
    height: auto; /* Maintains the image's aspect ratio */
    border-radius: 8px; /* Matches the card's border radius */
    display: block; /* Ensures the image behaves as a block element */
    margin: 0 auto; /* Centers the image horizontally */
}

.card-image {
    padding-top: 10px; /* Adjust this value to reduce the height at the top */
    overflow: hidden; /* Ensures the image doesn't overflow */
}

.card-image img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
}

h3 {
    margin-bottom: 10px; /* Add some space between MLL and the link */
    word-wrap: break-word; /* Prevent long words from overflowing */
}

a {
    word-wrap: break-word; /* Prevent long URLs from overflowing */
    color: rgb(46, 83, 218); /* Example link color */
}

/* Responsive Grid */
@media (max-width: 1200px) {
    .projects-container {
        grid-template-columns: repeat(3, 1fr); /* 3 columns for medium screens */
    }
}

@media (max-width: 992px) {
    .projects-container {
        grid-template-columns: repeat(2, 1fr); /* 2 columns for tablets */
    }
}

@media (max-width: 768px) {
    .projects-container {
        grid-template-columns: 1fr; /* 1 column for mobile */
    }
}
</style>
   
</head>
<body>
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
     <header class="main-header">

    <div class="nav-container">
            <div class="logo-section">
            <img src="{{ asset('assets/images/bigdata.png') }}" alt="Big Data Analytics Lab" class="bdal-logo">Big Data Analytics Lab
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
        <div class="login-btn">
            <a href="{{ route('login') }}" class="btn-login">LOG IN</a>
        </div>
    </div>
</header>
<div class="hero">
    <div class="hero-content">
        <h1 class="hero-title">BIG DATA ANALYTICS LAB</h1>
        <p class="hero-text">
            {{ $heroText->content ?? 'The Big Data Analytics Lab is a cutting-edge research facility focused on developing innovative solutions.' }}
        </p>
    </div>
</div>

    <section class="projects">
        <div class="section-title">
            <h2>CURRENT RESEARCH PROJECTS</h2>
           <div class="view-all-btn">
    VIEW ALL <span class="next-icon">▶</span>
</div>


        </div>
        <div class="card-grid">
       
            <div class="project-card">

<!-- projects according to priority -->
            <div class="projects-container">
    @foreach($projects as $project)
    <div class="project-card">
        <div class="card-image">
            @if($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
            @else
                <img src="{{ asset('images/default-project.png') }}" alt="Default Image">
            @endif
            <h3>{{ $project->title }}</h3>
            <a href="{{ $project->url }}" target="_blank">{{ $project->url }}</a>
            <p>{{ $project->description }}</p>
            
        </div>
    </div>
@endforeach


            </div></div>

                <!-- </div>
                <div class="card-content">
                    <h3 class="card-title">Data Mining & Analytics</h3>
                    <p class="card-description">Advanced pattern recognition in big data</p>
                </div>
            </div>
            <div class="project-card">
                <div class="card-image">
                    <img src="{{ asset('images/project2-icon.svg') }}" alt="Project 2">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Machine Learning Systems</h3>
                    <p class="card-description">Scalable ML infrastructure</p>
                </div>
            </div>
            <div class="project-card">
                <div class="card-image">
                    <img src="{{ asset('images/project3-icon.svg') }}" alt="Project 3">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Real-time Analytics</h3>
                    <p class="card-description">Stream processing frameworks</p>
                </div>
            </div>
            <div class="project-card">
                <div class="card-image">
                    <img src="{{ asset('images/project4-icon.svg') }}" alt="Project 4">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Predictive Modeling</h3>
                    <p class="card-description">Future-focused data analysis</p>
                </div>
            </div>
        </div> -->
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
            <p>Pittsburgh, PA — The Carnegie Mellon University Database Research Group is pleased to announce the spring semester of our database systems seminar series...</p>
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
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('hero-text-form');
    if (form) {
        form.addEventListener('submit', function(e) {
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