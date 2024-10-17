<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Detail</title>
    <link rel="stylesheet" href="/path/to/your/css/styles.css"> <!-- Ubah sesuai path CSS kamu -->
</head>
<body>
    <div class="job-detail-page">
        <!-- Bagian Profil Perusahaan -->
        <div class="company-profile">
            <img src="../../../public/images/company-pic.png" alt="Company Logo" class="company-logo">
            <h3><?php echo htmlspecialchars($job['company_name']); ?></h3>
            <p><?php echo htmlspecialchars($job['company_location']); ?></p>
            <p><?php echo htmlspecialchars($job['company_about']); ?></p>
        </div>

        <!-- Bagian Deskripsi Lowongan -->
        <div class="job-description">
            <h4><?php echo htmlspecialchars($job['position']); ?></h4>
            <p><?php echo htmlspecialchars($job['description']); ?></p>
            <div class="job-meta">
                <p>Type: <?php echo htmlspecialchars(ucfirst($job['job_type'])); ?></p>
                <p>Location: <?php echo htmlspecialchars(ucfirst($job['location_type'])); ?></p>
                <p>Posted on: <?php echo date('jS F Y', strtotime($job['created_at'])); ?></p>
            </div>
        </div>

        <!-- Bagian Aksi Pelamaran atau Detail Lamaran -->
        <div class="application-section">
            <?php if (!$application): ?>
                <!-- Jika pengguna belum melamar pekerjaan ini -->
                <a href="/apply/<?php echo $job['job_vacancy_id']; ?>" class="apply-button">Apply for this Job</a>
            <?php else: ?>
                <!-- Jika pengguna sudah melamar pekerjaan ini -->
                <div class="application-details">
                    <h5>Your Application</h5>
                    <p>Status: <?php echo htmlspecialchars($application['status']); ?></p>

                    <!-- Tampilkan link CV jika ada -->
                    <?php if (!empty($application['cv'])): ?>
                        <a href="/uploads/<?php echo htmlspecialchars($application['cv']); ?>" class="application-link">View CV</a>
                    <?php endif; ?>

                    <!-- Tampilkan link video jika ada -->
                    <?php if (!empty($application['video'])): ?>
                        <a href="/uploads/<?php echo htmlspecialchars($application['video']); ?>" class="application-link">View Introduction Video</a>
                    <?php endif; ?>

                    <!-- Tampilkan alasan atau tindak lanjut jika ada -->
                    <?php if (!empty($application['reason'])): ?>
                        <p>Reason/Follow-up: <?php echo htmlspecialchars($application['reason']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>