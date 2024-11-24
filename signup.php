<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "jcac1", "jacob", "final");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql)) {
        echo "Signup successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'header.php'; ?>

    <section class="form-section">
        <h2>Create an Account</h2>
        <form method="POST" class="form-container">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit" class="cta-button">Signup</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </section>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
