<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../../public/css/login/index.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>

<body>
    <!-- logo -->
    <a href="/home-jobseeker">
        <img src="../../../public/images/logo-dark.png" alt="logo" class="logo">
    </a>

    <main>
        <!-- form -->
        <div>
            <div class="title">
                <h1>Login</h1>
                <p>Welcome back!</p>
            </div>

            <!-- message div for displaying errors or success -->
            <?php if (!empty($message)): ?>
                <div style="color: <?= strpos($message, 'Success') !== false ? 'green' : 'red'; ?>;">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form id="login-form" method="POST">
                <div>
                    <p>Email</p>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div>
                    <p>Password</p>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <!-- button -->
                <div class="login">
                    <button type="submit">Login</button>
                    <p>Don&apos;t have an account? <a href="register">Sign up</a></p>
                </div>
            </form>
        </div>

        <!-- image -->
        <img src="../../../public/images/login.png" alt="login">
    </main>
</body>

</html>