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

$jobseekerName = $jobseekerName ?? '';
$home = false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jobseeker Edit Profile</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/jobseeker-edit-profile/index.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar-jobseeker.php'; ?>

    <main>
        <div class="back-arrow">
            <a href="/jobseeker-profile" class="back-link">
                <img src="../../../public/images/arrow-left.svg" alt="Back Icon">
                <span>Profile</span>
            </a>
        </div>

        <div class="edit-profile-section">
            <h2>Edit Profile</h2>

            <form id="editProfileForm" action="/jobseeker-update-profile" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="jobseeker-name">Name:</label>
                    <input type="text" id="jobseeker-name" name="jobseeker_name" class="form-control" required placeholder="Enter your name" value="<?php echo $jobseekerName; ?>">
                </div>

                <div class="form-group">
                    <label for="current-password">Current Password:</label>
                    <input type="text" id="current-password" name="current_password" class="form-control" placeholder="Enter current password">
                </div>

                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="text" id="new-password" name="new_password" class="form-control" placeholder="Enter new password">
                </div>

                <button class="save-btn">Save</button>
            </form>
        </div>
    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
    <script src="/public/js/jobseeker-edit-profile.js"></script>
</body>

</html>