<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to leave a review.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "jcac1", "jacob", "final");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $course_id = (int)$_POST['course_id'];
    $user_id = (int)$_SESSION['user_id'];
    $review_text = $conn->real_escape_string($_POST['review_text']);
    $rating = (int)$_POST['rating'];

    $sql = "INSERT INTO reviews (course_id, user_id, review_text, rating) 
            VALUES ($course_id, $user_id, '$review_text', $rating)";

    if ($conn->query($sql)) {
        header("Location: course_details.php?id=$course_id"); // Redirect to the course details page
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
