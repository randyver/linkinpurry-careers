<?php

class JobSeekerProfileController
{
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $jobseekerName = $this->getJobseekerName();
        $jobSeekerEmail = $this->getJobseekerEmail();
        $jobsAppliedNum = $this->getJobsAppliedNum();
        View::render('jobseeker-profile/index', [
            'jobseekerName' => $jobseekerName,
            'email' => $jobSeekerEmail,
            'jobsAppliedNum' => $jobsAppliedNum
        ]);
    }

    public function getJobseekerName() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['isValid' => false]);
            return;
        }

        $userId = $_SESSION['user_id'];
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT name FROM Users WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $companyName = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$companyName) {
            throw new Exception('No such name found.');
        }

        return $companyName['name'];
    }

    public function getJobseekerEmail() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['isValid' => false]);
            return;
        }

        $userId = $_SESSION['user_id'];

        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT email FROM Users WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $jobseekerEmail = $statement->fetch(PDO::FETCH_ASSOC);

        return $jobseekerEmail['email'];
    }

    public function getJobsAppliedNum() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['isValid' => false]);
            return;
        }
        
        $userId = $_SESSION['user_id'];

        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT COUNT(job_vacancy_id) AS applied_count FROM Application WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $jobsAppliedNum = $statement->fetch(PDO::FETCH_ASSOC);

        return $jobsAppliedNum['applied_count'];
    }
}