<?php

class CompanyJobController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SESSION['role'] !== 'company') {
            header('Location: /404');
            exit();
        }
    }
    public function index($jobId)
    {
        require_once __DIR__ . '/../config/db.php';

        try {
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }

            $pdo = Database::getConnection();
            $currentUserId = $_SESSION['user_id'];

            // Fetch job details
            $stmt = $pdo->prepare("
                SELECT jv.*, c.name AS company_name, cd.location AS company_location, cd.about AS company_about
                FROM JobVacancy jv
                JOIN Users c ON jv.company_id = c.user_id
                JOIN CompanyDetail cd ON c.user_id = cd.user_id
                WHERE jv.job_vacancy_id = :jobId AND jv.company_id = :currentUserId
            ");
            $stmt->execute([
                ':jobId' => $jobId,
                ':currentUserId' => $currentUserId
            ]);
            $job = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$job) {
                header('Location: /404');
            }

            $attachmentStmt = $pdo->prepare("SELECT file_path FROM JobVacancyAttachment WHERE job_vacancy_id = :jobId");
            $attachmentStmt->execute([
                ':jobId' => $jobId
            ]);
            $attachments = $attachmentStmt->fetchAll(PDO::FETCH_ASSOC);

            $applicantCountStmt = $pdo->prepare("SELECT COUNT(*) AS applicant_count FROM Application WHERE job_vacancy_id = :jobId");
            $applicantCountStmt->execute([
                ':jobId' => $jobId
            ]);
            $applicantCount = $applicantCountStmt->fetchColumn();

            View::render('company-job-detail/index', [
                'job' => $job,
                'attachments' => $attachments,
                'applicantCount' => $applicantCount
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

        $applicationFilesQuery = 'SELECT cv_path, video_path FROM Application WHERE job_vacancy_id = :job_id';
        $applicationFilesStmt = $pdo->prepare($applicationFilesQuery);
        $applicationFilesStmt->execute([
            ':job_id' => $jobId
        ]);

        $applications = $applicationFilesStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($applications as $application) {
            if (!empty($application['cv_path'])) {
                $cvFilePath = __DIR__ . '/../../public/uploads/cv/' . $application['cv_path'];
                if (file_exists($cvFilePath)) {
                    unlink($cvFilePath);
                }
            }

            if (!empty($application['video_path'])) {
                $videoFilePath = __DIR__ . '/../../public/uploads/videos/' . $application['video_path'];
                if (file_exists($videoFilePath)) {
                    unlink($videoFilePath);
                }
            }
        }

        $deleteJobQuery = 'DELETE FROM JobVacancy WHERE job_vacancy_id = :job_id';
        $deleteJobStmt = $pdo->prepare($deleteJobQuery);
        $deleteJobStmt->execute([
            ':job_id' => $jobId
        ]);

        if ($deleteJobStmt->rowCount() > 0) {
            header('HTTP/1.1 200 OK');
            echo 'Job and its attachments deleted successfully, including application files.';
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

    public function openJob()
    {
        $this->updateJobStatus(1);
    }

    public function closeJob()
    {
        $this->updateJobStatus(0);
    }

    private function updateJobStatus($isOpen)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $userId = $_SESSION['user_id'];

        if (!isset($_POST['job_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Job ID is required']);
            exit;
        }

        $jobId = $_POST['job_id'];

        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        try {
            $query = 'SELECT job_vacancy_id FROM JobVacancy WHERE job_vacancy_id = :job_id AND company_id = :company_id';
            $statement = $pdo->prepare($query);
            $statement->execute([
                ':job_id' => $jobId,
                ':company_id' => $userId
            ]);

            $job = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$job) {
                http_response_code(403);
                echo json_encode(['error' => 'Unauthorized to update this job']);
                return;
            }

            $updateQuery = 'UPDATE JobVacancy SET is_open = :is_open WHERE job_vacancy_id = :job_id';
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([
                ':is_open' => $isOpen,
                ':job_id' => $jobId
            ]);

            if ($updateStmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(['success' => true, 'message' => 'Job status updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update job status']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
        }
    }
}
