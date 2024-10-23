<div class="nav-placeholder"></div>
<nav class="navbar-desktop">
    <div class="navbar-left">
        <a href="/home-jobseeker">
            <img src="../../../public/images/logo-icon-text.svg" alt="Logo" class="logo">
        </a>
    </div>
    <div class="navbar-right">
        <?php if ($isLoggedIn): ?>
            <a href="/home-jobseeker" class="nav-item-link">
                <div class="nav-item <?= isset($home) && $home ? 'selected' : '' ?>">
                    <img src="../../../public/images/jobs-icon.svg" alt="Jobs Icon" class="nav-icon">
                    <span class="nav-link">Jobs</span>
                </div>
            </a>

            <a href="/application-history" class="nav-item-link">
                <div class="nav-item <?= isset($application_history) && $application_history ? 'selected' : '' ?>">
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
                <a href="/jobseeker-profile" class="dropdown-item">View Profile</a>
                <form action="/logout" method="POST" class="dropdown-item">
                    <button type="submit" style="background: none; border: none; padding: 0; color: red; font-size: 14px; cursor: pointer;">Sign Out</button>
                </form>
            </div>
        <?php else: ?>
            <div class="nav-login-section">
                <a href="/login" class="login-button">Sign In</a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<nav class="navbar-mobile">
    <div class="navbar-left">
        <a href="/home-jobseeker">
            <img src="../../../public/images/logo-icon-text.svg" alt="Logo" class="logo">
        </a>
    </div>
    <div class="hamburger-menu" id="hamburger-menu">
        <img src="../../../public/images/hamburger-icon.svg" alt="Menu Icon">
    </div>
    <div class="dropdown-menu" id="mobile-dropdown-menu">
        <a href="/home-jobseeker" class="dropdown-item">Jobs</a>
        <a href="/application-history" class="dropdown-item">Applications</a>
        <a href="/jobseeker-profile" class="dropdown-item">View Profile</a>
        <form action="/logout" method="POST" class="dropdown-item">
            <button type="submit" style="background: none; border: none; padding: 0; color: red; font-size: 14px; cursor: pointer;">Sign Out</button>
        </form>
    </div>
</nav>
<script src="../../../public/js/navbar.js"></script>