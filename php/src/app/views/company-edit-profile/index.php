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

$companyName = $companyName ?? '';
$companyDescription = $companyDescription ?? '';
$companyLocation = $companyLocation ?? '';
$home = false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Edit Profile</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/company-edit-profile/index.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar-company.php'; ?>

    <main>
        <div class="back-arrow">
            <a href="/company-profile" class="back-link">
                <img src="../../../public/images/arrow-left.svg" alt="Back Icon">
                <span>Profile</span>
            </a>
        </div>

        <div class="edit-profile-section">
            <h2>Edit Company Profile</h2>

            <form id="editProfileForm" action="/company-update-profile" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="company-name">Company Name:</label>
                    <input type="text" id="company-name" name="company_name" class="form-control" required placeholder="Enter company's name" value="<?php echo $name; ?>">
                </div>

                <div class="form-group">
                    <label for="current-password">Current Password:</label>
                    <input type="text" id="current-password" name="current_password" class="form-control" placeholder="Enter current password">
                </div>

                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="text" id="new-password" name="new_password" class="form-control" placeholder="Enter new password">
                </div>

                <div class="form-group">
                    <label for="company-location">Location:</label>
                    <input type="text" id="company-location" name="company_location" class="form-control" required placeholder="Enter company's location" value="<?php echo $companyLocation; ?>">
                </div>

                <div class="form-group">
                    <label for="company-description">About:</label>
                    <div id="editor" class="form-control" style="min-height: 200px;"><?php echo $companyDescription; ?></div>
                </div>

                <input type="hidden" id="company-description-hidden" name="company_description">
                <button class="save-btn">Save</button>
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
    <script src="/public/js/company-edit-profile.js"></script>
</body>

</html>
