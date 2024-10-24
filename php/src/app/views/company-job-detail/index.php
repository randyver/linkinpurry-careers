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
    <title>Job Detail</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/company-job-detail/index.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar-company.php'; ?>

    <main class="main-section">
        <div class="back-arrow">
            <a href="/home-company" class="back-link">
                <img src="../../../public/images/arrow-left.svg" alt="Back Icon">
                <span>Home</span>
            </a>
        </div>
        <div class="job-card" data-job-id="<?php echo htmlspecialchars($job['job_vacancy_id']); ?>">
            <div class="job-header">
                <div class="company-info">
                    <img src="../../../public/images/company-pic.png" alt="Company Logo" class="company-logo">
                    <div class="company-details">
                        <h3><?php echo htmlspecialchars($job['company_name']); ?></h3>
                        <p><?php echo htmlspecialchars($job['company_location']); ?></p>
                    </div>
                </div>

                <div class="job-actions">
                    <a href="/edit-job/<?php echo htmlspecialchars($job['job_vacancy_id']); ?>" class="edit-job-icon">
                        <img src="../../../public/images/edit-icon.svg" alt="Edit Icon">
                    </a>
                    <button class="delete-job-icon">
                        <img src="../../../public/images/trash-icon.svg" alt="Delete Icon">
                    </button>
                    <button
                        id="toggle-job-status-btn"
                        class="toggle-job-status-btn <?php echo $job['is_open'] ? 'close-job-btn' : 'open-job-btn'; ?>"
                        data-job-id="<?php echo htmlspecialchars($job['job_vacancy_id']); ?>"
                        data-is-open="<?php echo $job['is_open'] ? 'true' : 'false'; ?>">
                        <?php echo $job['is_open'] ? 'Close Job' : 'Open Job'; ?>
                    </button>
                </div>
            </div>

            <div class="job-details">
                <h4><?php echo htmlspecialchars($job['position']); ?></h4>
                <div class="job-meta">
                    <p><img src="../../../public/images/calendar-icon.svg" alt="Calendar Icon"> Posted: <?php echo date('jS F Y', strtotime($job['created_at'])); ?></p>
                    <p><img src="../../../public/images/location-icon.svg" alt="Location Icon"> Location: <?php echo htmlspecialchars(ucfirst($job['location_type'])); ?></p>
                    <p><img src="../../../public/images/type-icon.svg" alt="Type Icon"> Type: <?php echo htmlspecialchars(ucfirst($job['job_type'])); ?></p>
                </div>

                <div id="job-description" style="height: fit-content;"></div>

                <?php if (!empty($attachments)): ?>
                    <div class="job-attachments">
                        <ul class="attachment-list">
                            <?php foreach ($attachments as $attachment): ?>
                                <li>
                                    <a href="../../../public/uploads/attachments/<?php echo htmlspecialchars($attachment['file_path']); ?>" target="_blank">
                                        <img src="../../../public/uploads/attachments/<?php echo htmlspecialchars($attachment['file_path']); ?>" alt="Job Attachment" class="attachment-image">
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="filter-bar">
            <hr class="filter-line">
            <div class="filter-options">
                <span>Filter by:</span>
                <select aria-label="Filter by status">
                    <option value="all">All</option>
                    <option value="accepted">Accepted</option>
                    <option value="waiting">Waiting</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>

        <div class="status-rows">
        </div>
    </main>

    <!-- Modal for Deletion -->
    <div id="generalModal" class="modal hidden">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <p id="modalMessage"></p>
            <div class="modal-buttons">
                <button id="confirmButton" class="btn-yes">Yes</button>
                <button id="cancelButton" class="btn-no">No</button>
            </div>
        </div>
    </div>

    <!-- Modal for Other Messages -->
    <div id="otherModal" class="modal hidden">
        <div class="modal-content">
            <span class="close-other-modal">&times;</span>
            <p id="otherModalMessage"></p>
        </div>
    </div>
 
    <?php include __DIR__ . '/../templates/footer.php'; ?>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#job-description', {
            theme: 'snow',
            readOnly: true,
            modules: {
                toolbar: false
            }
        });

        quill.root.innerHTML = <?php echo json_encode($job['description']); ?>;
        document.querySelector('.ql-container').style.border = 'none';
    </script>
    <script src="../../../public/js/company-job-detail.js"></script>
</body>

</html>