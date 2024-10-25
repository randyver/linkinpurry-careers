<?php

if (!isset($_SESSION['user_id'])) {
    $name = 'Not Signed In';
    $isLoggedIn = false;
} else {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    $name = $_SESSION['name'];
    $isLoggedIn = true;
}

$home = true;
$application_history = false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseeker - Home</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/jobseeker/home-jobseeker.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar-jobseeker.php'; ?>

    <!-- Main Content -->
    <div class="main-container">
        <aside class="filter-section">
            <div class="profile-card">
                <div class="profile-banner">
                    <img src="../../../public/images/profile-banner.svg" alt="Profile Banner" class="banner-img">
                </div>

                <div class="profile-pic-wrapper">
                    <img src="../../../public/images/profile-pic.png" alt="Profile Pic" class="profile-pic">
                </div>

                <div class="profile-info">
                    <h2><?php echo $name; ?></h2>
                    <p>Welcome to LinkinPurry. Search for your dream job here!</p>
                </div>
            </div>

            <div class="filter-text">Filter</div>
            <div class="filter">
                <div class="filter-group">
                    <div for="posted" class="filter-type">Posted</div>
                    <select id="posted-month">
                        <option value="" disabled selected>Select month</option>
                        <option value="1">January</option>
                        <option value="2">Febuary</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                        <option value="clear">Clear Selection</option>
                    </select>
                    <select id="posted-year">
                        <option value="" disabled selected>Select year</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="clear">Clear Selection</option>
                    </select>
                </div>

                <div class="filter-group">
                    <div class="filter-type">Location</div>
                    <label><input type="checkbox" value="on-site" id='filter-location'> On-site</label>
                    <label><input type="checkbox" value="remote" id='filter-location'> Remote</label>
                    <label><input type="checkbox" value="hybrid" id='filter-location'> Hybrid</label>
                </div>

                <div class="filter-group">
                    <div for="type" class="filter-type">Type</div>
                    <label><input type="checkbox" value="full-time" id='filter-jobtype'> Full-time</label>
                    <label><input type="checkbox" value="part-time" id='filter-jobtype'> Part-time</label>
                    <label><input type="checkbox" value="internship" id='filter-jobtype'> Internship</label>
                </div>
            </div>
        </aside>

        <section class="job-listings">
            <div class="search-container">
                <img src="../../../public/images/search-icon.svg" alt="Search Icon" class="search-icon">
                <input type="text" class="search-input" placeholder="Discover jobs...">
            </div>
            <div class="sort-bar">
                <hr class="sort-line">
                <div class="sort-options">
                    <span>Sort by:</span>
                    <select>
                        <option value="recent">Recent</option>
                        <option value="oldest">Oldest</option>
                    </select>
                </div>
            </div>
            <div id="job-listings-response"></div>

        </section>

        <aside class="recommendations-section">
            <div class="recommendation-card">
                <h3>Trending jobs you may be interested in</h3>

                <div id="recommendation-response"></div>

                <!-- <a href=" #" class="recommendation-item-link">
                    <div class="recommendation-item">
                        <div class="recommendation-details">
                            <strong>Web Developer</strong>
                            <p>WBD Media Co.</p>
                        </div>
                    </div>
                    </a>

                    <a href="#" class="recommendation-item-link">
                        <div class="recommendation-item">
                            <div class="recommendation-details">
                                <strong>Junior Software Engineer</strong>
                                <p>WBD Corp</p>
                            </div>
                        </div>
                    </a> -->
            </div>

            <footer class="footer">
                <div class="footer-links">
                    <a href="/about">About</a>
                    <a href="#">More</a>
                </div>
                <div class="footer-logo">
                    <img src="../../../public/images/logo-icon-text.svg" alt="LinkedInPurry Logo">
                    <span>LinkinPurry © 2024</span>
                </div>
            </footer>
        </aside>
    </div>
    <script src="../../../public/js/company-navigation.js"></script>
    <script src="../../../public/js/home-jobseeker.js"></script>
</body>

</html>