<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Club Compass</title>
    <link rel="stylesheet" href="styles.css">

    <!-- Favicon Links -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>
<body>
    <header>
        <div class="header-container">
            <a href="index.php" class="site-logo">
                <img src="apple-touch-icon.png" alt="The Club Compass Logo">
            </a>
            <nav class="nav-bar">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="courses.php">Courses</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
                <div class="auth-links">
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="dashboard.php" class="auth-button">Dashboard</a>
                        <a href="logout.php" class="auth-button">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="auth-button">Login</a>
                        <a href="signup.php" class="auth-button">Signup</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
