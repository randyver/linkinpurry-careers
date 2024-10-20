<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'company') {
    header('Location: /login');
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Detail</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/company-application/index.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar-company.php'; ?>

    <main class="main-section">
        <div class="back-arrow">
            <a href="/company-job/<?php echo htmlspecialchars($application['job_vacancy_id']); ?>" class="back-link">
                <img src="../../../public/images/arrow-left.svg" alt="Back Icon">
                <span><?php echo htmlspecialchars($application['position']); ?></span>
            </a>
        </div>

        <!-- Applicant Section -->
        <div class="applicant-section" data-application-id="<?php echo htmlspecialchars($application['application_id']); ?>">
            <div class="applicant-header">
                <div class="applicant-info">
                    <img src="../../../public/images/profile-pic.png" alt="Profile Logo" class="profile-img">
                    <div class="profile-details">
                        <h3><?php echo htmlspecialchars($application['applicant_name']); ?></h3>
                        <p><?php echo htmlspecialchars($application['applicant_email']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Attachments -->
            <div class="attachments">
                <?php if (!empty($application['cv_path'])): ?>
                    <div class="file">
                        <p class="label">Curriculum Vitae:</p>
                        <img src="../../../public/images/detail-icon.svg" alt="Detail Icon">
                        <a href="../../../public/uploads/<?php echo htmlspecialchars($application['cv_path']); ?>" target="_blank">See CV Attachment</a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($application['video_path'])): ?>
                    <div class="file">
                        <p class="label">Introduction Video:</p>
                        <img src="../../../public/images/detail-icon.svg" alt="Detail Icon">
                        <a href="../../../public/uploads/<?php echo htmlspecialchars($application['video_path']); ?>" target="_blank">See Video Attachment</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Status Dropdown -->
            <div class="status-dropdown">
                <p class="status-label">Status:</p>
                <select id="status-select" <?php echo $application['status'] !== 'waiting' ? 'disabled' : ''; ?>>
                    <option value="waiting" <?php echo $application['status'] === 'waiting' ? 'selected' : ''; ?>>Waiting</option>
                    <option value="accepted" <?php echo $application['status'] === 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                    <option value="rejected" <?php echo $application['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                </select>
            </div>

            <div class="reason-editor">
                <label for="editor">Reason for Accepting/Rejecting:</label>
                <div id="editor" style="height: 150px;"></div>
            </div>

            <?php if ($application['status'] === 'waiting'): ?>
                <button class="save-btn">Save</button>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            readOnly: <?php echo $application['status'] === 'waiting' ? 'false' : 'true'; ?>,
            modules: {
                toolbar: <?php echo $application['status'] === 'waiting' ? 'true' : 'false'; ?>
            }
        });

        quill.root.innerHTML = <?php echo json_encode($application['status_reason'] ?? ''); ?>;
    </script>
    <script src="../../../public/js/company-application.js"></script>
</body>

</html>