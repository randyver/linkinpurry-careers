<?php

class CompanyJobController {
    public function deleteJob() {
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