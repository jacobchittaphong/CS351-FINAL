<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Golf Course Finder</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'header.php'; ?>

    <!-- Hero Section -->
    <section class="hero intro-hero">
        <div class="hero-content">
            <h2>Explore Golf Courses</h2>
            <p>Find the perfect golf course for your next game, tailored to your preferences and location.</p>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="courses-listing">
        <h3>Available Golf Courses</h3>

        <section class="courses-search">
    <form method="GET" action="courses.php" class="search-form">
        <!-- Search by Name or Location -->
        <input type="text" name="search" placeholder="Search by name or location" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

        <!-- Filter by Difficulty -->
        <select name="difficulty">
            <option value="">All Difficulties</option>
            <option value="Easy" <?php echo (isset($_GET['difficulty']) && $_GET['difficulty'] == 'Easy') ? 'selected' : ''; ?>>Easy</option>
            <option value="Intermediate" <?php echo (isset($_GET['difficulty']) && $_GET['difficulty'] == 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
            <option value="Hard" <?php echo (isset($_GET['difficulty']) && $_GET['difficulty'] == 'Hard') ? 'selected' : ''; ?>>Hard</option>
            <option value="Pro" <?php echo (isset($_GET['difficulty']) && $_GET['difficulty'] == 'Pro') ? 'selected' : ''; ?>>Pro</option>
        </select>

        <!-- Filter by Holes -->
        <select name="holes">
            <option value="">All Holes</option>
            <option value="9" <?php echo (isset($_GET['holes']) && $_GET['holes'] == '9') ? 'selected' : ''; ?>>9 Holes</option>
            <option value="18" <?php echo (isset($_GET['holes']) && $_GET['holes'] == '18') ? 'selected' : ''; ?>>18 Holes</option>
        </select>

        <!-- Filter by Location -->
        <select name="location">
            <option value="">All Locations</option>
            <?php
            // Fetch unique locations from the database
            $conn = new mysqli("localhost", "jcac1", "jacob", "final");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $location_query = "SELECT DISTINCT location FROM golf_courses";
            $location_result = $conn->query($location_query);

            if ($location_result->num_rows > 0) {
                while ($row = $location_result->fetch_assoc()) {
                    $selected = (isset($_GET['location']) && $_GET['location'] == $row['location']) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($row['location']) . '" ' . $selected . '>' . htmlspecialchars($row['location']) . '</option>';
                }
            }

            $conn->close();
            ?>
        </select>

        <!-- Submit Button -->
        <button type="submit" class="cta-button">Filter</button>
    </form>
</section>

        <!-- Courses Grid -->
        <div class="course-grid">
            <?php
            // Establish database connection
            $conn = new mysqli("localhost", "jcac1", "jacob", "final");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Base SQL query
            $sql = "SELECT * FROM golf_courses WHERE 1";

            // Add search condition
            if (!empty($_GET['search'])) {
                $search = $conn->real_escape_string($_GET['search']);
                $sql .= " AND (name LIKE '%$search%' OR location LIKE '%$search%')";
            }

            // Add difficulty filter
            if (!empty($_GET['difficulty'])) {
                $difficulty = $conn->real_escape_string($_GET['difficulty']);
                $sql .= " AND difficulty = '$difficulty'";
            }

            // Add holes filter
            if (!empty($_GET['holes'])) {
                $holes = (int)$_GET['holes'];
                $sql .= " AND holes = $holes";
            }

            // Add location filter
            if (!empty($_GET['location'])) {
                $location = $conn->real_escape_string($_GET['location']);
                $sql .= " AND location = '$location'";
            }

            // Execute query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Loop through the courses and display them
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="course-card">';
                    echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
                    echo '<p>' . htmlspecialchars($row['location']) . '</p>';
                    echo '<p>Difficulty: ' . htmlspecialchars($row['difficulty']) . '</p>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<a href="course_details.php?id=' . $row['id'] . '" class="cta-button">View Details</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>No courses match your criteria.</p>";
            }

            $conn->close();
            ?>
        </div>
    </section>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
