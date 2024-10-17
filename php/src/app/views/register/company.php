<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Company</title>
    <link rel="stylesheet" href="../../../public/css/register/company.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>
<body>
    <!-- logo -->
    <img src="../../../public/images/logo-dark.png" alt="logo" class="logo">

    <main>
        <!-- image -->
        <img src="../../../public/images/job-seeker-register.png" alt="job-seeker-register">
         
        <!-- form -->
        <div>
            <div class="title">
                <h1>Sign Up</h1>
                <p>Let&apos;s get you all set up!</p>
            </div>

            <!-- message div for displaying errors or success -->
            <?php if (!empty($message)): ?>
                <div style="color: <?= strpos($message, 'Success') !== false ? 'green' : 'red'; ?>;">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form id="register-company" method="POST">
                <div class="name-email-form">
                    <div class="input-group">
                        <p>Company's Name</p>
                        <input type="text" name="name" placeholder="Name" required>
                    </div>
                    <div class="input-group">
                        <p>Company's Email</p>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                </div>

                <div>
                    <p>Company's Location</p>
                    <input type="text" name="location" placeholder="Location" required>
                </div>
                <div>
                    <p>About the Company</p>
                    <textarea name="about" placeholder="About the Company" rows="4" required></textarea>
                </div>
                <div>
                    <p>Password</p>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div>
                    <p>Confirm Password</p>
                    <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
                </div>

                <!-- button -->
                <div class="sign-up">
                    <button type="submit">Create account</button>
                    <p>Already have an account? <a href="login">Login</a></p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
