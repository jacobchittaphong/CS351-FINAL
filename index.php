<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Club Compass</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'header.php'; ?>

    <!-- Hero Section: Introduction -->
    <section class="hero intro-hero">
        <div class="hero-left">
            <img src="mj.jpg" alt="Golf Course" class="hero-image">
        </div>
        <div class="hero-right">
            <h2>The Club Compass</h2>
            <p>Welcome to The Club Compass! Whether you're a seasoned golfer or just starting, we've got you covered. Discover the best courses near you, plan your next game, and connect with fellow golf enthusiasts. Let us help you find your perfect tee time and elevate your golfing experience!</p>
            <a href="courses.php" class="cta-button">Find Courses</a>
        </div>
    </section>

    <!-- Featured Golf Courses Section -->
    <section class="featured-courses">
        <h3>Featured Golf Courses</h3>
        <div class="course-grid">
            <div class="course-card">
                <img src="pipestem.jpg" alt="Pipestem Championship Golf Course">
                <h4>Pipestem Championship Golf Course</h4>
                <p>A stunning course with scenic views and challenging holes.</p>
            </div>
            <div class="course-card">
                <img src="greenbrier.jpg" alt="The Old White Golf Course - Greenbrier Resort">
                <h4>The Old White at the Greenbrier</h4>
                <p>Perfect for beginners and casual golfers seeking a relaxed game.</p>
            </div>
            <div class="course-card">
                <img src="fincastle.jpg" alt="Fincastle Golf Course">
                <h4>Fincastle Golf Course</h4>
                <p>Experience luxury golfing with top-notch facilities.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <h3>What Golfers Are Saying</h3>
        <div class="testimonial-cards">
            <div class="testimonial-card">
                <p>"The Club Compass helped me discover amazing courses near me. Highly recommend!"</p>
                <h4>- John D.</h4>
            </div>
            <div class="testimonial-card">
                <p>"A great tool for beginners and pros alike. I love the easy-to-use interface."</p>
                <h4>- Sarah L.</h4>
            </div>
            <div class="testimonial-card">
                <p>"Finding and booking my favorite courses has never been easier."</p>
                <h4>- Mike T.</h4>
            </div>
        </div>
    </section>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
