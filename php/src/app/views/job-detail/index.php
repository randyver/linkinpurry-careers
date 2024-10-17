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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Detail</title>
    <link rel="stylesheet" href="/path/to/your/css/styles.css">
    <link rel="stylesheet" href="../../../public/css/job-detail/index.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="../../../public/images/logo-icon.svg" alt="Logo" class="logo">
            <input type="text" class="search-input" placeholder="Discover jobs...">
            <button class="search-button">
                <img src="../../../public/images/search-icon.svg" alt="Search">
            </button>
        </div>
        <div class="navbar-right">
            <?php if ($isLoggedIn): ?>
                <a href="#" class="nav-item-link">
                    <div class="nav-item selected">
                        <img src="../../../public/images/jobs-icon.svg" alt="Jobs Icon" class="nav-icon">
                        <span class="nav-link">Jobs</span>
                    </div>
                </a>

                <a href="#" class="nav-item-link">
                    <div class="nav-item">
                        <img src="../../../public/images/applications-icon.svg" alt="Applications Icon" class="nav-icon">
                        <span class="nav-link">Applications</span>
                    </div>
                </a>

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
            <?php else: ?>
                <div class="nav-login-section">
                    <a href="/login" class="login-button">Sign In</a>
                </div>
                <div class="nav-profile-section hide">
                    <img src="../../../public/images/profile-pic.png" alt="Profile" class="nav-profile-pic">
                    <span class="profile-name"><?php echo htmlspecialchars($name); ?></span>
                    <img src="../../../public/images/arrow-down.svg" alt="Dropdown Arrow" class="dropdown-arrow" id="dropdown-arrow">
                </div>

                <div class="dropdown-menu hide" id="dropdown-menu">
                    <a href="#" class="dropdown-item">View Profile</a>
                    <form action="/logout" method="POST" class="dropdown-item">
                        <button type="submit" style="background: none; border: none; padding: 0; color: red; font-size: 14px; cursor: pointer;">Sign Out</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>


    </nav>

    <main>
        <div class="back-arrow">
            <a href="/home-jobseeker" class="back-link">
                <img src="../../../public/images/arrow-left.png" alt="Back Icon">
                <span>Jobs</span>
            </a>
        </div>
        <div class="job-card">
            <div class="job-header">
                <div class="company-info">
                    <img src="../../../public/images/company-pic.png" alt="Company Logo" class="company-logo">
                    <div class="company-details">
                        <h3><?php echo htmlspecialchars($job['company_name']); ?></h3>
                        <p><?php echo htmlspecialchars($job['company_location']); ?></p>
                    </div>
                </div>

            </div>

            <div class="job-details">
                <h4><?php echo htmlspecialchars($job['position']); ?></h4>
                <div class="job-meta">
                    <p><img src="../../../public/images/clock-icon.svg" alt="Clock Icon"> Posted: <?php echo date('jS F Y', strtotime($job['created_at'])); ?></p>
                    <p><img src="../../../public/images/location-icon.svg" alt="Location Icon"> Location: <?php echo htmlspecialchars(ucfirst($job['location_type'])); ?></p>
                    <p><img src="../../../public/images/type-icon.svg" alt="Type Icon"> Type: <?php echo htmlspecialchars(ucfirst($job['job_type'])); ?></p>
                </div>
                <p><?php echo htmlspecialchars($job['description']); ?></p>
            </div>

            <div class="job-image">
                <img src="../../../public/images/job-vacancy.png" alt="Job Image">
            </div>

            <div class="apply-button">
                <button>Apply</button>
            </div>
        </div>
    </main>

    <script src="../../../public/js/home-jobseeker.js"></script>
</body>
</html>