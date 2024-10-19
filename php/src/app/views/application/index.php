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
    <title>Application</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/application/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>
<body>
    <?php include __DIR__ . '/../templates/navbar-jobseeker.php'; ?>

    <main class="application-container">
        <!-- content -->
        <div>
            <!-- back button -->
            <div class="back-arrow">
                <a href="/job/<?php echo htmlspecialchars($job_vacancy_id); ?>" class="back-link">
                    <img src="../../../public/images/arrow-left.svg" alt="back">
                    <p>Job Detail</p>
                </a>
            </div>

            <!-- content -->
            <div class="application-content">
                <!-- intro -->
                <div class="intro">
                    <h1>Fill in your application</h1>
                    <p>You’re one step closer to your dream job!</p>
                    <!-- application exist, jika = 0 tampilkan pesan belum melamar, jika > 0 tampilkan pesan sudah melamar -->
                    <?php if ($applicationExists > 0): ?>
                        <p style="color: red;">You have already applied for this job.</p>
                    <?php endif; ?>
                </div>

                <!-- form -->
                <form class="application-form" method="POST" enctype="multipart/form-data">
                    <div class="file-upload">
                        <!-- Upload CV -->
                        <div class="upload-container">
                            <label class="upload-button" for="upload-cv">
                                <img src="../../../public/images/upload.svg" alt="upload">
                                <p id="cv-name">Upload CV</p>
                            </label>
                            <input type="file" id="upload-cv" name="cv" accept=".pdf, .doc, .docx" style="display: none;" <?= $applicationExists > 0 ? 'disabled' : '' ?> onchange="handleFileUpload('cv')">
                            <button id="cv-remove" class="remove-button" style="display:none;" onclick="removeFile('cv')" <?= $applicationExists > 0 ? 'disabled' : '' ?>>&times;</button>
                        </div>

                        <!-- Upload Introduction Video -->
                        <div class="upload-container">
                            <label class="upload-button" for="upload-video">
                                <img src="../../../public/images/upload.svg" alt="upload">
                                <p id="video-name">Upload Introduction Video</p>
                            </label>
                            <input type="file" id="upload-video" name="video" accept="video/*" style="display: none;" <?= $applicationExists > 0 ? 'disabled' : '' ?> onchange="handleFileUpload('video')">
                            <button id="video-remove" class="remove-button" style="display:none;" onclick="removeFile('video')" <?= $applicationExists > 0 ? 'disabled' : '' ?>>&times;</button>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                    <input type="hidden" name="job_vacancy_id" value="<?= $job_vacancy_id; ?>">
                    <button type="submit" class="send-button" <?= $applicationExists > 0 ? 'disabled' : '' ?>>Send</button>
                </form>
            </div>

            <!-- message div for displaying errors or success -->
            <?php if (!empty($message)): ?>
                <div style="color: <?= strpos($message, 'successfully') !== false ? 'green' : 'red'; ?>; margin-top: 20px">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- image -->
        <div class="application-image">
            <img src="../../../public/images/application-people.png" alt="application">
        </div>
    </main>
    <script src="../../../public/js/application.js"></script>
</body>
</html>