<?php
// session_start();

// if (!isset($_SESSION['user_id'])) {
//     header('Location: /login');
//     exit;
// }
// $user_id = $_SESSION['user_id'];
// $role = $_SESSION['role'];
// $name = $_SESSION['name'];

// if ($role != 'company') {
//     header('Location: /login');
//     exit;
// }

$user_id = 3;
$name = "company name";

$_SESSION['user_id'] = $user_id;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company - Home</title>
    <link rel="stylesheet" href="../../../public/css/company/home-company.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="../../../public/images/logo-icon.svg" alt="Logo" class="logo">
            <input type="text" class="search-input" placeholder="Search jobs...">
            <button class="search-button">
                <img src="../../../public/images/search-icon.svg" alt="Search">
            </button>
        </div>
        <div class="navbar-right">

            <div class="nav-profile-section">
                <img src="../../../public/images/profile-pic.png" alt="Profile" class="nav-profile-pic">
                <span class="profile-name"><?php echo htmlspecialchars($name); ?></span>
                <img src="../../../public/images/arrow-down.svg" alt="Dropdown Arrow" class="dropdown-arrow" id="dropdown-arrow">
            </div>

            <div class="dropdown-menu" id="dropdown-menu">
                <a href="#" class="dropdown-item">View Profile</a>
                <!-- Form untuk logout -->
                <form action="/logout" method="POST" class="dropdown-item">
                    <button type="submit" style="background: none; border: none; padding: 0; color: red; font-size: 14px; cursor: pointer;">Sign Out</button>
                </form>
            </div>
        </div>
    </nav>

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
                    <p>Company description</p>
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
            <footer class="footer">
                <div class="footer-links">
                    <a href="#">About</a>
                    <a href="#">More</a>
                </div>
                <div class="footer-logo">
                    <img src="../../../public/images/logo-icon-text.svg" alt="LinkedInPurry Logo">
                    <span>LinkinPurry © 2024</span>
                </div>
            </footer>
        </aside>

        <section class="job-listings">
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
    </div>

    <script src="../../../public/js/home-company.js"></script>
</body>

</html>