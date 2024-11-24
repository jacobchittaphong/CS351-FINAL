<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "jcac1", "jacob", "final");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'header.php'; ?>

    <section class="form-section">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" class="form-container">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit" class="cta-button">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Signup here</a>.</p>
    </section>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
