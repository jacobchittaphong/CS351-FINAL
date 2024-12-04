<?php
// Database connection
$conn = new mysqli("localhost", "jcac1", "jacob", "final");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - The Club Compass</title>
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


                <!-- Filter by State -->
                <select name="location">
                    <option value="">All States</option>
                    <option value="AL" <?php echo (isset($_GET['location']) && $_GET['location'] == 'AL') ? 'selected' : ''; ?>>Alabama (AL)</option>
                    <option value="AK" <?php echo (isset($_GET['location']) && $_GET['location'] == 'AK') ? 'selected' : ''; ?>>Alaska (AK)</option>
                    <option value="AZ" <?php echo (isset($_GET['location']) && $_GET['location'] == 'AZ') ? 'selected' : ''; ?>>Arizona (AZ)</option>
                    <option value="AR" <?php echo (isset($_GET['location']) && $_GET['location'] == 'AR') ? 'selected' : ''; ?>>Arkansas (AR)</option>
                    <option value="CA" <?php echo (isset($_GET['location']) && $_GET['location'] == 'CA') ? 'selected' : ''; ?>>California (CA)</option>
                    <option value="CO" <?php echo (isset($_GET['location']) && $_GET['location'] == 'CO') ? 'selected' : ''; ?>>Colorado (CO)</option>
                    <option value="CT" <?php echo (isset($_GET['location']) && $_GET['location'] == 'CT') ? 'selected' : ''; ?>>Connecticut (CT)</option>
                    <option value="DE" <?php echo (isset($_GET['location']) && $_GET['location'] == 'DE') ? 'selected' : ''; ?>>Delaware (DE)</option>
                    <option value="FL" <?php echo (isset($_GET['location']) && $_GET['location'] == 'FL') ? 'selected' : ''; ?>>Florida (FL)</option>
                    <option value="GA" <?php echo (isset($_GET['location']) && $_GET['location'] == 'GA') ? 'selected' : ''; ?>>Georgia (GA)</option>
                    <option value="HI" <?php echo (isset($_GET['location']) && $_GET['location'] == 'HI') ? 'selected' : ''; ?>>Hawaii (HI)</option>
                    <option value="ID" <?php echo (isset($_GET['location']) && $_GET['location'] == 'ID') ? 'selected' : ''; ?>>Idaho (ID)</option>
                    <option value="IL" <?php echo (isset($_GET['location']) && $_GET['location'] == 'IL') ? 'selected' : ''; ?>>Illinois (IL)</option>
                    <option value="IN" <?php echo (isset($_GET['location']) && $_GET['location'] == 'IN') ? 'selected' : ''; ?>>Indiana (IN)</option>
                    <option value="IA" <?php echo (isset($_GET['location']) && $_GET['location'] == 'IA') ? 'selected' : ''; ?>>Iowa (IA)</option>
                    <option value="KS" <?php echo (isset($_GET['location']) && $_GET['location'] == 'KS') ? 'selected' : ''; ?>>Kansas (KS)</option>
                    <option value="KY" <?php echo (isset($_GET['location']) && $_GET['location'] == 'KY') ? 'selected' : ''; ?>>Kentucky (KY)</option>
                    <option value="LA" <?php echo (isset($_GET['location']) && $_GET['location'] == 'LA') ? 'selected' : ''; ?>>Louisiana (LA)</option>
                    <option value="ME" <?php echo (isset($_GET['location']) && $_GET['location'] == 'ME') ? 'selected' : ''; ?>>Maine (ME)</option>
                    <option value="MD" <?php echo (isset($_GET['location']) && $_GET['location'] == 'MD') ? 'selected' : ''; ?>>Maryland (MD)</option>
                    <option value="MA" <?php echo (isset($_GET['location']) && $_GET['location'] == 'MA') ? 'selected' : ''; ?>>Massachusetts (MA)</option>
                    <option value="MI" <?php echo (isset($_GET['location']) && $_GET['location'] == 'MI') ? 'selected' : ''; ?>>Michigan (MI)</option>
                    <option value="MN" <?php echo (isset($_GET['location']) && $_GET['location'] == 'MN') ? 'selected' : ''; ?>>Minnesota (MN)</option>
                    <option value="MS" <?php echo (isset($_GET['location']) && $_GET['location'] == 'MS') ? 'selected' : ''; ?>>Mississippi (MS)</option>
                    <option value="MO" <?php echo (isset($_GET['location']) && $_GET['location'] == 'MO') ? 'selected' : ''; ?>>Missouri (MO)</option>
                    <option value="MT" <?php echo (isset($_GET['location']) && $_GET['location'] == 'MT') ? 'selected' : ''; ?>>Montana (MT)</option>
                    <option value="NE" <?php echo (isset($_GET['location']) && $_GET['location'] == 'NE') ? 'selected' : ''; ?>>Nebraska (NE)</option>
                    <option value="NV" <?php echo (isset($_GET['location']) && $_GET['location'] == 'NV') ? 'selected' : ''; ?>>Nevada (NV)</option>
                    <option value="NH" <?php echo (isset($_GET['location']) && $_GET['location'] == 'NH') ? 'selected' : ''; ?>>New Hampshire (NH)</option>
                    <option value="NJ" <?php echo (isset($_GET['location']) && $_GET['location'] == 'NJ') ? 'selected' : ''; ?>>New Jersey (NJ)</option>
                    <option value="NM" <?php echo (isset($_GET['location']) && $_GET['location'] == 'NM') ? 'selected' : ''; ?>>New Mexico (NM)</option>
                    <option value="NY" <?php echo (isset($_GET['location']) && $_GET['location'] == 'NY') ? 'selected' : ''; ?>>New York (NY)</option>
                    <option value="NC" <?php echo (isset($_GET['location']) && $_GET['location'] == 'NC') ? 'selected' : ''; ?>>North Carolina (NC)</option>
                    <option value="ND" <?php echo (isset($_GET['location']) && $_GET['location'] == 'ND') ? 'selected' : ''; ?>>North Dakota (ND)</option>
                    <option value="OH" <?php echo (isset($_GET['location']) && $_GET['location'] == 'OH') ? 'selected' : ''; ?>>Ohio (OH)</option>
                    <option value="OK" <?php echo (isset($_GET['location']) && $_GET['location'] == 'OK') ? 'selected' : ''; ?>>Oklahoma (OK)</option>
                    <option value="OR" <?php echo (isset($_GET['location']) && $_GET['location'] == 'OR') ? 'selected' : ''; ?>>Oregon (OR)</option>
                    <option value="PA" <?php echo (isset($_GET['location']) && $_GET['location'] == 'PA') ? 'selected' : ''; ?>>Pennsylvania (PA)</option>
                    <option value="RI" <?php echo (isset($_GET['location']) && $_GET['location'] == 'RI') ? 'selected' : ''; ?>>Rhode Island (RI)</option>
                    <option value="SC" <?php echo (isset($_GET['location']) && $_GET['location'] == 'SC') ? 'selected' : ''; ?>>South Carolina (SC)</option>
                    <option value="SD" <?php echo (isset($_GET['location']) && $_GET['location'] == 'SD') ? 'selected' : ''; ?>>South Dakota (SD)</option>
                    <option value="TN" <?php echo (isset($_GET['location']) && $_GET['location'] == 'TN') ? 'selected' : ''; ?>>Tennessee (TN)</option>
                    <option value="TX" <?php echo (isset($_GET['location']) && $_GET['location'] == 'TX') ? 'selected' : ''; ?>>Texas (TX)</option>
                    <option value="UT" <?php echo (isset($_GET['location']) && $_GET['location'] == 'UT') ? 'selected' : ''; ?>>Utah (UT)</option>
                    <option value="VT" <?php echo (isset($_GET['location']) && $_GET['location'] == 'VT') ? 'selected' : ''; ?>>Vermont (VT)</option>
                    <option value="VA" <?php echo (isset($_GET['location']) && $_GET['location'] == 'VA') ? 'selected' : ''; ?>>Virginia (VA)</option>
                    <option value="WA" <?php echo (isset($_GET['location']) && $_GET['location'] == 'WA') ? 'selected' : ''; ?>>Washington (WA)</option>
                    <option value="WV" <?php echo (isset($_GET['location']) && $_GET['location'] == 'WV') ? 'selected' : ''; ?>>West Virginia (WV)</option>
                    <option value="WI" <?php echo (isset($_GET['location']) && $_GET['location'] == 'WI') ? 'selected' : ''; ?>>Wisconsin (WI)</option>
                    <option value="WY" <?php echo (isset($_GET['location']) && $_GET['location'] == 'WY') ? 'selected' : ''; ?>>Wyoming (WY)</option>
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
                $total_results_sql .= " AND SUBSTRING_INDEX(location, ', ', -1) = '$location'";
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
                $sql .= " AND SUBSTRING_INDEX(location, ', ', -1) = '$location'";
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
