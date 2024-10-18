<?php

class ApplicationController {
    public function submitApplication($job_vacancy_id) {
        require_once __DIR__ . '/../config/db.php';
        $message = '';
        $applicationExists = 0; // Initialize variable
    
        // Create a connection to the database
        $pdo = Database::getConnection();
    
        // Cek apakah pengguna telah login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    
        // Dapatkan ID pengguna dari session
        $user_id = $_SESSION['user_id'];
    
        // Cek apakah pelamar sudah pernah melamar untuk job_vacancy_id ini
        $checkQuery = 'SELECT COUNT(*) FROM Application WHERE job_vacancy_id = :job_vacancy_id AND user_id = :user_id';
        $stmt = $pdo->prepare($checkQuery);
        $stmt->execute([
            'job_vacancy_id' => $job_vacancy_id,
            'user_id' => $user_id
        ]);
        $applicationExists = $stmt->fetchColumn();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Jika sudah pernah melamar, tampilkan pesan dan cegah pengiriman ulang
            if ($applicationExists > 0) {
                $message = 'You have already applied for this job.';
            } else {
                // Ambil data dari form
                $cv_path = $_FILES['cv']['name'];
                $video_path = !empty($_FILES['video']['name']) ? $_FILES['video']['name'] : null;
    
                // Tentukan direktori upload
                $upload_dir = __DIR__ . '/../../public/uploads/';
    
                // Validasi file CV
                if (empty($cv_path)) {
                    $message = 'Error: CV is required.';
                }
    
                // Validasi file video (wajib diupload)
                if (empty($video_path)) {
                    $message = 'Error: Video is required.';
                }
    
                // Jika tidak ada pesan error, mulai proses upload file dan simpan ke database
                if (empty($message)) {
                    $cv_uploaded = move_uploaded_file($_FILES['cv']['tmp_name'], $upload_dir . $cv_path);
                    $video_uploaded = $video_path ? move_uploaded_file($_FILES['video']['tmp_name'], $upload_dir . $video_path) : true;
    
                    if ($cv_uploaded && $video_uploaded) {
                        try {
                            // Simpan data ke database
                            $query = 'INSERT INTO Application (job_vacancy_id, user_id, cv_path, video_path) VALUES (:job_vacancy_id, :user_id, :cv_path, :video_path)';
                            $stmt = $pdo->prepare($query);
                            $stmt->execute([
                                'job_vacancy_id' => $job_vacancy_id,
                                'user_id' => $user_id,
                                'cv_path' => $cv_path,
                                'video_path' => $video_path
                            ]);
    
                            $message = 'Application submitted successfully.';
                        } catch (PDOException $e) {
                            $message = 'Database Error: ' . htmlspecialchars($e->getMessage());
                        }
                    } else {
                        $message = 'Failed to upload files.';
                    }
                }
            }
        }
    
        // Render view with the message
        View::render('application/index', [
            'job_vacancy_id' => $job_vacancy_id,
            'message' => $message,
            'applicationExists' => $applicationExists > 0 // Kirim data apakah sudah melamar atau belum
        ]);
    }    
}