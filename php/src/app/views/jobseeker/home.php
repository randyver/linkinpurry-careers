<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseeker Dashboard</title>
    <link rel="stylesheet" href="../../../public/css/jobseeker/home-jobseeker.css">
</head>

<body>

    <nav class="navbar">
        <div class="navbar-left">
            <img src="../../../public/images/logo-icon.svg" alt="Logo" class="logo">
            <input type="text" class="search-input" placeholder="Discover jobs...">
            <button class="search-button">
                <img src="../../../public/images/search-icon.svg" alt="Search">
            </button>
        </div>
        <div class="navbar-right">
            <!-- Jobs Section (selected) -->
            <div class="nav-item selected">
                <img src="../../../public/images/jobs-icon.svg" alt="Jobs Icon" class="nav-icon">
                <a href="#" class="nav-link">Jobs</a>
            </div>

            <!-- Applications Section -->
            <div class="nav-item">
                <img src="../../../public/images/applications-icon.svg" alt="Applications Icon" class="nav-icon">
                <a href="#" class="nav-link">Applications</a>
            </div>

            <!-- Profile Section -->
            <div class="profile-section">
                <img src="../../../public/images/profile-pic.png" alt="Profile" class="profile-pic">
                <?php $username = 'test'; ?>
                <span class="profile-name"><?php echo $username; ?></span>
                <img src="../../../public/images/arrow-down.svg" alt="Dropdown Arrow" class="dropdown-arrow" id="dropdown-arrow">
            </div>

            <div class="dropdown-menu" id="dropdown-menu">
                <a href="#" class="dropdown-item">View Profile</a>
                <a href="#" class="dropdown-item">Sign Out</a>
            </div>
        </div>
    </nav>
    <script>
        const dropdownArrow = document.getElementById('dropdown-arrow');
        const dropdownMenu = document.getElementById('dropdown-menu');

        dropdownArrow.addEventListener('click', () => {
            dropdownMenu.style.display = dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '' ? 'block' : 'none';
        });

        window.addEventListener('click', (e) => {
            if (!dropdownArrow.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    </script>
</body>

</html>