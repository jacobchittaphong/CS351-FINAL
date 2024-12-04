<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli("localhost", "jcac1", "jacob", "final");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and validate inputs
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    // Insert the feedback into the database
    $sql = "INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        // Redirect with a success message
        header("Location: about.php?feedback=success");
        exit();
    } else {
        // Redirect with an error message
        header("Location: about.php?feedback=error");
        exit();
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
