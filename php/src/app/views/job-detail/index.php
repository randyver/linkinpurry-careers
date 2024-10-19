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

$home = true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Detail</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/job-detail/index.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>
<body>
    <?php include __DIR__ . '/../templates/navbar-jobseeker.php'; ?>

    <main>
        <div class="back-arrow">
            <a href="/home-jobseeker" class="back-link">
                <img src="../../../public/images/arrow-left.svg" alt="Back Icon">
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
                    <p><img src="../../../public/images/calendar-icon.svg" alt="Calendar Icon"> Posted: <?php echo date('jS F Y', strtotime($job['created_at'])); ?></p>
                    <p><img src="../../../public/images/location-icon.svg" alt="Location Icon"> Location: <?php echo htmlspecialchars(ucfirst($job['location_type'])); ?></p>
                    <p><img src="../../../public/images/type-icon.svg" alt="Type Icon"> Type: <?php echo htmlspecialchars(ucfirst($job['job_type'])); ?></p>
                </div>
                <p><?php echo htmlspecialchars($job['description']); ?></p>
            </div>

            <div class="job-image">
                <img src="../../../public/images/job-vacancy.png" alt="Job Image">
            </div>

            <div class="apply-section">
                <?php if ($application): ?>
                    <div class="application">
                        <div class="file">
                            <img src="../../../public/images/detail-icon.svg" alt="Detail Icon">
                            <a href="../../../public/uploads/<?php echo htmlspecialchars($application['cv_path']); ?>" target="_blank">See CV Attachment</a>
                        </div>
                        <?php if ($application['video_path']): ?>
                            <div class="file">
                                <img src="../../../public/images/detail-icon.svg" alt="Detail Icon">
                                <a href="../../../public/uploads/<?php echo htmlspecialchars($application['video_path']); ?>" target="_blank">See Video Attachment</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="apply-button">
                        <a href="/job/<?php echo htmlspecialchars($job['job_vacancy_id']); ?>/application">
                            <button>Apply</button>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>
    <?php include __DIR__ . '/../templates/footer.php'; ?>
</body>
</html>