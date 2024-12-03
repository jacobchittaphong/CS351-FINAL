<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - The Club Compass</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="about-section">
        <h2>About The Club Compass</h2>
        <img src="family.jpg" alt="Family Golfing" class="about-image">
        <p>
            Welcome to <strong>The Club Compass</strong>, your go-to destination for discovering the best golf courses tailored to your preferences. Whether you're a seasoned golfer or just starting your journey, we aim to simplify your golfing experience by providing detailed course information, reviews, and personalized recommendations.
        </p>
        <p>
            Our mission is to connect golfers with courses that suit their skill levels, locations, and amenities. From local favorites to world-reowned courses, we make it easy to find and explore your next golfing adventure. 
        </p>  
    </section>

    <section class="mission-section">
        <h3>Our Mission</h3>
        <p>
            At <strong>The Club Compass</strong>, our mission is to inspire and assist golfers of all levels providing a comprehensive platform to discover, review, and connect with golf courses worldwide. We are dedicated to enhancing the golfing experience and fostering a community of enthusiast who share a passion for the game.
        </p>
    </section>
    
    <section class="statistics-section">
        <h3>Golf Industry by the Numbers</h3>
        <ul>
            <li>The U.S. has over <strong>16,000 golf courses</strong>, more than any other country.</li>
            <li>Golf generates an estimated <strong>$84 billion</strong> annually in the U.S. economy.</li>
            <li>Over <strong>24 million people</strong> play golf each year in the United States.</li>
            <li>Scotland is home to some of the world's oldest and most iconic golf courses, including St. Andrews.</li>
        </ul>
    </section>

    <section class="feedback-section">
        <h3>We Value Your Feedback</h3>
        <p>
            Your feedback helps us improve and provide the best golfing experience for our community. Please use the form below to share your thoughts or ask questions.
        </p>
        <form method="POST" action="submit_feedback.php" class="feedback-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Your Feedback or Questions" required style="height: 200px;"></textarea>

            <button type="submit" class="cta-button">Submit</button>
        </form>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>
