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
    <title>Add Job Posting</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/company-add-job/index.css">
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
            <h2>Add New Job Posting</h2>

            <form id="addJobForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="job-name">Job Name:</label>
                    <input type="text" id="job-name" name="job_name" class="form-control" required placeholder="Enter job's name">
                </div>

                <div class="form-group">
                    <label for="job-location">Location:</label>
                    <select id="job-location" name="job_location" class="form-control" required>
                        <option value="on-site">On-site</option>
                        <option value="remote">Remote</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="job-type">Type:</label>
                    <select id="job-type" name="job_type" class="form-control" required>
                        <option value="full-time">Full-time</option>
                        <option value="part-time">Part-time</option>
                        <option value="internship">Internship</option>
                    </select>
                </div>

                <div class="form-group form-group-file">
                    <label class="file-label" for="job-image-upload">Upload Job Image</label>
                    <input type="file" id="job-image-upload" name="job_image" accept="image/*">
                    <p class="file-name" id="file-name">No file chosen</p>
                </div>

                <div class="form-group">
                    <label for="job-description">Job Description:</label>
                    <div id="editor" style="height: 150px;"></div>
                </div>

                <button class="save-btn">Submit Job</button>
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
    </script>
    <script src="../../../public/js/company-add-job.js"></script>
</body>

</html>