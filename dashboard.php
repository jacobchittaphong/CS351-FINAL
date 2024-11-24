<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$conn = new mysqli("localhost", "jcac1", "jacob", "final");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $playing_level = $conn->real_escape_string($_POST['playing_level']);
    $handicap = isset($_POST['handicap']) ? (float)$_POST['handicap'] : null;

    // Update email, playing level, and handicap
    $update_sql = "UPDATE users SET email = ?, playing_level = ?, handicap = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssdi", $email, $playing_level, $handicap, $user_id);
    $stmt->execute();

    // Update password if provided
    if (!empty($_POST['new_password']) && !empty($_POST['current_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        // Verify current password
        if (password_verify($current_password, $user['password'])) {
            $password_sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($password_sql);
            $stmt->bind_param("si", $new_password, $user_id);
            $stmt->execute();
        } else {
            $error = "Current password is incorrect.";
        }
    }

    header("Location: dashboard.php"); // Refresh the page after update
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'header.php'; ?>

    <section class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        <p>Update your profile details below:</p>

        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" class="dashboard-form">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="playing_level">Playing Level:</label>
            <select name="playing_level" id="playing_level">
                <option value="beginner" <?php if ($user['playing_level'] == 'beginner') echo 'selected'; ?>>Beginner</option>
                <option value="amateur" <?php if ($user['playing_level'] == 'amateur') echo 'selected'; ?>>Amateur</option>
                <option value="pro" <?php if ($user['playing_level'] == 'pro') echo 'selected'; ?>>Pro</option>
            </select>

            <label for="handicap">Handicap:</label>
            <input type="number" step="0.1" name="handicap" id="handicap" value="<?php echo htmlspecialchars($user['handicap']); ?>">

            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" placeholder="Required to change password">

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" placeholder="Enter new password">

            <button type="submit" class="cta-button">Save Changes</button>
        </form>
    </section>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
