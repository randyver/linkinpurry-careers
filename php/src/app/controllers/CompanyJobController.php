<?php

class CompanyJobController
{
    public function index($jobId)
    {
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

        $deleteQuery = 'DELETE FROM JobVacancy WHERE job_vacancy_id = :job_id';
        $deleteStatement = $pdo->prepare($deleteQuery);
        $deleteStatement->execute([
            ':job_id' => $jobId
        ]);

        if ($deleteStatement->rowCount() > 0) {
            header('HTTP/1.1 200 OK');
            echo 'Job deleted successfully';
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo 'Failed to delete the job. Please try again.';
        }
        exit;
    }
}
