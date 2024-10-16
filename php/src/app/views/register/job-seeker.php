<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Job Seeker</title>
    <link rel="stylesheet" href="../../../public/css/register/job-seeker.css">
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
            <div id="message" style="display:none;"></div>
            
            <form id="register-job-seeker" method="POST">
                <div>
                    <p>Name</p>
                    <input type="text" id="name" name="name" placeholder="Name" required>
                </div>
                <div>
                    <p>Email</p>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div>
                    <p>Password</p>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div>
                    <p>Confirm Password</p>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
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
