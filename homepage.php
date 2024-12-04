<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/homepage-style.css">
    <title>Neighborly: Housing Allocation System</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="homepage.php" class="logo">Neighborly</a>
        <div class="menu">
            <ul>
                <li><a href="homepage.php">HOME</a></li>
                <li><a href="profile.php">MY PROFILE</a></li>
                <li><a href="searching.php">HOUSING OFFERS</a></li>
                <li><a href="#about">ABOUT</a></li>
            </ul>
        </div>
        <a href="logout.php" class="btn">LOGOUT</a>
    </nav>

    <section class="slideshow">
        <div class="slide active">
            <div class="slide-image-container">
                <img src="img/1.png" alt="Modern Home" class="slide-image">
                <div class="overlay"></div>
            </div>
            <div class="slide-content">
                <h2>Modern Living Spaces</h2>
                <p>Discover contemporary homes designed for modern families, featuring open layouts and smart amenities.</p>
                <a href="searching.php" class="btn apply-now">Apply Now</a>
            </div>
        </div>
        <div class="slide">
            <div class="slide-image-container">
                <img src="img/2.png" alt="Sustainable Community" class="slide-image">
                <div class="overlay"></div>
            </div>
            <div class="slide-content">
                <h2>Sustainable Communities</h2>
                <p>Join eco-friendly neighborhoods that prioritize sustainability and community well-being.</p>
                <a href="searching.php" class="btn apply-now">Apply Now</a>
            </div>
        </div>
        <div class="slide">
            <div class="slide-image-container">
                <img src="img/3.png" alt="Affordable Housing" class="slide-image">
                <div class="overlay"></div>
            </div>
            <div class="slide-content">
                <h2>Affordable Housing</h2>
                <p>Find quality homes at affordable prices, making homeownership accessible to everyone.</p>
                <a href="searching.php" class="btn apply-now">Apply Now</a>
            </div>
        </div>
        <div class="slide-arrows">
            <button class="arrow prev" onclick="previousSlide()">&#8249;</button>
            <button class="arrow next" onclick="nextSlide()">&#8250;</button>
        </div>
    </section>

    <section id = "about" class="about">
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

        setInterval(nextSlide, 5000);
    </script>
</body>
</html>

