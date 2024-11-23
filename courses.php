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

        <!-- Search and Filters Section -->
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
                    ?>
                </select>

                <!-- Sorting Dropdown -->
                <select name="sort_by">
                    <option value="">Sort By</option>
                    <option value="name_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'name_asc') ? 'selected' : ''; ?>>Name (A-Z)</option>
                    <option value="name_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'name_desc') ? 'selected' : ''; ?>>Name (Z-A)</option>
                    <option value="cost_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'cost_asc') ? 'selected' : ''; ?>>Cost (Low to High)</option>
                    <option value="cost_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'cost_desc') ? 'selected' : ''; ?>>Cost (High to Low)</option>
                    <option value="rating_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'rating_desc') ? 'selected' : ''; ?>>Rating (High to Low)</option>
                    <option value="rating_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'rating_asc') ? 'selected' : ''; ?>>Rating (Low to High)</option>
                </select>

                <!-- Submit Button -->
                <button type="submit" class="cta-button">Filter</button>
            </form>
        </section>

        <!-- Courses Grid -->
        <div class="course-grid">
            <?php
            // Pagination logic
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
            $results_per_page = 9;
            $offset = ($page - 1) * $results_per_page;

            // Get total number of matching courses for pagination
            $total_results_sql = "SELECT COUNT(*) AS total FROM golf_courses WHERE 1";

            // Add filters to count query
            if (!empty($_GET['search'])) {
                $search = $conn->real_escape_string($_GET['search']);
                $total_results_sql .= " AND (name LIKE '%$search%' OR location LIKE '%$search%')";
            }
            if (!empty($_GET['difficulty'])) {
                $difficulty = $conn->real_escape_string($_GET['difficulty']);
                $total_results_sql .= " AND difficulty = '$difficulty'";
            }
            if (!empty($_GET['holes'])) {
                $holes = (int)$_GET['holes'];
                $total_results_sql .= " AND holes = $holes";
            }
            if (!empty($_GET['location'])) {
                $location = $conn->real_escape_string($_GET['location']);
                $total_results_sql .= " AND location = '$location'";
            }

            $total_results_result = $conn->query($total_results_sql);
            $total_results_row = $total_results_result->fetch_assoc();
            $total_results = $total_results_row['total'];
            $total_pages = ceil($total_results / $results_per_page);

            // Fetch courses for current page
            $sql = "SELECT * FROM golf_courses WHERE 1";

            // Add filters to main query
            if (!empty($_GET['search'])) {
                $sql .= " AND (name LIKE '%$search%' OR location LIKE '%$search%')";
            }
            if (!empty($_GET['difficulty'])) {
                $sql .= " AND difficulty = '$difficulty'";
            }
            if (!empty($_GET['holes'])) {
                $sql .= " AND holes = $holes";
            }
            if (!empty($_GET['location'])) {
                $sql .= " AND location = '$location'";
            }

            // Add sorting to the query
            if (!empty($_GET['sort_by'])) {
                switch ($_GET['sort_by']) {
                    case 'name_asc':
                        $sql .= " ORDER BY name ASC";
                        break;
                    case 'name_desc':
                        $sql .= " ORDER BY name DESC";
                        break;
                    case 'cost_asc':
                        $sql .= " ORDER BY cost ASC";
                        break;
                    case 'cost_desc':
                        $sql .= " ORDER BY cost DESC";
                        break;
                    case 'rating_desc':
                        $sql .= " ORDER BY rating DESC";
                        break;
                    case 'rating_asc':
                        $sql .= " ORDER BY rating ASC";
                        break;
                }
            }

            // Add LIMIT and OFFSET for pagination
            $sql .= " LIMIT $results_per_page OFFSET $offset";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Display courses dynamically
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="course-card">';
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

        <!-- Pagination -->
        <section class="pagination">
            <?php
            if ($page > 1) {
                echo '<a href="?page=' . ($page - 1) . '" class="cta-button">Previous</a>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<strong class="current-page">' . $i . '</strong>';
                } else {
                    echo '<a href="?page=' . $i . '" class="cta-button">' . $i . '</a>';
                }
            }
            if ($page < $total_pages) {
                echo '<a href="?page=' . ($page + 1) . '" class="cta-button">Next</a>';
            }
            ?>
        </section>
    </section>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
