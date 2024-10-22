<?php

class ApplicationController
{
    public function submitApplication($job_vacancy_id)
    {
        require_once __DIR__ . '/../config/db.php';
        $message = '';
        $code = 0;

        $pdo = Database::getConnection();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $user_id = $_SESSION['user_id'];

        $checkQuery = 'SELECT COUNT(*) FROM Application WHERE job_vacancy_id = :job_vacancy_id AND user_id = :user_id';
        $stmt = $pdo->prepare($checkQuery);
        $stmt->execute([
            'job_vacancy_id' => $job_vacancy_id,
            'user_id' => $user_id
        ]);
        $applicationExists = $stmt->fetchColumn();

        if ($applicationExists > 0) {
            $message = 'You have already applied for this job.';
            View::render('application/index', [
                'job_vacancy_id' => $job_vacancy_id,
                'message' => $message,
                'code' => 2,
            ]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cv_path = $_FILES['cv']['name'];
            $video_path = !empty($_FILES['video']['name']) ? $_FILES['video']['name'] : null;

            $upload_dir_vid  = __DIR__ . '/../../public/uploads/videos/';
            $upload_dir_cv = __DIR__ . '/../../public/uploads/cv/';

            if (empty($cv_path)) {
                $message = 'Error: CV is required.';
            } else {
                $cv_path = time() . "_" . basename($cv_path);

                if (!empty($video_path)) {
                    $video_path = time() . "_" . basename($video_path);
                }

                if (empty($message)) {
                    $cv_uploaded = move_uploaded_file($_FILES['cv']['tmp_name'], $upload_dir_cv . $cv_path);
                    $video_uploaded = $video_path ? move_uploaded_file($_FILES['video']['tmp_name'], $upload_dir_vid . $video_path) : true;

                    try {
                        $query = 'INSERT INTO Application (job_vacancy_id, user_id, cv_path, video_path) VALUES (:job_vacancy_id, :user_id, :cv_path, :video_path)';
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([
                            'job_vacancy_id' => $job_vacancy_id,
                            'user_id' => $user_id,
                            'cv_path' => $cv_path,
                            'video_path' => $video_path
                        ]);

                        $message = 'Your application has been submitted successfully.';
                        $code = 1;
                    } catch (PDOException $e) {
                        $message = 'Database Error: ' . htmlspecialchars($e->getMessage());
                    }
                }
            }

            View::render('application/index', [
                'job_vacancy_id' => $job_vacancy_id,
                'message' => $message,
                'code' => $code
            ]);
            
        } else {
            View::render('application/index', [
                'job_vacancy_id' => $job_vacancy_id,
                'message' => $message,
                'code' => 0
            ]);
        }
    }
}
