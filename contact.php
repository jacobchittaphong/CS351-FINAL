<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - The Club Compass</title>
    <link rel="stylesheet" href="styles.css">
</head>
<?php include 'header.php'; ?>
<section class="contact-section">
        <h2>Contact Us</h2>
        <p>
            We value your feedback and would love to hear from you! If you have any questions, suggestions, or need assistance, please use the form below to reach out to us.
        </p>
        <form method="POST" action="submit_feedback.php" class="contact-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Your Feedback or Questions" required></textarea>

            <button type="submit" class="cta-button">Submit</button>
        </form>
</section>
<?php include 'footer.php'; ?>
</body>
</html>
