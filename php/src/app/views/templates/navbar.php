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

?>

<nav class="navbar">
    <div class="navbar-left">
        <img src="../../../public/images/logo-icon.svg" alt="Logo" class="logo">
        <input type="text" class="search-input" placeholder="Discover jobs...">
        <button class="search-button">
            <img src="../../../public/images/search-icon.svg" alt="Search">
        </button>
    </div>
    <div class="navbar-right">
        <?php if ($isLoggedIn): ?>
            <a href="#" class="nav-item-link">
                <div class="nav-item selected">
                    <img src="../../../public/images/jobs-icon.svg" alt="Jobs Icon" class="nav-icon">
                    <span class="nav-link">Jobs</span>
                </div>
            </a>

            <a href="#" class="nav-item-link">
                <div class="nav-item">
                    <img src="../../../public/images/applications-icon.svg" alt="Applications Icon" class="nav-icon">
                    <span class="nav-link">Applications</span>
                </div>
            </a>

            <div class="nav-profile-section">
                <img src="../../../public/images/profile-pic.png" alt="Profile" class="nav-profile-pic">
                <span class="profile-name"><?php echo htmlspecialchars($name); ?></span>
                <img src="../../../public/images/arrow-down.svg" alt="Dropdown Arrow" class="dropdown-arrow" id="dropdown-arrow">
            </div>

            <div class="dropdown-menu" id="dropdown-menu">
                <a href="#" class="dropdown-item">View Profile</a>
                    <!-- Form untuk logout -->
                <form action="/logout" method="POST" class="dropdown-item">
                    <button type="submit" style="background: none; border: none; padding: 0; color: red; font-size: 14px; cursor: pointer;">Sign Out</button>
                </form>
            </div>
        <?php else: ?>
            <div class="nav-login-section">
                <a href="/login" class="login-button">Sign In</a>
            </div>
            <div class="nav-profile-section hide">
                <img src="../../../public/images/profile-pic.png" alt="Profile" class="nav-profile-pic">
                <span class="profile-name"><?php echo htmlspecialchars($name); ?></span>
                <img src="../../../public/images/arrow-down.svg" alt="Dropdown Arrow" class="dropdown-arrow" id="dropdown-arrow">
            </div>

            <div class="dropdown-menu hide" id="dropdown-menu">
                <a href="#" class="dropdown-item">View Profile</a>
                <form action="/logout" method="POST" class="dropdown-item">
                    <button type="submit" style="background: none; border: none; padding: 0; color: red; font-size: 14px; cursor: pointer;">Sign Out</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</nav>
<script src="../../../public/js/navbar.js"></script>