<?php

class ApplicationController {
    public function submitApplication($job_vacancy_id) {
        require_once __DIR__ . '/../config/db.php';
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::getConnection();

            // Cek apakah pengguna telah login
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }

            // Dapatkan ID pengguna dari session
            $user_id = $_SESSION['user_id'];

            // Ambil data dari form
            $cv_path = $_FILES['cv']['name'];
            $video_path = !empty($_FILES['video']['name']) ? $_FILES['video']['name'] : null;

            // Tentukan direktori upload
            $upload_dir = __DIR__ . '/../../public/uploads/';
            
            // Validasi file CV
            if (empty($cv_path)) {
                $message = 'Error: CV is required.';
            }

            // Upload file CV
            if (!move_uploaded_file($_FILES['cv']['tmp_name'], $upload_dir . $cv_path)) {
                $message = 'Failed to upload CV.';
            }

            // Upload file video jika ada
            if ($video_path && !move_uploaded_file($_FILES['video']['tmp_name'], $upload_dir . $video_path)) {
                $message = 'Failed to upload video.';
            }

            if (empty($message)) {
                try {
                    // Insert data aplikasi ke tabel Application
                    $query = "INSERT INTO Application (user_id, job_vacancy_id, cv_path, video_path) 
                            VALUES (:user_id, :job_vacancy_id, :cv_path, :video_path)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([
                        ':user_id' => $user_id,
                        ':job_vacancy_id' => $job_vacancy_id,
                        ':cv_path' => $cv_path,
                        ':video_path' => $video_path,
                    ]);

                    // Set success message
                    $message = 'Application submitted successfully.';
                } catch (PDOException $e) {
                    $message = 'Database Error: ' . htmlspecialchars($e->getMessage());
                }
            }
        }

        // Render view with the message
        View::render('application/index', [
            'job_vacancy_id' => $job_vacancy_id,
            'message' => $message
        ]);
    }
}