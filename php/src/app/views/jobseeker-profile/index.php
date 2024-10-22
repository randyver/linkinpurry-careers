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

$jobseekerName = $jobseekerName ?? 'Loading...';
$email = $email ?? 'Not available';
$jobsAppliedNum = $jobsAppliedNum ?? 0;
$home = false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Profile</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/jobseeker-profile/index.css">
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

        <div class="jobseeker-profile-card">
            <div class="banner-container">
                <img src="../../../public/images/profile-banner.svg" alt="jobseeker Banner" class="banner-image">
            </div>

            <div class="profile-picture">
                <img src="../../../public/images/profile-pic.png" alt="Profile Pic" class="profile-image">
            </div>

            <div class="jobseeker-details">
                <h1 class="jobseeker-name"><?php echo $jobseekerName; ?></h1>
                <p class="jobseeker-details-subtitle">Email</p>
                <p class="jobseeker-info"><?php echo $email; ?></p>
                <p class="jobseeker-details-subtitle">Jobs Applied</p>
                <p class="jobseeker-info"><?php echo $jobsAppliedNum; ?></p>
            </div>

            <div class="settings-icon">
                <a href="/jobseeker-edit-profile">
                    <img src="../../../public/images/settings-icon.svg" alt="Settings Icon">
                </a>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
</body>

</html>
