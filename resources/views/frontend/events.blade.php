<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Big Data Analytics Lab</title>
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

        .events-hero {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 4rem 0;
            color: white;
            text-align: center;
            margin-bottom: 3rem;
        }

        .events-hero h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .events-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .event-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            gap: 2rem;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .event-date {
            min-width: 100px;
            text-align: center;
            background: #28a745;
            color: white;
            border-radius: 8px;
            padding: 1rem;
            height: fit-content;
        }

        .event-date .day {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .event-date .month {
            font-size: 1rem;
            text-transform: uppercase;
            margin-top: 0.25rem;
        }

        .event-date .year {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .event-content {
            flex: 1;
        }

        .event-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .event-type {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #e9ecef;
            color: #495057;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .event-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .event-meta {
            display: flex;
            gap: 2rem;
            color: #999;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .event-meta i {
            margin-right: 0.5rem;
            color: #28a745;
        }

        .event-link {
            padding: 0.5rem 1.5rem;
            background: #28a745;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: background 0.2s ease;
            display: inline-block;
        }

        .event-link:hover {
            background: #218838;
        }

        .no-events {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
        }

        .no-events i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .event-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-left: 1rem;
        }

        .event-status.upcoming {
            background: #d4edda;
            color: #155724;
        }

        .event-status.past {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    @include('components.navbar')

    <div class="content-wrapper">
        <!-- Hero Section -->
        <div class="events-hero">
            <div class="container">
                <h1>Events</h1>
                <p>Conferences, workshops, seminars, and lab activities</p>
            </div>
        </div>

        <!-- Events List -->
        <div class="container pb-5">
            <!-- Example Event Structure - Replace with dynamic content when ready -->
            <div class="no-events">
                <i class="fas fa-calendar-alt"></i>
                <h3>Events Coming Soon</h3>
                <p>Information about upcoming conferences, workshops, and seminars will be displayed here.</p>
                <p class="text-muted">Stay tuned for announcements about our lab activities and events.</p>
            </div>

            <!-- Uncomment and use this structure when you have events data -->
            <!--
            <div class="event-card">
                <div class="event-date">
                    <div class="day">15</div>
                    <div class="month">Mar</div>
                    <div class="year">2025</div>
                </div>
                <div class="event-content">
                    <div>
                        <span class="event-type">Workshop</span>
                        <span class="event-status upcoming">Upcoming</span>
                    </div>
                    <div class="event-title">
                        Introduction to Machine Learning for Big Data
                    </div>
                    <div class="event-meta">
                        <span><i class="fas fa-clock"></i>2:00 PM - 5:00 PM</span>
                        <span><i class="fas fa-map-marker-alt"></i>Lab Conference Room</span>
                    </div>
                    <div class="event-description">
                        Join us for an interactive workshop covering the fundamentals of machine learning 
                        techniques applied to large-scale data analysis. Suitable for beginners and intermediate learners.
                    </div>
                    <a href="#" class="event-link">
                        <i class="fas fa-info-circle mr-1"></i> Learn More
                    </a>
                </div>
            </div>

            <div class="event-card">
                <div class="event-date">
                    <div class="day">22</div>
                    <div class="month">Mar</div>
                    <div class="year">2025</div>
                </div>
                <div class="event-content">
                    <div>
                        <span class="event-type">Seminar</span>
                        <span class="event-status upcoming">Upcoming</span>
                    </div>
                    <div class="event-title">
                        Advanced Data Visualization Techniques
                    </div>
                    <div class="event-meta">
                        <span><i class="fas fa-clock"></i>10:00 AM - 12:00 PM</span>
                        <span><i class="fas fa-map-marker-alt"></i>Virtual Event</span>
                    </div>
                    <div class="event-description">
                        Explore cutting-edge visualization methods for complex datasets. 
                        Guest speaker: Dr. Jane Smith from Data Science Institute.
                    </div>
                    <a href="#" class="event-link">
                        <i class="fas fa-video mr-1"></i> Join Online
                    </a>
                </div>
            </div>
            -->
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
    </div>

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>