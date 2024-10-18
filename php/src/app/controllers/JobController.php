<?php

class JobController {
    public function show($jobId) {
        require_once __DIR__ . '/../config/db.php';
        
        try {

            // Jika user belum login, redirect ke halaman login
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }

            $pdo = Database::getConnection();

            // Ambil detail pekerjaan berdasarkan job_vacancy_id
            $stmt = $pdo->prepare("
                SELECT jv.*, c.name AS company_name, cd.location AS company_location, cd.about AS company_about 
                FROM JobVacancy jv
                JOIN Users c ON jv.company_id = c.user_id
                JOIN CompanyDetail cd ON c.user_id = cd.user_id
                WHERE jv.job_vacancy_id = :jobId
            ");
            $stmt->execute([':jobId' => $jobId]);
            $job = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$job) {
                throw new Exception('Job not found');
            }

            $jobSeekerId = $_SESSION['user_id']; // Ambil user_id dari session
            $stmt = $pdo->prepare("
                SELECT * 
                FROM Application 
                WHERE job_vacancy_id = :jobId 
                AND user_id = :jobSeekerId
            ");
            $stmt->execute([
                ':jobId' => $jobId,
                ':jobSeekerId' => $jobSeekerId,
            ]);
            $application = $stmt->fetch(PDO::FETCH_ASSOC);

            // Render view job detail
            View::render('job-detail/index', [
                'job' => $job,
                'application' => $application ?? null,
            ]);

        } catch (PDOException $e) {
            echo "Database Error: " . htmlspecialchars($e->getMessage());
        } catch (Exception $e) {
            echo "General Error: " . htmlspecialchars($e->getMessage());
        }
    }
}