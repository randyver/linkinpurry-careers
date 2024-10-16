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
            <form action="register/job-seeker" method="POST">
                <div>
                    <p>Name</p>
                    <input type="text" name="name" placeholder="Name">
                </div>
                    <p>Email</p>
                    <input type="email" name="email" placeholder="Email">
                <div>
                </div>
                <div>
                    <p>Password</p>
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div>
                    <p>Confirm Password</p>
                    <input type="password" name="confirmPassword" placeholder="Confirm Password">
                </div>
            
            <!-- check box -->
            <div>
                <input type="checkbox" name="terms" id="terms">
                <label for="terms">I agree to all the Terms and Privacy Policies</label>
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