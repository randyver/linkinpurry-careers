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
    <title>About</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/jobseeker-company-profile/index.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar-jobseeker.php'; ?>

    <main>
        <div class="back-arrow">
            <a href="/home-company" class="back-link">
                <img src="../../../public/images/arrow-left.svg" alt="Back Icon">
                <span>Home</span>
            </a>
        </div>

        <div class="company-profile-card">
            <div class="banner-container">
                <img src="../../../public/images/profile-banner.svg" alt="Company Banner" class="banner-image">
            </div>

            <div class="profile-picture">
                <img src="../../../public/images/company-pic.png" alt="Company Logo" class="profile-image">
            </div>

            <div class="company-details">
                <h1 class="company-name"><?php echo $companyName; ?></h1>
                <p class="company-location"><img src="../../../public/images/location-icon.svg" alt="Location Icon"><?php echo $companyLocation; ?></p>
                <p id="company-description"><?php echo $companyDescription; ?></p>
            </div>
        </div>

        <div class="job-listings">
            <h2>Job Listings</h2>
            <?php foreach ($jobs as $job): ?>
                <div class="job-card">
                    <h3><?php echo htmlspecialchars($job['position']); ?></h3>
                    <p>Posted: <?php echo date('jS F Y', strtotime($job['created_at'])); ?></p>
                    <p>Location: <?php echo htmlspecialchars($job['location_type']); ?></p>
                    <p>Type: <?php echo htmlspecialchars($job['job_type']); ?></p>
                    <a href="/job/<?php echo $job['job_vacancy_id']; ?>">View Job</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
</body>