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
    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
</body>

</html>
