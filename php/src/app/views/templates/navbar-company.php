<nav class="navbar">
    <div class="navbar-left">
        <a href="/home-company">
            <img src="../../../public/images/logo-icon-text.svg" alt="Logo" class="logo">
        </a>
    </div>
    <div class="navbar-right">

        <a href="/home-company" class="nav-item-link">
            <?php if (isset($home) && $home == true) { ?>
                <div class="nav-item selected">
                <?php } else { ?>
                    <div class="nav-item">
                    <?php } ?>
                    <img src="../../../public/images/jobs-icon.svg" alt="Jobs Icon" class="nav-icon">
                    <span class="nav-link">Jobs</span>
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
    </div>
</nav>
<script src="../../../public/js/navbar.js"></script>