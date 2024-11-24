<?php
// Ensure 'id' is provided in the URL and is numeric
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid course ID.");
}

$course_id = (int)$_GET['id'];

// Connect to the database
$conn = new mysqli("localhost", "jcac1", "jacob", "final");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch course details
$sql = "SELECT * FROM golf_courses WHERE id = $course_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Course not found.");
}

$course = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['name']); ?> - Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'header.php'; ?>

    <!-- Course Details Section -->
    <section class="course-details">
        <h2><?php echo htmlspecialchars($course['name']); ?></h2>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($course['location']); ?></p>
        <p><strong>Difficulty:</strong> <?php echo htmlspecialchars($course['difficulty']); ?></p>
        <p><strong>Holes:</strong> <?php echo htmlspecialchars($course['holes']); ?></p>
        <p><strong>Cost:</strong> $<?php echo number_format($course['cost'], 2); ?></p>
        <p><strong>Rating:</strong> <?php echo htmlspecialchars($course['rating']); ?>/5</p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($course['description']); ?></p>
        <p><strong>Amenities:</strong> <?php echo htmlspecialchars($course['amenities']); ?></p>
    </section>

    <!-- Google Maps Integration -->
    <section class="google-map">
        <h3>Location Map</h3>
        <iframe
            src="https://www.google.com/maps?q=<?php echo urlencode($course['location']); ?>&output=embed"
            width="600"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </section>

    <!-- Reviews Section -->
    <section class="course-reviews">
        <h3>Reviews</h3>
        <?php
        // Fetch reviews for the course
        $review_sql = "SELECT * FROM reviews WHERE course_id = $course_id ORDER BY created_at DESC";
        $review_result = $conn->query($review_sql);

        if ($review_result->num_rows > 0) {
            while ($review = $review_result->fetch_assoc()) {
                echo '<div class="review">';
                echo '<p><strong>' . htmlspecialchars($review['user_name']) . ':</strong> ' . htmlspecialchars($review['review_text']) . '</p>';
                echo '<p>Rating: ' . htmlspecialchars($review['rating']) . '/5</p>';
                echo '<p><small>Posted on: ' . htmlspecialchars($review['created_at']) . '</small></p>';
                echo '</div>';
            }
        } else {
            echo "<p>No reviews available for this course.</p>";
        }
        ?>
    </section>

    <!-- Booking Link -->
    <section class="booking-link">
        <h3>Ready to Book?</h3>
        <a href="contact.php?course_id=<?php echo $course_id; ?>" class="cta-button">Contact Us for Booking</a>
    </section>

    <!-- Back Button -->
    <section class="back-button">
        <a href="courses.php" class="cta-button">Back to Courses</a>
    </section>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>

    <?php $conn->close(); ?>
</body>
</html>
