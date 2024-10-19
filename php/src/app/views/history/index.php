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
    <title>Job Application History</title>
    <link rel="stylesheet" href="/public/css/navbar/style.css">
    <link rel="stylesheet" href="/public/css/history/style.css">
    <link rel="stylesheet" href="/public/css/footer/style.css">
    <link rel="icon" href="/public/images/logo-icon.svg" type="image/x-icon">
</head>
<body>
    <?php include __DIR__ . '/../templates/navbar-jobseeker.php'; ?>

    <main>
        <h2>Job Application History</h2>
        
        <div class="job-history">
            <?php if (empty($appliedJobs)): ?>
                <p>You have not applied for any jobs yet.</p>
            <?php else: ?>
                <?php foreach ($appliedJobs as $job): ?>
                    <div class="job-card">
                        <div class="job-header">
                            <div class="company-info">
                                <img src="/public/images/company-pic.png" alt="Company Logo" class="company-logo">
                                <div class="company-details">
                                    <h3><?php echo htmlspecialchars($job['company_name']); ?></h3>
                                    <p><?php echo htmlspecialchars($job['company_location']); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="job-details">
                            <h4><?php echo htmlspecialchars($job['position']); ?></h4>
                            <div class="job-meta">
                                <p><img src="/public/images/clock-icon.svg" alt="Clock Icon"> Applied on: <?php echo date('jS F Y', strtotime($job['created_at'])); ?></p>
                            </div>
                        </div>

                        <!-- Tampilkan status lamaran -->
                        <div class="application-status">
                            <p>Status: <strong><?php echo htmlspecialchars($job['status']); ?></strong></p>
                        </div>

                        <!-- Tombol detail yang mengarahkan ke halaman /job/{id} -->
                        <div class="job-actions">
                            <a href="/job/<?php echo htmlspecialchars($job['job_vacancy_id']); ?>" class="btn-detail">Detail</a>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    
    <?php include __DIR__ . '/../templates/footer.php'; ?>
</body>
</html>