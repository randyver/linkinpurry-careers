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
                <!-- Edit and Delete icons -->
                <div class="job-actions">
                    <a href="/edit-job" class="edit-job-icon">
                        <img src="../../../public/images/edit-icon.svg" alt="Edit Icon">
                    </a>
                    <button class="delete-job-icon">
                        <img src="../../../public/images/trash-icon.svg" alt="Delete Icon">
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

                <?php if (!empty($job['file_path'])): ?>
                    <div class="job-image">
                        <img src="../../../public/uploads/attachments/<?php echo htmlspecialchars($job['file_path']); ?>" alt="Job Image">
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="filter-bar">
            <hr class="filter-line">
            <div class="filter-options">
                <span>Filter by:</span>
                <select>
                    <option value="all">All</option>
                    <option value="accepted">Accepted</option>
                    <option value="waiting">Waiting</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>

        <div class="status-rows">
            <!-- <div class="status-row">
                <span class="applicant-name">Job Applicant Name</span>
                <span class="status accepted">
                    <span class="status-label">Status:</span> <img src="../../../public/images/accepted-icon.svg" alt="Accepted Icon" class="status-icon"> Accepted
                </span>
                <a href="#" class="details-link">
                    <img src="../../../public/images/details-icon.svg" alt="Details Icon" class="details-icon">
                    <span>Details</span>
                </a>
            </div>

            <div class="status-row">
                <span class="applicant-name">Job Applicant Name</span>
                <span class="status waiting">
                    <span class="status-label">Status:</span> <img src="../../../public/images/waiting-icon.svg" alt="Waiting Icon" class="status-icon"> Waiting
                </span>
                <a href="#" class="details-link">
                    <img src="../../../public/images/details-icon.svg" alt="Details Icon" class="details-icon">
                    <span>Details</span>
                </a>
            </div>

            <div class="status-row">
                <span class="applicant-name">Job Applicant Name</span>
                <span class="status rejected">
                    <span class="status-label">Status:</span> <img src="../../../public/images/rejected-icon.svg" alt="Rejected Icon" class="status-icon"> Rejected
                </span>
                <a href="#" class="details-link">
                    <img src="../../../public/images/details-icon.svg" alt="Details Icon" class="details-icon">
                    <span>Details</span>
                </a>
            </div> -->
        </div>
    </main>

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