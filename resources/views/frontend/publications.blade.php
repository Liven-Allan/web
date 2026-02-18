<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publications - Big Data Analytics Lab</title>
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

        .publications-hero {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 4rem 0;
            color: white;
            text-align: center;
            margin-bottom: 3rem;
        }

        .publications-hero h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .publications-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .publication-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .publication-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .publication-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .publication-authors {
            color: #666;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .publication-venue {
            color: #28a745;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .publication-year {
            color: #999;
            font-size: 0.9rem;
        }

        .publication-links {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
        }

        .publication-link {
            padding: 0.5rem 1rem;
            background: #28a745;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: background 0.2s ease;
        }

        .publication-link:hover {
            background: #218838;
        }

        .no-publications {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
        }

        .no-publications i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    @include('components.navbar')

    <div class="content-wrapper">
        <!-- Hero Section -->
        <div class="publications-hero">
            <div class="container">
                <h1>Publications</h1>
                <p>Research papers, journal articles, and academic contributions from our lab</p>
            </div>
        </div>

        <!-- Publications List -->
        <div class="container pb-5">
            <!-- Example Publication Structure - Replace with dynamic content when ready -->
            <div class="no-publications">
                <i class="fas fa-book-open"></i>
                <h3>Publications Coming Soon</h3>
                <p>Our research publications and academic papers will be displayed here.</p>
                <p class="text-muted">Check back later for updates on our latest research findings.</p>
            </div>

            <!-- Uncomment and use this structure when you have publications data -->
            <!--
            <div class="publication-card">
                <div class="publication-title">
                    Sample Publication Title: Advanced Machine Learning Techniques for Big Data Analysis
                </div>
                <div class="publication-authors">
                    John Doe, Jane Smith, Robert Johnson
                </div>
                <div class="publication-venue">
                    International Conference on Data Science (ICDS 2024)
                </div>
                <div class="publication-year">
                    2024
                </div>
                <div class="publication-links">
                    <a href="#" class="publication-link">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </a>
                    <a href="#" class="publication-link">
                        <i class="fas fa-link mr-1"></i> DOI
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