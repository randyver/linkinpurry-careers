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

$companyName = $companyName ?? 'Loading...';
$companyDescription = $companyDescription ?? 'Loading...';
$companyLocation = $companyLocation ?? 'Loading...';
$home = false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/jobseeker-company-profile/index.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar-jobseeker.php'; ?>

    <main>
        <div class="back-arrow">
            <a href="/home-jobseeker" class="back-link">
                <img src="../../../public/images/arrow-left.svg" alt="Back Icon">
                <span>Home</span>
            </a>
        </div>

        <div class="content-container">
            <div class="company-profile-card">
                <div class="banner-container">
                    <img src="../../../public/images/profile-banner.svg" alt="Company Banner" class="banner-image">
                </div>
                <div class="profile-picture">
                    <img src="../../../public/images/company-pic.png" alt="Company Logo" class="profile-image">
                </div>
                <div class="company-details">
                    <h1><?php echo htmlspecialchars($companyName); ?></h1>
                    <p>Location: <?php echo htmlspecialchars($companyLocation); ?></p>
                    <p>About: <?php echo htmlspecialchars($companyDescription); ?></p>
                </div>
            </div>

            <div class="below-card-container">
                <aside class="filter-section">
                    <div class="filter-text">Filter</div>
                    <div class="filter">
                        <div class="filter-group">
                            <div class="filter-type">Posted</div>
                            <select id="posted-month">
                                <option value="" disabled selected>Select month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
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
                            <label><input type="checkbox" value="on-site" id="filter-location-on-site"> On-site</label>
                            <label><input type="checkbox" value="remote" id="filter-location-remote"> Remote</label>
                            <label><input type="checkbox" value="hybrid" id="filter-location-hybrid"> Hybrid</label>
                        </div>

                        <div class="filter-group">
                            <div class="filter-type">Type</div>
                            <label><input type="checkbox" value="full-time" id="filter-jobtype-fulltime"> Full-time</label>
                            <label><input type="checkbox" value="part-time" id="filter-jobtype-parttime"> Part-time</label>
                            <label><input type="checkbox" value="internship" id="filter-jobtype-internship"> Internship</label>
                        </div>
                    </div>
                </aside>

                <section class="job-listings-container">
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

                    <section class="job-listings">
                        <?php if (empty($jobs)): ?>
                            <div id="job-listings-response">No jobs found</div>
                        <?php else: ?>
                            <div id="job-listings-response">
                                <?php foreach ($jobs as $job) {
                                    $jobId = $job['job_vacancy_id'];
                                    $jobTitle = $job['position'];
                                    $jobLocation = $job['location_type'];
                                    $jobType = $job['job_type'];

                                    include __DIR__ . '/../templates/profile-job-listings-template.php';
                                } ?>
                            </div>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
    <script src="../../../public/js/jobseeker-company-profile.js"></script>
</body>

</html>
