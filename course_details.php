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

    <section class="course-reviews">
    <h3>Reviews</h3>

    <?php
    // Fetch average rating for the course
    $average_rating_sql = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE course_id = ?";
    $stmt = $conn->prepare($average_rating_sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $avg_result = $stmt->get_result();
    $avg_row = $avg_result->fetch_assoc();
    $average_rating = $avg_row['avg_rating'] ? number_format($avg_row['avg_rating'], 2) : "No ratings yet";

    // Display average rating
    echo '<div class="average-rating">';
    if (is_numeric($average_rating)) {
        echo "<p>Average Rating: <strong>$average_rating / 5</strong></p>";
    } else {
        echo "<p>$average_rating</p>"; // Display "No ratings yet" if no reviews
    }
    echo '</div>';
    ?>

    <?php
    // Fetch and display reviews
    $review_sql = "SELECT r.id AS review_id, r.review_text, r.rating, r.created_at, u.username, u.handicap, u.playing_level, u.id AS user_id
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
            // Show delete button only if the logged-in user is the review author
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']) {
                echo '<form method="POST" action="delete_review.php" style="display:inline;">
                        <input type="hidden" name="review_id" value="' . htmlspecialchars($review['review_id']) . '">
                        <input type="hidden" name="course_id" value="' . htmlspecialchars($course_id) . '">
                        <button type="submit" class="delete-button">Delete</button>
                      </form>';
            }
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

        <?php if (!empty($course['website_url'])): ?>
            <a href="<?php echo htmlspecialchars($course['website_url']); ?>" target="_blank" class="cta-button">Visit Website</a>
        <?php endif; ?>
    </section>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>

    <?php $conn->close(); ?>
</body>
</html>
