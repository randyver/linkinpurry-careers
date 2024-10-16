<?php

class RegisterController {
    public function register_form_job_seeker() {
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
    
            // Perbaikan: tambahkan tanda kutip pada 'jobseeker'
            $stmt = $pdo->prepare('INSERT INTO users (role, name, email, password) VALUES (\'jobseeker\', :name, :email, :password)');
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
    
    public function register_index() {
        View::render('register/index');
    }

    public function register_page_job_seeker(){
        View::render('register/job-seeker');
    }

    public function register_page_company(){
        View::render('register/company');
    }
}
