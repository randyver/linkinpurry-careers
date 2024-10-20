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
    <title>Edit Job Posting</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/company-edit-job/index.css">
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
                <span>Back to Home</span>
            </a>
        </div>

        <div class="job-posting-section">
            <h2>Edit Job Posting</h2>

            <form id="editJobForm" enctype="multipart/form-data" method="POST" action="/edit-job/<?php echo htmlspecialchars($job['job_vacancy_id']); ?>">
                <div class="form-group">
                    <label for="job-name">Job Name:</label>
                    <input type="text" id="job-name" name="job_name" class="form-control" required value="<?php echo htmlspecialchars($job['position']); ?>">
                </div>

                <div class="form-group">
                    <label for="job-location">Location:</label>
                    <select id="job-location" name="job_location" class="form-control" required>
                        <option value="on-site" <?php echo $job['location_type'] == 'on-site' ? 'selected' : ''; ?>>On-site</option>
                        <option value="remote" <?php echo $job['location_type'] == 'remote' ? 'selected' : ''; ?>>Remote</option>
                        <option value="hybrid" <?php echo $job['location_type'] == 'hybrid' ? 'selected' : ''; ?>>Hybrid</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="job-type">Type:</label>
                    <select id="job-type" name="job_type" class="form-control" required>
                        <option value="full-time" <?php echo $job['job_type'] == 'full-time' ? 'selected' : ''; ?>>Full-time</option>
                        <option value="part-time" <?php echo $job['job_type'] == 'part-time' ? 'selected' : ''; ?>>Part-time</option>
                        <option value="internship" <?php echo $job['job_type'] == 'internship' ? 'selected' : ''; ?>>Internship</option>
                    </select>
                </div>

                <div class="form-group form-group-file">
                    <label class="file-label" for="job-image-upload">Upload New Job Image</label>
                    <input type="file" id="job-image-upload" name="job_image" accept="image/*">
                    <p class="file-name" id="file-name">No file chosen!</p>
                </div>
                <!-- Display the current image if it exists -->
                <?php if (!empty($job['file_path'])): ?>
                    <div class="current-attachment">
                        <p>Old Attachment:</p>
                        <a href="../../../public/uploads/attachments/<?php echo htmlspecialchars($job['file_path']); ?>" target="_blank">
                            <img src="../../../public/uploads/attachments/<?php echo htmlspecialchars($job['file_path']); ?>" alt="Job Image" class="current-image" style="max-width: 150px; height: auto;">
                        </a>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="job-description">Job Description:</label>
                    <div id="editor" style="min-height: 200px;"></div>
                </div>

                <button class="save-btn">Update Job</button>
            </form>
        </div>
    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, false]
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    ['bold', 'italic', 'underline'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'align': []
                    }],
                    ['clean']
                ]
            }
        });
        quill.root.innerHTML = <?php echo json_encode($job['description']); ?>;
    </script>
    <script src="../../../public/js/company-edit-job.js"></script>
</body>

</html>