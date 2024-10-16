<?php

class RegisterController {
    public function register_index() {
        View::render('register/index');
    }

    public function register_form_job_seeker() {
        require_once __DIR__ . '/../config/db.php';
        $message = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Ambil data dari form
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
        
            // Validasi
            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                $message = "Error: All fields are required.";
            } elseif ($password !== $confirmPassword) {
                $message = "Error: Passwords do not match.";
            } else {
                try {
                    $pdo = Database::getConnection();

                    // Cek apakah email sudah terdaftar
                    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
                    $stmt->execute([':email' => $email]);
                    $count = $stmt->fetchColumn();

                    if ($count > 0) {
                        $message = "Error: Email already registered.";
                    }
                    else {
                    // Simpan ke tabel Users
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
                    $stmt = $pdo->prepare('INSERT INTO users (role, name, email, password) VALUES (\'jobseeker\', :name, :email, :password)');
                    $stmt->execute([
                        ':name' => $name,
                        ':email' => $email,
                        ':password' => $hashedPassword,
                    ]);
                    
                    $message = "Success: User registered.";
                    }
                } catch (PDOException $e) {
                    $message = "Error: " . htmlspecialchars($e->getMessage());
                } catch (Exception $e) {
                    $message = "General Error: " . htmlspecialchars($e->getMessage());
                }
            }
            
            // Jika ada error, hentikan eksekusi
            if (!empty($message)) {
                View::render('register/job-seeker', [
                    'message' => $message,
                ]);
                return; // Hentikan eksekusi jika ada error
            }
        }
    
        View::render('register/job-seeker', [
            'message' => $message,
        ]);
    }

    public function register_form_company() {
        require_once __DIR__ . '/../config/db.php';
        $message = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Ambil data dari form
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $location = trim($_POST['location']);
            $about = trim($_POST['about']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];
        
            // Validasi
            if (empty($name) || empty($email) || empty($location) || empty($about) || empty($password) || empty($confirmPassword)) {
                $message = "Error: All fields are required.";
            } elseif ($password !== $confirmPassword) {
                $message = "Error: Passwords do not match.";
            } else {
                try {
                    $pdo = Database::getConnection();
    
                    // Cek apakah email perusahaan sudah terdaftar
                    $stmt = $pdo->prepare('SELECT COUNT(*) FROM Users WHERE email = :email');
                    $stmt->execute([':email' => $email]);
                    $count = $stmt->fetchColumn();
    
                    if ($count > 0) {
                        $message = "Error: Email already registered.";
                    } else {
                        // Simpan ke tabel Users
                        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                        $stmt = $pdo->prepare('INSERT INTO Users (name, email, password, role) VALUES (:name, :email, :password, \'company\') RETURNING user_id');
                        $stmt->execute([
                            ':name' => $name,
                            ':email' => $email,
                            ':password' => $hashedPassword,
                        ]);
    
                        // Ambil user_id yang baru saja ditambahkan
                        $userId = $stmt->fetchColumn();
    
                        // Simpan detail perusahaan ke tabel CompanyDetail
                        $stmt = $pdo->prepare('INSERT INTO CompanyDetail (user_id, location, about) VALUES (:user_id, :location, :about)');
                        $stmt->execute([
                            ':user_id' => $userId,
                            ':location' => $location,
                            ':about' => $about,
                        ]);
    
                        $message = "Success: Company registered.";
                    }
                } catch (PDOException $e) {
                    $message = "Database Error: " . htmlspecialchars($e->getMessage());
                } catch (Exception $e) {
                    $message = "General Error: " . htmlspecialchars($e->getMessage());
                }
            }
            
            // Jika ada error, hentikan eksekusi
            if (!empty($message)) {
                View::render('register/company', [
                    'message' => $message,
                ]);
                return;
            }
        }
    
        View::render('register/company', [
            'message' => $message,
        ]);
    }
    

}

