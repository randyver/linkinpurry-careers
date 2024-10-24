<?php

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'company') {
    header('Location: /login');
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$name = $_SESSION['name'];

$home = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company - Home</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="stylesheet" href="../../../public/css/company/home-company.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar-company.php'; ?>

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
                    <div id="company-description">
                        <p>Company description</p>
                    </div>
                </div>
            </div>

            <div class="filter-text">Filter</div>
            <div class="filter">
                <div class="filter-group">
                    <div for="posted" class="filter-type">Posted</div>
                    <select id="posted-month" aria-label="Filter by posted month">
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
                    <select id="posted-year" aria-label="Filter by posted year">
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
            <footer class="small-footer">
                <div class="small-footer-links">
                    <a href="/about">About</a>
                    <a href="#">Back to Top</a>
                </div>
                <div class="small-footer-logo">
                    <img src="../../../public/images/logo-icon-text.svg" alt="LinkedInPurry Logo">
                    <span>LinkinPurry © 2024</span>
                </div>
            </footer>
        </aside>

        <section class="job-listings">
            <div class="search-container">
                <img src="../../../public/images/search-icon.svg" alt="Search Icon" class="search-icon">
                <input type="text" class="search-input" placeholder="Search jobs...">
            </div>
            <div class="sort-bar">
                <hr class="sort-line">
                <div class="sort-options">
                    <span>Sort by:</span>
                    <select aria-label="Sort jobs">
                        <option value="recent">Recent</option>
                        <option value="oldest">Oldest</option>
                    </select>
                </div>
            </div>
            <div id="job-listings-response"></div>
        </section>
    </div>

    <!-- Floating Button -->
    <div class="floating-btn">
        <a href="/add-job">
            <img src="../../../public/images/plus-icon.svg" alt="Add Job Icon">
        </a>
    </div>

    <!-- Modal -->
    <div id="generalModal" class="modal hidden">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <p id="modalMessage"></p>
            <div class="modal-buttons">
                <button id="confirmButton" class="btn-yes">Yes</button>
                <button id="cancelButton" class="btn-no">No</button>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
    <script src="../../../public/js/home-company.js"></script>
</body>

</html>