<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="header-container">
        <h1 class="site-title">The Club Compass</h1>
        <nav class="nav-bar">
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="courses.php">Courses</a></li>
                <li><a href="contact.php">Contact</a></li>
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
