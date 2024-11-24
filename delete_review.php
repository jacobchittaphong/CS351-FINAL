<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "jcac1", "jacob", "final");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $review_id = (int)$_POST['review_id'];
    $course_id = (int)$_POST['course_id'];
    $user_id = $_SESSION['user_id'];

    // Verify the review belongs to the logged-in user
    $check_sql = "SELECT * FROM reviews WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $review_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete the review
        $delete_sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $review_id);
        $stmt->execute();

        // Redirect back to the course details page
        $_SESSION['success'] = "Review deleted successfully.";
        header("Location: course_details.php?id=$course_id");
        exit();
    } else {
        $_SESSION['error'] = "Unauthorized action.";
        header("Location: course_details.php?id=$course_id");
        exit();
    }
}
?>
