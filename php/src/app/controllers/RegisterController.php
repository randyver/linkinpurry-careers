<?php

class RegisterController {
    public function register_form() {
        require_once __DIR__ . '/../config/db.php';

        // Ambil data dari form
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Validasi
        if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
            echo json_encode(['success' => false, 'error' => 'All fields are required.']);
            return;
        }

        if ($password !== $confirmPassword) {
            echo json_encode(['success' => false, 'error' => 'Passwords do not match.']);
            return;
        }

        // Simpan ke database
        try {
            $pdo = Database::getConnection();
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
            ]);

            echo json_encode(['success' => true]);

        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function register_page() {
        View::render('register/job-seeker');
    }
}
