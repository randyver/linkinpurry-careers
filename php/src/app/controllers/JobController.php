<?php

class JobController {
    public function show($jobId) {
        require_once __DIR__ . '/../config/db.php';
        
        try {
            // Redirect jika belum login
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }

            $pdo = Database::getConnection();

            // Ambil detail pekerjaan
            $stmt = $pdo->prepare("
                SELECT jv.*, c.name AS company_name, cd.location AS company_location, cd.about AS company_about, jva.file_path 
                FROM JobVacancy jv
                JOIN Users c ON jv.company_id = c.user_id
                JOIN CompanyDetail cd ON c.user_id = cd.user_id
                LEFT JOIN JobVacancyAttachment jva ON jv.job_vacancy_id = jva.job_vacancy_id
                WHERE jv.job_vacancy_id = :jobId
            ");
            $stmt->execute([':jobId' => $jobId]);
            $job = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$job) {
                throw new Exception('Job not found');
            }

            // Cek apakah user sudah melamar pekerjaan ini
            $jobSeekerId = $_SESSION['user_id'];
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
                'application' => $application ?? null, // Mengirimkan data application
            ]);

        } catch (PDOException $e) {
            echo "Database Error: " . htmlspecialchars($e->getMessage());
        } catch (Exception $e) {
            echo "General Error: " . htmlspecialchars($e->getMessage());
        }
    }
}