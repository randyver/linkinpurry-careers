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
    <link rel="stylesheet" href="../../../public/css/company-profile/index.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar-company.php'; ?>

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
                <h1 class="company-name"><?php echo $name; ?></h1>
                <p class="company-location"><img src="../../../public/images/location-icon.svg" alt="Location Icon"><?php echo $companyLocation; ?></p>
                <p id="company-description"><?php echo $companyDescription; ?></p>
            </div>

            <div class="settings-icon">
                <a href="/company-edit-profile">
                    <img src="../../../public/images/settings-icon.svg" alt="Settings Icon">
                </a>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
</body>

</html>
