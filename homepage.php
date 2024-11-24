<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neighborly - Housing Allocation System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Navbar Styles */
        .navbar {
            background-color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .logo {
            color: #4F46E5;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }

        .menu ul {
            display: flex;
            list-style: none;
            gap:8rem;
        }

        .menu a {
            text-decoration: none;
            color: #374151;
            font-weight: 500;
        }

        .btn {
            background-color: #4F46E5;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            text-decoration: none;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background-image: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0) 100%), url('2.png.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 1rem;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.25rem;
            max-width: 800px;
            margin-bottom: 2rem;
        }

        /* Slideshow Section */
        .slideshow {
            position: relative;
            height: 80vh;
            overflow: hidden;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            display: flex;
            align-items: center;
            padding: 2rem;
        }

        .slide.active {
            opacity: 1;
        }

        .slide-content {
            width: 50%;
            padding: 2rem;
        }

        .slide-image {
            width: 50%;
            height: 100%;
            object-fit: cover;
        }

        .slide-arrows {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 2rem;
            transform: translateY(-50%);
        }

        .arrow {
            background: rgba(0,0,0,0.5);
            color: white;
            padding: 1rem;
            border: none;
            cursor: pointer;
            border-radius: 50%;
            font-size: 1.5rem;
        }

        /* About Section */
        .about {
            padding: 5rem 2rem;
            background-color: #f3f4f6;
        }

        .about-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .about-card {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            text-align: center;
        }

        /* Contact Section */
        .contact {
            padding: 5rem 2rem;
            background-color: white;
        }

        .contact-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        /* Footer */
        .footer {
            background-color: #1f2937;
            color: white;
            padding: 2rem 1rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: #9ca3af;
            text-decoration: none;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1rem;
            margin-top: 1rem;
            border-top: 1px solid #374151;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="logo">Neighborly</a>
        <div class="menu">
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="#">MY PROFILE</a></li>
                <li><a href="searching.php">HOUSING OFFERS</a></li>
                <li><a href="#">ABOUT</a></li>
            </ul>
        </div>
        <a href="#" class="btn">LOGOUT</a>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Housing Allocation System</h1>
        <p>Empowering cities and communities with technology to manage affordable housing, aligned with Sustainable Development Goal 11: Building inclusive, safe, and sustainable urban spaces.</p>
        <a href="#" class="btn">Apply Now</a>
    </section>

    <!-- Slideshow Section -->
    <section class="slideshow">
        <div class="slide active">
            <div class="slide-content">
                <h2>Modern Living Spaces</h2>
                <p>Discover contemporary homes designed for modern families, featuring open layouts and smart amenities.</p>
            </div>
            <img src="2.png.jpg" alt="Modern Home" class="slide-image">
        </div>
        <div class="slide">
            <div class="slide-content">
                <h2>Sustainable Communities</h2>
                <p>Join eco-friendly neighborhoods that prioritize sustainability and community well-being.</p>
            </div>
            <img src="property_images/sustainable-community.jpg" alt="Sustainable Community" class="slide-image">
        </div>
        <div class="slide">
            <div class="slide-content">
                <h2>Affordable Housing</h2>
                <p>Find quality homes at affordable prices, making homeownership accessible to everyone.</p>
            </div>
            <img src="property_images/affordable-housing.jpg" alt="Affordable Housing" class="slide-image">
        </div>
        <div class="slide-arrows">
            <button class="arrow" onclick="previousSlide()">&#8249;</button>
            <button class="arrow" onclick="nextSlide()">&#8250;</button>
        </div>
    </section>

    <!-- About Section -->
    <section class="about">
        <div class="about-content">
            <div class="about-card">
                <h3>Our Mission</h3>
                <p>To provide accessible and affordable housing solutions while building sustainable communities.</p>
            </div>
            <div class="about-card">
                <h3>Our Vision</h3>
                <p>Creating inclusive neighborhoods where everyone has access to quality housing and community resources.</p>
            </div>
            <div class="about-card">
                <h3>Our Values</h3>
                <p>Commitment to sustainability, community engagement, and affordable housing solutions.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact">
        <div class="contact-content">
            <h2>Get in Touch</h2>
            <p>We're here to help you find your perfect home</p>
            <div class="contact-info">
                <div>
                    <h3>Email</h3>
                    <p>info@neighborly.com</p>
                </div>
                <div>
                    <h3>Phone</h3>
                    <p>+1 (555) 123-4567</p>
                </div>
                <div>
                    <h3>Address</h3>
                    <p>123 Housing Street<br>Metro Manila, Philippines</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; 2024 Neighborly. All rights reserved.</p>
        </div>
    </footer>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function previousSlide() {
            showSlide(currentSlide - 1);
        }

        // Auto advance slides every 5 seconds
        setInterval(nextSlide, 5000);
    </script>
</body>
</html>