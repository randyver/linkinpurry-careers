<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseeker Dashboard</title>
    <link rel="stylesheet" href="../../../public/css/jobseeker/home-jobseeker.css">
</head>

<?php $username = 'username test'; ?>

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
                <span class="profile-name"><?php echo $username; ?></span>
                <img src="../../../public/images/arrow-down.svg" alt="Dropdown Arrow" class="dropdown-arrow" id="dropdown-arrow">
            </div>

            <div class="dropdown-menu" id="dropdown-menu">
                <a href="#" class="dropdown-item">View Profile</a>
                <a href="#" class="dropdown-item">Sign Out</a>
            </div>
        </div>

    </nav>

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
                    <h2><?php echo $username; ?></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>

            <div class="filter-text">Filter</div>
            <div class="filter">
                <div class="filter-group">
                    <div for="deadline" class="filter-type">Deadline</div>
                    <select id="deadline-month">
                        <option value="" disabled selected>Select month</option>
                        <option>January</option>
                        <option>Febuary</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                        <option value="clear">Clear Selection</option>
                    </select>
                    <select id="deadline-year">
                        <option value="" disabled selected>Select year</option>
                        <option>2024</option>
                        <option>2025</option>
                        <option>2026</option>
                        <option>2027</option>
                        <option value="clear">Clear Selection</option>
                    </select>
                </div>

                <div class="filter-group">
                    <div class="filter-type">Location</div>
                    <label><input type="checkbox"> On-site</label>
                    <label><input type="checkbox"> Remote</label>
                    <label><input type="checkbox"> Hybrid</label>
                </div>

                <div class="filter-group">
                    <div for="type" class="filter-type">Type</div>
                    <label><input type="checkbox"> Full-time</label>
                    <label><input type="checkbox"> Part-time</label>
                    <label><input type="checkbox"> Internship</label>
                </div>
            </div>
        </aside>

        <section class="job-listings">
            <div class="sort-bar">
                <hr class="sort-line">
                <div class="sort-options">
                    <span>Sort by:</span>
                    <select>
                        <option>Recent</option>
                        <option>Oldest</option>
                    </select>
                </div>
            </div>


            <div class="job-card">
                <div class="job-header">
                    <div class="company-info">
                        <img src="../../../public/images/company-pic.png" alt="Company Logo" class="company-logo">
                        <div class="company-details">
                            <h3>WBD Corp</h3>
                            <p>Technology, Information and Media</p>
                        </div>
                    </div>

                    <div class="job-view">
                        <button>View</button>
                    </div>
                </div>

                <div class="job-details">
                    <h4>Junior Software Engineer</h4>
                    <div class="job-meta">
                        <p>
                            <img src="../../../public/images/clock-icon.svg" alt="Clock Icon"> Application opened: 15th October 2024
                        </p>
                        <p>
                            <img src="../../../public/images/clock-icon.svg" alt="Clock Icon"> Application closed: 15th November 2024
                        </p>
                        <p>
                            <img src="../../../public/images/location-icon.svg" alt="Location Icon"> Location: Jakarta
                        </p>
                        <p>
                            <img src="../../../public/images/type-icon.svg" alt="Type Icon"> Type: Full-time
                        </p>
                    </div>
                    <p>WBD Corp is seeking a motivated Junior Software Engineer to join our dynamic team. You will work closely with senior engineers on modern technologies...</p>
                </div>

                <div class="job-image">
                    <img src="../../../public/images/job-vacancy.png" alt="Job Image">
                </div>
            </div>

        </section>

        <aside class="recommendations-section">
            <div class="recommendation-card">
                <h3>Jobs you may be interested in</h3>

                <a href="#" class="recommendation-item-link">
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
                </a>
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
    </div>

    <script src="../../../public/js/home-jobseeker.js"></script>
</body>

</html>