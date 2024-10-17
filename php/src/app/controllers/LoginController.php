<?php

class LoginController {
    public function login_index() {
        session_start();
        require_once __DIR__ . '/../config/db.php';
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil input dari form
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Validasi input
            if (empty($email) || empty($password)) {
                $message = "Error: Both fields are required.";
            } else {
                try {
                    $pdo = Database::getConnection();

                    // Ambil user dari database berdasarkan email
                    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
                    $stmt->execute([':email' => $email]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        // Verifikasi password
                        if (password_verify($password, $user['password'])) {
                            // Jika login berhasil, simpan user_id dan role ke session
                            $_SESSION['user_id'] = $user['user_id'];
                            $_SESSION['role'] = $user['role'];
                            $_SESSION['name'] = $user['name'];

                            // Redirect berdasarkan role
                            if ($user['role'] === 'jobseeker') {
                                header('Location: /home-jobseeker');
                            } elseif ($user['role'] === 'company') {
                                header('Location: /home-company');
                            }
                            exit;
                        } else {
                            $message = "Error: Invalid password.";
                        }
                    } else {
                        $message = "Error: User not found.";
                    }
                } catch (PDOException $e) {
                    $message = "Database Error: " . htmlspecialchars($e->getMessage());
                } catch (Exception $e) {
                    $message = "General Error: " . htmlspecialchars($e->getMessage());
                }
            }
        }

        // Render halaman login dengan pesan error jika ada
        View::render('login/index', [
            'message' => $message,
        ]);
    }

    // Fungsi untuk logout dan menghapus session
    public function logout() {
        session_start();
        session_destroy(); // Hapus semua session
        header('Location: /login'); // Redirect ke halaman login
        exit;
    }
}
