<?php
session_start(); // Start session for user authentication

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
            src="https://www.google.com/maps?q=<?php echo urlencode($course['address']); ?>&output=embed"
            loading="lazy">
        </iframe>
    </section>

    <!-- Review Form (for logged-in users) -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <section class="add-review">
        <h3>Leave a Review</h3>
        <form method="POST" action="submit_review.php">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <textarea name="review_text" placeholder="Write your review here..." required></textarea>
            <label for="rating">Rating:</label>
            <select name="rating" required>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select>
            <button type="submit" class="cta-button">Submit Review</button>
        </form>
    </section>
    <?php else: ?>
    <p style="text-align: center;"><a href="login.php">Login</a> to leave a review.</p>
    <?php endif; ?>

    <!-- Reviews Section -->
    <section class="course-reviews">
<h3>Reviews</h3>
<?php
// Fetch reviews for the course
$review_sql = "SELECT r.review_text, r.rating, r.created_at, u.username, u.handicap, u.playing_level
               FROM reviews r
               JOIN users u ON r.user_id = u.id
               WHERE r.course_id = $course_id
               ORDER BY r.created_at DESC";
$review_result = $conn->query($review_sql);

if ($review_result->num_rows > 0) {
    while ($review = $review_result->fetch_assoc()) {
        echo '<div class="review">';
        echo '<p><strong>' . htmlspecialchars($review['username']) . '</strong>';
        if (!is_null($review['handicap'])) {
            echo ' (Handicap: ' . (($review['handicap'] > 0) ? '+' : '') . htmlspecialchars($review['handicap']) . ')';
        }
        echo ' - ' . ucfirst(htmlspecialchars($review['playing_level'])) . '</p>';
        echo '<p>' . htmlspecialchars($review['review_text']) . '</p>';
        echo '<p>Rating: ' . htmlspecialchars($review['rating']) . '/5</p>';
        echo '<p><small>Posted on: ' . htmlspecialchars($review['created_at']) . '</small></p>';
        echo '</div>';
    }
} else {
    echo "<p>No reviews yet. Be the first to review this course!</p>";
}
?>
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
