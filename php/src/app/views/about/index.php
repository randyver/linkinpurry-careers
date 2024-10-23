<?php
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    $name = $_SESSION['name'];

    $isLoggedIn = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/about/index.css">
    <link rel="stylesheet" href="../../../public/css/footer/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>

<body>
    <?php
        if ($role === 'jobseeker') {
            include __DIR__ . '/../templates/navbar-jobseeker.php';
        } elseif ($role === 'company') {
            include __DIR__ . '/../templates/navbar-company.php';
        }
    ?>
    <main>
        <section class="hero">
            <h1><span class="highlight">LinkinPurry</span> – Your Bridge to Opportunity</h1>
            <p>LinkinPurry is your go-to platform for connecting job seekers with the right opportunities and enabling companies to upload and manage job listings effortlessly.</p>
            <p>We are dedicated to making the job search and recruitment experience smooth, efficient, and successful for both individuals and businesses.</p>

            <h3>Join 1,000+ job seekers finding their ideal opportunity</h3>
            <div class="workers-wrapper">
                <div class="workers">
                    <div class="worker">
                        <img src="../../../public/images/worker1-pic.png" alt="worker 1">
                    </div>
                    <div class="worker">
                        <img src="../../../public/images/worker2-pic.png" alt="worker 2">
                    </div>
                    <div class="worker">
                        <img src="../../../public/images/worker3-pic.png" alt="worker 3">
                    </div>
                    <div class="worker">
                        <img src="../../../public/images/worker4-pic.png" alt="worker 4">
                    </div>
                    <div class="worker">
                        <img src="../../../public/images/worker5-pic.png" alt="worker 5">
                    </div>
                    <div class="worker">
                        <img src="../../../public/images/worker6-pic.png" alt="worker 6">
                    </div>
                    <div class="worker">
                        <img src="../../../public/images/worker7-pic.png" alt="worker 7">
                    </div>
                    <div class="worker">
                        <img src="../../../public/images/worker8-pic.png" alt="worker 8">
                    </div>
                </div>
            </div>
        </section>

        <section class="team fade-in">
            <h2>Meet Our Team</h2>
            <div class="team-container">
                <div class="team-member" id="member-1">
                    <img src="../../../public/images/juan-pic.png" alt="Juan Alfred Widjaya">
                    <p><strong>Juan Alfred Widjaya</strong><br>13522073</p>
                </div>
                <div class="team-member" id="member-2">
                    <img src="../../../public/images/randy-pic.png" alt="Randy Verdian">
                    <p><strong>Randy Verdian</strong><br>13522067</p>
                </div>
                <div class="team-member" id="member-3">
                    <img src="../../../public/images/salsa-pic.png" alt="Salsabilla">
                    <p><strong>Salsabilla</strong><br>13522062</p>
                </div>
            </div>
        </section>

        <section class="closing-image fade-in">
            <img src="../../../public/images/desk-pic.png" alt="Picture of a Desk">
        </section>
    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
    <script>
        window.addEventListener('load', function () {
            const workersWrapper = document.querySelector('.workers-wrapper');
            const workers = document.querySelector('.workers');

            const clone = workers.cloneNode(true);
            workers.appendChild(clone);

            let scrollSpeed = 2;
            let scrollDirection = 1;

            function autoScroll() {
                workersWrapper.scrollLeft += scrollSpeed * scrollDirection;

                if (workersWrapper.scrollLeft >= workers.scrollWidth / 2) {
                    workersWrapper.scrollLeft = 0;
                }

                setTimeout(autoScroll, 20);
            }

            autoScroll();
        });
    </script>
    <script>
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top < (window.innerHeight || document.documentElement.clientHeight) &&
                rect.bottom >= 0
            );
        }

        function fadeInOnScroll() {
            const fadeElements = document.querySelectorAll('.fade-in');
            
            fadeElements.forEach(element => {
                if (isInViewport(element)) {
                    element.classList.add('show');
                }
            });
        }

        window.addEventListener('scroll', fadeInOnScroll);
        window.addEventListener('load', fadeInOnScroll);
    </script>
</body>

</html>