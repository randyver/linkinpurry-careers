<?php
// Mulai session untuk mendapatkan informasi user_id
session_start();

// Cek apakah pengguna sudah login dengan memeriksa session user_id
if (!isset($_SESSION['user_id'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header('Location: /login');
    exit;
}

// Ambil user_id dan role dari session
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../../public/css/dashboard/index.css">
</head>
<body>
    <header>
        <h1>Welcome to Your Dashboard</h1>
        <p>You are logged in as <?= htmlspecialchars($role); ?></p>
    </header>

    <main>
        <section>
            <h2>Your Profile</h2>
            <p>User ID: <?= htmlspecialchars($user_id); ?></p>
            <p>Role: <?= htmlspecialchars($role); ?></p>
        </section>

        <!-- Tombol logout -->
        <section>
            <form action="/logout" method="POST">
                <button type="submit">Logout</button>
            </form>
        </section>
    </main>

</body>
</html>
