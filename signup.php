<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $conn = new mysqli("localhost", "jcac1", "jacob", "final");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and validate input data
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $handicap = isset($_POST['handicap']) && $_POST['handicap'] !== '' ? (float)$_POST['handicap'] : null;
    $playing_level = isset($_POST['playing_level']) ? $conn->real_escape_string($_POST['playing_level']) : 'beginner';

    // Validate handicap input
    if ($handicap !== null && ($handicap < -10.0 || $handicap > 54.0)) {
        die("Invalid handicap value. Must be between -10.0 and 54.0.");
    }

    // Insert user into the database
    $sql = "INSERT INTO users (username, email, password, handicap, playing_level)
            VALUES ('$username', '$email', '$password', " . ($handicap !== null ? $handicap : "NULL") . ", '$playing_level')";

    if ($conn->query($sql)) {
        echo "Signup successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
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

            <label for="handicap">Handicap (e.g., -3.0 for plus handicap, 10.0 for standard handicap):</label>
            <input type="number" step="0.1" name="handicap" id="handicap" placeholder="Optional" min="-10.0" max="54.0">

            <label for="playing_level">Playing Level:</label>
            <select name="playing_level" id="playing_level">
                <option value="beginner">Beginner</option>
                <option value="amateur">Amateur</option>
                <option value="pro">Pro</option>
            </select>

            <button type="submit" class="cta-button">Signup</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </section>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
