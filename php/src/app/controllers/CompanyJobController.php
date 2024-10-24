<?php

class CompanyJobController
{
    public function index($jobId)
    {
        require_once __DIR__ . '/../config/db.php';

        try {
            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }

            $pdo = Database::getConnection();
            $currentUserId = $_SESSION['user_id'];

            // Get job details and verify if the job belongs to the logged-in company
            $stmt = $pdo->prepare("
                SELECT jv.*, c.name AS company_name, cd.location AS company_location, cd.about AS company_about, jva.file_path 
                FROM JobVacancy jv
                JOIN Users c ON jv.company_id = c.user_id
                JOIN CompanyDetail cd ON c.user_id = cd.user_id
                LEFT JOIN JobVacancyAttachment jva ON jv.job_vacancy_id = jva.job_vacancy_id
                WHERE jv.job_vacancy_id = :jobId AND jv.company_id = :currentUserId
            ");

            $stmt->execute([
                ':jobId' => $jobId,
                ':currentUserId' => $currentUserId
            ]);
            $job = $stmt->fetch(PDO::FETCH_ASSOC);

            // If job is not found or doesn't belong to the current user
            if (!$job) {
                throw new Exception('Job not found or you do not have permission to view this job.');
            }

            // Render the job details
            View::render('company-job-detail/index', [
                'job' => $job
            ]);
        } catch (PDOException $e) {
            echo "Database Error: " . htmlspecialchars($e->getMessage());
        } catch (Exception $e) {
            echo "General Error: " . htmlspecialchars($e->getMessage());
        }
    }

    public function getApplicantsByStatus()
    {
        require_once __DIR__ . '/../config/db.php';

        try {
            $jobId = isset($_GET['job_id']) ? $_GET['job_id'] : null;
            $status = isset($_GET['status']) ? $_GET['status'] : 'all';

            if (!$jobId) {
                http_response_code(400);
                echo json_encode(['error' => 'Job ID is required.']);
                exit;
            }

            $pdo = Database::getConnection();

            $query = "
            SELECT a.*, u.name as applicant_name
            FROM Application a
            JOIN Users u ON a.user_id = u.user_id
            WHERE a.job_vacancy_id = :jobId
        ";

            if ($status !== 'all') {
                $query .= " AND a.status = :status";
            }

            $stmt = $pdo->prepare($query);
            $params = [':jobId' => $jobId];

            if ($status !== 'all') {
                $params[':status'] = $status;
            }

            $stmt->execute($params);
            $applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            ob_start();
            include __DIR__ . '/../views/templates/applicant-list.php';
            $applicantHtml = ob_get_clean();

            echo $applicantHtml;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database Error: ' . htmlspecialchars($e->getMessage())]);
        }
    }

    public function deleteJob()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        if (!isset($_POST['job_id'])) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Job ID is missing.';
            exit;
        }

        $jobId = $_POST['job_id'];

        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();
        
        $query = 'SELECT job_vacancy_id FROM JobVacancy WHERE job_vacancy_id = :job_id AND company_id = :company_id';
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':job_id' => $jobId,
            ':company_id' => $userId
        ]);

        $job = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$job) {
            header('HTTP/1.1 403 Forbidden');
            echo 'You are not authorized to delete this job listing.';
            exit;
        }

        $attachmentQuery = 'SELECT file_path FROM JobVacancyAttachment WHERE job_vacancy_id = :job_id';
        $attachmentStmt = $pdo->prepare($attachmentQuery);
        $attachmentStmt->execute([
            ':job_id' => $jobId
        ]);

        $attachments = $attachmentStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($attachments as $attachment) {
            $filePath = __DIR__ . '/../../public/uploads/attachments/' . $attachment['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $deleteJobQuery = 'DELETE FROM JobVacancy WHERE job_vacancy_id = :job_id';
        $deleteJobStmt = $pdo->prepare($deleteJobQuery);
        $deleteJobStmt->execute([
            ':job_id' => $jobId
        ]);

        if ($deleteJobStmt->rowCount() > 0) {
            header('HTTP/1.1 200 OK');
            echo 'Job and its attachments deleted successfully';
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo 'Failed to delete the job. Please try again.';
        }

        exit;
    }

    public function downloadApplicantsCSV() {
        if (!isset($_GET['job_id'])) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Job ID is required.';
            exit;
        }
    
        $jobId = $_GET['job_id'];
    
        require_once __DIR__ . '/../config/db.php';
    
        try {
            $pdo = Database::getConnection();
    
            $stmt = $pdo->prepare("
                SELECT u.email, u.name, jv.position, a.created_at, a.cv_path, a.video_path, a.status, a.status_reason
                FROM Users u 
                NATURAL JOIN Application a 
                JOIN JobVacancy jv ON a.job_vacancy_id = jv.job_vacancy_id
                WHERE a.job_vacancy_id = :job_id
            ");
            $stmt->execute([':job_id' => $jobId]);
            $applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (!$applicants) {
                header('HTTP/1.1 404 Not Found');
                echo 'No applicants found.';
                exit;
            }
    
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $jobId . '-applicants.csv"');
            $output = fopen('php://output', 'w');
    
            fputcsv($output, ['Name', 'Email', 'Position', 'Applied At', 'CV Path', 'Video Path', 'Status', 'Status Reason']);
    
            foreach ($applicants as $applicant) {
                fputcsv($output, [$applicant['name'], $applicant['email'], $applicant['position'], $applicant['created_at'], $applicant['cv_path'], $applicant['video_path'], $applicant['status'], $applicant['status_reason']]);
            }
    
            fclose($output);
            exit;
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo 'Database Error: ' . htmlspecialchars($e->getMessage());
        }
    }    
}
